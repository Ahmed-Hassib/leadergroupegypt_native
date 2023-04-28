<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // create an object of Pieces class
  $pcs_obj = new Pieces();
  // get latest id in pieces table
  $latest_id = intval($pcs_obj->get_latest_records("`id`", "`pieces_info`", "", "`id`", 1)[0]['id']);
  // get next id
  $id = $latest_id + 1;
  // get piece info from the form
  $full_name  = isset($_POST['full-name'])  && !empty($_POST['full-name'])  ? trim($_POST['full-name'], ' ')  : '';
  $ip         = isset($_POST['ip'])         && !empty($_POST['ip'])         ? trim($_POST['ip'], ' ')         : '';
  $username   = isset($_POST['user-name'])  && !empty($_POST['user-name'])  ? trim($_POST['user-name'], ' ')  : '';
  $password   = isset($_POST['password'])   && !empty($_POST['password'])   ? trim($_POST['password'], ' ')   : '';
  $dir_id     = isset($_POST['direction'])  && !empty($_POST['direction'])  ? trim($_POST['direction'], ' ')  : '';

  // check if client or not
  if (isset($_POST['is-client'])) {
    // get value
    $is_client_value = $_POST['is-client'];
    // switch ... case
    switch ($is_client_value) {
      case 0:
        // make it client
        $is_client   = 1;
        $device_type = 0;
      break;
      
      case 1:
        // make it transmitter
        $is_client   = 0;
        $device_type = 1;
      break;
      
      case 2:
        // make it receiver
        $is_client   = 0;
        $device_type = 2;
      break;
      
      default:
        // make it default
        $is_client   = -1;
        $device_type = -1;
      break;
    }
  } else {
    // make it default
    $is_client   = -1;
    $device_type = -1;
  }

  // get source id
  $source_id      = isset($_POST['source-id']) ? trim($_POST['source-id'], ' ')   : -1;
  $alt_source_id  = isset($_POST['alt-source-id']) ? trim($_POST['alt-source-id'], ' ')   : -1;
  $device_id      = isset($_POST['device-id']) ? trim($_POST['device-id'], ' ')   : -1;
  $model_id       = isset($_POST['device-model']) ? trim($_POST['device-model'], ' ')   : -1;

  $phone      = trim($_POST['phone-number'], ' ');
  $address    = trim($_POST['address'], ' ');
  $conn_type  = isset($_POST['conn-type'])  && !empty($_POST['conn-type']) ? trim($_POST['conn-type'], ' ')  : '';
  $notes      = empty(trim($_POST['notes'], ' ')) ? 'لا توجد ملاحظات' : trim($_POST['notes'], ' ');
  $visit_time = isset($_POST['visit-time']) ? $_POST['visit-time'] : 1;
  $ssid       = trim($_POST['ssid'], ' ');
  $pass_conn  = trim($_POST['password-connection'], ' ');
  $frequency  = trim($_POST['frequency'], ' ');
  $wave       = trim($_POST['wave'], ' ');
  $mac_add    = trim($_POST['mac-add'], ' ');

  // validate the form
  $form_error = []; // error array

  if ($source_id == $id) {
    $source_id = 0;
  }

  if ($alt_source_id == $id) {
    $alt_source_id = 0;
  }

  // empty message
  $msg = '';
  // check if empty form error
  if (empty($form_error)) {
    // check if user is exist in database or not
    $is_exist_name  = $pcs_obj->count_records("`id`", "`pieces_info`", "WHERE `full_name` = $full_name AND `company_id` = " . $_SESSION['company_id']);
    $is_exist_mac   = !empty($macAdd) ? $pcs_obj->count_records("`pieces_mac_addr`.`id`", "`pieces_mac_addr`", "LEFT JOIN `pieces_info` ON `pieces_info`.`id` = `pieces_mac_addr`.`id` WHERE `pieces_mac_addr`.`mac_add` = $mac_add AND `pieces_info`.`company_id` = ".$_SESSION['company_id']) : 0;
    $is_exist_ip    = $ip == '0.0.0.0' ? 0 : $pcs_obj->count_records("`id`", "`pieces_info`", "WHERE `ip` = '$ip' AND `direction_id` = $dir_id AND `company_id` = " . $_SESSION['company_id']);
    // check piece name
    if ($is_exist_name > 0) {
      // show erroe message
      $msg = '<div class="alert alert-warning text-capitalize"><i class="bi bi-exclamation-triangle-fill"></i>&nbsp;'.language('THIS USERNAME IS ALREADY EXIST', @$_SESSION['systemLang']).'</div>';
    } elseif ($is_exist_mac > 0) {
      $msg = '<div class="alert alert-warning text-capitalize"><i class="bi bi-exclamation-triangle-fill"></i>&nbsp;'.language('THIS MAC ADD IS ALREADY EXIST', @$_SESSION['systemLang']).'</div>';
    } elseif ($is_exist_ip > 0) {
      $msg = '<div class="alert alert-warning text-capitalize"><i class="bi bi-exclamation-triangle-fill"></i>&nbsp;'.language('THIS IP ADD IS ALREADY EXIST', @$_SESSION['systemLang']).'</div>';
    } else {
      // create an array of piece info
      $pcs_info = array();
      // push piece info into an array
      array_push($pcs_info, $full_name, $ip, $username, $password, $conn_type, $dir_id, $source_id, $alt_source_id, $is_client, $device_type, $device_id, $model_id, $_SESSION['UserID'], get_date_now(), $_SESSION['company_id'], $notes, $visit_time);
      // call insert function
      $is_inserted = $pcs_obj->insert_new_piece($pcs_info);

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
      
      // echo success message
      $msg = '<div class="alert alert-success text-capitalize" dir="' . (@$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr') . '"><i class="bi bi-check-circle-fill"></i>&nbsp;' . language('PIECE/CLIENT ADDED SUCCESSFULLY', @$_SESSION['systemLang']) . '</div>';
    }
  } else {
    // echo success message
    $msg = '<div class="alert alert-danger text-capitalize" dir="' . (@$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr') . '"><i class="bi bi-exclamation-triangle-fill"></i>&nbsp;' . language('A PROPLEM HAS BEEN HAPPEND WHILE INSERTING A PIECE/CLIENT', @$_SESSION['systemLang']) . '</div>';
    // loop on errors
    foreach($form_error as $error) {
      $msg .= '<div class="alert alert-danger text-capitalize" dir="' . (@$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr') . '"><i class="bi bi-exclamation-triangle-fill"></i>&nbsp;' . language(strtoupper($error), @$_SESSION['systemLang']) . '</div>';
    }
  } 
?>    
<!-- start edit profile page -->
<div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
    <!-- start header -->
    <header class="header">
      <?php redirectHome($msg, 'back'); ?>
    </header>
</div>
<?php } else {
  // include permission error module
  include_once $globmod . 'permission-error.php';
} ?>