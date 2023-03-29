<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/book')]
class BookController extends AbstractController
{
    #[Route('',
        name: 'app_book_index',
        methods: ['GET'])
    ]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }

    #[Route('/create', name: 'app_book_create', methods: ['GET', 'POST'])]
    public function create(Request $request, BookRepository $repository): Response
    {
        $this->container->get('mailer.mailer');
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           dump($book);

           $repository->save($book, true);
           return $this->redirectToRoute('app_book_create');
        }

        return $this->render('book/new.html.twig', [
            'form' => $form,
            ]);
    }
}
