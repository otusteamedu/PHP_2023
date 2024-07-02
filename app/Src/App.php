<?php
declare(strict_types=1);
namespace App\Src;

use Exception;

include('Validator.php');
include('Auth.php');

class App
{
    private $validator = null;
    private $auth = null;

    public function __construct() {
        $this->validator = new Validator();
        $this->auth = new Auth();
    }

    public function run() {

        try {
            $this->auth->auth();
            $string = $_POST['string'] ?? '';
            $message = "Cтрока корректна";
            header('HTTP/1.1 ' . 200);
            $this->validator->validate($string);
        } catch (Exception $e) {
            header('HTTP/1.1 ' . 400);
            $message = $e->getMessage();
        }
        
        $this->auth->info();
        echo "<br><br>string: " . $string . '<br>';
        echo "Обработка строки string: " . $message;
    }
}
