<?php

$server = new OpenSwoole\HTTP\Server("localhost", $_ENV['PORT']);

$server->on("start", function (OpenSwoole\Http\Server $server) {
    echo "OpenSwoole http server is started at http://127.0.0.1:9501\n";
});

$server->on("request", function (OpenSwoole\Http\Request $request, OpenSwoole\Http\Response $response) {
//    $response->header("Content-Type", "text/plain");
//    $response->end("Hello World\n");
    $response->status(403);
    //$response->status(200);
});

$server->start();
