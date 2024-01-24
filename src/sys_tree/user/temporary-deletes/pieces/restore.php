<?php
// get piece id
$piece_id = isset($_GET['id']) && !empty($_GET['id']) ? base64_decode(trim($_GET['id'], " ")) : null;
// array of error
$err_arr = array();

// check piece id
if (!filter_var($piece_id, FILTER_VALIDATE_INT)) {
  $err_arr[] = 'THERE IS AN ERROR OR MISSING DATA';
}

// check error array
if (empty($err_arr)) {
  // create an object of PiecesDeletes class
  $pcs_del_obj = new PiecesDeletes();

  // check if piece id was exists
  if ($pcs_del_obj->is_exist("`id`", "`deleted_pieces_info`", $piece_id) && $pcs_del_obj->is_exist("`id`", "`deleted_pieces_dates`", $piece_id)) {
    // restore previous data
    $is_restored = $pcs_del_obj->restore_piece_data($piece_id);
    // delete previous data
    $is_restored = $pcs_del_obj->delete_piece_prev_data($piece_id);
    // prepare flash session variables
    $_SESSION['flash_message'] = 'PIECE RESTORED';
    $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
    $_SESSION['flash_message_class'] = 'success';
    $_SESSION['flash_message_status'] = true;
    $_SESSION['flash_message_lang_file'] = $lang_file;
  } else {
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
