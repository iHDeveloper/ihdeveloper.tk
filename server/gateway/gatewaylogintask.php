<?php

namespace Gateway;

class GateWayLoginTask {
    
    public static function run(){
        foreach($users as $user){
            $session = $user['session'];
            if ($seesion == array()){
                $username = $user['username'];
                if ($username == null){
                    $seesion['logintimeout'] = 0;
                }
            } else {
                if ($session['logintimeout'] == null){
                    $seesion['logintimeout'] = 0;
                }
                if ($username == null){
                    $timeout = $seesion['logintimeout'];
                    $timeout = $timeout + 1;
                    $session['logintimeout'] = $timeout;
                }
            }
            $user['session'] = $session;
        }
    }
}