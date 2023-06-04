<?php

class VerificationData
{
    function email($arEmails){

        $re = '/.*@(.*\..*)/m';

        foreach($arEmails as $key => $email){
            preg_match_all($re, $email, $matches, PREG_SET_ORDER);
            if (!empty($matches)) {
                getmxrr($matches[0][1], $hosts);
                if($hosts[0]){
                    $arEmails[$key] = [
                        $email, 
                        [
                            'STATUS' => 'SUCCESS',
                            'RESULT' => 'На почту можно отправить письмо!'
                        ]
                    ];
                }else{
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
}