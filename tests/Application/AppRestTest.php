<?php

namespace Application;

use GuzzleHttp\Client;
use NdybnovHw03\CnfRead\ConfigStorage;
use PHPUnit\Framework\TestCase;

class AppRestTest extends TestCase
{
    public function testRun(): void
    {
        $configStorage = (new ConfigStorage())
            ->fromDotEnvFile([dirname(__DIR__, 2), '.env']);

        $httpClient = new Client();
        $host = 'http://' . $configStorage->get('NGINX_DOCKER_HOST');

        $tryCount = 2;
        for ($i=0; $i<$tryCount; $i++) {
            $req = $httpClient->post(
                $host . '/add',
                [
                    'form_params' => [
                        'info' => 'info-test',
                        'uuid' => '321',
                    ]
                ]
            );

            $realStatusCode = $req->getStatusCode();
            $this->assertTrue(
                (200 <= $realStatusCode) && ($realStatusCode <= 299),
                'Is Success Status Code : ' . $realStatusCode
            );

            $responseContent = $req->getBody()->getContents();
            $decoded = \json_decode($responseContent, true, 512, JSON_THROW_ON_ERROR);

            $this->assertTrue(isset($decoded['success']), 'Has success');
            $this->assertTrue($decoded['success'], 'Is True success');
            $this->assertTrue(isset($decoded['data']['uuid']), 'Has data.uuid');

            $uuid = $decoded['data']['uuid'];
            $req = $httpClient->get(
                $host . '/status?uuid=' . $uuid
            );

            sleep(1);
            $realStatusCode = $req->getStatusCode();
            $this->assertTrue(
                (200 <= $realStatusCode) && ($realStatusCode <= 299),
                'Is Success Status Code : ' . $realStatusCode
            );
        }

        $responseContent = $req->getBody()->getContents();
        $decoded = \json_decode($responseContent, true, 512, JSON_THROW_ON_ERROR);
        $this->assertTrue(isset($decoded['success']), 'Has success');
        $this->assertTrue($decoded['success'], 'Is True success');

        $this->assertTrue(isset($decoded['data']['status']), 'Has data.status');
        $this->assertTrue(isset($decoded['data']['uuid']), 'Has data.uuid');

        $this->assertEquals('start', $decoded['data']['status'], 'Is `start` status');
        $this->assertEquals($uuid, $decoded['data']['uuid'], 'Is equal uuid');

        // процесс обработки очереди запускается с докер-композ`ером
        // внутри пауза - для прохождения тестов!
        // ! команда консольная запускается при старте докер-контейнера !
        $pause = $configStorage->get('QA_PAUSE_IN_WATCH_QUEUE') ?? 0;
        sleep($pause + 2);

        $req = $httpClient->get(
            $host . '/status?uuid=' . $uuid
        );

        $realStatusCode = $req->getStatusCode();
        $this->assertTrue(
            (200 <= $realStatusCode) && ($realStatusCode <= 299),
            'Is Success Status Code : ' . $realStatusCode
        );

        $responseContent = $req->getBody()->getContents();
        $decoded = \json_decode($responseContent, true, 512, JSON_THROW_ON_ERROR);
        $this->assertTrue(isset($decoded['success']), 'Has success');
        $this->assertTrue($decoded['success'], 'Is True success');

        $this->assertTrue(isset($decoded['data']['status']), 'Has data.status');
        $this->assertTrue(isset($decoded['data']['uuid']), 'Has data.uuid');

        $this->assertEquals('complete', $decoded['data']['status'], 'Is `complete` status');
        $this->assertEquals($uuid, $decoded['data']['uuid'], 'Is equal uuid');
    }
}
