<?php
declare(strict_types=1);

namespace Elena\Hw5;

class App
{
   function run()
    {
        require __DIR__ .'/../src/view/form.php' ;
        if($_REQUEST['email_str'])
        {
            $validation= new EmailValidation();
            return $validation->check_email();
        }
    }

}
