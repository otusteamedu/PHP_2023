<?php
return [
    'mode' => getenv('APP_MODE') ?? 'server', // server or client
    'socket' => '/data/default/socket.sock'
];