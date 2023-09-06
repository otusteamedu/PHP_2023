<?php

declare(strict_types=1);

namespace App;

class App
{
    public function run()
    {
        if($_SERVER['REQUEST_URI'] === '/'){
            $home = new Home();

            $home->home();
        }

        if($_SERVER['REQUEST_URI'] === '/info'){
            $home = new Info();

            $home->getInfo();
        }

        if($_SERVER['REQUEST_URI'] === '/string-validation'){
            $stringValidation = new StringValidation();

            $stringValidation->validation();
        }
    }
}