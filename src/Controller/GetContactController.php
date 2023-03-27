<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetContactController extends AbstractController
{
    #[Route('/contact',
        name: 'app_Main_contact',
        methods: ['GET']
    )]
    public function __invoke(): Response
    {
        return $this->render('contact/contact.html.twig', [
            'controller_name' => 'Contact',
        ]);
    }
}
