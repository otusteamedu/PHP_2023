<?php


//Сложность O(n)
function hasCycle($head) {
    if($head === null) {
          return false;
      }

      $slow = $head;
      $fast = $head;

      while ($fast != null && $fast->next !=null) {
          $slow = $slow->next;
          $fast = $fast->next->next;
          if($fast === $slow) {
              return true;
          }
      }
      return false;
}