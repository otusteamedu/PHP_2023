<?php

namespace App;

use App\Exception\AppException;

class App
{
    /** @var string  */
    protected const SERVER = 'server';

    /** @var string  */
    protected const CLIENT  = 'client';

    /** @var string */
    protected string $mode;

    /**
     * @throws AppException
     */
    public function __construct()
    {
        if (!isset($argv[1])) {
            throw new AppException('The application must be started with one of the arguments: server, client');
        }

        $this->mode = $argv[1];
    }

    /**
     * @return void
     * @throws AppException
     */
    public function run(): void
    {
        switch ($this->mode) {
            case static::SERVER:
                $this->runServer();
                break;
            case static::CLIENT:
                $this->runClient();
                break;
            default:
                //TODO
                break;
        }
    }

    /**
     * @return void
     * @throws AppException
     */
    protected function runServer(): void
    {
        //TODO
    }

    /**
     * @return void
     * @throws AppException
     */
    protected function runClient(): void
    {
        //TODO
    }

}