<?php
declare(strict_types=1);

namespace App\Utilities;

use App\Models\Book;

class OutputHelper {
    public static function outputTable(array $books): void {
        $tableHeader = "| %-10s | %-30s | %-20s | %-10s | %-6s |\n";
        $tableRow = "| %-10d | %-30s | %-20s | %10.2f | %6d |\n";
        $tableSeparator = str_repeat('-', 92) . "\n";

        // Output table header
        printf($tableHeader, 'ID', 'Title', 'Category', 'Price', 'Stock');
        echo $tableSeparator;

        // Output table rows
        /** @var Book $book */
        foreach ($books as $book) {
            printf(
                $tableRow,
                $book->getId(),
                mb_strimwidth($book->getTitle(), 0, 28, "..."),
                mb_strimwidth($book->getCategory(), 0, 18, "..."),
                $book->getPrice(),
                $book->getStock()
            );
        }

        // Output table separator
        echo $tableSeparator;
    }
}
