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
use \Gateway\GateWayClient;

class GateWayHandler extends WebSocketUriHandler{

    static $gatewayusers = array();

    public static function getUsers(){
        return self::$gatewayusers;
    }

    public static function saveUsers($users){
        $gatewayusers = $users;
    }

    public function onConnect(WebSocketTransportInterface $client){ // on connect method
        // Setup the client
        $clientid = $client->getId(); // get the id
        $user = array(); // make a user array
        $user['connection'] = $client; // put a connection value
        $user['id'] = $client->getId(); // put a id of the client
        $user['username'] = null; // put a username
        #$user['object'] = new GateWayClient($client->getId(), null);
        self::$gatewayusers[$clientid] = $user; // save the array to the users list
        // Setup the login for the client
        $this->logger->notice('client#' . $client->getId() . " is logging in..."); // log
        $packetlogin = new PacketOutLogin('require'); // make a packet login with require type
        $client->sendString($packetlogin->encode()); // encode it and send it
    }

    public function onDisconnect(WebSocketTransportInterface $client){ // on disconnect method
        $clientid = $client->getId(); // get the client id
        $user = self::$gatewayusers[$clientid]; // get the user from users list
        if ($user != null){ // check if the user is online
            self::$gatewayusers[$clientid] = null; // remove the user from the list
        } // end of the check of the user
    } // end of the disconnect method

    public function onMessage(WebSocketTransportInterface $client, WebSocketMessageInterface $msg) { // on packet incoming method
        $clientid = $client->getId(); // get the client id
        $m = $msg->getData(); // get the mesasge data
        $type = PacketIn::GET_TYPE($m); // get the type of the packet
        if ($type == "ping"){ // check if the packet type is ping
            $packet = new PacketPong(); // create a packet pong
            $client->sendString($packet->encode()); // encode the packet and send it
        } else if ($type == "login"){ // check if the packet type is login
            $packet = new PacketInLogin($m); // create a packet login
            if ($packet->getUsername() == null){ // if the username is null
                $outpacket = new PacketOutLogin('failed'); // create packet login
                $client->sendString($outpacket->encode()); // encode the packet and send it
                return; // return it
            } // end of username checker
            $username = $packet->getUsername(); // get the username of the packet
            $clientobj = self::$gatewayusers[$clientid]; // get the client object
            $clientobj['username'] = $username; // get the username and set it on the client object 
            self::$gatewayusers[$clientid] = $clientobj; // update the client object in the gateway users array
            $this->logger->notice("client#" . $client->getId() . ' loggined in as ' . $username); // log the login event
            $outpacket = new PacketOutLogin('success'); // make a success login packet
            $client->sendString($outpacket->encode()); // encode the packet and send it to the client
        } // end of packet type
    } // end of the packet incoming method

}