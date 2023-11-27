<?php
declare(strict_types=1);

namespace Elena\Hw5;

use Exception;

class App
{
   function run()
    {
        $viewFile = __DIR__ .'/../src/view/form.php' ;
        $renders = new MyRender();

        try {
            if (!$view = $renders->render_view($viewFile)){
                throw new Exception('Файл не найден');
            }
        }
        catch ( Exception $e) {
            return  "</br> Ошибка открытия страницы - ". $e->getMessage() ;
        }

        echo($view);

        if (isset($_REQUEST['email_str'])) {
            $validation = new EmailValidation();
            return $validation->check_email();
        }

    }

}
