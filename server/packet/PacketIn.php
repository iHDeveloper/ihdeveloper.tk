<?php
namespace Packet;

use Packet\Packet;

class PacketIn extends Packet{

    public static function GET_TYPE($json){
        $packet = json_decode($json, true);
        if ($packet['type'] != null){
            return $packet['type'];
        }
        return null;
    }

    public function __construct($packet){
        $this->decode($packet);
    }

    public function decode($packet){
        $this->data = json_decode($packet, true);
        $this->type = $this->data['type'];
    }

    public function read($key){
        return $this->data[$key];
    }

}