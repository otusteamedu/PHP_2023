# 14. Leetcode практикум.1

## 17. Letter Combinations of a Phone Number

https://leetcode.com/problems/letter-combinations-of-a-phone-number/

```php
class Solution {

    /**
     * @param String $digits
     * @return String[]
     */
    function letterCombinations($digits) {
        $phoneKeypad = [
            '2' => ['a', 'b', 'c'],
            '3' => ['d', 'e', 'f'],
            '4' => ['g', 'h', 'i'],
            '5' => ['j', 'k', 'l'],
            '6' => ['m', 'n', 'o'],
            '7' => ['p', 'q', 'r', 's'],
            '8' => ['t', 'u', 'v'],
            '9' => ['w', 'x', 'y', 'z'],
        ];

        $i = 0;
        $response = [];

        $result = [''];
        $len = strlen($digits);

        if ($len == 0) {
            return [];
        }


        for ($i = 0; $i < $len; $i++) {
            $digit = $digits[$i];
            $letters = $phoneKeypad[$digit];

            $newResult = [];
            foreach ($result as $prefix) {
                foreach ($letters as $letter) {
                    $newResult[] = $prefix . $letter;
                }
            }

            $result = $newResult;
        }


        return $result;
    }
}
```


## 141. Linked List Cycle

https://leetcode.com/problems/linked-list-cycle/

```php
/**
 * Definition for a singly-linked list.
 * class ListNode {
 *     public $val = 0;
 *     public $next = null;
 *     function __construct($val) { $this->val = $val; }
 * }
 */

class Solution {
    /**
     * @param ListNode $head
     * @return Boolean
     */
    function hasCycle($head) {
        $array = [];
        $is = false;

        do {
            $array[] = $head->value;

            if (count($array) !== count(array_unique($array))) {
                $is = true;
                break;
            }

            
        } while ($head->next != null);

        return $is;
    }
}
```