<?php 
// check the request post
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // get user id
  $user_id = $_SESSION['UserID'];
  // get ping counter value
  $ping_counter = isset($_POST['ping-counter']) && $_POST['ping-counter'] > 0 ? intval($_POST['ping-counter']) : $_SESSION['ping_counter'];

  // check if user object was created or not
  if (!isset($user_obj)) {
    // create an object of Company class
    $user_obj = new User();
  }
  
  // check if any changes was happened
  if ($_SESSION['ping_counter'] != $ping_counter) {
    // change other settings
    $is_changed = $user_obj->change_other_settings(array($ping_counter, $user_id));
    
    if ($is_changed) {
      // prepare flash session variables
      $_SESSION['flash_message'] = 'SETTINGS HAS BEEN UPDATED SUCCESSFULLY';
      $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
      $_SESSION['flash_message_class'] = 'success';
      $_SESSION['flash_message_status'] = true;
      
      if (!isset($session_obj)) {
        // create an object of Session class
        $session_obj = new Session();
      }
      // get user info
      $user_info = $session_obj->get_user_info($_SESSION['UserID']);
      // check if done
      if ($user_info[0] == true) {
        // set user session
        $session_obj->set_user_session($user_info[1]);
      }
    } else {
      // prepare flash session variables
      $_SESSION['flash_message'] = 'SOMETHING WRONG WAS HAPPEN WHILE UPDATING SETTINGS';
      $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
      $_SESSION['flash_message_class'] = 'danger';
      $_SESSION['flash_message_status'] = false;
    }
  } else {
    // prepare flash session variables
    $_SESSION['flash_message'] = 'NO CHANGES WAS HAPPENED';
    $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
    $_SESSION['flash_message_class'] = 'info';
    $_SESSION['flash_message_status'] = false;
  }
  // redirect home
  redirect_home(null, 'back', 0);
} else {
  // include_once per
  include_once $globmod . 'permission-error.php';
}