<?php

/**
 * Класс для поиска в эластике
 * php version 8.2.8
 *
 * @category ItIsDepricated
 * @package  AmedvedevPHP2023Otus
 * @author   Alex 150Rus <alex150rus@outlook.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @Version  GIT: 1.0.0
 * @link     http://github.com/Alex150Rus My_GIT_profile
 */

declare(strict_types=1);

namespace Amedvedev\code\applications\elastic\services\search;

use Amedvedev\code\applications\console\entities\Book;
use Amedvedev\code\applications\elastic\presenters\ConsolePresenter;
use Amedvedev\code\applications\elastic\storages\ElasticStorage;
use Amedvedev\code\applications\elastic\storages\Storage;
use Amedvedev\code\config\Config;

class ConsoleSearchService extends SearchService
{
    private readonly Storage $storage;
    private readonly ConsolePresenter $presenter;

    public function __construct()
    {
        $this->storage = new ElasticStorage();
        $this->presenter = new ConsolePresenter();
    }

    /**
     * Стратегия выбора метода
     * @param array $data
     * @param int $argc
     * @return void
     */
    public function strategy(array $data, int $argc): void
    {
        switch ($data[$argc - 1] ?? '') {
            case 'check':
                $this->check();
                break;
            case 'init':
                $this->init();
                break;
            case 'search':
                $this->search();
                break;
            default:
                $this->help();
        }
    }

    /**
     * Справка по коммандам
     * @return void
     */
    public function help(): void
    {
        echo PHP_EOL . 'Это консольное приложение для поиска по товарам. ' . PHP_EOL .
            'Команды для работы: ' . PHP_EOL .
            'init - для построения индекса по books.json' . PHP_EOL .
            '-fname init - для построения индекса по name.json' . PHP_EOL .
            'check - проверка соединения с сервисом поиска' . PHP_EOL .
            'параметры search - поиск' . PHP_EOL .
            'параметры: -tтекст -pцена -cкатегория -iиндекс' . PHP_EOL .
            'Пример команды: app.php check' . PHP_EOL .
            'Пример команды: app.php -tрыцори -p2000 -с"исторический роман" -iotus-shop search' . PHP_EOL . PHP_EOL;
    }

    /**
     * Метод проверки работоспособности сервиса поиска
     * @return void
     */
    public function check(): void
    {
        echo $this->storage->info();
    }

    /**
     * @return void
     */
    public function init(): void
    {
        $filename = 'books';

        $options = getopt('f::');
        if (!empty($options['f'])) {
            $filename = $options['f'];
        }

        $fileExtension = '.json';
        $file = file(Config::get('project_dir') . 'db/json/' . $filename . $fileExtension);

        if (!$file) {
            echo 'файл ' . $filename . $fileExtension . ' не существует' . PHP_EOL;
            exit();
        }

        $params = [];
        foreach ($file as $string) {
            $json = json_decode($string, true);
            if (str_contains($string, 'create')) {
                $params['index'] = $json['create']['_index'];
                $params['id'] = $json['create']['_id'];
                continue;
            }

            $params += $json;
            //в будущем можно подумать про паттерн абстрактная фабрика для других сущностей
            $entity = new Book($params);
            $entity->save($this->storage);
            $params = [];
        }

        echo 'Индекс создан' . PHP_EOL;
    }

    /**
     * @return void
     */
    public function search(): void
    {
        //php app.php -tрыцори -iotus-shop search
        //php app.php -tрыцори -p1000 -iotus-shop search
        //php app.php -tрыцори -p1000 -cдетектив -iotus-shop search
        //php app.php -tрыцори -p1000 -c"исторический роман" -iotus-shop  search
        //php app.php -tрыцори -p1000 -cисторический -iotus-shop search
        //php app.php -tрыцори -cисторический -iotus-shop search
        $hits = $this->storage->search(getopt('p::t::c::i::'));

        if (empty($hits)) {
            echo 'ничего не найдено';
            exit();
        }
        $this->presenter->showTextTable($hits);
    }
}
