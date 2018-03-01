<?php
namespace Packet\In;

use Packet\PacketIn;

class PacketLogin extends PacketIn {

    public function __construct($packet){
        $this->decode($packet);
        $username = $this->read('username');
        $this->username = $username;
    }

    public function getUsername(){
        return $this->username;
    }

}