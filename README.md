### Решение алгоритмических задач 
1. Linked List Cycle
*https://leetcode.com/problems/linked-list-cycle/* 


```php
class Solution 
{
  /**
   * @param ListNode $head
   * @return Boolean
   */
  function hasCycle($head)
  {
      $a = $head;
      $b = $head;
      while ($a !== null && $b->next !== null) {
        $a = $a->next;
        $b = $b->next->next;
        if ($a === $b) return true;
      }
      return false;
  }
}

```
O(n) — линейная сложность. Нам придётся пройтись по всем n элементам массива.

---

2. Letter Combinations of a Phone Number
*https://leetcode.com/problems/letter-combinations-of-a-phone-number/* 

```php
class Solution
{
  public $letters = [
                        2 => ['a','b','c'], 
                        3 => ['d','e','f'], 
                        4 => ['g','h','i'], 
                        5 => ['j','k','l'], 
                        6 => ['m','n','o'], 
                        7 => ['p','q','r','s'], 
                        8 => ['t','u','v'], 
                        9 => ['w','x','y','z']
                    ]; 
  
  function letterCombinations($digits)
  {
    if ($digits==='') return []; 
    $res = $this->letters[$digits[0]];
    for ($i = 1; $i < strlen($digits); $i++) {
        $temp = []; 
        foreach ($this->letters[$digits[$i]] as $ch) { 
            foreach ($res as $r) { 
                $temp[] = $r . $ch;
            }
        }
        $res = $temp;
    }
    return $res;
  }
}
```

O(n2) — квадратичная сложность. Количество операций будет зависеть от размера $digits


