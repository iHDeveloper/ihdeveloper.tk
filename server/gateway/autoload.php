<?php

function req_gateway($file){
    require_once(__DIR__.'/'.$file);
}

req_gateway("gatewayuser.php");
req_gateway("gatewayhandler.php");
req_gateway("gatewaylogintask.php");