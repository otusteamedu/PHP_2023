<?php

namespace IilyukDmitryi\App\Storage\Elastic;

use Elastic\Elasticsearch\Client;
use IilyukDmitryi\App\Storage\Base\MovieStorageInterface;
use IilyukDmitryi\App\Storage\Base\ChannelStorageInterface;
use IilyukDmitryi\App\Storage\Elastic\Entity\MovieStorage;
use IilyukDmitryi\App\Storage\Elastic\Entity\ChannelStorage;
use IilyukDmitryi\App\Storage\Base\StorageInterface;

use Elastic\Elasticsearch\ClientBuilder;

class ElasticStorage implements StorageInterface
{
    private Client $client;

    public function __construct($host,$port,$user,$pass)
    {
    // $test = file_get_contents('https://elastic:test@elasticsearch:9200');//gethostbyname("elasticsearch");
    // var_dump($test);

    $client = ClientBuilder::create()
        ->setHosts([$host.':'.$port])
        //->setBasicAuthentication($user, $pass) // Пароль
        //->setCABundle('/data/mysite.local/http_ca.crt') // Сертификат
        ->build();
    $this->client = $client;

       // echo '<pre>' . print_r([$client], 1) . '</pre>' . __FILE__ . ' # ' . __LINE__;//test_delete

        /*
        $client = ClientBuilder::create()
        ->setHosts(['http://elastic:9200'])
        //->setBasicAuthentication('elastic', 'secret') // Пароль
        /// ->setCABundle('/data/mysite.local/http_ca.crt') // Сертификат
        ->build();
        */

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
            throw new \Exception("Ошибка импорта данных");
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