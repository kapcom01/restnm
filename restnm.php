<?php

use Psr\Http\Message\ServerRequestInterface;
use React\EventLoop\Factory;
use React\Http\Response;
use React\Http\Server;

require __DIR__ . '/vendor/autoload.php';

$loop = Factory::create();

$server = new Server(function (ServerRequestInterface $request) {
   $method = $request->getMethod();
   $path = $request->getUri()->getPath();

   switch ($path) {
    case '/':
        include 'index.php';
        $payload = getAll();
        break;
	}

    return new Response(
        200,
        array(
            'Content-Type' => 'text/plain'
        ),
        $payload
    );
});

$socket = new \React\Socket\Server(isset($argv[1]) ? $argv[1] : '0.0.0.0:0', $loop);
$server->listen($socket);

echo 'Listening on ' . str_replace('tcp:', 'http:', $socket->getAddress()) . PHP_EOL;

$loop->run();
