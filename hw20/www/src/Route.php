<?php
declare(strict_types=1);

namespace Shabanov\Otusphp;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Shabanov\Otusphp\Controller\ApiController;
use FastRoute;
use FastRoute\RouteCollector;
use Shabanov\Otusphp\Entity\Lead;
use Shabanov\Otusphp\Repository\LeadRepository;
use Symfony\Component\HttpFoundation\Request;

class Route
{
    private EntityRepository $leadRepository;
    public function __construct(private readonly EntityManager $entityManager)
    {}

    public function run()
    {
        $this->leadRepository = new LeadRepository($this->entityManager, Lead::class);
        $apiController = new ApiController($this->leadRepository);

        $router = FastRoute\simpleDispatcher(function (RouteCollector $r) use ($apiController) {
            $r->addRoute('POST', '/api/v1/lead', [$apiController, 'create']);
            $r->addRoute('POST', '/api/v1/lead/status', [$apiController, 'status']);
            $r->addRoute('GET', '/api/v1/leads', [$apiController, 'list']);
            $r->addRoute('GET', '/api/v1/leads/{id:\d+}', [$apiController, 'detail']);
        });

        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];

        if (($pos = strpos($uri, '?')) !== false) {
            $uri = substr($uri, 0, $pos);
        }

        $routeInfo = $router->dispatch($httpMethod, $uri);

        switch ($routeInfo[0]) {
            case FastRoute\Dispatcher::NOT_FOUND:
                http_response_code(404);
                break;
            case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                http_response_code(405);
                break;
            case FastRoute\Dispatcher::FOUND:
                echo $this->responseHandler($routeInfo);
                break;
        }
    }

    private function responseHandler(array $routeInfo): string
    {
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        $request = Request::createFromGlobals();

        $controller = new $handler[0]($this->leadRepository);
        $method = $handler[1];

        $response = $controller->$method($request, $vars);

        $headers = $response->headers->all();
        foreach ($headers as $name => $values) {
            foreach ($values as $value) {
                header(sprintf('%s: %s', $name, $value), false);
            }
        }

        return $response->getContent();
    }
}
