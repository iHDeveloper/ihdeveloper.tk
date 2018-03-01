<?php

namespace Packet\Out;

use Packet\PacketOut;

class PacketPong extends PacketOut {
    public function __construct(){
        $this->write('type','pong');
    }
}