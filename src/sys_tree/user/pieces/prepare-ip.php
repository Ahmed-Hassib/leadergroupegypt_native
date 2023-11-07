<?php
// get data
$address = isset($_GET['address']) && !empty($_GET['address']) ? $_GET['address'] : -1; // target ip
$port = isset($_GET['port']) && !empty($_GET['port']) ? $_GET['port'] : 443; // target port

// empty array for errors
$errors = array();

// check address
if ($address == -1 || empty($address)) {
  $errors[] = 'ip null';
}

// check port
if ($port <= 0 || empty($port)) {
  $errors[] = 'port null';
}

// check if array of erros is empty or not
if (empty($errors)) {
  // create an object of Pieces class
  $pcs_obj = new Pieces();
  // create an object of Company class
  $company_obj = new Company();
  // check number of opened port from database
  $opened_ports = intval($pcs_obj->select_specific_column("`opened_ports`", "`companies`", "WHERE `company_id` = " . base64_decode($_SESSION['sys']['company_id']))[0]['opened_ports']);
  // check number of opened ports
  if ($opened_ports >= 10) {
    // reset opened ports
    $opened_ports = 0;
  } else {
    // increase opened ports
    $opened_ports += 1;
  }
  // update number of opened port in database
  $company_obj->update_opened_ports(base64_decode($_SESSION['sys']['company_id']), $opened_ports);
  // get next port
  $next_port = intval($_SESSION['sys']['company_port']) + $opened_ports + 1;
  // connect to mikrotik api
  if ($api_obj->connect($mikrotik_ip, $mikrotik_username, $mikrotik_password)) {
    // get users
    $users = $api_obj->comm(
      "/ip/firewall/nat/print",
      array(
        "?comment" => "mohamady",
        "?disabled" => "false"
      )
    );
    // check count of roles
    if (count($users) < $opened_ports) {
      // create a new role
      $users = $api_obj->comm(
        "/ip/firewall/nat/add",
        array(
          "action" => "dst-nat",
          "chain" => "dstnat",
          "comment" => "mohamady",
          "dst-port" => $next_port,
          "in-interface" => "MANAGEMENT-SYSTEM",
          "protocol" => "tcp",
          "to-addressed" => $address,
          "to-ports" => $port
        )
      );
    } else {
      // get id
      $id = $users[0]['.id'];
      // change ir in api
      $users = $api_obj->comm(
        "/ip/firewall/nat/set",
        array(
          "numbers" => $id,
          "to-ports" => $port,
          "to-addresses" => $address,
        )
      );
    }

    // protocol
    $protocol = $port == 80 ? 'http' : 'https';
    // url
    $url = "$protocol://leadergroupegypt.com:$next_port/";


    echo "<div dir='ltr'>";
    // show success message 
    echo "<h3 class='h3 text-success'>" . lang('MIKROTIK SUCCESS') . "</h3>";
    // target link
    echo "If not redirect after 3 sec <a href='$url'>click here</a>";
    echo "</div>";
    // redirect page to url to open device
    // header("refresh:0;url=$url");
    // die;
  } else {
    // show success message 
    echo "<h3 class='h3 text-success'>" . lang('MIKROTIK FAILED') . "</h3>";
    // redirect to the previous page
    redirect_home(null, "back", 5);
  }
} else {
  foreach ($errors as $key => $error) {
    // prepare flash session variables
    $_SESSION['flash_message'][$key] = strtoupper($error);
    $_SESSION['flash_message_icon'][$key] = 'bi-exclamation-triangle-fill';
    $_SESSION['flash_message_class'][$key] = 'danger';
    $_SESSION['flash_message_status'][$key] = false;
    $_SESSION['flash_message_lang_file'][$key] = 'global_';
  }
  // redirect to the previous page
  redirect_home(null, "back", 0);
}