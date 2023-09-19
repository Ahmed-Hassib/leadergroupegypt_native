<?php
// create an object of Piece Class
$pcs_obj = !isset($pcs_obj) ? new Pieces() : $pcs_obj;
// check if Get request client-id is numeric and get the integer value
$client_id = isset($_GET['client-id']) && !empty($_GET['client-id']) ? base64_decode($_GET['client-id']) : 0;
// get client name
$client_name = $pcs_obj->select_specific_column("`full_name`", "`pieces_info`", "WHERE `id` = $client_id")[0]['full_name'];
// get back flag if return back is possible
$is_back = isset($_GET['back']) && !empty($_GET['back']) ? 'back' : null;
// get user info from database
$is_exist = $pcs_obj->is_exist("`id`", "`pieces_info`", $client_id);
// check if exist
if ($is_exist == true) {
  // check if the client have a children or not
  $count_child = $pcs_obj->count_records("`id`", "`pieces_info`", "WHERE `source_id` = $client_id AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']));
  // check the counter
  if ($is_exist > 0 && $count_child == 0) {
    // call delete function
    $pcs_obj->delete_piece($client_id);
    // log message
    $logMsg = "Delete client with name `$client_name`";
    create_logs($_SESSION['sys']['UserName'], $logMsg, 3);
    // prepare flash session variables
    $_SESSION['flash_message'] = 'DELETED';
    $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
    $_SESSION['flash_message_class'] = 'success';
    $_SESSION['flash_message_status'] = true;
    $_SESSION['flash_message_lang_file'] = 'clients';
  } else {
    // log message
    $logMsg = "You cannot delete the client because it hase more than 1 child..";
    create_logs($_SESSION['sys']['UserName'], $logMsg, 2);
    // prepare flash session variables
    $_SESSION['flash_message'] = 'CANNOT DELETE';
    $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
    $_SESSION['flash_message_class'] = 'danger';
    $_SESSION['flash_message_status'] = false;
    $_SESSION['flash_message_lang_file'] = 'pieces';
  }
  // redirect to the previous page
  redirect_home(null, $is_back, 0);
} else {
  // include no data founded module
  include_once $globmod . 'no-data-founded-no-redirect.php';
}
