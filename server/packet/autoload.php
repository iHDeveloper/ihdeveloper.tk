<?php

function req_packet($file){
    require_once(__DIR__.'/'.$file);
}

// Packet
req_packet("Packet.php");
req_packet("PacketOut.php");

// Output Packets
req_packet("PacketOutLogin.php");