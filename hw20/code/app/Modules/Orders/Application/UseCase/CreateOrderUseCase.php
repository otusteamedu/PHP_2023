<?php

declare(strict_types=1);

namespace App\Modules\Orders\Application\UseCase;

use App\Modules\Orders\Application\Request\CreateOrderRequest;
use App\Modules\Orders\Application\Response\CreateOrderResponse;
use App\Modules\Orders\Domain\Entity\Order;
use App\Modules\Orders\Domain\ValueObject\Comment;
use App\Modules\Orders\Domain\ValueObject\Email;
use App\Modules\Orders\Domain\ValueObject\UUID;
use App\Modules\Orders\Infrastructure\Jobs\SaveOrderInDBJob;
use Illuminate\Support\Facades\Queue;

class CreateOrderUseCase
{
    public function __invoke(CreateOrderRequest $request): CreateOrderResponse
    {
        $uuid = uuid_create();
        $order = new Order(
            new UUID($uuid),
            new Email($request->email),
            new Comment($request->comment)
        );

        $response = new CreateOrderResponse($uuid);

        Queue::push(new SaveOrderInDBJob($order));
        return $response;
    }
}
