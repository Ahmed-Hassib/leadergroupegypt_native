<?php
// get data

use function PHPSTORM_META\type;

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
  // check if Pieces class object was created or not
  if (!isset($pcs_obj)) {
    $pcs_obj = new Pieces();
  }
  // check if Company class object was created or not
  if (!isset($company_obj)) {
    $company_obj = new Company();
  }
  // check number of opened port from database
  $opened_ports = intval($pcs_obj->select_specific_column("`opened_ports`", "`companies`", "WHERE `company_id` = " . $_SESSION['company_id'])[0]['opened_ports']);
  // check number of opened ports
  if ($opened_ports >= 10) {
    // reset opened ports
    $opened_ports =  0;
  } else {
    // increase opened ports
    $opened_ports += 1;
  }
  // update number of opened port in database
  $company_obj->update_opened_ports($_SESSION['company_id'], $opened_ports);
  // get next port
  $next_port = intval($_SESSION['company_port']) + $opened_ports + 2;

  // change ir in api
  $users = $API->comm("/ip/firewall/nat/set", array(
    "numbers" => $id,
    "to-ports" => $port,
    "to-addresses" => $address,
  ));

  echo "If not redirect after 3 sec <a href='https://94.130.39.215:$next_port/'>click here</a>";
  // redirect page to url to open device
  header("refresh:0;url=https://94.130.39.215:$next_port/");
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
  redirect_home(null, "back", 0);
}
