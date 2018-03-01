<?php

function req($file){
    require_once(__DIR__.$file);
}

req("gatewayhandler.php");