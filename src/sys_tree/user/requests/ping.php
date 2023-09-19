<?php
// get ip
$ip = $_GET['ip'];
// get number of ping message
$c = isset($_GET['c']) && intval($_GET['c']) > 0 && $_GET['c'] != null ? intval($_GET['c']) : $_SESSION['sys']['ping_counter'];
// execute ping
$res = ping($ip, $c);
// return result
echo json_encode($res);