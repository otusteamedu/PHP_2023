<?php

namespace Order\Infrastructure;

use Common\Infrastructure\Templating\Twig;
use Order\App\AddOrderDTO;
use Order\App\AddOrderToQueueAction;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Sunrise\Http\Message\Response\HtmlResponse;

class Controller
{
    public function order(ServerRequestInterface $request): ResponseInterface
    {
        $template = Twig::get('index.twig');

        $data = [];
        $data['from'] = new \DateTime($request->getParsedBody()['from']);
        $data['to'] = new \DateTime($request->getParsedBody()['to']);
        $data['email'] = $request->getParsedBody()['email'];

        $delta = $data['to']->getTimestamp() - $data['from']->getTimestamp();

        if ($delta < 24 * 60 * 60) {
            $template = Twig::get('index.twig');
            return new HtmlResponse(200, $template->render(['error' => 'Минимальный заказ 24 часа']));
        }

        if (filter_var($data['email'], FILTER_VALIDATE_EMAIL) === false) {
            $template = Twig::get('index.twig');
            return new HtmlResponse(200, $template->render(['error' => 'Неверный email']));
        }

        $dto = new AddOrderDTO(
            $data['email'],
            $data['from'],
            $data['to']
        );

        try {
            $action = container()->make(AddOrderToQueueAction::class);
            $action->execute($dto);
        } catch (\Exception $e) {
            $template = Twig::get('index.twig');
            return new HtmlResponse(200, $template->render(['error' => $e->getMessage()]));
        }

        return new HtmlResponse(200, $template->render(['success' => 'Заказ успешно добавлен в очередь']));
    }
}
