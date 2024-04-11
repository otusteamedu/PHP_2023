<?php

declare(strict_types=1);

namespace App\Dto;

use App\ElasticsearchBase;

class SearchDto extends ElasticsearchBase
{
    private ?string $command = null;
    private ?string $title = null;
    private ?string $category = null;
    private ?int $minPrice = null;
    private ?int $maxPrice= null;

    public function __construct(array $arguments)
    {

        foreach ($arguments as $argument) {
            $_array = explode('=', $argument);

            if (count($_array) < 2) {
                continue;
            }


            [$argumentName, $argumentValue] = explode('=', $argument);

            switch ($argumentName) {
                case 'command':
                    $this->command = $argumentValue;
                    break;
                case 'title':
                    $this->title = $argumentValue;
                    break;
                case 'category':
                    $this->category = $argumentValue;
                    break;
                case 'minPrice':
                    $this->minPrice = (int)$argumentValue;
                    break;
                case 'maxPrice':
                    $this->maxPrice = (int)$argumentValue;
                    break;
            }
        }
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }


    public function getCommand(): ?string
    {
        return $this->command;
    }

    /**
     * @return string|null
     */
    public function getCategory(): ?string
    {
        return $this->category;
    }


    /**
     * @return int|null
     */
    public function getMinPrice(): ?int
    {
        return $this->minPrice;
    }

    public function getMaxPrice(): ?int
    {
        return $this->maxPrice;
    }

}