<?php

namespace App\Service;

use App\ElasticsearchBase;

class ElasticsearchCleanup extends ElasticsearchBase
{

    public function clearIndex()
    {

        // Удаляем все документы из индекса
        $params = [
            'index' => $this->getIndexName(),
            'body' => [
                'query' => [
                    'match_all' => (object)[]
                ]
            ]
        ];
        $this->client->deleteByQuery($params);

        // Ждем, чтобы документы полностью удалились
        sleep(1);

        // Удаляем сам индекс
        $this->client->indices()->delete(['index' => $this->getIndexName()]);

        echo 'Индекс успешно очищен и удален.';
    }

}
