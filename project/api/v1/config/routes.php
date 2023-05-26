<?php

declare(strict_types=1);

return [
    '/api/v1/statement/period' => [
        'method' => 'POST',
        'controller' => 'Vp\App\Infrastructure\Controllers\Statement',
        'action' => 'period'
    ],
];
