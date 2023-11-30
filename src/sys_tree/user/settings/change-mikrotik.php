<?php
// check the request post
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // get company id
  $company_id = base64_decode($_SESSION['sys']['company_id']);
  // create an object of Company class
  $company_obj = !isset($company_obj) ? new Company() : $company_obj;
  // create an object of Session class
  $session_obj = !isset($session_obj) ? new Session() : $session_obj;
  // get user info
  $user_info = $session_obj->get_user_info(base64_decode($_SESSION['sys']['UserID']));

  // array of errors
  $err_arr = array();

  // get mikrotik data
  $ip = isset($_POST['mikrotik-ip']) && !empty($_POST['mikrotik-ip']) ? $_POST['mikrotik-ip'] : null;
  $port = isset($_POST['mikrotik-port']) && !empty($_POST['mikrotik-port']) ? $_POST['mikrotik-port'] : null;
  $username = isset($_POST['mikrotik-username']) && !empty($_POST['mikrotik-username']) ? $_POST['mikrotik-username'] : null;
  $password = isset($_POST['mikrotik-password']) && !empty($_POST['mikrotik-password']) ? $_POST['mikrotik-password'] : null;

  // ip validation
  if ($ip == null) {
    $err_arr[] = 'ip empty';
  }

  // port validation
  if ($port == null) {
    $err_arr[] = 'port empty';
  }

  // username validation
  if ($username == null) {
    $err_arr[] = 'username empty';
  }

  // password validation
  if ($password == null) {
    $err_arr[] = 'password empty';
  }

  // create a new object of mikrotik api
  $mikrotik_api_obj = new RouterosAPI();
  // // make debug flag => true
  // $mikrotik_api_obj->debug = true;

  // connect to cloud server of mikrotik
  if (!$mikrotik_api_obj->connect($conf['mikrotik']['ip'], $conf['mikrotik']['username'], $conf['mikrotik']['password'])) {
    $errors[] = 'process error';
  }

  if (empty($err_arr)) {
    // call function to update info
    $is_updated = $company_obj->update_mikrotik(array($ip, $port, $username, $password, $company_id));
    // check if changed
    if ($is_updated) {
      // prepare flash session variables
      $_SESSION['flash_message'] = 'MIKROTIK UPDATED';
      $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
      $_SESSION['flash_message_class'] = 'success';
      $_SESSION['flash_message_status'] = true;
      $_SESSION['flash_message_lang_file'] = 'settings';

      // log message
      $logMsg = "mikrotik info was updated successfully by " . $_SESSION['sys']['UserName'] . " at " . date('D d/m/Y h:i a');

      // check if done
      if ($user_info[0] == true) {
        // set user session
        $session_obj->set_user_session($user_info[1]);
      }
    } else {
      // prepare flash session variables
      $_SESSION['flash_message'] = 'NO CHANGES';
      $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
      $_SESSION['flash_message_class'] = 'info';
      $_SESSION['flash_message_status'] = false;
      $_SESSION['flash_message_lang_file'] = 'global_';
      // log message
      $logMsg = "there is no data was added to update mikrotik info";
    }

    $next_ip = $db_obj->select_specific_column("`next_remote_ip`", "`settings`", "LIMIT 1")[0]["next_remote_ip"];
    $is_exist_remote_ip = $db_obj->is_exist("`remote_ip`", "`companies`", "{$next_ip}");
    $is_exist_company_remote_ip = $company_obj->get_remote_ip("{$company_id}");
    
    if (!empty($is_exist_company_remote_ip)) {
      $remote_ip = $is_exist_company_remote_ip;
    } else {
      if ($is_exist_remote_ip == true) {
        $remote_ip = get_next_ip($next_ip);
        $db_obj->set_next_remote_ip($remote_ip);
      } else {
        $remote_ip = $next_ip;
      }
    }    
    $company_obj->set_remote_ip($company_id, $remote_ip);

    // check if done
    if ($user_info[0] == true) {
      // set user session
      $session_obj->set_user_session($user_info[1]);
    }
    // create a secret role in ppp
    $mikrotik_api_obj->comm("/ppp/secret/add", [
      "name" => $_SESSION['sys']['company_name'],
      "password" => $_SESSION["sys"]["mikrotik"]["password"],
      "service" => "any",
      "remote-address" => $remote_ip,
    ]);

  } else {
    // prepare flash session variables
    foreach ($err_arr as $key => $err) {
      $_SESSION['flash_message'][$key] = strtoupper($err);
      $_SESSION['flash_message_icon'][$key] = 'bi-exclamation-triangle-fill';
      $_SESSION['flash_message_class'][$key] = 'danger';
      $_SESSION['flash_message_status'][$key] = false;
      $_SESSION['flash_message_lang_file'][$key] = 'settings';
    }

    // log message
    $logMsg = "mikrotik was not updated because there is a problem while updating it";
  }
  // create a log
  create_logs($_SESSION['sys']['UserName'], $logMsg);
  // redirect home
  redirect_home(null, 'back', 0);
} else {
  // include_once per
  include_once $globmod . 'permission-error.php';
}
