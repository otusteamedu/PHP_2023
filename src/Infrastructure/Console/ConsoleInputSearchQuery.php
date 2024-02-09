<?php

namespace Dimal\Hw11\Infrastructure\Console;

use Dimal\Hw11\Application\InputSearchQueryInterface;
use Dimal\Hw11\Application\SearchQueryDTO;
use Dimal\Hw11\Domain\ValueObject\Category;
use Dimal\Hw11\Domain\ValueObject\Price;
use Dimal\Hw11\Domain\ValueObject\Title;
use Exception;

class ConsoleInputSearchQuery implements InputSearchQueryInterface
{


    public function __invoke($params): SearchQueryDTO
    {
        if (count($params) < 2) {
            throw new Exception("Empty Search query!");
        }


        $minPrice = new Price();
        $maxPrice = new Price();
        $category = new Category();
        $name = '';
        for ($i = 1; $i < count($params); $i++) {
            if ($params[$i] == '--min-price') {
                $minPrice = new Price(((float)trim(str_replace(',', '.', $params[$i + 1]))));
                $i++;
                continue;
            }

            if ($params[$i] == '--max-price') {
                $maxPrice = new Price(((float)trim(str_replace(',', '.', $params[$i + 1]))));
                $i++;
                continue;
            }

            if ($params[$i] == '--category') {
                $category = new Category(trim($params[$i + 1]));
                $i++;
                continue;
            }

            $name .= ' ' . trim($params[$i]);
        }

        $title = new Title(trim($name));

        return new SearchQueryDTO($title, $category, $minPrice, $maxPrice);
    }
}