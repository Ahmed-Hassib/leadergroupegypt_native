<pre dir="ltr"><?php print_r($_POST) ?></pre>
<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  // array of error
  $err_arr = array();

  // check errors
  if (empty($err_arr)) {
    // create an object of Direction class
    $sec_obj = !isset($sec_obj) ? new Section() : $sec_obj;
    // 

    // check if direction is exist or not
    if ($is_exist == true) {
      // prepare flash session variables
      $_SESSION['flash_message'] = '';
      $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
      $_SESSION['flash_message_class'] = 'danger';
      $_SESSION['flash_message_status'] = false;
      $_SESSION['flash_message_lang_file'] = 'directions';
    } else {

      // prepare flash session variables
      $_SESSION['flash_message'] = '';
      $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
      $_SESSION['flash_message_class'] = 'success';
      $_SESSION['flash_message_status'] = true;
      $_SESSION['flash_message_lang_file'] = 'directions';
    }
  } else {
    // prepare flash session variables
    foreach ($err_arr as $key => $err) {
      $_SESSION['flash_message'][$key] = strtoupper($err);
      $_SESSION['flash_message_icon'][$key] = 'bi-exclamation-triangle-fill';
      $_SESSION['flash_message_class'][$key] = 'danger';
      $_SESSION['flash_message_status'][$key] = false;
      $_SESSION['flash_message_lang_file'][$key] = 'directions';
    }
  }
  // // redirect to the previous page
  // redirect_home(null, "back", 0);
} else {
  // include permission error module
  include_once $globmod . 'permission-error.php';
}
