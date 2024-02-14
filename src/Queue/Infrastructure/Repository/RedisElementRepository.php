<?php

declare(strict_types=1);

namespace src\Queue\Infrastructure\Repository;

use Predis\Client;
use src\Queue\Application\Factory\ElementFactory;
use src\Queue\Application\Factory\ElementFactoryInterface;
use src\Queue\Domain\Entity\Element;
use src\Queue\Domain\Repository\ElementRepositoryInterface;

class RedisElementRepository implements ElementRepositoryInterface
{
    protected Client $client;
    private ElementFactoryInterface $elementFactory;
    const KEY = 'element:';

    public function __construct()
    {
        $env = parse_ini_file(__DIR__ . '/../../../../.env');
        $connectionParameters = sprintf(
            '%s://%s:%s',
            'tcp',
            $env['QUEUE_HOST'],
            $env['QUEUE_PORT']
        );
        $this->client = new Client($connectionParameters);
        $this->elementFactory = new ElementFactory();
    }

    public function get(string $uuid): ?Element
    {
        $response = $this->getElement($this->getKey($uuid));
        if (!$response) {
            return null;
        }
        return $this->elementFactory->fromRedisResponse($response);
    }

    public function add(Element $element): void
    {
        $this->client->set(
            $this->getKey($element->getUuid()),
            json_encode([
                'uuid' => $element->getUuid(),
                'body' => $element->getBody(),
                'status' => $element->getStatus()
            ])
        );
    }

    public function delete(string $uuid): void
    {
        $this->client->del($this->getKey($uuid));
    }

    public function readAll(): array
    {
        $keys = $this->client->keys(self::KEY . '*');
        $out = [];
        foreach ($keys as $key) {
            $element = $this->getElement($key);
            if ($element !== null) {
                $out[] = $this->elementFactory->fromRedisResponse($element);
            }
        }
        return $out;
    }

    private function getElement(string $key): ?array
    {
        $response = $this->client->get($key);
        if (!$response) {
            return null;
        }
        return json_decode($response, true);
    }

    private function getKey(string $uuid): string
    {
        return self::KEY . $uuid;
    }
}
