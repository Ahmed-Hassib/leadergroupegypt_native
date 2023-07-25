
<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
  // get direction name
  $dir_name = isset($_POST['direction-name']) && !empty($_POST['direction-name']) ? $_POST['direction-name'] : '';
  // direction name validation
  if (!empty($dir_name)) {
    if (!isset($dir_obj)) {
      // create an object of Direction class
      $dir_obj = new Direction();
    }
    // check if name is exist or not
    $is_exist = $dir_obj->count_records("`direction_id`", "`direction`", "WHERE `direction_name` = $dir_name AND `company_id` = " . $_SESSION['company_id']);

    // check if direction is exist or not
    if ($is_exist == true) {
      // prepare flash session variables
      $_SESSION['flash_message'] = 'THIS NAME IS ALREADY EXIST';
      $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
      $_SESSION['flash_message_class'] = 'danger';
      $_SESSION['flash_message_status'] = false;
    } else {
      // call insert direction function
      $dir_obj->insert_new_direction(array($dir_name, get_date_now(), $_SESSION['UserID'], $_SESSION['company_id']));
      // prepare flash session variables
      $_SESSION['flash_message'] = 'A NEW DIRECTION ADDED SUCCESSFULLY';
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
  // redirect to the previous page
  redirect_home(null, "back", 0);
} else {
  // include permission error module
  include_once $globmod . 'permission-error.php';
}