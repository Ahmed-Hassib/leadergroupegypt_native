<?php 
  // get user id 
  $user_id = isset($_GET['user-id']) ? $_GET['user-id'] : 0;
  if (!isset($session_obj)) {
    // create an object of Session class
    $session_obj = new Session();
  }
  // get user info
  $user_info = $session_obj->get_user_info($user_id);
  // check if done
  if ($user_info[0] == true) {
    // set user session
    $session_obj->set_user_session($user_info[1]);
  }
  $_SESSION['flash_message'] = "SESSION HAS BEEN UPDATED SUCCESSFULLY";
  $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
  $_SESSION['flash_message_class'] = 'success';
  $_SESSION['flash_message_status'] = true;
  // redirect to the home
  redirectHome(null, "back", 0);
