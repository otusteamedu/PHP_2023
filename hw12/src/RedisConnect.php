<?php
declare(strict_types=1);

namespace Elena\Hw12;

use Predis\Client;

class RedisConnect
{
    public $r_client;

    public function __construct($scheme = 'tcp', $host = 'redis_db', $port = 6379)
    {
        $this->r_client = new Client([
            'scheme' => $scheme,
            'host' => $host,
            'port' => $port,
        ]);
    }

    public function add()
    {
        //Транзакция. Заполняю два сортированных списка и одну хэш-таблицу

        $file_s = file_get_contents(__DIR__ . '/../Data/data.json');
        $data = json_decode($file_s);
        $id = 0;

        foreach ($data as $one) {
            $id++;
            $this->r_client->executeRaw(['MULTI']);

            $zadd = $this->r_client->executeRaw(['ZADD', 'priority', $one->priority, '' . $id]);
            $zadd1 = $this->r_client->executeRaw(['ZADD', 'events', '' . $id, $one->event]);

            $arr_conditions = (array)$one->conditions;
            $keys = array_keys($arr_conditions);

            foreach ($keys as $param) {
                $hset = $this->r_client->executeRaw(['HSET', '' . $id, $param, $arr_conditions[$param]]);
            }

            $this->r_client->executeRaw(['EXEC']);

        }
        return 'success. Take the pie';
    }

    public function clear()
    {

        $response = $this->r_client->executeRaw(['FLUSHDB']);
        return 'cleared';
    }

    public function select_event($criteria)
    {

        $result = " Such criterias were not found";
        $priority = $this->r_client->executeRaw(['ZREVRANGE', 'priority', 0, -1]);
        foreach ($priority as $one) {
            $param_parent = $this->r_client->executeRaw(['HGETALL', '' . $one]);
            $param = [];
            for ($i = 0; $i < count($param_parent); $i += 2) {
                $param[$param_parent[$i]] = $param_parent[$i + 1];
            }
            if ($param == $criteria) {
                $event = $this->r_client->executeRaw(['ZREVRANGEBYSCORE', 'events', '' . $one, '' . $one]);
                $result = $event[0];
                break;
            }
        }
        return $result;
    }
}
