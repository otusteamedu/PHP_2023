<?php

namespace App\Service;

use App\ElasticsearchBase;

class ElasticsearchStart extends ElasticsearchBase
{

    public function createIndex(): void
    {
        var_dump('createIndex');
        $this->client->indices()->create($this->getSettings());
    }

    public function bulkData(){

        $data = file_get_contents($this->getFileName());
        var_dump('$data: '. $data);

        // Проверяем, что файл содержит данные
        if (empty($data)) {
            die('Файл json пуст или отсутствует.');
        }

        $params = ['body' => $data];

        $response = $this->client->bulk($params);

        if ($response['errors'] === false) {
            echo 'Данные успешно загружены в Elasticsearch.';
        } else {
            echo 'При загрузке данных возникли ошибки: ' . json_encode($response['items']);
        }
    }

}

