<?php
declare(strict_types=1);

namespace Vp\App\Services;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class Preparer
{
    private const LINE_FEED_PATTERN = "|[\r\n]|s";

    public function fromEmail(string $email): array
    {
        return [$email];
    }

    public function fromEmails(string $emails): array
    {
        return $this->toArray($emails);
    }

    public function fromFile($file): array
    {
        if (!($file instanceof UploadedFile)) {
            return [];
        }

        if ($emails = file_get_contents($file->getPathname())) {
            return $this->toArray($emails);
        }

        return [];
    }

    private function toArray(string $emails): array
    {
        return preg_split(self::LINE_FEED_PATTERN, $emails, -1, PREG_SPLIT_NO_EMPTY);
    }
}
