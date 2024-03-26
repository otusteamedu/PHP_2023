<?php

declare(strict_types=1);

namespace App\Modules\Orders\Infrastructure\Jobs;

use App\Modules\Orders\Application\UseCase\SaveOrderInDBUseCase;
use App\Modules\Orders\Domain\Entity\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SaveOrderInDBJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private Order $order
    )
    {}


    public function handle(): void
    {
        $useCase = new SaveOrderInDBUseCase();
        ($useCase)($this->order);
    }
}
