<?php

namespace App\Controller;

use App\Dto\Contact;
use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetContactController extends AbstractController
{
    #[Route('/contact',
        name: 'app_Main_contact',
        methods: ['GET']
    )]
    public function __invoke(Request $request): Response
    {
        $dto = new Contact();
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dump($dto);
            return $this->redirectToRoute('app_get_contact');
        }

        return $this->render('contact/contact.html.twig', [
            'form' => $form,
        ]);
    }

}
