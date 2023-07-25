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

    // prepare flash session variables
    $_SESSION['flash_message'] = 'SESSION HAS BEEN UPDATED SUCCESSFULLY';
    $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
    $_SESSION['flash_message_class'] = 'success';
    $_SESSION['flash_message_status'] = true;
  } else {
    // prepare flash session variables
    $_SESSION['flash_message'] = 'SOMETHING WRONG WAS HAPPEN WHILE UPDATING SESSION';
    $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
    $_SESSION['flash_message_class'] = 'danger';
    $_SESSION['flash_message_status'] = false;
  }

  // redirect to the home
  redirect_home("", "back", 0);
