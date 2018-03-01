<?php

function req_gateway($file){
    require_once(__DIR__.'/'.$file);
}

req_gateway("gatewayhandler.php");