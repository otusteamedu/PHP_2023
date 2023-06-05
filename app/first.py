class ListNode:
    def __init__(self, x):
        self.val = x
        self.next = None

def hasCycle(head):
    if head is None:
        return False

    slow = head
    fast = head

    while fast is not None and fast.next is not None:
        slow = slow.next
        fast = fast.next.next

        if slow == fast:
            return True

    return False