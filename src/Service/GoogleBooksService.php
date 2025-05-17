<?php

namespace App\Service;

use App\DTO\BookDTO;
use App\DTO\BookFilterDTO;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;


class GoogleBooksService {

    public function __construct(
        EntityManagerInterface $em,
        HttpClientInterface $httpClient
    ) {
        $this->em = $em;
        $this->client = $httpClient;
    }

    public function searchBooks(BookFilterDTO $filters): array
    {

        $queryParams = [];

        if ($filters->getTitle()) {
            $queryParams[] = 'intitle:' . $filters->getTitle();
        }
    
        if ($filters->getAuthor()) {
            $queryParams[] = 'inauthor:' . $filters->getAuthor();
        }
    
        if ($filters->getCategory()) {
            $queryParams[] = 'subject:' . $filters->getCategory();
        }
    
        $query = implode('+', $queryParams);

        $response = $this->client->request('GET', 'https://www.googleapis.com/books/v1/volumes', [
            'query' => [
                'q' => $query,
                'maxResults' => 10,
                'langRestrict' => 'fr',
                // ajoute price filters si tu les gères via ta propre logique
            ],
        ]);
    // dd($response);
        $data = $response->toArray();
        return array_map(function (array $item) {
            return new BookDTO(
                $item['id'],
                $item['volumeInfo']['title'] ?? '',
                $item['volumeInfo']['description'] ?? null,
                $item['volumeInfo']['authors'][0] ?? '',
                $item['volumeInfo']['publishedDate'] ?? null,
                $item['volumeInfo']['publisher'] ?? null,
                $item['volumeInfo']['categories'] ?? [],
                $item['volumeInfo']['pageCount'] ?? 0,
                $item['volumeInfo']['language'] ?? 'en',
                $item['volumeInfo']['imageLinks']['thumbnail'] ?? null,
                $item['volumeInfo']['previewLink'] ?? null,
                $item['volumeInfo']['infoLink'] ?? null,
                null, // price
                null, // currency
                null  // buyLink
            );
        }, $data['items'] ?? []);
    }
}