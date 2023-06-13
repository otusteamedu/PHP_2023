<?php

declare(strict_types=1);

namespace Otus\App;

class Application
{
    public function run() {
        ($_REQUEST) ? (new Validation())->check($_POST["text"]) : HTMLStatic::mainPage();
    }
}
