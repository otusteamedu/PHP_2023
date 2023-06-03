<?php

namespace IilyukDmitryi\App;

use IilyukDmitryi\App\Config;
use IilyukDmitryi\App\Workers\Workers;
use InvalidArgumentException;

class App
{
    private Config\ConfigProvider $configProvider;
    private Workers $worker;

    public function __construct(Config\ConfigProvider $configProvider)
    {
        $this->configProvider = $configProvider;
    }

    public function run(): void
    {
        $this->init();
        $this->worker->run();
    }

    private function init(): void
    {
        $behaviorProvider = static::createObject($this->configProvider->getNameClassBehaviorProvider());
        if ($behaviorProvider->isServer()) {
            $this->worker = static::createObject($this->configProvider->getNameClassServerWorker());
        } elseif ($behaviorProvider->isClient()) {
            $this->worker = static::createObject($this->configProvider->getNameClassClientWorker());
        } else {
            throw new InvalidArgumentException('Unknown worker');
        }
    }

    private static function createObject(string $className)
    {
        if (empty($className) || !class_exists($className)) {
            throw new InvalidArgumentException("Unknown class " . $className);
        }
        return new $className();
    }
}
