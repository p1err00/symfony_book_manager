<?php

namespace App\DTO;

class BookDTO
{

    private $id;
    private $title;
    private $description;
    private $author;
    private $publishedDate;
    private $publisher;
    private $categories;
    private $pageCount;
    private $language;
    private $thumbnail;
    private $previewLink;
    private $infoLink;
    private $price;
    private $currency;
    private $buyLink;

    public function __construct(
        ?string $id = null,
        string $title = '',
        ?string $description = null,
        ?string $author = null,
        ?string $publishedDate = null,
        ?string $publisher = null,
        array $categories = [],
        int $pageCount = 0,
        string $language = 'en',
        ?string $thumbnail = null,
        ?string $previewLink = null,
        ?string $infoLink = null,
        ?float $price = null,
        ?string $currency = null,
        ?string $buyLink = null
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->author = $author;
        $this->publishedDate = $publishedDate;
        $this->publisher = $publisher;
        $this->categories = $categories;
        $this->pageCount = $pageCount;
        $this->language = $language;
        $this->thumbnail = $thumbnail;
        $this->previewLink = $previewLink;
        $this->infoLink = $infoLink;
        $this->price = $price;
        $this->currency = $currency;
        $this->buyLink = $buyLink;
    }

    public function getTitle(): ?string {return $this->title; }
    public function setTitle(string $title): BookDTO { $this->title = $title; return $this; }

    public function getDescription(): ?string {return $this->description; }
    public function setDescription(string $description): BookDTO { $this->description = $description; return $this; }

    public function getAuthors(): ?string { return $this->author; }
    public function setAuthors(array $author): BookDTO { $this->author = $author[0]; return $this; }

    public function getPublishedDate(): ?string {return $this->publishedDate; }
    public function setPublishedDate(string $publishedDate): BookDTO { $this->publishedDate = $publishedDate; return $this; }

    public function getPublisher(): ?string { return $this->publisher; }
    public function setPublisher(string $publisher): BookDTO { $this->publisher = $publisher; return $this; }

    public function getCategories(): array { return $this->categories; }
    public function setCategories(array $categories): BookDTO { $this->categories = $categories; return $this; }

    public function getBuyLink(): string { return $this->buyLink; }
    public function setBuyLink(string $buyLink): BookDTO { $this->buyLink = $buyLink; return $this; }

    public function getPageCount(): int { return $this->pageCount; }
    public function setPageCount(int $pageCount): BookDTO { $this->pageCount = $pageCount; return $this; }

    public function getLanguage(): string { return $this->language; }
    public function setLanguage(string $language): BookDTO { $this->language = $language; return $this; }

    public function getThumbnail(): ?string { return $this->thumbnail; }
    public function setThumbnail(string $thumbnail): BookDTO { $this->thumbnail = $thumbnail; return $this; }

    public function getPreviewLink(): string { return $this->previewLink; }
    public function setPreviewLink(string $previewLink): BookDTO { $this->previewLink = $previewLink; return $this; }

    public function getInfoLink(): string { return $this->infoLink; }
    public function setInfoLink(string $infoLink): BookDTO { $this->infoLink = $infoLink; return $this; }

    public function getPrice():int { return $this->price; }
    public function setPrice(int $price): BookDTO { $this->price = $price; return $this; }

    public function getCurrency(): string { return $this->currency; }
    public function setCurrency(string $currency): BookDTO { $this->currency = $currency; return $this; }


}
