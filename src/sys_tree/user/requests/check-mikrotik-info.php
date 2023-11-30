<?php
// include mikrotic api
include_once $func . "{$page_category}/api.php";
// create an object of RouterosAPI (Mikrotik API)
$mikrotik_api = new RouterosAPI();

// all data
$get_req_data = json_decode($_GET['data'][0]);
// check parameter data in GET request
if (isset($get_req_data) && !empty($get_req_data) && count($get_req_data) == 4) {

  // get mikrotik info
  // get host
  $host = $get_req_data[0];
  // get port
  $port = $get_req_data[1];
  // get username
  $username = $get_req_data[2];
  // get password
  $password = $get_req_data[3];

  echo json_encode($mikrotik_api->connect($host, $username, $password));
} else {
  echo json_encode(false);
}