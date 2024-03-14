<?php

declare(strict_types=1);

namespace AYamaliev\hw11\Application\Dto;

class SearchDto
{
    private ?string $title = null;
    private ?string $category = null;
    private ?string $compareSign = null;
    private ?int $price = null;

    public function __construct(array $arguments)
    {
        foreach ($arguments as $argument) {
            $_array = explode('=', $argument);

            if (count($_array) < 2) {
                continue;
            }

            [$argumentName, $argumentValue] = explode('=', $argument);

            switch ($argumentName) {
                case '--title':
                    $this->title = $argumentValue;
                    break;
                case '--category':
                    $this->category = $argumentValue;
                    break;
                case '--price':
                    $_array = explode(' ', $argumentValue);

                    if (count($_array) === 2) {
                        [$this->compareSign, $_price] = explode(' ', $argumentValue);
                        $this->price = (int)$_price;
                    }
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

    /**
     * @return string|null
     */
    public function getCategory(): ?string
    {
        return $this->category;
    }

    /**
     * @return string|null
     */
    public function getCompareSign(): ?string
    {
        return $this->compareSign;
    }

    /**
     * @return int|null
     */
    public function getPrice(): ?int
    {
        return $this->price;
    }
}
