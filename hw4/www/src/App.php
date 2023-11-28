<?php
namespace Shabanov\Otusphp;

class App
{
    public function run()
    {
        $brackets = new Brackets();
        $result = $brackets->check();
        $response = new Response($result);
        $response->showStatus();
    }
}
