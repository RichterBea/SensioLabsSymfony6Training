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
        return $this->render('movie/index.html.twig', [
            'controller_name' => 'MovieController::show - id :' . $id,
        ]);
    }
}


