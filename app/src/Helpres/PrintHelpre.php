
<?php
declare(strict_types=1);

namespace App\Utilities;

use App\Models\Book;

class OutputHelper {
    public static function outputTable(array $books): void {
        $tableHeader = "| %-10s | %-30s | %-20s | %-10s | %-20s |\n";
        $tableRow = "| %-10d | %-30s | %-20s | %10.2f | %20s |\n"; // Modify format for stock
        $tableSeparator = str_repeat('-', 106) . "\n"; // Modify separator length

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
                mb_strimwidth($book->getStock(), 0, 28, "...") // Treat stock as string
            );
        }

        // Output table separator
        echo $tableSeparator;
    }
}