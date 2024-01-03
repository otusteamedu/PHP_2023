<?php

namespace Gkarman\Otuselastic\Dto;

class BookDto
{
    public ?string $category;
    public ?string $title;
    public ?string $price;
    public ?array $stock;

    public function __construct(array $data)
    {
        $this->category = $data['category'] ?? null;
        $this->title = $data['title'] ?? null;
        $this->price = $data['price'] ?? null;
        $this->stock = $data['stock'] ?? null;
    }
}
