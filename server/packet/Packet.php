<?php

namespace Packet;

class Packet {

    private $data = array();

    public function write($key, $value){
        $data[$key] = $value;
    }

    public function read($key){
        return $data[$key];
    }

    public function encode(){
        return json_encode($data);
    }

}