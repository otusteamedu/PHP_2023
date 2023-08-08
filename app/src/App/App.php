<?php

declare(strict_types=1);

namespace DEsaulenko\Hw12\App;

use DEsaulenko\Hw12\Constants;
use DEsaulenko\Hw12\Controller\ControllerInterface;
use DEsaulenko\Hw12\Controller\RedisController;
use DEsaulenko\Hw12\Storage\RedisStorage;
use DEsaulenko\Hw12\Storage\StorageInterface;
use Dotenv\Dotenv;

class App
{
    public const NO_DEFAULT_STORAGE = 'Set DEFAULT_STORAGE in .env';
    public const NO_METHOD_ARGV = 'Не задан метод method';
    public const NO_DATA_ARGV = 'Не передан json в data';
    public const UNKNOWN_METHOD = 'Unknown method';
    public const NO_DATA_GET = 'Не переданы данные выборки';
    public const NO_DATA_ADD = 'Не переданы данные для добавления';
    public const WRONG_METHOD = 'WRONG METHOD';
    protected string $method;
    protected string $data = '';

    protected ControllerInterface $controller;
    protected StorageInterface $storage;

    public function __construct()
    {
        Dotenv::createUnsafeImmutable(realpath(__DIR__ . '/../../'))->load();
        $this->prepareData();
        $this->init();
    }

    /**
     * Поддерживает методы:
     * <ul>
     * <li>
     * PUT - добавление даннах в формате
     * {"priority":1000,"conditions":["param1=1"],"event":"::event::"}
     * </li>
     * <li>
     * GET - получение нужного события, требует json
     * {"params": ["param1=1", "param2=2"]}
     * </li>
     * <li>
     * DELETE - очистка хранилища
     * </li>
     * </ul>
     *
     * @return void
     * @throws \Exception
     */
    public function run(): void
    {
        switch ($this->method) {
            case Constants::METHOD_ADD:
                if (empty($this->data)) {
                    throw new \Exception(self::NO_DATA_ARGV);
                }
                $this->controller->add($this->data);
                break;
            case Constants::METHOD_GET:
                echo $this->controller->getEvent($this->data);
                break;
            case Constants::METHOD_DELETE:
                $this->controller->deleteAll();
                break;
            default:
                throw new \Exception(self::UNKNOWN_METHOD);
        }
    }

    /**
     * Инициализирует хранилище и контроллер
     *
     * @return void
     * @throws \Exception
     */
    protected function init(): void
    {
        $typeStorage = getenv(Constants::DEFAULT_STORAGE);
        switch ($typeStorage) {
            case Constants::STORAGE_REDIS:
                $this->storage = new RedisStorage();
                $this->controller = new RedisController($this->storage);
                break;
            default:
                throw new \Exception(self::NO_DEFAULT_STORAGE);
        }
    }

    protected function prepareData(): void
    {
        /**
         * Для запуска с консоли
         */
        if (!$_SERVER['REQUEST_METHOD']) {
            $this->prepareFromArgv();
            return;
        }

        /**
         * Для методов PUT, DELETE, GET
         */
        $this->prepareFromRequest();
    }

    protected function prepareFromArgv(): void
    {
        global $argv;
        foreach ($argv as $arg) {
            if (mb_strpos($arg, 'method') !== false) {
                $method = explode('=', $arg);
            }
            if (mb_strpos($arg, 'data') !== false) {
                $data = explode('=', $arg);
            }
            if (mb_strpos($arg, 'file') !== false) {
                $data = [
                    0 => 'data',
                    1 => file_get_contents(__DIR__ . '/../../' . explode('=', $arg)[1])
                ];
            }
        }

        if (
            !$method
            || !$method[1]
        ) {
            throw new \Exception(self::NO_METHOD_ARGV);
        }
        $this->method = $method[1];

        if (
            $data
            && $data[1]
        ) {
            $this->data = $data[1];
        }
    }

    protected function prepareFromRequest(): void
    {
        $rawBody = file_get_contents('php://input');

        $this->data = $rawBody;
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                $this->method = Constants::METHOD_GET;
                if (!$rawBody) {
                    throw new \Exception(self::NO_DATA_GET);
                }
                break;
            case 'PUT':
                $this->method = Constants::METHOD_ADD;
                if (!$rawBody) {
                    throw new \Exception(self::NO_DATA_ADD);
                }
                break;
            case 'DELETE':
                $this->method = Constants::METHOD_DELETE;
                break;
            default:
                throw new \Exception(self::WRONG_METHOD);
        }
    }
}
