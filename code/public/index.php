
<p>Суммарное кол-во лайков и дизлайков для канала по всем его видео</p>

<form>
    <p>Название канала</p>
    <input type="text"></input>
    <input type="submit"></input>
</form>

<hr hoshade>

<p>Топ N каналов с лучшим соотношением кол-во лайков/кол-во дизлайков</p>

<form>
    <p>Введите число</p>
    <input type="text"></input>
    <input type="submit"></input>
</form>


<?php
require __DIR__ . "/../vendor/autoload.php";

use Elastic\Elasticsearch\ClientBuilder;

// $test = file_get_contents('https://elastic:test@elasticsearch:9200');//gethostbyname("elasticsearch");
// var_dump($test);


$client = ClientBuilder::create()
->setHosts(['https://es01:9200']) // https!
->setBasicAuthentication('elastic', '1xb=dOa*Rj0goqD_jWZv') // Пароль
 ->setCABundle('/data/mysite.local/http_ca.crt') // Сертификат
->build();

var_dump($client->info());

