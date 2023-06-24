<?php
if (!isset($pcs_obj)) {
  // create an object of Piece Class
  $pcs_obj = new Pieces();
}
// check if Get request client-id is numeric and get the integer value
$client_id = isset($_GET['client-id']) && is_numeric($_GET['client-id']) ? intval($_GET['client-id']) : 0;
// get client name
$client_name = $pcs_obj->select_specific_column("`full_name`", "`pieces_info`", "WHERE `id` = $client_id")[0]['full_name'];
// get back flag if return back is possible
$is_back = isset($_GET['back']) && !empty($_GET['back']) ? 'back' : null;
// get user info from database
$is_exist = $pcs_obj->is_exist("`id`", "`pieces_info`", $client_id);
// check if exist
if ($is_exist == true) {
  // check if the client have a children or not
  $count_child = $pcs_obj->count_records("`id`", "`pieces_info`", "WHERE `source_id` = $client_id AND `company_id` = ".$_SESSION['company_id']);
  // check the counter
  if ($is_exist > 0 && $count_child == 0) {
    // call delete function
    $pcs_obj->delete_piece($client_id); 
    // log message
    $logMsg = "Delete client with name `" . $client_name . "`";
    createLogs($_SESSION['UserName'], $logMsg, 3);
    // prepare flash session variables
    $_SESSION['flash_message'] = 'CLIENT INFO WAS DELETED SUCCESSFULLY';
    $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
    $_SESSION['flash_message_class'] = 'success';
    $_SESSION['flash_message_status'] = true;
  } else {
    // log message
    $logMsg = "You cannot delete the client because it hase more than 1 child..";
    createLogs($_SESSION['UserName'], $logMsg, 2);
    // prepare flash session variables
    $_SESSION['flash_message'] = 'YOU CANNOT DELETE THIS PIECE BECAUSE IT HAVE MORE THAN 1 CHILD';
    $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
    $_SESSION['flash_message_class'] = 'danger';
    $_SESSION['flash_message_status'] = false;
  } 
  // redirect to the previous page
  redirectHome(null, $is_back, 0);
} else {
  // include no data founded module
  include_once $globmod . 'no-data-founded-no-redirect.php';
}