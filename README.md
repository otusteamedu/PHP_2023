## https://leetcode.com/problems/intersection-of-two-linked-lists/

сложность O(m+n)


```
class Solution {
    function getIntersectionNode($headA, $headB) {
        $itemA = $headA;
        $itemB = $headB;

        while ($itemA !== $itemB) {
            $itemA = $itemA ? $itemA->next : $headB;
            $itemB = $itemB ? $itemB->next : $headA;
        }
        return $itemA;        
    }
}
```

## https://leetcode.com/problems/fraction-to-recurring-decimal/description/

сложность O(n)

```
function fractionToDecimal($numerator, $denominator) {
    if ($numerator == 0) {
        return "0";
    }
    
    $result = "";
    
    $numeratorSign = $numerator < 0 ? "-" : "";
    $denominatorSign = $denominator < 0 ? "-" : "";
    
    if ($numeratorSign !== $denominatorSign) {
        $result .= "-";
    }
    
    $numerator = abs($numerator);
    $denominator = abs($denominator);
    
    $quotient = (int) ($numerator / $denominator);
    $remainder = $numerator % $denominator;
    
    $result .= (string) $quotient;
    
    if ($remainder === 0) {
        return $result;
    }
    
    $result .= ".";
    
    $fractionalPart = "";
    $remainderPositions = [];
    
    while ($remainder !== 0) {
        if (isset($remainderPositions[$remainder])) {
            $index = $remainderPositions[$remainder];
            $fractionalPart = substr_replace($fractionalPart, "(", $index, 0);
            $fractionalPart .= ")";
            break;
        }
        
        $remainderPositions[$remainder] = strlen($fractionalPart);
        $remainder *= 10;
        $quotient = (int) ($remainder / $denominator);
        $fractionalPart .= (string) $quotient;
        $remainder %= $denominator;
    }
    
    return $result . $fractionalPart;
}
```
