<?php

declare(strict_types=1);

$prices = [
    5,
    10,
    2,
    3,
    3,
    20,
    100,
];

function getMaxPrice($prices): int
{
    foreach ($prices as $price) {
        if (!isset($max)) {
            $max = $price;
        }
        if ($price > $max) {
            $max = $price;
        }
    }
    return $max;
}

function normalizePrice($prices): array
{
    $minPrice = $prices[0];
    foreach ($prices as $price) {
        if ($price < $minPrice) {
            $minPrice = $price;
        }
    }
    foreach ($prices as &$value) {
        $value -= $minPrice;
    }
    return $prices;
}

function countPricesGreaterThanEach(array $prices): array
{
    $result = [];
    foreach ($prices as $price) {
        foreach ($prices as $otherPrice) {
            if ($price < $otherPrice) {
                if (!isset($result[$price])) {
                    $result[$price] = 1;
                } else {
                    $result[$price]++;
                }
            }
        }
    }
    return $result;
}

function findGreatestPrices($prices): int
{
   $len = count($prices);
   return $prices[$len-1];
}

function reverseString($string): string
{
    $len = strlen($string);
    $ans = '';
    for ($i = $len - 1; $i >= 0; $i--) {
        var_dump($string[$i]);
        $ans .= $string[$i];
    }
    return $ans;
}

function sumNumber(int $number): int
{
    $sum = 0;
    while ($sum != 555 && $sum < 1000) {
        $sum += $number;
    }

    return $sum;
}

print_r(sumNumber(15));