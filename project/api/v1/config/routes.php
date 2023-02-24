<?php

return [
    '/api/v1/verification/email' => [
        'method' => 'POST',
        'controller' => 'Vp\App\Controllers\Email',
        'action' => 'email'
    ],
    '/api/v1/verification/emails' => [
        'method' => 'POST',
        'controller' => 'Vp\App\Controllers\Email',
        'action' => 'emails'
    ],
    '/api/v1/verification/file' => [
        'method' => 'POST',
        'controller' => 'Vp\App\Controllers\Email',
        'action' => 'file'
    ],
];
