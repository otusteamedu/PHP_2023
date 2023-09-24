<?php

declare(strict_types=1);

namespace Integration;

use App\Repository\PaymentRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BackRepoTest extends WebTestCase
{
    public function test_success_payment(): void
    {
        $testData = $this->validData;
        $testData[0] = '1234567890123455';

        $client = static::createClient();
        $crawler = $client->request('POST', '/api/payment/movie');
        $crawler->addContent(json_encode($testData));

        $repo = new PaymentRepository();
        $element = $repo->findById($testData[4]);

        $this->assertEquals($testData, $element);
    }

    public function test_failed_payment(): void
    {
        $testData = $this->validData;
        $testData[0] = '1234567890123456';

        $client = static::createClient();
        $crawler = $client->request('POST', '/api/payment/movie');
        $crawler->addContent(json_encode($testData));

        $repo = new PaymentRepository();
        $element = $repo->findById($testData[4]);

        $this->assertEquals(null, $element);
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
