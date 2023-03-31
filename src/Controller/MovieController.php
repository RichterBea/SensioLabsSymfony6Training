<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Form\MovieType;
use App\Security\Voter\MovieVoter;
use App\Movie\MovieProvider;
use App\Movie\OmdbApiConsumer;
use App\Repository\MovieRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/movie')]
class MovieController extends AbstractController
{
    #[Route('',
        name: 'app_movie_index',
        methods: ['GET'])
    ]
    public function index(): Response
    {
        return $this->render('movie/index.html.twig', [
            'controller_name' => 'MovieController',
        ]);
    }

    //[Route('/{id<\d+>?2}', name: 'app_movie_show')]
    #[Route('/show/{id}',
        name: 'app_movie_show',
        requirements: ['id' => '\d+'],
        defaults: ['id' => 1])
    ]
    public function show(int $id): Response
    {
        $movie = [
            'id' => $id,
            'title' => 'Star Wars IV: A New Hope',
            'releasedAt' => new \DateTimeImmutable('25 May 1977'),
            'genre' => ['Action', 'Adventure', 'Fantasy']
        ];

        return $this->render('movie/show.html.twig', [
            'movie' => $movie,
        ]);
    }

    public function decades(): Response
    {
        return $this->render('movie/_decades.html.twig', [
            'decades' => [
                ['year' => '1980'],
                ['year' => '1990'],
                ['year' => '2000'],
            ],
        ])->setMaxAge(120);
    }

    #[Route('/{id<\d+>}', name: 'app_movie_details',)]
    public function details(Movie $movie = null): Response
    {
        $movie ??= new Movie();
        $this->denyAccessUnlessGranted(MovieVoter::VIEW, $movie);

        return $this->render('movie/details.html.twig', [
            'movie' => $movie,
        ]);
    }


    #[Route('/omdb/{title}', name: 'app_movie_omdb')]
    public function omdb(string $title, MovieProvider $provider): Response
    {
        $movie = $provider->getMovie(OmdbApiConsumer::MODE_TITLE, $title);
        $this->denyAccessUnlessGranted(MovieVoter::VIEW, $movie);

        return $this->render('movie/details.html.twig', [
            'movie' => $provider->getMovie(OmdbApiConsumer::MODE_TITLE, $title),
            'movie' => $movie,
        ]);
    }

    #[Route('/create', name: 'app_movie_create', methods: ['GET', 'POST'])]
    public function create(Request $request, MovieRepository $repository): Response
    {
        $movie = new Movie();
        $form = $this->createForm(MovieType::class, $movie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dump($movie);

            $repository->save($movie, true);
            return $this->redirectToRoute('app_movie_create');
        }

        return $this->render('movie/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/delete', name: 'app_movie_delete', methods: ['GET', 'POST'])]
    public function delete(Request $request, Movie $movie, MovieRepository $repository): Response
    {
        $form = $this->createForm(MovieType::class, $movie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $repository->remove($movie, true);
            return $this->redirectToRoute('app_movie_show');
        }

        return $this->redirectToRoute('book.list');
    }
}


