<?php

namespace App\Views;

use App\Models\Products\Burger;
use App\Models\Products\Sandwich;
use App\Models\Products\HotDog;

class ProductView
{
    public function display(array $products)
    {
        foreach ($products as $product) {
            if ($product instanceof Burger) {
                echo "Burger\n";
            } elseif ($product instanceof Sandwich) {
                echo "Sandwich\n";
            } elseif ($product instanceof HotDog) {
                echo "HotDog\n";
            } else {
                echo "Unknown Product\n";
            }
        }
    }
}
