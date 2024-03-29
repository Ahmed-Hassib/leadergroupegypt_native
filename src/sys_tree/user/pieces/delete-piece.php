<?php
// create an object of Piece Class
$pcs_obj = new PiecesDeletes();
// check if Get request piece-id is numeric and get the integer value
$piece_id = isset($_GET['piece-id']) && !empty($_GET['piece-id']) ? intval(base64_decode($_GET['piece-id'])) : 0;
// get back flag if return back is possible
$is_back = isset($_GET['back']) && !empty($_GET['back']) ? 'back' : null;
// get piece name
$piece_name = $pcs_obj->select_specific_column("`full_name`", "`pieces_info`", "WHERE `id` = $piece_id")[0]['full_name'];
// get user info from database
$is_exist = $pcs_obj->is_exist("`id`", "`pieces_info`", $piece_id);
// check if exist
if ($is_exist == true) {
  // check license
  if ($_SESSION['sys']['isLicenseExpired'] == 0) {
    // check if the piece have a children or not
    $count_child = $pcs_obj->count_records("`id`", "`pieces_info`", "WHERE `source_id` = $piece_id AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']));

    if ($count_child == 0) {
      // call delete function
      $is_deleted = $pcs_obj->temporary_delete_piece($piece_id, get_date_now());
      // check if deleted
      if ($is_deleted) {
        $pcs_obj->delete_piece($piece_id);
        // log message
        $log_msg = "Delete piece or client with name `$piece_name`";
        create_logs($_SESSION['sys']['username'], $log_msg, 3);

        // prepare flash session variables
        $_SESSION['flash_message'] = 'TEMPORARY DELETED';
        $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
        $_SESSION['flash_message_class'] = 'success';
        $_SESSION['flash_message_status'] = true;
        $_SESSION['flash_message_lang_file'] = $lang_file;
      } else {
        // prepare flash session variables
        $_SESSION['flash_message'] = 'QUERY PROBLEM';
        $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
        $_SESSION['flash_message_class'] = 'danger';
        $_SESSION['flash_message_status'] = false;
        $_SESSION['flash_message_lang_file'] = 'global_';
      }
    } else {
      // log message
      $log_msg = "You cannot delete the piece because it hase more than 1 child..";
      create_logs($_SESSION['sys']['username'], $log_msg, 2);

      // prepare flash session variables
      $_SESSION['flash_message'] = 'CANNOT DELETE';
      $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
      $_SESSION['flash_message_class'] = 'danger';
      $_SESSION['flash_message_status'] = false;
      $_SESSION['flash_message_lang_file'] = $lang_file;
    }
  } else {
    // prepare flash session variables
    $_SESSION['flash_message'] = 'FEATURE NOT AVAILABLE';
    $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
    $_SESSION['flash_message_class'] = 'danger';
    $_SESSION['flash_message_status'] = false;
    $_SESSION['flash_message_lang_file'] = 'global_';
  }
  // redirect to previous page
  redirect_home(null, $is_back, 0);
} else {
  // include no data founded module
  include_once $globmod . 'no-data-founded-no-redirect.php';
}
