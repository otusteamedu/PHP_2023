<?php

declare(strict_types=1);

namespace Dmitryesaulenko\Php2023;

class Email
{
    const TYPE_MX = 'MX';
    const EMAILS_KEY = 'email_list';

    protected array $emailList;

    public function __construct()
    {
        $this->emailList = $this->makeListFromInput();

        if (!$this->emailList) {
            throw new \Exception(
                Response::ERROR_EMPTY_REQUEST,
                Response::EMPTY_REQUEST_STATUS
            );
        }
    }

    public function verify(): string
    {
        $this->checkList();
        return json_encode($this->emailList, JSON_THROW_ON_ERROR);
    }

    protected function checkList(): void
    {
        foreach ($this->emailList as $email => &$res) {
            $res['result'] = false;
            if (!$this->checkRegExp((string)$email)) {
                $res['errors'][] = Response::ERROR_REGEXP;
                continue;
            }

            if (!$this->checkDns((string)$email)) {
                $res['errors'][] = Response::ERROR_DNS;
            }

            if (!$res['errors']) {
                $res['result'] = true;
            }
        }
        unset($res);
    }

    /**
     * Формирует список из входящего json
     *
     * @return array
     */
    protected function makeListFromInput(): array
    {
        if ($json = file_get_contents('php://input')) {
            $data = json_decode($json, true);
            if (
                $data
                && $data[self::EMAILS_KEY]
            ) {
                $emailList = [];
                foreach ($data[self::EMAILS_KEY] as $email) {
                    $emailList[$email] = [];
                }
                return $emailList;
            }
        }

        return [];
    }

    protected function checkRegExp(string $email): bool
    {
        $regExp = '/^((([0-9A-Za-z]{1}[-0-9A-z.]{1,}[0-9A-Za-z]{1})|([0-9А-Яа-я]{1}[-0-9А-я.]{1,}[0-9А-Яа-я]{1}))@([-0-9A-Za-z]{1,}\.){1,2}[-A-Za-z]{2,})$/u';
        return preg_match($regExp, $email) === 1;
    }

    protected function checkDns(string $email): bool
    {
        return checkdnsrr(explode('@', $email)[1] ?: '', self::TYPE_MX);
    }
}
