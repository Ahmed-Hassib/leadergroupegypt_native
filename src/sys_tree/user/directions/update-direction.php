
<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
  // get direction id
  $direction_id = isset($_POST['updated-dir-id']) && !empty($_POST['updated-dir-id']) ? $_POST['updated-dir-id'] : '';
  // get direction new name
  $new_direction_name = isset($_POST['new-direction-name']) && !empty($_POST['new-direction-name']) ? $_POST['new-direction-name'] : '';
  if (!isset($dir_obj)) {
    // create an object of Direction class
    $dir_obj = new Direction();
  }
  // check if direction is exist
  $is_exist = $dir_obj->is_exist("`direction_id`", "`direction`", $direction_id);

  // direction name validation
  if (!empty($new_direction_name) && $is_exist == true) {
    // directions counter that have the same name in the same company
    $directions_counter = $dir_obj->count_records("`direction_id`", "`direction`", "WHERE `direction_id` != $direction_id AND `direction_name` = '$new_direction_name' AND `company_id` = " . $_SESSION['company_id']);
    // check if direction name is exist or not
    if ($directions_counter > 0) {
      // prepare flash session variables
      $_SESSION['flash_message'] = 'THIS NAME IS ALREADY EXIST';
      $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
      $_SESSION['flash_message_class'] = 'danger';
      $_SESSION['flash_message_status'] = false;
    } else {
      // call update direction function
      $dir_obj->update_direction($new_direction_name, $direction_id);
      // prepare flash session variables
      $_SESSION['flash_message'] = 'DIRECTION UPDATED SUCCESSFULLY';
      $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
      $_SESSION['flash_message_class'] = 'success';
      $_SESSION['flash_message_status'] = true;
    }
  } else {
    // prepare flash session variables
    $_SESSION['flash_message'] = 'DIRECTION NAME CANNOT BE EMPTY';
    $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
    $_SESSION['flash_message_class'] = 'danger';
    $_SESSION['flash_message_status'] = false;
  }
  // redirect to previous page
  redirectHome(null, "back", 0);
} else {
  // include permission error module
  include_once $globmod . 'permission-error.php';
}