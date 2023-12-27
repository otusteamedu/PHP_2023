<?php

declare(strict_types=1);

namespace Chernomordov\App;

class App
{
    /**
     * Run the application.
     *
     * @return void
     * @throws \Exception
     */
    public function run(): void
    {
        $route = $this->getRequestRoute();

        if ($route === '/validation') {
            (new Validation())->run();
        } else {
            (new Balancer())->run();
        }
    }

    /**
     * Get the request route.
     *
     * @return string
     */
    private function getRequestRoute(): string
    {
        return $_SERVER['REQUEST_URI'] ?? '';
    }
}
