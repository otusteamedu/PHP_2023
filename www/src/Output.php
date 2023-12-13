<?php

declare(strict_types=1);

namespace Yalanskiy\Lists;

/**
 * Print list values
 */
class Output
{
    /**
     * Print list values
     *
     * @param ListNode|null $list
     * @param string $separator
     *
     * @return void
     */
    public static function print(ListNode|null $list, string $separator = ' - '): void
    {
        while ($list !== null) {
            echo $list->val;
            $list = $list->next;
            if ($list !== null) {
                echo $separator;
            }
        }
        echo PHP_EOL;
    }
}
