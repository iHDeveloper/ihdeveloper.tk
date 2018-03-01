<?php

namespace Packet;

class Packet {
    public function __construct(){
        $this->data = array();
    }

    public function write($key, $value){
        $this->data[$key] = $value;
    }

    public function read($key){
        return $this->data[$key];
    }

    public function encode(){
        return json_encode($this->data);
    }

}