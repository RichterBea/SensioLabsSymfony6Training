<?php

namespace App\Controller;

use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
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

    #[Route('/decades', name: 'app_movie_decades')]
    public function getDecades(): Response
    {
        return $this->render( 'movie/_decades.html.twig', [
            'decades' => [
                '1950',
                '1960',
                '1970'
            ]
        ]);
    }
}


