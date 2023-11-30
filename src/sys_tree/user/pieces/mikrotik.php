<?php
// get data
$ip = isset($_POST['ip']) && !empty($_POST['ip']) ? $_POST['ip'] : null; // target ip
$port = isset($_POST['port']) && !empty($_POST['port']) ? $_POST['port'] : null; // target port

// empty array for errors
$errors = array();

// check ip
if ($ip == null || empty($ip)) {
  $errors[] = 'ip null';
}

// check port
if ($port == null || empty($port)) {
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
    $api_obj->comm("/interface/sstp-client/add", [
      "name" => $_SESSION['sys']['company_name'],
      "user" => $_SESSION['sys']['company_name'],
      "password" => $_SESSION['sys']['mikrotik']['password'],
      "connect-to" => "leadergroupegypt.com",
      "port" => "444"
    ]);

    // Enable the SSTP client
    $api_obj->comm("/interface/sstp-client/enable", [
      "find" => [
        "where" => [
          "name" => $_SESSION['sys']['company_name'],
        ]
      ]
    ]);
    // get users
    $users = $api_obj->comm(
      "/ip/firewall/nat/print",
      array(
        "?comment" => "mohamady",
        "?disabled" => "false"
      )
    );
    // check count of roles
    if ((count($users) < $opened_ports || empty($users)) && count($users) < 10) {
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
          "to-addresses" => $ip,
          "to-ports" => $port
        )
      );
    } else {
      // get id
      $id = $users[$opened_ports]['.id'];
      // change ir in api
      $users = $api_obj->comm(
        "/ip/firewall/nat/set",
        array(
          "numbers" => $id,
          "to-ports" => $port,
          "to-addresses" => $ip,
        )
      );
    }

    $api_obj->connect($conf['mikrotik']['ip'], $conf['mikrotik']['username'], $conf['mikrotik']['password']);
    // get server users
    $server_users = $api_obj->comm(
      "/ip/firewall/nat/print",
      array(
        "?comment" => $_SESSION['sys']['company_name'],
        "?disabled" => "false"
      )
    );

    if ((empty($server_users) || count($server_users) < $opened_ports) && count($server_users) < 10) {
      // create a new role
      $server_users = $api_obj->comm(
        "/ip/firewall/nat/add",
        array(
          "action" => "dst-nat",
          "chain" => "dstnat",
          "comment" => $_SESSION['sys']['company_name'],
          "dst-port" => $next_port,
          "in-interface" => "ether1",
          "protocol" => "tcp",
          "to-addresses" => $_SESSION['sys']['remote_ip'],
          "to-ports" => $next_port
        )
      );
    } else {
      // get id
      $id = $server_users[$opened_ports]['.id'];
      // change ir in api
      $server_users = $api_obj->comm(
        "/ip/firewall/nat/set",
        array(
          "numbers" => $id,
          "to-ports" => $next_port,
          "to-addresses" => $_SESSION['sys']['remote_ip'],
        )
      );
    }


    // protocol
    $protocol = $port == 80 ? 'http' : 'https';
    // url
    $url = "{$protocol}://leadergroupegypt.com:{$next_port}/";

    echo "<div dir='ltr'>";
    // target link
    echo "If not redirect after 3 sec <a href='$url'>click here</a><br>";
    echo "</div>";
    // redirect page to url to open device
    header("refresh:0;url=$url");
    die;
  } else {
    // prepare flash session variables
    $_SESSION['flash_message'] = 'MIKROTIK FAILED';
    $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
    $_SESSION['flash_message_class'] = 'danger';
    $_SESSION['flash_message_status'] = false;
    $_SESSION['flash_message_lang_file'] = '_global';
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
    $_SESSION['flash_message_lang_file'][$key] = $lang_file;
  }
  // redirect to the previous page
  redirect_home(null, "back", 0);
}
