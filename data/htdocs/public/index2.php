<?php

declare(strict_types=1);

class TreeNode
{
    function __construct(
        public int|string $val,
        public ?TreeNode $left = null,
        public ?TreeNode $right = null
    ) {
    }
}

$root = new TreeNode(
    '+',
    new TreeNode(9),
    new TreeNode(
        '*',
        new TreeNode(15),
        new TreeNode(7)
    )
);

function evaluate(TreeNode $root): int
{
    // Граничный случай (узел содержит число)
    if (is_int($root->val)) {
        return $root->val;
    }

    if($root->val == '+') {
        return evaluate($root->left) + evaluate($root->right);
    } elseif($root->val == '*') {
        return evaluate($root->left) * evaluate($root->right);
    }

    return 0;
}


echo evaluate($root) . PHP_EOL;
