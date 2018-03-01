<?php
namespace Packet\Out;

use Packet\PacketOut;

class PacketKick extends PacketOut{

    public function __construct($message){
        $this->write('type', 'kick');
        $this->write('message', $message);
        $this->write('kicktype', 'reason');
    }

}