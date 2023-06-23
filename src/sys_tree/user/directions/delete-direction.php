<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
  // get direction id
  $direction_id = isset($_POST['deleted-dir-id']) && !empty($_POST['deleted-dir-id']) ? $_POST['deleted-dir-id'] : '';
  // check if dir object was created or not
  if (!isset($dir_obj)) {
    // create an object of Direction class
    $dir_obj = new Direction();
  }
  // check if direction is exist
  $is_exist = $dir_obj->is_exist("`direction_id`", "`direction`", $direction_id);
  // direction name validation
  if (!empty($direction_id) && $is_exist == true) {
    // count pieces on this direction
    $pieces_counter = $dir_obj->count_records("`id`", "`pieces_info`", "WHERE `direction_id` = $direction_id AND `company_id` = ".$_SESSION['company_id']);
    // check if direction name is exist or not
    if ($pieces_counter > 0) {
      // prepare flash session variables
      $_SESSION['flash_message'] = 'CANNOT DELETE THIS DIRECTION BECAUSE THIS DIR CONTAINS ONE PIECE OR MORE';
      $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
      $_SESSION['flash_message_class'] = 'danger';
      $_SESSION['flash_message_status'] = false;
    } else {
      // call delete direction function
      $dir_obj->delete_direction($direction_id);
      // prepare flash session variables
      $_SESSION['flash_message'] = 'DIRECTION DELETED SUCCESSFULLY';
      $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
      $_SESSION['flash_message_class'] = 'success';
      $_SESSION['flash_message_status'] = true;
    }
  } else {
    // prepare flash session variables
    $_SESSION['flash_message'] = 'DIRECTION NAME CANNOT BE EMPTY';
    $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
    $_SESSION['flash_message_class'] = 'warning';
    $_SESSION['flash_message_status'] = false;
  }
  // redirect to previous page
  redirectHome(null, "back", 0);
} else {
  // include permission error module
  include_once $globmod . 'permission-error.php';
}