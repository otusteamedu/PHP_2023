<?php
function letterCombinations($digits) {
  if (empty($digits)) {
    return [];
  }

  $mapping = [
    '2' => ['a', 'b', 'c'],
    '3' => ['d', 'e', 'f'],
    '4' => ['g', 'h', 'i'],
    '5' => ['j', 'k', 'l'],
    '6' => ['m', 'n', 'o'],
    '7' => ['p', 'q', 'r', 's'],
    '8' => ['t', 'u', 'v'],
    '9' => ['w', 'x', 'y', 'z']
  ];

  $combinations = [''];

  for ($i = 0; $i < strlen($digits); $i++) {
    $new_combinations = [];
    foreach ($combinations as $combination) {
      foreach ($mapping[$digits[$i]] as $letter) {
        $new_combinations[] = $combination . $letter;
      }
    }
    $combinations = $new_combinations;
  }

  return $combinations;
}

// Пример использования:
// $digits = "23";
// print_r(letterCombinations($digits)); // Выведет ["ad","ae","af","bd","be","bf","cd","ce","cf"]
