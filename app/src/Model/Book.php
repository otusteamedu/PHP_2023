<?php
declare(strict_types=1);

namespace App\Models;

class Book {
    private $id;
    private $title;
    private $category;
    private $price;
    private $stock;

    public function __construct($id, $title, $category, $price, $stock) {
        $this->id = $id;
        $this->title = $title;
        $this->category = $category;
        $this->price = $price;
        $this->stock = $stock;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getCategory() {
        return $this->category;
    }

    public function setCategory($category) {
        $this->category = $category;
    }

    public function getPrice() {
        return $this->price;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function getStock() {
        return $this->stock;
    }

    public function setStock($stock) {
        $this->stock = $stock;
    }
}
