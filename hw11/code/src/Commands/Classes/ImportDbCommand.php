<?php

namespace Gkarman\Otuselastic\Commands\Classes;

class ImportDbCommand extends AbstractCommand
{
    public function run(): string
    {
        $data = $this->getJSON();
        $result = $this->sendRequest($data);

        return $result;
    }

    private function getJSON(): string
    {
        return file_get_contents("src/Storage/books.json");
    }

    private function sendRequest(string $data): string
    {
        $ch = curl_init('http://elasticsearch:9200/_bulk/');
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type:application/json']);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);

        $res = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($res, 1);
        $result = empty($res['errors']) ? 'ok' : 'есть ошибки при добавлении';

        return $result;
    }
}
