<?php

declare(strict_types=1);

namespace Dpankratov\Hw4\Requests;

class EmailValidation
{
    public function email($arEmails)
    {

        $re = '/.*@(.*\..*)/m';

        foreach ($arEmails as $key => $email) {
            preg_match_all($re, $email, $matches, PREG_SET_ORDER);
            if (!empty($matches)) {
                getmxrr($matches[0][1], $hosts);
                if ($hosts[0]) {
                    $arEmails[$key] = [
                        $email,
                        [
                            'STATUS' => 'SUCCESS',
                            'RESULT' => 'Коректный адрес электронной почты'
                        ]
                    ];
                } else {
                    $arEmails[$key] = [
                        $email,
                        [
                            'STATUS' => 'ERROR',
                            'RESULT' => 'Для домена не найдена МХ запись'
                        ]
                    ];
                }
            } else {
                $arEmails[$key] = [
                    $email,
                    [
                        'STATUS' => 'ERROR',
                        'RESULT' => 'Не корретно указан адрес электронной почты. Не указаны символы @ или .'
                    ]
                ];
            }
        }

        return $arEmails;
    }
}
