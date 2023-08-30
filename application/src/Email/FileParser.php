<?php

declare(strict_types=1);

namespace Gesparo\Hw\Email;

use Gesparo\Hw\Exception\EmailException;

class FileParser
{
    private const LIMIT_OF_EMAILS = 100;

    private string $pathToFile;
    private array $emails;

    /**
     * @throws EmailException
     */
    public function __construct(string $pathToFile)
    {
        $this->pathToFile = $pathToFile;
        $this->emails = $this->getEmailsFromFile();
    }

    /**
     * @throws EmailException
     */
    private function getEmailsFromFile(): array
    {
        $fileDescriptor = $this->openFile();
        $result = [];

        try {
            foreach ($this->getFileIterator($fileDescriptor) as $email) {
                // protection of empty lines
                if (!is_string($email) || $email === '') {
                    continue;
                }

                if (count($result) >= self::LIMIT_OF_EMAILS) {
                    throw EmailException::tooMuchEmails($this->pathToFile, self::LIMIT_OF_EMAILS);
                }

                $result[] = $email;
            }
        } finally {
            fclose($fileDescriptor);
        }

        return $result;
    }

    /**
     * @throws EmailException
     */
    private function openFile()
    {
        if (is_dir($this->pathToFile)) {
            throw EmailException::pathIsDirectory($this->pathToFile);
        }

        if (!file_exists($this->pathToFile)) {
            throw EmailException::fileDoesNotExist($this->pathToFile);
        }

        if (!is_readable($this->pathToFile)) {
            throw EmailException::fileIsNotReadable($this->pathToFile);
        }

        $descriptor = fopen($this->pathToFile, 'rb');

        if ($descriptor === false) {
            throw EmailException::cannotCreateFileDescriptorForFile($this->pathToFile);
        }

        return $descriptor;
    }

    private function getFileIterator($fileDescriptor): \Generator
    {
        while (!feof($fileDescriptor)) {
            yield fgets($fileDescriptor);
        }
    }

    public function getEmails(): array
    {
        return $this->emails;
    }
}