<?php

// get user info
$username = isset($_POST['username']) && !empty($_POST['username']) ? $_POST['username'] : null;
$password = isset($_POST['password']) && !empty($_POST['password']) ? $_POST['password'] : null;
$language = isset($_POST['language']) && !empty($_POST['language']) ? $_POST['language'] : 'ar';
// get hashed password
$hashed_pass = sha1($password);

// array of error
$err_arr = array();

// validation on username
if ($username == null) {
  $err_arr[] = 'username empty';
}

// validation on password
if ($password == null) {
  $err_arr[] = 'password empty';
}

// check array of error
if (empty($err_arr)) {
  // create an object of Login class
  $login_obj = new Login($username, $password);

  // get user info
  $user_info = $login_obj->user_login();

  // check result
  if ($user_info != null) {
    // create an object of Session class to set session
    $session_obj = !isset($session_obj) ? new Session() : $session_obj;
    // set session
    $session_obj->set_user_session($user_info);
    // prepare flash session variables
    $_SESSION['flash_message'] = 'LOGIN SUCCESS';
    $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
    $_SESSION['flash_message_class'] = 'success';
    $_SESSION['flash_message_status'] = true;
    $_SESSION['flash_message_lang_file'] = 'global_';

    // check logined user
    if ($_SESSION['website']['is_root'] == 1) {
      // redirect to admin page
      header("Location: root/dashboard/index.php");
      exit();
    }
  } else {
    // prepare flash message variables
    $_SESSION['flash_message'] = 'LOGIN FAILED';
    $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
    $_SESSION['flash_message_class'] = 'danger';
    $_SESSION['flash_message_status'] = false;
    $_SESSION['flash_message_lang_file'] = 'global_';
    // redirect back
    redirect_home(null, 'back', 0);
  }
} else {
  // prepare flash message variables
  foreach ($err_arr as $key => $err) {
    $_SESSION['flash_message'][$key] = strtoupper($err);
    $_SESSION['flash_message_icon'][$key] = 'bi-exclamation-triangle-fill';
    $_SESSION['flash_message_class'][$key] = 'danger';
    $_SESSION['flash_message_status'][$key] = false;
    $_SESSION['flash_message_lang_file'][$key] = 'login';
  }
  // redirect back
  redirect_home(null, 'back', 0);
}
