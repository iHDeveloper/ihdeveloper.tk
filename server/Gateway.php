<?php

echo 'Loading libraries...' . "\n";
require_once(__DIR__ . '/Loader.php');

use Devristo\Phpws\Server\WebSocketServer;
use Gateway\GateWayHandler as Handler;
use Gateway\GateWayLoginTask as LoginTask;

$loop = \React\EventLoop\Factory::create();
// Create a logger which writes everything to the STDOUT
$logger = new \Zend\Log\Logger();
$writer = new Zend\Log\Writer\Stream("php://output");
$logger->addWriter($writer);
// Create a WebSocket server using SSL
$server = new WebSocketServer("tcp://0.0.0.0:7070", $loop, $logger);
$router = new \Devristo\Phpws\Server\UriHandler\ClientRouter($server, $logger);
$router->addRoute('#^(.*)$#i', new Handler($logger));
$loop->addPeriodicTimer(5, function() use($server, $logger){ // run the method every 5 seconds
    LoginTask::run();
});
// Bind the server
$server->bind();
// Start the event loop
$loop->run();