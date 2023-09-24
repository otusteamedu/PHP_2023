<?php

declare(strict_types=1);

namespace Application;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MoviePaymentTest extends WebTestCase
{
    public function test_incorrect_cvv(): void
    {
        $client = static::createClient();

        $testData = $this->validData;
        $testData[3] = 'qwe';

        $crawler = $client->request('POST', '/api/payment/movie');
        $crawler->addContent(json_encode($testData));

        $this->assertSelectorTextContains('.cvv__text', 'Не удалось списать данные с карты, проверьте реквизиты');
    }

    public function test_incorrect_order_number(): void
    {
        $client = static::createClient();

        $testData = $this->validData;
        $testData[4] = '';

        $crawler = $client->request('POST', '/api/payment/movie');
        $crawler->addContent(json_encode($testData));

        $this->assertSelectorTextContains('.orderNumber__text', 'Не удалось найти заказ по данному номеру');
    }

    private array $validData = [
        '1234567890123456',
        'Lebedev Vyacheslav',
        '08/24',
        123,
        'w34fa*%@#_idvkds',
        '1242,34'
    ];
}
