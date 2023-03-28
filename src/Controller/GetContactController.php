<?php

namespace App\Controller;

use App\Form\ContactType;
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
        $form = $this->createForm(ContactType::class);

        return $this->render('contact/contact.html.twig', [
            'form' => $form,
        ]);
    }

}
