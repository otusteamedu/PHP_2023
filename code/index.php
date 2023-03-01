<?php

// Check if the input is valid
if (!isset($_POST['string']) || !is_string($_POST['string'])) {
    http_response_code(400);
    echo "Error: Invalid input.";
    exit;
}

// Get the string from the POST request
$string = $_POST['string'];

// Count the number of open and closed parentheses
$open_count = substr_count($string, '(');
$close_count = substr_count($string, ')');

// Check if the number of open and closed parentheses is equal
if ($open_count !== $close_count) {
    http_response_code(400);
    echo "Error: The number of opening and closing parentheses do not match.";
    exit;
}

// Check if the parentheses are correctly balanced
$stack = [];
for ($i = 0; $i < strlen($string); $i++) {
    if ($string[$i] === '(') {
        array_push($stack, '(');
    } elseif ($string[$i] === ')') {
        if (empty($stack)) {
            http_response_code(400);
            echo "Error: The parentheses are not correctly balanced.";
            exit;
        } else {
            array_pop($stack);
        }
    }
}

// If the stack is not empty, the parentheses are not balanced
if (!empty($stack)) {
    http_response_code(400);
    echo "Error: The parentheses are not correctly balanced.";
    exit;
}

// If everything is fine, return 200 OK response
http_response_code(200);
echo "The string has correctly balanced parentheses.";
