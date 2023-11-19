<?php
require_once __DIR__ . '/vendor/autoload.php';

$curl = curl_init();

$url = "http://localhost:9200/otus-shop/_search";

$headers = array(
    "Accept: application/json",
    "Content-Type: application/json",
);

$data = <<<DATA
{
  "from": 0,
  "size": 1,
  "sort": [
        {"price": "desc"}
    ],
  "query": {
    "match_all": {}
  }
}
DATA;

curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$resp = curl_exec($curl);
curl_close($curl);

echo $resp;
