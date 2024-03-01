<?php
declare(strict_types=1);

namespace Shabanov\Otusphp\Infrastructure\Render;

use Shabanov\Otusphp\Domain\Collection\BookCollection;
use Shabanov\Otusphp\Infrastructure\Render\RenderInterface;

readonly class BooksRender implements RenderInterface
{
    public function __construct(private BookCollection $data) {}

    public function getTable(): string
    {
        $str = 'SKU | Title | Category | Price | Shop | Stock ' . PHP_EOL;
        if (!empty($this->data)) {
            foreach ($this->data as $item) {
                $str .= $item['sku'] . ' | '
                    . $item['title'] . ' | '
                    . $item['category'] . ' | '
                    . $item['price'] . ' | '
                    . PHP_EOL;
            }
        }
        return $str;
    }
}
