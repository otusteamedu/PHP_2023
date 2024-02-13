<?php
class ListNode {
  public $val = 0;
  public $next = null;
  function __construct($val = 0, $next = null) {
    $this->val = $val;
    $this->next = $next;
  }
}

function hasCycle($head) {
  if ($head == null || $head->next == null) {
    return false;
  }

  $slow = $head;
  $fast = $head->next;

  while ($fast != null && $fast->next != null) {
    if ($slow == $fast) {
      return true;
    }
    $slow = $slow->next;
    $fast = $fast->next->next;
  }

  return false;
}

// Пример использования:
// $head = new ListNode(3);
// $head->next = new ListNode(2);
// $head->next->next = new ListNode(0);
// $head->next->next->next = new ListNode(-4);
// $head->next->next->next->next = $head->next; // Делаем цикл: -4 -> 2

// var_dump(hasCycle($head)); // Вернет true
