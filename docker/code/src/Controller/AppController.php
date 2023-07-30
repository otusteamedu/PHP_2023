<?php

namespace IilyukDmitryi\App\Controller;

use IilyukDmitryi\App\Utils\TemplateEngine;

class AppController
{
    public function indexAction(): void
    {
        $templateEngine = new TemplateEngine();
        $resultHtml = $templateEngine->render('App/index.php');
        echo $resultHtml;
    }
}
