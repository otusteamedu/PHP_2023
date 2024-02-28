<?php
declare(strict_types=1);

namespace App\Component\Strategy;

use App\Component\FileSystem\Directory;
use App\Component\FileSystem\FileInterface;
use ByteUnits\Metric;

class RenderDirectoryRowExtended implements RenderDirectoryRowInterface
{
    private const NUMBER_OF_SPACES_FOR_INDENTATION = 2;

    public function render(Directory $directory, int $level = 0): string
    {
        $results   = [];
        $results[] = sprintf(
            '%s|-%s    %s',
            str_repeat(' ', $level),
            $directory->getDirectory()->getFilename(),
            Metric::bytes($directory->getSize())->format()
        );

        $level += static::NUMBER_OF_SPACES_FOR_INDENTATION;

        foreach ($directory->getElements() as $element) {
            /** @var FileInterface $element */
            $results[] = $element->render($level);
        }

        return implode("\n", $results);
    }
}
