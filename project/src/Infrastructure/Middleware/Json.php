<?php

declare(strict_types=1);

namespace Vp\App\Infrastructure\Middleware;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Vp\App\Infrastructure\Middleware\Contract\MiddleWareInterface;

class Json implements MiddleWareInterface
{
    public function handle(Request $request, Application $app): ?Response
    {
        if (!$this->isJsonContent($request)) {

            return new Response(
                json_encode(['error' => "Content-Type not accepted"]),
                Response::HTTP_BAD_REQUEST
            );
        }

        $data = json_decode($request->getContent(), true);

        if ($data === null) {

            return new Response(
                json_encode(['error' => "Invalid json: " . json_last_error_msg()]),
                Response::HTTP_BAD_REQUEST
            );
        }

        $request->request->replace(is_array($data) ? $data : []);

        return null;
    }

    private function isJsonContent(Request $request): bool
    {
        return 0 === strpos($request->headers->get('Content-Type'), 'application/json');
    }
}
