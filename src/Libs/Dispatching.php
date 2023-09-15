<?php

namespace Rofflexor\Hw\Libs;

use Exception;

class Dispatching
{
    /**
     * @throws Exception
     */
    public function dispatch(array $argv) {
        $serviceName = 'Rofflexor\Hw\Services\\'.ucfirst($argv[1]).'Service';
        if(isset($argv[1]) && class_exists($serviceName)) {
            return new $serviceName();
        }
        return throw new Exception('Service '.$serviceName.' not found');
    }
}