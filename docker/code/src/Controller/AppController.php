<?php

namespace IilyukDmitryi\App\Controller;

class AppController
{
    public function indexAction()
    {
        $resultHtml = '
<h1>Добро пожаловать!</h1>
<p>Тестируем работу с Elastic</p>
        ';
        include $_SERVER['DOCUMENT_ROOT'].'/src/View/App/index.php';
    }
}