<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw5\EmailVerificator;

use VKorabelnikov\Hw5\EmailVerificator\lib\Verificator;

class Application
{
    public function run()
    {
        $sEmailsArrayPostParamName = "emailsArray";

        if (empty($_POST[$sEmailsArrayPostParamName])) {
            throw new \Exception("Не передан параметр emailsArray");
        }

        if (!is_array($_POST[$sEmailsArrayPostParamName])) {
            throw new \Exception("Параметр emailsArray должен быть массивом");
        }

        $arInputEmails = $_POST[$sEmailsArrayPostParamName];

        $obVerificator = new Verificator($arInputEmails);
        $obVerificator->checkEmailsByRegexp();
        $obVerificator->checkEmailsByMxRecord();
    }
}
