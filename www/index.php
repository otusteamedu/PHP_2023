<?php

include "./autoload.php";

use Nalofree\WsTest\Skobochnik;

// Упражняться с роутингом нет особого смысла, так что мы просто проверим что там в адресе
if ($_SERVER['REQUEST_URI'] === '/form') {
  require "./views/form.php";
} else {
  if ($_SERVER['REQUEST_URI'] !== '/') { // любой неверный роут ведет к ошибке
    header('HTTP/1.1 400 Bad Reuqest');
    exit('Текст, что всё плохо');
  }
  if (isset($_POST['string'])) {
    // будем проверять скобки стеком LIFO
    $checker = new Skobochnik($_POST['string']);
    if ($checker->check()) {
      header('HTTP/1.1 200 OK');
      exit('Текст, что всё хорошо');
    } else {
      header('HTTP/1.1 400 Bad Reuqest');
      exit('Текст, что всё плохо');
    }
  } else {
    header('HTTP/1.1 400 Bad Reuqest');
    exit('Текст, что всё плохо');
  }
}


