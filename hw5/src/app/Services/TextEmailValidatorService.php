<?php

namespace app\Services;

/**
 * TextEmailValidator Service provides check of the email addresses validity
 * and existence of its domains' DNS MX records.
 *
 * Accepts a plain text or an array of strings where it expects
 * to fond email addresses for the check.
 *
 * Returns an array of parameters:
 * 'response' with the status of the check ('success' or 'error')
 * 'all_emails' - an array of all email addresses found in the input
 * in case of the check failure additionally
 * 'invalid_emails' - an array of invalid email addresses
 * 'emails_without_mx' - an array of email addresses that domains
 * don't have DNS MX records.
 *
 * @package app\Services
 */
class TextEmailValidatorService
{
    private ?array $emailsFromString = [];
    private ?array $emailsWithoutMX = [];
    private ?array $invalidEmails = [];

    const PARAM_RESPONSE = 'response';
    const PARAM_ALL_EMAILS = 'all_emails';
    const PARAM_INVALID_EMAILS = 'invalid_emails';
    const PARAM_EMAILS_WITHOUT_MX = 'emails_without_mx';

    const STATUS_ERROR = 'error';
    const STATUS_SUCCESS = 'success';

    public function validate(array|string $text = null): array
    {
        $this->emailsFromString = $this->emailsWithoutMX = $this->invalidEmails = [];

        if (! is_array($text)) {
            $strings = $this->splitStrings($text);
        } else {
            $strings = $text;
        }

        foreach ($strings as $string) {
            $this->containsEmail($string);
        }

        $this->validateEmails();

        $response = [self::PARAM_ALL_EMAILS => $this->emailsFromString];
        if (count($this->invalidEmails) > 0 || count($this->emailsWithoutMX) > 0) {
            $response[self::PARAM_RESPONSE] = self::STATUS_ERROR;

            if (count($this->invalidEmails) > 0) {
                $response[self::PARAM_INVALID_EMAILS] = $this->invalidEmails;
            }
            if (count($this->emailsWithoutMX) > 0) {
                $response[self::PARAM_EMAILS_WITHOUT_MX] = $this->emailsWithoutMX;
            }
        } else {
            $response[self::PARAM_RESPONSE] = self::STATUS_SUCCESS;
        }

        return $response;
    }

    private function splitStrings(string $text): array
    {
        return explode(PHP_EOL, $text);
    }

    private function containsEmail(string $text): void
    {
        preg_match_all("/\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/", $text, $emailsFromString, PREG_SET_ORDER);
        if ($emailsFromString) {
            foreach ($emailsFromString as $email) {
                if (! in_array($email[0], $this->emailsFromString)) {
                    $this->emailsFromString[] = $email[0];
                }
            }
        }
    }

    private function validateEmails(): void
    {
        foreach ($this->emailsFromString as $email) {
            if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
                if (! in_array($email, $this->invalidEmails)) {
                    $this->invalidEmails[] = $email;
                }
            } elseif (! getmxrr(substr($email, strpos($email, '@') + 1), $hosts)) {
                if (! in_array($email, $this->emailsWithoutMX)) {
                    $this->emailsWithoutMX[] = $email;
                }
            }
        }
    }
}
