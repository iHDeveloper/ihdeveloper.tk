<?php

echo 'Loading libraries...';
require_once(__DIR__ . '/Loader.php');

use Devristo\Phpws\Server\WebSocketServer;
use Gateway\GateWayHandler as Handler;

$loop = \React\EventLoop\Factory::create();
// Create a logger which writes everything to the STDOUT
$logger = new \Zend\Log\Logger();
$writer = new Zend\Log\Writer\Stream("php://output");
$logger->addWriter($writer);
// Create a WebSocket server using SSL
$server = new WebSocketServer("tcp://0.0.0.0:7070", $loop, $logger);
$router = new \Devristo\Phpws\Server\UriHandler\ClientRouter($server, $logger);
$loop->addPeriodicTimer(0.5, function() use($server, $logger){
    $time = new DateTime();
    $string = $time->format("Y-m-d H:i:s");
    $logger->notice("Broadcasting time to all clients: $string");
    foreach($server->getConnections() as $client)
        $client->sendString($string);
});
$router->addRoute('#^(.*)$#i', new Handler($logger));
// Bind the server
$server->bind();
// Start the event loop
$loop->run();