<?php

declare(strict_types = 1);

namespace VKorabelnikov\Hw13\DataMapper;

class FilmsCollection
{
    protected $filmsArray = [];

    // public function __construct(int $size)
    // {
    //     $this->filmsArray
    // }

    // public function add(Film $film) {
    //     $this->filmsArray[] = $film;
    // }

    public function get(int $index): Film {
        return $this->filmsArray[$index];
    }

    public function set(int $index, Film $film) {
        $this->filmsArray[$index] = $film;
    }

    public function unset(int $index) {
        unset($this->filmsArray[$index]);
    }
}
