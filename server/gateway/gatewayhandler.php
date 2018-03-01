<?php

namespace Gateway;

use Devristo\Phpws\Server\UriHandler\WebSocketUriHandler;
use Devristo\Phpws\Protocol\WebSocketTransportInterface;
use Devristo\Phpws\Messaging\WebSocketMessageInterface;
use Packet\Out\PacketLogin as PacketOutLogin;
use Packet\In\PacketLogin as PacketInLogin;
use Packet\Out\PacketPong;
use Packet\PacketIn;
use Packet\In\PacketPing;

class GateWayHandler extends WebSocketUriHandler{

    public function onConnect(WebSocketTransportInterface $client){
        $this->logger->notice('client#' . $client->getId() . " is logging in...");
        $packetlogin = new PacketOutLogin('require');
        $client->sendString($packetlogin->encode());
    }

    public function onMessage(WebSocketTransportInterface $client, WebSocketMessageInterface $msg) {
        $m = $msg->getData();
        $type = PacketIn::GET_TYPE($m);
        if ($type == "ping"){
            $packet = new PacketPong();
            $client->sendString($packet->encode());
        } else if ($type == "login"){
            $packet = new PacketInLogin($m);
            $this->logger->notice("client#" . $client->getId() . ' loggined in as ' . $packet->getUsername());
            $outpacket = new PacketOutLogin('success');
            $client->sendString($outpacket->encode());
        }
    }

}