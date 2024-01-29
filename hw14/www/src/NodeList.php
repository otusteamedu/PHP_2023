<?php

namespace Shabanov\Otusphp;

class NodeList
{
    private int $value;
    private ?self $next = null;

    public function __construct(int $value)
    {
        $this->value = $value;
    }
    public function getValue(): int
    {
        return $this->value;
    }

    public function getNext(): ?self
    {
        return $this->next;
    }

    public function setNext(?self $next): self
    {
        $this->next = $next;
        return $this;
    }

    public static function setFromArray(array $data, ?int $posCycle = null): ?self
    {
        $head = $current = $nodeCycle = null;
        if (!empty($data)) {
            foreach($data as $k=>$v) {
                $node = new self($v);
                if ($head === null) {
                    $head = $node;
                    $current = $head;
                } else {
                    $current->setNext($node);
                    $current = $current->getNext();
                }

                if (isset($posCycle) && $posCycle == $k) {
                    $nodeCycle = $node;
                }
            }

            if (!empty($nodeCycle)) {
                $current->setNext($nodeCycle);
            }
        }
        return $head;
    }

    public static function hasCycle(self $head): bool
    {
        $hash = [];
        while($head !== null) {
            $objectId = spl_object_id($head);

            if (isset($hash[ $objectId ])) {
                return true;
            }

            $hash[ $objectId ] = true;
            $head = $head->getNext();
        }
        return false;
    }
}
