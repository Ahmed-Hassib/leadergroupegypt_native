<?php
// check if Get request userid is numeric and get the integer value
$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
if (!isset($user_obj)) {
  // create an object of User class
  $user_obj = new User();
}
// check if user is exist
$is_exist = $user_obj->is_exist("`UserID`", "`users`", $userid);
// if user exist
if ($is_exist == true) {
  // get user name
  $username = $user_obj->select_specific_column("`UserName`", "`users`", "WHERE `UserID` = " . $userid)[0]['UserName'];
  // call delete user function
  $user_obj->delete_user($userid);

  // log message
  $logMsg = "Users dept:: user deleted successfully.";
  createLogs($_SESSION['UserName'], $logMsg);

  $_SESSION['flash_message'] = 'AN USER WAS DELETED SUCCESSFULLY';
  $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
  $_SESSION['flash_message_class'] = 'success';
  $_SESSION['flash_message_status'] = true;
  // redirect to home page
  redirectHome(null, null, 0);
} else {
  // include_once no data founded module
  include_once $globmod .'no-data-founded.php';
}