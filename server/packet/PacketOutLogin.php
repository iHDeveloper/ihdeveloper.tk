<?php

namespace Packet\Out;

use Packet\PacketOut;

class PacketLogin extends PacketOut{
    
    public function __construct($type){
        $this->write('type', 'login');
        if($type == "require"){
            $this->write('logintype', 'require');
        } else if ($type == "success"){
            $this->write('logintype', 'info');
            $this->write('status', 'success');
        } else if ($type == "failed"){
            $this->write('logintype', 'info');
            $this->write('status', 'failed');
        }
    }

}