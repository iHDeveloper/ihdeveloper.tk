<?php

namespace Gateway;

use Devristo\Phpws\Server\UriHandler\WebSocketUriHandler;
use Devristo\Phpws\Protocol\WebSocketTransportInterface;
use Gateway\GateWayClient;

$users = array();

class GateWayUserHandler extends WebSocketUriHandler{

    public function onConnect(WebSocketTransportInterface $client){
        $user = array();
        $user['connection'] = $client;
        $user['id'] = $client->getId();
        $user['session'] = array();
        $user['username'] = null;
        $user['object'] = new GateWayClient($client->getId(), null);
        $users[$client->getId()] = $user;
    }
}