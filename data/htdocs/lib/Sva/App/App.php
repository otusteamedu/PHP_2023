<?php

namespace Sva\App;

use Sva\App\Exceptions\UnknownMode;
use Exception;

class App
{
    public Config $config;

    /**
     * @return void
     * @throws UnknownMode
     * @throws Exception
     */
    public function run()
    {
        $this->config = Config::getInstance();
        $mode = $this->config->get('mode');

        if ($mode == 'server') {
            $this->startServer();
        } elseif ($mode == 'client') {
            $this->startClient();
        } else {
            throw new UnknownMode($mode);
        }
    }

    /**
     * @throws Exception
     */
    private function startServer(): void
    {
        foreach ((new ServerMode())->start() as $line) {
            echo $line;
        }
    }

    /**
     * @throws Exception
     */
    private function startClient(): void
    {
        foreach ((new ClientMode())->start() as $line) {
            echo $line;
        }
    }
}
