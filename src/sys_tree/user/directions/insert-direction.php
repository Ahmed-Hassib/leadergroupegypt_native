
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
    $is_exist = $dir_obj->count_records("`direction_id`", "`direction`", "WHERE `direction_name` = $dir_name AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']));

    // check if direction is exist or not
    if ($is_exist == true) {
      // prepare flash session variables
      $_SESSION['flash_message'] = 'NAME EXIST';
      $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
      $_SESSION['flash_message_class'] = 'danger';
      $_SESSION['flash_message_status'] = false;
      $_SESSION['flash_message_lang_file'] = 'directions';
    } else {
      // call insert direction function
      $dir_obj->insert_new_direction(array($dir_name, get_date_now(), base64_decode($_SESSION['sys']['UserID']), base64_decode($_SESSION['sys']['company_id'])));
      // prepare flash session variables
      $_SESSION['flash_message'] = 'INSERTED';
      $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
      $_SESSION['flash_message_class'] = 'success';
      $_SESSION['flash_message_status'] = true;
      $_SESSION['flash_message_lang_file'] = 'directions';

    }
  } else {
    // prepare flash session variables
    $_SESSION['flash_message'] = 'DIRECTION ERROR';
    $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
    $_SESSION['flash_message_class'] = 'danger';
    $_SESSION['flash_message_status'] = false;
    $_SESSION['flash_message_lang_file'] = 'directions';
  }
  // redirect to the previous page
  redirect_home(null, "back", 0);
} else {
  // include permission error module
  include_once $globmod . 'permission-error.php';
}