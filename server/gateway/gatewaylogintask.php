<?php

namespace Gateway;

use Gateway\GateWayHandler as Handler;
use Packet\Out\PacketKick;

class GateWayLoginTask {
    
    static $timeouts = array();

    public static function run(){
        $users = Handler::getUsers();
        foreach($users as $user){
            if ($user == null) continue;
            if ($user['username'] != null) continue;
            $id = $user['id'];
            $timeout = self::$timeouts[$id];
            if ($timeout == null){
                $timeout = 0;
            }
            $timeout = $timeout + 1;
            if ($timeout >= 10){
                $connection = $user['connection'];
                $kickpacket = new PacketKick("You have been kicked reason: Login Idle");
                $connection->sendString($kickpacket->encode());
                $connection->close();
                self::$timeouts[$id] = null;
                echo "Client#" . $id . "got kicked for: Login Idle \n";
                continue;
            }
            self::$timeouts[$id] = $timeout;
            echo "Checking login timeout : " . $timeout . ' for ' . $id . "\n";
        }
    }
}