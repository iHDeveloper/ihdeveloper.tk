<?php

function req_packet($file){
    require_once(__DIR__.'/'.$file);
}

// Packet
req_packet("Packet.php");
req_packet("PacketOut.php");
req_packet("PacketIn.php");

// Input Packets
req_packet("PacketInPing.php");
req_packet("PacketInLogin.php");

// Output Packets
req_packet("PacketOutLogin.php");
req_packet("PacketOutPong.php");
req_packet("PacketOutKick.php");