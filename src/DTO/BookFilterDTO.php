<?php

namespace App\DTO;

class BookFilterDTO {

    private $author = null;
    private $title = null;
    private $category = null;
    private $publishedYear = null;
    private $language = null;
    private $minPrice = null;
    private $maxPrice = null;

    public function getAuthor (): ?string { return $this->author; }
    public function setAuthor (string $author): BookFilterDTO { $this->author = $author; return $this; }

    public function getTitle (): ?string { return $this->title; }
    public function setTitle (string $title): BookFilterDTO { $this->title = $title; return $this; }

    public function getCategory (): ?string { return $this->category; }
    public function setCategory (string $category): BookFilterDTO { $this->category = $category; return $this; }

    public function getPublishedYear (): ?int { return $this->publishedYear; }
    public function setPublishedYear (int $publishedYear): BookFilterDTO { $this->publishedYear = $publishedYear; return $this; }

    public function getLanguage (): ?string { return $this->language; }
    public function setLanguage (string $language): BookFilterDTO { $this->language = $language; return $this; }

    public function getMinPrice (): ?int { return $this->minPrice; }
    public function setMinPrice (int $minPrice): BookFilterDTO { $this->minPrice = $minPrice; return $this; }

    public function getMaxPrice (): ?int { return $this->maxPrice; }
    public function setMaxPrice (int $maxPrice): BookFilterDTO { $this->maxPrice = $maxPrice; return $this; }


}