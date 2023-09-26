<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // create an object of Pieces class
  $pcs_obj = !isset($pcs_obj) ? new Pieces() : $pcs_obj;
  // get latest id in pieces table
  $latest_id = intval($pcs_obj->get_latest_records("`id`", "`pieces_info`", "", "`id`", 1)[0]['id']);
  // get next id
  $id = $latest_id + 1;
  // get piece info from the form
  $full_name = isset($_POST['full-name']) && !empty($_POST['full-name']) ? trim($_POST['full-name'], ' ') : '';
  $ip = isset($_POST['ip']) && !empty($_POST['ip']) ? trim($_POST['ip'], ' ') : '';
  $port = isset($_POST['port']) && !empty($_POST['port']) ? trim($_POST['port'], ' ') : '';
  $username = isset($_POST['user-name']) && !empty($_POST['user-name']) ? trim($_POST['user-name'], ' ') : '';
  $password = isset($_POST['password']) && !empty($_POST['password']) ? trim($_POST['password'], ' ') : '';
  $dir_id = isset($_POST['direction']) && !empty($_POST['direction']) ? base64_decode(trim($_POST['direction'], ' ')) : '';

  // make it client
  $is_client = 1;
  $device_type = 0;

  // get source id
  $source_id = isset($_POST['source-id']) ? trim($_POST['source-id'], ' ') : -1;
  $alt_source_id = isset($_POST['alt-source-id']) ? trim($_POST['alt-source-id'], ' ') : -1;
  $device_id = isset($_POST['device-id']) ? base64_decode(trim($_POST['device-id'], ' ')) : -1;
  $model_id = isset($_POST['device-model']) ? trim($_POST['device-model'], ' ') : -1;

  $phone = trim($_POST['phone-number'], ' ');
  $address = trim($_POST['address'], ' ');
  $conn_type = isset($_POST['conn-type']) && !empty($_POST['conn-type']) ? trim($_POST['conn-type'], ' ') : '';
  $notes = empty(trim($_POST['notes'], ' ')) ? 'لا توجد ملاحظات' : trim($_POST['notes'], ' ');
  $visit_time = isset($_POST['visit-time']) ? $_POST['visit-time'] : 1;
  $ssid = trim($_POST['ssid'], ' ');
  $pass_conn = trim($_POST['password-connection'], ' ');
  $frequency = trim($_POST['frequency'], ' ');
  $wave = trim($_POST['wave'], ' ');
  $mac_add = trim($_POST['mac-add'], ' ');
  $internet_source = trim($_POST['internet-source'], ' ');

  // validate the form
  $form_error = []; // error array

  if ($source_id == $id) {
    $source_id = 0;
  }

  if ($alt_source_id == $id) {
    $alt_source_id = 0;
  }

  // check if user is exist in database or not
  $is_exist_name = $pcs_obj->count_records("`id`", "`pieces_info`", "WHERE `full_name` = '$full_name' AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']));
  $is_exist_mac = !empty($macAdd) ? $pcs_obj->count_records("`pieces_mac_addr`.`id`", "`pieces_mac_addr`", "LEFT JOIN `pieces_info` ON `pieces_info`.`id` = `pieces_mac_addr`.`id` WHERE `pieces_mac_addr`.`mac_add` = $mac_add AND `pieces_info`.`company_id` = " . base64_decode($_SESSION['sys']['company_id'])) : 0;
  $is_exist_ip = $ip == '0.0.0.0' ? 0 : $pcs_obj->count_records("`id`", "`pieces_info`", "WHERE `ip` = '$ip' AND `direction_id` = $dir_id AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']));

  // check piece name
  if ($is_exist_name > 0) {
    $form_error[] = 'name exist';
  }

  // check piece mac
  if ($is_exist_mac > 0) {
    $form_error[] = 'ip exist';
  }

  // check piece mac
  if ($is_exist_ip > 0) {
    $form_error[] = 'mac exist';
  }

  // check if empty form error
  if (empty($form_error)) {
    // get current date
    $date_now = get_date_now();
    // call insert function
    $is_inserted = $pcs_obj->insert_new_piece(array($full_name, $ip, $port, $username, $password, $conn_type, $dir_id, $source_id, $alt_source_id, $is_client, $device_type, $device_id, $model_id, base64_decode($_SESSION['sys']['UserID']), get_date_now(), base64_decode($_SESSION['sys']['company_id']), $notes, $visit_time));

    // check address
    if (!empty($address)) {
      // echo "<br>* address is not empty<br>";
      // insert address
      $pcs_obj->insert_address($id, $address);
    }

    // check frequency
    if (!empty($frequency)) {
      // echo "<br>* frequency is not empty<br>";
      // insert frequency
      $pcs_obj->insert_frequency($id, $frequency);
    }

    // check mac_add
    if (!empty($mac_add)) {
      // echo "<br>* mac add is not empty<br>";
      // insert mac_add
      $pcs_obj->insert_mac_add($id, $mac_add);
    }

    // check pass_connection
    if (!empty($pass_conn)) {
      // echo "<br>* pass connection is not empty<br>";
      // insert pass_conn
      $pcs_obj->insert_pass_connection($id, $pass_conn);
    }

    // check phones
    if (!empty($phone)) {
      // echo "<br>* phone is not empty<br>";
      // insert phones
      $pcs_obj->insert_phones($id, $phone);
    }

    // check ssid
    if (!empty($ssid)) {
      // echo "<br>* ssid is not empty<br>";
      // insert ssid
      $pcs_obj->insert_ssid($id, $ssid);
    }

    // check wave
    if (!empty($wave)) {
      // echo "<br>* wave is not empty<br>";
      // insert wave
      $pcs_obj->insert_wave($id, $wave);
    }

    // check internet source
    if (!empty($internet_source)) {
      // echo "<br>* internet source is not empty<br>";
      // insert internet source
      $pcs_obj->insert_internet_source($id, $internet_source);
    }

    // check if inserted
    if ($is_inserted) {
      // prepare flash session variables
      $_SESSION['flash_message'] = 'INSERTED';
      $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
      $_SESSION['flash_message_class'] = 'success';
      $_SESSION['flash_message_status'] = true;
      $_SESSION['flash_message_lang_file'] = 'clients';
    } else {
      // assign POST request data to session
      $_SESSION['sys']['request_data'] = $_POST;
      // prepare flash session variables
      $_SESSION['flash_message'] = 'QUERY PROBLEM';
      $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
      $_SESSION['flash_message_class'] = 'danger';
      $_SESSION['flash_message_status'] = false;
      $_SESSION['flash_message_lang_file'] = 'global_';
    }
  } else {
    // assign POST request data to session
    $_SESSION['sys']['request_data'] = $_POST;
    // loop on errors
    foreach ($form_error as $key => $error) {
      // prepare flash session variables
      $_SESSION['flash_message'][$key] = strtoupper($error);
      $_SESSION['flash_message_icon'][$key] = 'bi-exclamation-triangle-fill';
      $_SESSION['flash_message_class'][$key] = 'danger';
      $_SESSION['flash_message_status'][$key] = false;
      $_SESSION['flash_message_lang_file'][$key] = 'clients';
    }
  }
  // redirect to previous page
  redirect_home(null, 'back', 0);
} else {
  // include permission error module
  include_once $globmod . 'permission-error.php';
}