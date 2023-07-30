<?php

namespace IilyukDmitryi\App\Storage\Elastic;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Exception;
use IilyukDmitryi\App\Storage\Base\ChannelStorageInterface;
use IilyukDmitryi\App\Storage\Base\MovieStorageInterface;
use IilyukDmitryi\App\Storage\Base\StorageInterface;
use IilyukDmitryi\App\Storage\Elastic\Entity\ChannelStorage;
use IilyukDmitryi\App\Storage\Elastic\Entity\MovieStorage;

class ElasticStorage implements StorageInterface
{
    private Client $client;

    public function __construct($host, $port, $user, $pass)
    {
        $client = ClientBuilder::create()
            ->setHosts([$host . ':' . $port])
            //->setBasicAuthentication($user, $pass) // Пароль
            //->setCABundle('/data/mysite.local/http_ca.crt') // Сертификат
            ->build();
        $this->client = $client;
    }

    public function bulk($params)
    {
        $response = $this->client->bulk($params);

        if ($response['errors']) {
            foreach ($response['items'] as $item) {
                if (isset($item['index']['error'])) {
                    echo "Ошибка при добавлении документа с ID " . $item['index']['_id'] . ": ";
                    echo $item['index']['error']['reason'] . "\n";
                }
            }
            throw new Exception("Ошибка импорта данных");
        }
    }

    /**
     * @return mixed
     */
    public function getMovieStorage(): MovieStorageInterface
    {
        return new MovieStorage($this->client);
    }

    /**
     * @return mixed
     */
    public function getChannelStorage(): ChannelStorageInterface
    {
        return new ChannelStorage($this->client);
    }
}
