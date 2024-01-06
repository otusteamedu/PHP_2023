<?php

namespace App\Application\Action\Notifier;

use App\Application\Action\Notify\NotifyInterface;
use NdybnovHw03\CnfRead\Storage;

class Notifier implements RunnableInterface
{
    private array $notifies;
    private Storage $cnf;

    public function __construct(Storage $cnf)
    {
        $this->cnf = $cnf;
    }

    public function add(string $classNotify): void
    {
        $type = $this->getTypeFromClassName($classNotify);
        $this->notifies[$type] = new $classNotify($this->cnf);
    }

    private function getTypeFromClassName(string $classNotify): string
    {
        $onlyClass = explode('\\', $classNotify);
        $shortClassName = $onlyClass[count($onlyClass) - 1];
        $notifyPos = strpos($shortClassName, 'Notify');
        $typeName = substr($shortClassName, 0, $notifyPos);
        $type = strtolower($typeName);

        return $type;
    }

    public function getNotifyTypes(): array // or hasType byKey
    {
        return array_keys($this->notifies);
    }

    public function run(string $content): void
    {
        foreach ($this->notifies as $notify)
        {
            /** @var NotifyInterface $notify */
            $notify->send($content);
        }
    }
}
