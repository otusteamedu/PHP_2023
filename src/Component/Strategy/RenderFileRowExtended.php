<?php
declare(strict_types=1);

namespace App\Component\Strategy;

use App\Component\FileSystem\File;
use ByteUnits\Metric;

class RenderFileRowExtended implements RenderFileRowInterface
{
    private const NUMBER_CHARACTERS_IN_PREVIEW = 50;

    public function render(File $file, int $level = 0): string
    {
        $preview = match ($file->getFile()->getExtension()) {
            'txt' => $this->getPreviewTxt($file),
            'html' => $this->getPreviewHtml($file),
            default => ''
        };

        return sprintf(
            '%s|-%s   %s    %s',
            str_repeat(' ', $level),
            $file->getFile()->getFilename(),
            Metric::bytes($file->getFile()->getSize())->format(),
            $preview
        );
    }

    private function getPreviewTxt(File $file): string
    {
        $fileContent = $file->getFile()->openFile()->fread(static::NUMBER_CHARACTERS_IN_PREVIEW * 4);
        $fileContent = str_replace("\n", '', $fileContent);

        return mb_substr($fileContent, 0, static::NUMBER_CHARACTERS_IN_PREVIEW);
    }

    private function getPreviewHtml(File $file): string
    {
        $fileContent = $file->getFile()->openFile()->fread($file->getFile()->getSize());
        $fileContent = strip_tags($fileContent);
        $fileContent = str_replace(["\n", '  '], '', $fileContent);

        return mb_substr($fileContent, 0, static::NUMBER_CHARACTERS_IN_PREVIEW);
    }
}
