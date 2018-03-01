<?php

namespace Gateway;

use Devristo\Phpws\Server\UriHandler\WebSocketUriHandler;
use Devristo\Phpws\Protocol\WebSocketTransportInterface;
use Packet\Out\PacketLogin;

class GateWayHandler extends WebSocketUriHandler{

    public function onConnect(WebSocketTransportInterface $user){
        $this->logger->notice("A user has been joined!");
        $packetlogin = new PacketLogin();
        $user->sendString($packetlogin->encode());
    }

}