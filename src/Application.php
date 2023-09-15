<?php

namespace Rofflexor\Hw;

use Exception;
use Rofflexor\Hw\Libs\Dispatching;

class Application
{

    /**
     * @throws Exception
     */
    public function run(array $argv) {
        return (new Dispatching())->dispatch($argv)->start();
    }

}