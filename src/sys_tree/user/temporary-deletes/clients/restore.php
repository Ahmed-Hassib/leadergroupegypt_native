<?php
// get client id
$client_id = isset($_GET['id']) && !empty($_GET['id']) ? base64_decode(trim($_GET['id'], " ")) : null;
// array of error
$err_arr = array();

// check client id
if (!filter_var($client_id, FILTER_VALIDATE_INT)) {
  $err_arr[] = 'THERE IS AN ERROR OR MISSING DATA';
}

// check error array
if (empty($err_arr)) {
  // create an object of ClientsDeletes class
  $clts_del_obj = new ClientsDeletes();

  // check if client id was exists
  if ($clts_del_obj->is_exist("`id`", "`deleted_pieces_info`", $client_id) && $clts_del_obj->is_exist("`id`", "`deleted_pieces_dates`", $client_id)) {
    // restore previous data
    $is_restored = $clts_del_obj->restore_client_data($client_id);
    // delete previous data
    $is_restored = $clts_del_obj->delete_client_prev_data($client_id);
    // prepare flash session variables
    $_SESSION['flash_message'] = 'CLIENT RESTORED';
    $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
    $_SESSION['flash_message_class'] = 'success';
    $_SESSION['flash_message_status'] = true;
    $_SESSION['flash_message_lang_file'] = $lang_file;
  } else {
    // prepare flash session variables
    $_SESSION['flash_message'] = 'NO DATA';
    $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
    $_SESSION['flash_message_class'] = 'danger';
    $_SESSION['flash_message_status'] = false;
    $_SESSION['flash_message_lang_file'] = 'global_';
  }
} else {
  foreach ($err_arr as $key => $error) {
    // prepare flash session variables
    $_SESSION['flash_message'][$key] = strtoupper($error);
    $_SESSION['flash_message_icon'][$key] = 'bi-exclamation-triangle-fill';
    $_SESSION['flash_message_class'][$key] = 'danger';
    $_SESSION['flash_message_status'][$key] = false;
    $_SESSION['flash_message_lang_file'][$key] = 'global_';
  }
}

// redirect back
redirect_home(null, 'back', 0);
