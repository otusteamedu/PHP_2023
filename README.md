 https://leetcode.com/problems/linked-list-cycle/
 
O(n)
```
class Solution {
    /**
     * @param ListNode $head
     * @return Boolean
     */
    function hasCycle($head) {
        $hash = [];
        while ($head->next) {
            $hashClass = md5(serialize($head));
            if (!empty($hash[$hashClass])) {
                return true;
            }
            $hash[$hashClass] = true;
            $head = $head->next;
        }
        return false;
    }
}
```


https://leetcode.com/problems/letter-combinations-of-a-phone-number/

```
 function letterCombinations($digits) {
        $numbersMapping = [
            2 => ['a', 'b', 'c'],
            3 => ['d', 'e', 'f'],
            4 => ['g', 'h', 'i'],
            5 => ['j', 'k', 'l'],
            6 => ['m', 'n', 'o'],
            7 => ['p', 'q', 'r', 's'],
            8 => ['t', 'u', 'v'],
            9 => ['w', 'x', 'y', 'z']
        ];
        
        if (strlen($digits) === 0) {
            return [];
        }
        
        $letterCombinations = $numbersMapping[$digits[0]];
        
        for ($i = 1; $i < strlen($digits); $i++) {
            $digit = $digits[$i];
            $letters = $numbersMapping[$digit];
            $new = [];
            
            foreach ($letterCombinations as $letterCombination) {
                foreach ($letters as $letter) {
                    $new[] = $letterCombination . $letter;
                }
            }

            $letterCombinations = $new;
        }

        return $letterCombinations;
    }
```
