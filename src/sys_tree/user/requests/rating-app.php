<?php 
// get user id
$user_id = $_SESSION['UserID'];
// get current date 
$curr_date = get_date_now();
// get current time
$curr_time = get_time_now();
// get company id
$company_id = $_SESSION['company_id'];
// get rating
$rating = $_POST['rating'];
// create an object of User class
$user_obj = new User();
// count user rating in database
$is_rating = $user_obj->count_records("`id`", "`app_rating`", "WHERE `added_by` = $user_id") > 0 ? true : false;
// check if the user do rate before or not
if (!$is_rating) {
  // rate app
  $is_rating_now = $user_obj->do_rating_app(array($user_id, $curr_date, $curr_time, $company_id, $rating, null));
  // check if rated
  if ($is_rating_now) {
    $_SESSION['flash_message_class'] = 'success';
    $_SESSION['flash_message_status'] = true;
    $_SESSION['flash_message'] = "THANK YOU, YOU HAVE SUCCESSFULLY RATED THE SYSTEM";
  } else {
    $_SESSION['flash_message_class'] = 'danger';
    $_SESSION['flash_message_status'] = false;
    $_SESSION['flash_message'] = "A PROBLEM WAS HAPPENED WHILE RATING THE SYSTEM";
  }
} else {
  $_SESSION['flash_message_class'] = 'info';
  $_SESSION['flash_message_status'] = true;
  $_SESSION['flash_message'] = "THANK YOU, YOU HAVE ALREADY RATED THE SYSTEM";
}
// redirect to the previous page
redirectHome('', 'back', 0);