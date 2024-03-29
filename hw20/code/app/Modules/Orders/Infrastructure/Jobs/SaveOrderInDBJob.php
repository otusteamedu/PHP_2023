<?php

declare(strict_types=1);

namespace App\Modules\Orders\Infrastructure\Jobs;

use App\Modules\Orders\Application\UseCase\OrderSaveInDBUseCase;
use App\Modules\Orders\Domain\Entity\Order;
use App\Modules\Orders\Infrastructure\Repository\OrderDBRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SaveOrderInDBJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private Order $order,
    )
    {}

    public function handle(): void
    {
        $useCase = new OrderSaveInDBUseCase(new OrderDBRepository());
        ($useCase)($this->order);
    }
}
