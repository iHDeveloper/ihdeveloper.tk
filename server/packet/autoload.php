<?php

function req($file){
    require_once(__DIR__.'/'.$file);
}

// Packet
req("Packet.php");
req("PacketOut.php");

// Output Packets
req("PacketOutLogin.php");