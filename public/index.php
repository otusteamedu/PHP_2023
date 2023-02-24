<?php

$string = $_POST['string'] ?? '';

function check(string $string): bool {
  if (!$string) {
    return false;
  }

  $counter = 0;
  for ($i = 0; $i < strlen($string); $i++) {
    if ($string[$i] === '(') {
      $counter++;
    } elseif ($string[$i] === ')') {
      $counter--;
    }
    if ($counter < 0) {
      return false;
    }
  }

  return $counter === 0;
}

if (check($string)) {
  http_response_code(200);
  echo 'OK';
} else {
  http_response_code(400);
  echo 'Bad request';
}
