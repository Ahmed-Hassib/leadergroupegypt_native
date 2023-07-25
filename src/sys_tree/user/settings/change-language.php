<?php
// get user id
$user_id = isset($_POST['id']) ? intval($_POST['id']) : 0; 
if (!isset($user_obj)) {
  // create an object of User class
  $user_obj = new User();
}
// check user if exist or not
$check = $user_obj->is_exist("`UserID`", "`users`", $user_id);
// check
if ($check == true) {
  // get language
  $lang = isset($_POST['language']) ? intval($_POST['language']) : 0;
  // call change_user_langugae
  $is_changed = $user_obj->change_user_language($lang, $user_id);
  // check if language is changed
  if ($is_changed) {
    if (!isset($session_obj)) {
      // create an object of Session class
      $session_obj = new Session();
    }
    // get user info
    $user_details = $session_obj->get_user_info($user_id);
    // check if exist
    if ($user_details[0] == true) {
      // reset session
      $session_obj->set_user_session($user_details[1]);
    }
  }
  // redirect to home page
  redirect_home("", 'back', 0);
}