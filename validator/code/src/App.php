<?php

namespace app\src;

use app\helpers\Validator;

require 'View.php';
require 'helpers/Validator.php';

class App
{
    public $view;

    public function __construct()
    {
        $this->view = new View();
    }

    /**
     * @throws \Exception
     */
    public function load(): void
    {
        $validator = new Validator();
        $data = ['validator' => $validator->checkString()];
        $this->view->generate('index.php', $data);
    }
}
