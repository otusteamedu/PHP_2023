<?php
declare(strict_types=1);

namespace Shabanov\Otusphp;

use Shabanov\Otusphp\Controller\PageController;
use Shabanov\Otusphp\Render\Error404Render;

class Route
{
    private const MAP = [
        '/' => 'main',
        '/formHandler' => 'formHandler',
    ];
    public function __construct(private string $url)
    {}

    public function run(): void
    {
        $action = self::MAP[$this->url] ?? null;
        if ($action !== null) {
            $controller = new PageController();
            if (method_exists($controller, $action)) {
                $controller->$action();
                return;
            }
        }

        http_response_code(404);
        echo (new Error404Render())->show();
    }
}
