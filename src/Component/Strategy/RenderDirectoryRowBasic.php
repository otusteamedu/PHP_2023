<?php
declare(strict_types=1);

namespace App\Component\Strategy;

use App\Component\FileSystem\Directory;
use App\Component\FileSystem\FileInterface;

class RenderDirectoryRowBasic implements RenderDirectoryRowInterface
{
    private const NUMBER_OF_SPACES_FOR_INDENTATION = 2;

    public function render(Directory $directory, int $level = 0): string
    {
        $results   = [];
        $results[] = sprintf(
            '%s|-%s %s',
            str_repeat(' ', $level),
            $directory->getDirectory()->getFilename(),
            $directory->getSize()
        );
        $level     += static::NUMBER_OF_SPACES_FOR_INDENTATION;

        foreach ($directory->getElements() as $element) {
            /** @var FileInterface $element */
            $results[] = $element->render($level);
        }

        return implode("\n", $results);
    }
}
