<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class HelloController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/hello/{name<[a-zA-Z- ]*>?World}',
        name: 'app_hello_index')
    ]
    public function index(string $name, string $sfVersion): Response
    {
        // example fpr granted access:
        if ($this->isGranted('ROLE_ADMIN')){
            dump($sfVersion);
        }
        return $this->forward('hello/index.html.twig', [
            'controller_name' => " $name!",
        ]);
    }


    #[Route('/hello/{name}',
        name: 'app_hello_helloWorld')
    ]
    public function helloWorld(string $name): Response
    {
        return $this->render('hello/index.html.twig', [
            'controller_name' => 'HelloController',
        ]);
    }
}
