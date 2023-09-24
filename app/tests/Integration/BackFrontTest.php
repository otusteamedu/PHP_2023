<?php

declare(strict_types=1);

namespace Integration;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BackFrontTest extends WebTestCase
{
    public function test_more_then_one_space_card_owner(): void
    {
        $client = static::createClient();

        $testData = $this->validData;
        $testData[1] = 'Le Be Dev';

        $crawler = $client->request('POST', '/api/payment/movie');
        $crawler->addContent(json_encode($testData));

        $this->assertSelectorExists('.card_holder error');
    }

    public function test_incorrect_symbols_card_number(): void
    {
        $client = static::createClient();

        $testData = $this->validData;
        $testData[0] = 'qwe';

        $crawler = $client->request('POST', '/api/payment/movie');
        $crawler->addContent(json_encode($testData));

        $this->assertSelectorExists('.card_number error');
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