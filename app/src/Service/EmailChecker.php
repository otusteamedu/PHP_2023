<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\CheckEmailFileResult;
use Generator;
use Symfony\Component\HttpFoundation\File\File;

class EmailChecker
{
    public const NOT_VALID_EMAIL_MESSAGE = 'email is not valid';

    public function isEmailValid(string $email): bool
    {
        $isValid = true;
        $atIndex = strrpos($email, "@");
        if (is_bool($atIndex) && !$atIndex) {
            $isValid = false;
        } else {
            $domain = substr($email, $atIndex + 1);
            $local = substr($email, 0, $atIndex);
            $localLen = strlen($local);
            $domainLen = strlen($domain);
            if ($localLen < 1 || $localLen > 64) {
                // local part length exceeded
                $isValid = false;
            } elseif ($domainLen < 1 || $domainLen > 255) {
                // domain part length exceeded
                $isValid = false;
            } elseif ($local[0] === '.' || $local[$localLen - 1] === '.') {
                // local part starts or ends with '.'
                $isValid = false;
            } elseif (preg_match('/\.\./', $local)) {
                // local part has two consecutive dots
                $isValid = false;
            } elseif (!preg_match('/^[A-Za-zА-я0-9\-\.]+$/u', $domain)) {
                // character not valid in domain part
                $isValid = false;
            } elseif (preg_match('/\.\./', $domain)) {
                // domain part has two consecutive dots
                $isValid = false;
            }
            if ($isValid && !(checkdnsrr(idn_to_ascii($domain)) || checkdnsrr(idn_to_ascii($domain), "A"))) {
                // domain not found in DNS
                $isValid = false;
            } elseif
            (!preg_match(
                    '/^(\\.|[A-Za-zА-я0-9!#%&`_=\/$\'*+?^{}|~.-])+$/u',
                    str_replace("\\", "", $local)
                )) {
                // character not valid in local part unless
                // local part is quoted
                if (!preg_match(
                    '/^"(\\"|[^"])+"$/',
                    str_replace("\\", "", $local)
                )) {
                    $isValid = false;
                }
            }
        }
        return $isValid;
    }

    public function checkEmailWithFile(File $file): CheckEmailFileResult
    {
        $result = new CheckEmailFileResult();

        foreach ($this->getFileRows($file) as $email) {
            $email = trim($email);

            if ($this->isEmailValid($email)) {
                $result->addValidEmail($email);
            } else {
                $result->addInvalidEmail($email);
            }
        }

        return $result;
    }

    private function getFileRows(File $file): Generator
    {
        $handle = $file->openFile();

        // пока не достигнем конца файла
        while (!$handle->eof()) {
            yield $handle->fgets();
        }

        // закрытие файла
        $handle = null;
    }
}