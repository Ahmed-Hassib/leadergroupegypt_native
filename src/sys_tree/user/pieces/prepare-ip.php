<?php
// get data
$id = isset($_GET['id']) && !empty($_GET['id']) ? base64_decode($_GET['id']) : -1; // get id
$address = isset($_GET['address']) && !empty($_GET['address']) ? $_GET['address'] : -1;  // target ip
$port = isset($_GET['port']) && !empty($_GET['port']) ? $_GET['port'] : 443; // target port

// empty array for errors
$errors = array();

// check id
if ($id == -1 || empty($id)) {
  $errors[] = 'id cannot be empty';
}

// check address
if ($address == -1 || empty($address)) {
  $errors[] = 'ip address cannot be empty';
}

// check port
if ($port == -1 || empty($port)) {
  $errors[] = 'port cannot be empty';
}

// check if array of erros is empty or not
if (empty($errors)) {
  // change ir in api
  $users = $API->comm("/ip/firewall/nat/set", array(
    "numbers" => $id,
    "to-ports" => $port,
    "to-addresses" => $address,
  ));

  // redirect page to url to open device
  header("refresh:0;url=https://leadergroupegypt.com:5002/");
  die;
} else {
  foreach ($errors as $key => $error) {
    // prepare flash session variables
    $_SESSION['flash_message'][$key] = strtoupper($error);
    $_SESSION['flash_message_icon'][$key] = 'bi-exclamation-triangle-fill';
    $_SESSION['flash_message_class'][$key] = 'danger';
    $_SESSION['flash_message_status'][$key] = false;
  }
  // redirect to the previous page
  redirectHome(null, "back", 0);
}
