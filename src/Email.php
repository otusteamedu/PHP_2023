<?php

declare(strict_types=1);

namespace Dmitryesaulenko\Php2023;

class Email
{
    const TYPE_MX = 'MX';
    const EMAILS_KEY = 'email_list';

    /**
     * Проверяет список Email:
     * 1. По регулярному выражению
     * 2. MX запись DNS
     *
     * @return string
     * @throws \JsonException
     */
    public static function verify(): string
    {
        $emailList = static::makeListFromInput();
        if (!$emailList) {
            throw new \Exception(
                Response::ERROR_EMPTY_REQUEST,
                Response::EMPTY_REQUEST_STATUS
            );
        }

        $response = [];
        foreach ($emailList as $email) {
            $response[$email]['result'] = false;

            if (!self::checkRegExp($email)) {
                $response[$email]['errors'][] = Response::ERROR_REGEXP;
                continue;
            }

            if (!self::checkDns($email)) {
                $response[$email]['errors'][] = Response::ERROR_DNS;
            }

            if (!$response[$email]['errors']) {
                $response[$email]['result'] = true;
            }

            unset($item);
        }

        return json_encode([self::EMAILS_KEY => $response], JSON_THROW_ON_ERROR);
    }

    /**
     * Формирует список из входящего json
     *
     * @return array
     */
    protected static function makeListFromInput(): array
    {
        if ($json = file_get_contents('php://input')) {
            $data = json_decode($json, true);
            if (
                $data
                && $data[self::EMAILS_KEY]
            ) {
                return $data[self::EMAILS_KEY];
            }
        }

        return [];
    }

    protected static function checkRegExp(string $email): bool
    {
        $regExp = '/^((([0-9A-Za-z]{1}[-0-9A-z.]{1,}[0-9A-Za-z]{1})|([0-9А-Яа-я]{1}[-0-9А-я.]{1,}[0-9А-Яа-я]{1}))@([-0-9A-Za-z]{1,}\.){1,2}[-A-Za-z]{2,})$/u';
        return preg_match($regExp, $email) === 1;
    }

    protected static function checkDns(string $email): bool
    {
        return checkdnsrr(explode('@', $email)[1] ?: '', self::TYPE_MX);
    }
}
