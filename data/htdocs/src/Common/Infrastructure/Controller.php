<?php

namespace Common\Infrastructure;

use Common\Infrastructure\Templating\Twig;
use OpenApi\Annotations as OA;
use Order\App\AddOrderDTO;
use Order\App\AddOrderToQueueAction;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Sunrise\Http\Message\Response\HtmlResponse;

class Controller
{
    public function __construct()
    {
    }

    /**
     * @OA\Get(
     *     path="/",
     *     operationId="index",
     *     @OA\Response(
     *         response="200",
     *         description="Main page"
     *     )
     * )
     */
    public function index(): ResponseInterface
    {
        $template = Twig::get('index.twig');
        $response = new HtmlResponse(200, $template->render([]));
        return $response;
    }
}
