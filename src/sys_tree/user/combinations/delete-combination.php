<?php
// get combination id
$comb_id = isset($_GET['comb-id']) && intval($_GET['comb-id']) ? intval($_GET['comb-id']) : 0;
if (!isset($comb_obj)) {
  // create an object of Combination
  $comb_obj = new Combination();
}
// check if the current combination id is exist or not
$is_exist = $comb_obj->is_exist("`comb_id`", "`combinations`", $comb_id);
// get back flag if return back is possible
$is_back = isset($_GET['back']) && !empty($_GET['back']) ? 'back' : null;

if ($is_exist == true) {
  // call delete function
  $is_deleted = $comb_obj->delete_combination($comb_id);

  // check if deleted
  if ($is_deleted == true) {
  // prepare flash session variables
    $_SESSION['flash_message'] = 'COMBINATION WAS DELETED SUCCESSFULLY';
    $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
    $_SESSION['flash_message_class'] = 'success';
    $_SESSION['flash_message_status'] = true;
  } else {    
    // prepare flash session variables
    $_SESSION['flash_message'] = 'A PROBLEM WAS HAPPENED WHILE DELETING THE COMBINATION';
    $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
    $_SESSION['flash_message_class'] = 'danger';
    $_SESSION['flash_message_status'] = false;
  }
  // redirect to the previous page
  redirectHome(null, $is_back, 0);
} else {
  // prepare flash session variables
  $_SESSION['flash_message'] = 'NO DATA FOUNDED';
  $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
  $_SESSION['flash_message_class'] = 'danger';
  $_SESSION['flash_message_status'] = false;
}