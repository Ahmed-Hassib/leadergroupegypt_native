<?php
// include mikrotic api
include_once $func . "api.php";
// create an object of RouterosAPI (Mikrotik API)
$mikrotik_api = new RouterosAPI();

// get mikrotik info
// get host
$host = $_GET['data'][0];
// get port
$port = $_GET['data'][1];
// get username
$username = $_GET['data'][2];
// get password
$password = $_GET['data'][3];

echo json_encode($mikrotik_api->connect($host, $username, $password));