<?php

namespace Dimal\Hw11\Entity;

class Book
{
    private string $id = '';
    private string $title = '';
    private string $category = '';
    private float $price = 0.00;
    private array $avail = [];

    public function __construct($id, $title, $category, $price, $avail)
    {
        $this->id = $id;
        $this->title = $title;
        $this->category = $category;
        $this->price = $price;
        $this->avail = $avail;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getPrice()
    {
        return number_format($this->price, 2, ',', ' ');
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function getAvailToString()
    {
        $str = '';
        foreach ($this->avail as $shopname => $cnt) {
            if ($cnt) {
                if ($str) {
                    $str .= ', ';
                }
                $str .= "$shopname - $cnt";
            }
        }

        return $str;
    }

}