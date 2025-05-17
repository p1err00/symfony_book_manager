<?php

namespace App\Controller;

use App\DTO\BookFilterDTO;
use App\Form\SearchBookFormType;
use App\Service\GoogleBooksService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class SearchBookController extends AbstractController
{
    #[Route('/search/book', name: 'app_search_book')]
    public function index(Request $request, GoogleBooksService $googleBooksService): Response
    {
        $bookFilter = new BookFilterDTO();
        $form  = $this->createForm(SearchBookFormType::class, $bookFilter);
        $form->handleRequest($request);

        $books = [];

        if ($form->isSubmitted() && $form->isValid()) {
            $books = $googleBooksService->searchBooks($bookFilter);
        }

        return $this->render('search_book/index.html.twig', [
            'controller_name' => 'SearchBookController',
            'form' => $form->createView(),
            'books' => $books
        ]);
    }
}
