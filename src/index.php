<?php

declare(strict_types=1);

require_once dirname(__DIR__).'/vendor/autoload.php';

use Imitronov\CbrfCurrencyRate\Client;

$cbrf = new Client();
$currencyRates = $cbrf->getCurrencyRates();

/**
 * Перебор всех доступных валют
 */
foreach ($currencyRates as $currencyRate) {
    echo sprintf(
        '1 %s = %s RUB' . PHP_EOL,
        $currencyRate->getCharCode(),
        $currencyRate->getRate()
    );
}

/**
 * Получение курса по нужной валюте
 */
$usdCurrencyRate = $cbrf->getCurrencyRateByCharCode('USD');

echo sprintf(
    '1 %s = %s RUB',
    $usdCurrencyRate->getCharCode(),
    $usdCurrencyRate->getRate(),
);
