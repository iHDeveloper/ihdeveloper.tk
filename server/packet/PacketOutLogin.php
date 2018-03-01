<?php

namespace Packet\Out;

use Packet\PacketOut;

class PacketLogin extends PacketOut{
    
    public function __construct(){
        $this->write('type', 'login');
    }

}