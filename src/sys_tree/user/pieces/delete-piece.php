<?php
if (!isset($pcs_obj)) {
  // create an object of Piece Class
  $pcs_obj = new Pieces();
}

// check if Get request piece-id is numeric and get the integer value
$piece_id = isset($_GET['piece-id']) && is_numeric($_GET['piece-id']) ? intval($_GET['piece-id']) : 0;
// get back flag if return back is possible
$is_back = isset($_GET['back']) && !empty($_GET['back']) ? 'back' : null;
// get piece name
$piece_name = $pcs_obj->select_specific_column("`full_name`", "`pieces_info`", "WHERE `id` = $piece_id")[0]['full_name'];
// get user info from database
$is_exist = $pcs_obj->is_exist("`id`", "`pieces_info`", $piece_id);
// check if exist
if ($is_exist == true) {
  // check if the piece have a children or not
  $count_child = $pcs_obj->count_records("`id`", "`pieces_info`", "WHERE `source_id` = $piece_id AND `company_id` = ".$_SESSION['company_id']);

  if ($count_child == 0) {
    // call delete function
    $pcs_obj->delete_piece($piece_id); 
    // log message
    $logMsg = "Delete piece or client with name `" . $piece_name . "`";
    createLogs($_SESSION['UserName'], $logMsg, 3);

    // prepare flash session variables
    $_SESSION['flash_message'] = 'PIECE INFO WAS DELETED SUCCESSFULLY';
    $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
    $_SESSION['flash_message_class'] = 'success';
    $_SESSION['flash_message_status'] = true;
  } else {
    // log message
    $logMsg = "You cannot delete the piece because it hase more than 1 child..";
    createLogs($_SESSION['UserName'], $logMsg, 2);
    
    // prepare flash session variables
    $_SESSION['flash_message'] = 'YOU CANNOT DELETE THIS PIECE BECAUSE IT HAVE MORE THAN 1 CHILD';
    $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
    $_SESSION['flash_message_class'] = 'danger';
    $_SESSION['flash_message_status'] = false;
  } 
  // redirect to previous page
  redirectHome(null, $is_back, 0);
} else {
  // include no data founded module
  include_once $globmod . 'no-data-founded-no-redirect.php';
}