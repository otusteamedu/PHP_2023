<?php

declare(strict_types=1);

final class ListNode
{
    function __construct(
        private readonly int $val,
        private ListNode|null $next = null,
    ) {
    }

    public function getVal(): int
    {
        return $this->val;
    }

    public function getNext(): ?ListNode
    {
        return $this->next;
    }

    public function setNext(?ListNode $next): void
    {
        $this->next = $next;
    }

    public function hasNext(): bool
    {
        return $this->next !== null;
    }
}

final class Solution
{
    private array $hash = [];

    public function __construct(
        private WeakMap $weakHash = new WeakMap(),
    ) {
    }

    /**
     * Использовал алгоритм с урока - hash map.
     * Сложность O(n) так как тут зависимость от кол-во нод в цепи,
     * и по памяти тоже O(n) так как используем hash map для накопления нод.
     */
    function hasCycleWithUniqueValues(ListNode $head): bool
    {
        $this->hash[$head->getVal()] += 1;

        if ($this->hash[$head->getVal()] >= 2) {
            return true;
        }

        if ($head->hasNext()) {
            return $this->hasCycleWithUniqueValues($head->getNext());
        }

        return false;
    }

    /**
     * Предыдущий алгоритм не прошёл тесты на литкоде,
     * из-за того что он не умеет работать с неуникальными значениями.
     * Поэтому после нескольких часов мучений я решил всё же поискать другой алгоритм.
     * Нашёл алгоритм черепахи и зайца.
     * Сложность у него такая же O(n) так как зависит от кол-ва узлов в цепи,
     * но по памяти у него O(1) так как не используется hash map или что-то другое для накопления каких-то значений.
     */
    public function hasCycle(ListNode $head): bool
    {
        if (!$head->hasNext() || !$head->getNext()->hasNext()) {
            return false;
        }

        $first = $head;
        $second = $head;

        while ($first !== null && $second !== null) {
            $first = $first->getNext();
            $second = $second->getNext()->getNext();

            if ($first === $second) {
                return true;
            }
        }

        return false;
    }

    /**
     * Ещё немного подумав я вспомнил о существовании WeakMap
     * и решил что можно его использовать в качестве хеш мапа,
     * а в качестве ключей будут ноды, и это сработало.
     * Значения здесь не используются, поэтому можно принимать ноды с любыми значениями.
     * Сложность этого алгоритма O(n) как и у первого варианта,
     * по памяти так же O(n) так как используется хеш мап.
     * Но есть ощущение, что памяти используется больше,
     * так как ключи в хеш мапе стали тяжелее, к тому же используется не просто массив,
     * а сложная структура - коллекция.
     */
    function hasCycleWithWeakMap(ListNode $head): bool
    {
        if ($this->weakHash->offsetExists($head)) {
            return true;
        }

        $this->weakHash[$head] = 'something';

        if ($head->hasNext()) {
            return $this->hasCycleWithWeakMap($head->getNext());
        }

        return false;
    }
}

$firstNode = new ListNode(3);
$secondNode = new ListNode(2);
$thirdNode = new ListNode(0);
$fourthNode = new ListNode(-4);

$firstNode->setNext($secondNode);
$secondNode->setNext($thirdNode);
$thirdNode->setNext($fourthNode);
$fourthNode->setNext($secondNode);

//$hasCycle = (new Solution())->hasCycleWithUniqueValues($firstNode);
//$hasCycle = (new Solution())->hasCycle($firstNode);
$hasCycle = (new Solution())->hasCycleWithWeakMap($firstNode);

var_dump($hasCycle);
