<?php
namespace src;
use Exception;

require __DIR__ .'/../src/Validation.php';


class App
{
   function run()
    {
        try {
            if (!isset($_POST['string'])){
                throw new Exception('Отсутствует параметр string');
            }else{
                $ch_str = $_POST['string'];
            }

            $brack = get_brackets($ch_str);

            if (is_full($brack)){
                throw new Exception('В параметре string нет скобок');
            }

            if (!correct_brackets($brack)){
                throw new Exception('Некорректные скобки');
            }

            return ('200 Ok. В строке "'.$ch_str.'" скобки расставлены правильно' );

        } catch ( Exception $e){
            return( "400 Bad Request. ".$e->getMessage());
        }
    }

}
