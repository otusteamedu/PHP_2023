<?php

declare(strict_types=1);

namespace Storage;

use Storage\Interface\StorageInterface;
use MongoDB\Client;

class MongoStorage extends Storage implements StorageInterface
{  
    const DB = 'myDb';

     public function buildClient(): void
     {
        $this->client = new Client("mongodb://root:123456@mongo:27017");
     }

     public function add($key, $score, $events): int | null
     {
        $db = $this->client->selectDatabase(self::DB);

        $collection = $db->selectCollection($key);
        if (!$collection) {
            $collection = $db->createCollection($key);
            $collection->createIndex(['event' => 1], ['unique' => true]);
        }
        $res = $collection->insertOne([
            'score' => $score,
            'event' => $events
        ]);

        return $res->getInsertedCount();
     }

     public function delete($key): bool | int
     { 
        $db = $this->client->selectDatabase(self::DB);
        $res = $db->dropCollection($key);

        return (int) $res->ok;
     }

     public function get($key): array | null
     {   
        $data = [];
        $db = $this->client->selectDatabase(self::DB);
        $col = $db->selectCollection($key);
        foreach ($col->find([], ['sort' => ['score' => -1]]) as $doc) { 
            $data[$doc->event] = $doc->score;
        }
        return $data;
     }

     public function getAll(): array
     {
        $data = [];
        $db = $this->client->selectDatabase(self::DB);
        foreach ($db->listCollectionNames() as $collectionName) {
            $col = $db->selectCollection($collectionName);
            foreach ($col->find([]) as $doc) { 
                $data[$collectionName][] = [
                    'score' => $doc->score,
                    'event' => $doc->event
                ];
            } 
        }
        return $data;
     }

     public function getKey($conditions): string
     {
        $key = 'events:';
        foreach ($conditions as $k => $v) {
          $key .= $k . ':' . $v . '|';
        }
        return substr($key, 0, -1);
     }

     public function hasKey($key, $event): bool | int
     {
          return 0;
     }
}
