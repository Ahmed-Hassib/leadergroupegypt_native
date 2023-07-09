<?php
// get ip
$ip = $_GET['ip'];

$command = "ping -n 1 $ip";

$exec = exec($command, $output, $status);
$res = array(
  "output" => $output, 
  "status" => $status);

echo json_encode($res);