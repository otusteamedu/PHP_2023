<?php

declare(strict_types=1);

namespace App\Service;

use App\Exception\EmailIsNotValidException;
use App\Exception\UserExceptionInterface;
use App\Model\CheckEmailFileResult;
use Exception;
use Generator;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Response;

class EmailChecker
{
    public const NOT_VALID_EMAIL_MESSAGE = 'email is not valid';

    /**
     * @throws EmailIsNotValidException
     */
    public function isEmailValid(string $email): void
    {
        $atIndex = strrpos($email, "@");
        if (is_bool($atIndex) && !$atIndex) {
            throw EmailIsNotValidException::absentA();
        } else {
            $domain = substr($email, $atIndex + 1);
            $local = substr($email, 0, $atIndex);
            $localLen = strlen($local);
            $domainLen = strlen($domain);
            if ($localLen < 1 || $localLen > 64) {
                throw EmailIsNotValidException::localPartLengthExceeded();
            } elseif ($domainLen < 1 || $domainLen > 255) {
                throw EmailIsNotValidException::domainPartLengthExceeded();
            } elseif ($local[0] === '.' || $local[$localLen - 1] === '.') {
                throw EmailIsNotValidException::localPartStartsOrEndsWithDot();
            } elseif (preg_match('/\.\./', $local)) {
                throw EmailIsNotValidException::localPartHasTwoConsecutiveDots();
            } elseif (!preg_match('/^[A-Za-zА-я0-9\-\.]+$/u', $domain)) {
                throw EmailIsNotValidException::characterNotValidInDomainPart();
            } elseif (preg_match('/\.\./', $domain)) {
                throw EmailIsNotValidException::domainPartHasTwoConsecutiveDots();
            }
            if (!(checkdnsrr(idn_to_ascii($domain)) || checkdnsrr(idn_to_ascii($domain), "A"))) {
                throw EmailIsNotValidException::domainNotFoundInDns();
            } elseif
            (
                !preg_match(
                    '/^(\\.|[A-Za-zА-я0-9!#%&`_=\/$\'*+?^{}|~.-])+$/u',
                    str_replace("\\", "", $local)
                )
            ) {
                // character not valid in local part unless
                // local part is quoted
                if (!preg_match(
                    '/^"(\\"|[^"])+"$/',
                    str_replace("\\", "", $local)
                )) {
                    throw EmailIsNotValidException::characterNotValidInLocalPart();
                }
            }
        }
    }

    public function checkEmailWithFile(File $file): CheckEmailFileResult
    {
        $result = new CheckEmailFileResult();

        foreach ($this->getFileRows($file) as $email) {
            $email = trim($email);

            try {
                $this->isEmailValid($email);
            } catch (Exception) {
                $result->addInvalidEmail($email);
                continue;
            }

            $result->addValidEmail($email);
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