<?php

declare(strict_types=1);

namespace Gesparo\Hw\Email;

class Response
{
    /**
     * @param ValidateResult[] $validatedEmails
     * @return void
     */
    public function response(array $validatedEmails): void
    {
        $dividedEmails = $this->divideEmails($validatedEmails);
        $message = '';

        if (empty($dividedEmails['valid'])) {
            $message .= 'There is no valid emails' . PHP_EOL . PHP_EOL;
        } else {
            $message .= 'Valid emails:' . PHP_EOL;
            $message .= implode(PHP_EOL, $dividedEmails['valid']) . PHP_EOL;
        }

        $message .= PHP_EOL;

        if (empty($dividedEmails['invalid'])) {
            $message .= 'All emails was valid' . PHP_EOL . PHP_EOL;
        } else {
            $message .= 'Invalid emails:' . PHP_EOL;
            $message .= implode(PHP_EOL, $dividedEmails['invalid']) . PHP_EOL;
        }

        echo $message;
    }

    /**
     * @param ValidateResult[] $validatedEmails
     * @return mixed
     */
    private function divideEmails(array $validatedEmails): array
    {
        return array_reduce(
            $validatedEmails,
            static function(array $carry, ValidateResult $item) {
                if ($item->getIsValid()) {
                    $carry['valid'][] = $item->getEmail();
                } else {
                    $carry['invalid'][] = $item->getEmail();
                }

                return $carry;
            },
            ['valid' => [], 'invalid' => []]
        );
    }
}