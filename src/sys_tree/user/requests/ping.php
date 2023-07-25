<?php
// get ip
$ip = $_GET['ip'];

$c = isset($_GET['c']) && intval($_GET['c']) > 0 && $_GET['c'] != null ? intval($_GET['c']) : $_SESSION['ping_counter'];

$command = "ping -n $c $ip";

$exec = exec($command, $output, $status);
$res = array(
  "output" => $output, 
  "status" => $status);

echo json_encode($res);