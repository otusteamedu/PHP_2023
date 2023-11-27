<?php
declare(strict_types=1);

namespace Elena\Hw5;

use Exception;

class EmailValidation
{
  public function check_email()
  {
      try {
          if (!isset($_POST['email_str'])){
              throw new Exception('Отсутствует строка для проверки');
          }else{
              $email_str = $_POST['email_str'];
              $domain = preg_replace('/^([.a-z0-9-])*/i',"",$email_str);
              $domain = preg_replace('/^(@){1}/i',"",$domain);
          }

          if (!filter_var($email_str, FILTER_VALIDATE_EMAIL)) {
              throw new Exception("Некорректный Email $email_str ");
          }

          if (!checkdnsrr($domain, 'MX')) {
              // домен недействителен
              throw new Exception("Некорректный домен $domain ");
          }

          return "</br> Адрес $email_str корректный" ;

      } catch ( Exception $e){
          return  "</br> Ошибка проверки адреса $email_str - ". $e->getMessage() ;
      }

  }
}


