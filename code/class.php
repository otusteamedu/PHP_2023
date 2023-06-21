<?php

namespace Vendor\HomeWork;

class EmailVerifier
{
    public function verify(array $arEmails)
    {

        $re = '/.*@(.*\..*)/m';

        foreach ($arEmails as $key => $email) {
            $this->pregMatchAll($re, $email, $matches);
            if (!$this->emptyMatches($matches)) {
                $this->getMxRr($matches, $hosts);

                if (!$this->emptyMatches($hosts)) {
                    $arEmails[$key] = [
                        $email,
                        [
                            'STATUS' => 'SUCCESS',
                            'RESULT' => 'На почту можно отправить письмо!'
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
                        'RESULT' => 'Не корретно указана почта. Не найдены спецсимволы @ или .'
                    ]
                ];
            }
        }

        return $arEmails;
    }

    public function pregMatchAll($re, $email, &$matches)
    {
        preg_match_all($re, $email, $matches, PREG_SET_ORDER);
    }

    public function getMxRr($matches, &$hosts)
    {
        getmxrr($matches[0][1], $hosts);
    }

    public function emptyMatches($matches)
    {
        return empty($matches);
    }
}
