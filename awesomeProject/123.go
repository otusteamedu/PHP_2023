package main

import "fmt"

type ListNode struct {
	Val  int
	Next *ListNode
}

func mergeTwoLists(list1 *ListNode, list2 *ListNode) *ListNode {
	if list1 == nil {
		return list2
	}

	if list2 == nil {
		return list1
	}

	if list1.Val >= list2.Val {
		list2.Next = mergeTwoLists(list1, list2.Next)
		return list2
	} else {
		list1.Next = mergeTwoLists(list1.Next, list2)
		return list1
	}
}

func main() {
	node1 := &ListNode{Val: 1, Next: nil}

	node2 := &ListNode{Val: 2, Next: nil}

	node1.Next = node2

	node3 := &ListNode{Val: 4, Next: nil}

	node2.Next = node3

	node4 := &ListNode{Val: 1, Next: nil}

	node5 := &ListNode{Val: 3, Next: nil}

	node4.Next = node5

	node6 := &ListNode{Val: 4, Next: nil}

	node5.Next = node6

	node := mergeTwoLists(node1, node4)

	fmt.Println(node.Val)
}
