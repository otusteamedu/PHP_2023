<?php

namespace Common\Domain;

use Exception;

class Phone
{
    private string $phone;

    /**
     * @throws Exception
     */
    public function __construct(string $phone)
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);

        if(str_starts_with($phone, '+7') && mb_strlen($phone) == 12) {
            $phone = mb_substr($phone, 2);
        } elseif (str_starts_with($phone, '8') && mb_strlen($phone) == 11) {
            $phone = mb_substr($phone, 1);
        } elseif (str_starts_with($phone, '7') && mb_strlen($phone) == 11) {
            $phone = mb_substr($phone, 1);
        }

        if(mb_strlen($phone) != 10) {
            throw new Exception('Неверный формат телефона');
        }

        $this->phone = $phone;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getPhoneWithPlusSeven():string
    {
        return '+7' . $this->phone;
    }

    public function getPhoneWithEight():string
    {
        return '8' . $this->phone;
    }

    public function getPhoneWithSeven():string
    {
        return '7' . $this->phone;
    }
}
