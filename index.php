<?php
class Solution {

    /**
     * @param String $digits
     * @return String[]
     */
    public static function letterCombinations(string $digits): array
    {
        $keyboard = [
            1 => null,
            2 => ["a","b","c"],
            3 => ["d","e","f"],
            4 => ["g","h","i"],
            5 => ["j","k","l"],
            6 => ["m","n","o"],
            7 => ["p","q","r","s"],
            8 => ["t","u","v"],
            9 => ["w","x","y","z"],
        ];

        if($digits == '') {
            return [];
        }

        $sol = $keyboard[$digits[0]];

        if(strlen($digits) > 1) {
            for ($i = 0; $i < strlen($digits)-1; $i++) {
                $tmp = [];
                for ($j = 0; $j < count($sol); $j++) {
                    if (isset($digits[$i+1])) {
                        for ($k = 0; $k < count($keyboard[$digits[$i+1]]); $k++) {
                            $tmp[] = $sol[$j].$keyboard[$digits[$i+1]][$k];
                        }
                    }
                }
                $sol = $tmp;
            }
        }
        return $sol;
    }

    /**
     * @param ListNode $head
     * @return bool
     */
    public static function hasCycle(ListNode $head): bool
    {
        /*$hash = [];
        $copy = $head->next;
        $hash[] = $head;
        while ($copy->next !== null) {
            if (in_array($copy, $hash, true)) {
                return true;
            }else{
                $hash[] = $copy;
                $copy = $copy->next;
            }
        }
        return false;*/
        // Пробовал через хэштаблицу, но нормальное значение ключа без занесения всего элемента не придумал,
        // получилось медленно, что-то в районе 420мс

        // Этот вариант, с пометками элементов, 22мс, вероятно тоже не слишком оптимальный
        $copy = $head;
        while ($copy->next !== null) {
            if (isset($copy->index)) {
                return true;
            }else{
                $copy->index = 1;
                $copy = $copy->next;
            }
        }
        return false;
    }
}

print_r(Solution::letterCombinations("234"));

class ListNode
{
    public int $val = 0;
    public ListNode|null $next = null;
    function __construct($val = 0, $next = null)
    {
        $this->val = $val;
        $this->next = $next;
    }
}

$list1 = new ListNode(3,
         new ListNode(2,
         new ListNode(0,
         new ListNode(-4, null))));

$list2 = new ListNode(1,
         new ListNode(3,
         new ListNode(4, null)));

$lore = $list1->next;

$list1->next->next->next->next = $lore;

print_r(Solution::hasCycle($list1));