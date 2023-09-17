<?php

declare(strict_types=1);

namespace DEsaulenko\Hw19\App;

use DEsaulenko\Hw19\Interfaces\PublisherServiceInterface;

class PublisherApp implements AppInterface
{
    private PublisherServiceInterface $publisherService;

    public function __construct(PublisherServiceInterface $publisherService)
    {
        $this->publisherService = $publisherService;
    }

    public function run(): void
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $this->publisherService->publish(json_encode($data));
        /**
         * Ответ - огонь
         */
        echo json_encode([
            'result' => [
                'message' => 'published'
            ]
        ]);
    }
}
