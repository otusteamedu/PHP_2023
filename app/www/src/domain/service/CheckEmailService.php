<?php

namespace Root\Www\Domain\Service;

use Root\Www\Exception\ValidationException;

/**
 * Service.
 */
final class CheckEmailService
{
    public $validation;

    public function __construct(ValidationException $validation)
    {
        $this->validation = $validation;
    }

    public function run($data): string | array
    {
        if (!array_key_exists('emails', $data)) {
            return "Передайте список emails";
        }
        $list = $this->parser($data['emails']);
        foreach ($list as $email) {
            $this->validateEmail($email);
        }

        if ($this->validation->getErrors()) {
            return json_encode($this->validation->getErrors(), JSON_UNESCAPED_UNICODE);
        }
        return 'Список emails обработан успешно!';
    }

    private function parser(string $str): array
    {
        return explode(',', str_replace(' ', '', $str));
    }

    private function validateEmail(string $email): void
    {
        $pattern = '/^[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?$/';
        if (empty($email)) {
            $this->validation->addError("Пустое значение в списке Emails");
        } elseif (!preg_match($pattern, $email)) {
            $this->validation->addError("Неверный адрес электронной почты [{$email}]");
        } elseif (!$this->checkDomain($email)) {
            $this->validation->addError("Ошибка доменого имени для [{$email}]");
        }
    }

    private function checkDomain($email): bool
    {
        $domain = substr(strrchr($email, "@"), 1);
        $res = getmxrr($domain, $mx_records, $mx_weight);
        if (false == $res || 0 == count($mx_records) || (1 == count($mx_records) && ($mx_records[0] == null  || $mx_records[0] == "0.0.0.0" ) )) {
            return false;
        }
        return true;
    }
}
