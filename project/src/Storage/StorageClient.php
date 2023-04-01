<?php

declare(strict_types=1);

namespace Vp\App\Storage;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use Vp\App\Config;

trait StorageClient
{
    /**
     * @throws AuthenticationException
     */
    public function getClient(): Client
    {
        return ClientBuilder::create()
            ->setHosts(['elasticsearch:' . Config::getInstance()->getPort()])
            ->setBasicAuthentication(Config::getInstance()->getUser(), Config::getInstance()->getPassword())
            ->build();
    }
}
