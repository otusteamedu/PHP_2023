<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw5\EmailVerificator\lib;

class Verificator
{
    private $arEmailAddressesList;

    public function __construct(array $arEmailAddressesList)
    {
        foreach ($arEmailAddressesList as $value) {
            if (!is_string($value)) {
                throw new \Exception("В массиве найдено значение, не являющееся строкой.");
            }
        }

        $this->arEmailAddressesList = $arEmailAddressesList;
    }

    public function checkEmailsByRegexp(): void
    {
        foreach ($this->arEmailAddressesList as $sEmailAddress) {
            if (preg_match("/^[^@.]+\@[^@]+\.[^@]+$/", $sEmailAddress) !== 1) {
                throw new \Exception("Найден невалидный email: " . $sEmailAddress);
            }
        }
    }

    public function checkEmailsByMxRecord(): void
    {
        foreach ($this->arEmailAddressesList as $sEmailAddress) {
            $sEmailDomain = $this->getDomainFromEmailAddress($sEmailAddress);

            if (!$this->isDomainExisis($sEmailDomain)) {
                //Проверка не пройдена - нормальные mx-записи не обнаружены
                throw new \Exception("Не найдено MX записи для домена: $sEmailDomain");
            }
        }
    }

    protected function getDomainFromEmailAddress(string $sEmailAddress): string
    {
        return mb_substr(mb_strrchr($sEmailAddress, "@"), 1);
    }

    protected function isDomainExisis(string $sEmailDomain): bool
    {
        $bMxRecordsSearchRes = getmxrr($sEmailDomain, $arMxRecords, $arMxWeights);
        return $this->mxFoundCondition($bMxRecordsSearchRes, $arMxRecords);
    }

    protected function mxFoundCondition(bool $bMxRecordsSearchRes, array $arMxRecords): bool
    {
        if ($bMxRecordsSearchRes === false) {
            return false;
        } else if (count($arMxRecords) == 0) {
            return false;
        } else if (
            (count($arMxRecords) >= 1)
            && (
                ($arMxRecords[0] == null)
                || ($arMxRecords[0] == "0.0.0.0")
            )
        ) {
            return false;
        }

        return true;
    }
}
