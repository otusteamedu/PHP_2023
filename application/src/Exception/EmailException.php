<?php

declare(strict_types=1);

namespace Gesparo\Hw\Exception;

class EmailException extends \Exception
{
    public static function pathIsDirectory(string $path): self
    {
        return new self("Path '$path' is a directory");
    }

    public static function fileDoesNotExist(string $path): self
    {
        return new self("Cannot find file by path '$path'");
    }

    public static function fileIsNotReadable(string $path): self
    {
        return new self("File '$path' is not readable");
    }

    public static function cannotCreateFileDescriptorForFile(string $path): self
    {
        return new self("Cannot create file descriptor for file '$path'");
    }

    public static function tooMuchEmails(string $path, int $limit): self
    {
        return new self("File '$path' contains more then $limit emails to check");
    }

    public static function failToGetResponseFromTheApi(string $domain, \CurlHandle $curl): self
    {
        return new self(
            "Fail to send request to the domains api and get the result for domain '$domain'. Error: " . curl_error($curl),
            curl_errno($curl)
        );
    }

    public static function apiRespondWithError(string $errorMessage, string $domain): self
    {
        return new self("Api for checking domain responded with error. Error message: '$errorMessage'. Domain: '$domain'");
    }
}
