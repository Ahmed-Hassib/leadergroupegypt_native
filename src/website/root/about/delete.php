<pre dir="ltr">
<?php
// create an object of AboutUs class
$about_obj = !isset($about_obj) ? new AboutUs() : $about_obj;
// is back flag
$is_back = isset($_GET['back']) ? 'back' : null;
// get text id
$text_id = isset($_GET['id']) && !empty($_GET['id']) ? base64_decode($_GET['id']) : null;

// check if text id exists or not
if ($about_obj->is_exist("`id`", "`about_us`", $text_id)) {
  // deleted text
  $is_deleted = $about_obj->delete_text($text_id);
  // check if text deleted
  if ($is_deleted) {
    // prepare flash session variables
    $_SESSION['flash_message'] = 'DELETED';
    $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
    $_SESSION['flash_message_class'] = 'success';
    $_SESSION['flash_message_status'] = true;
    $_SESSION['flash_message_lang_file'] = 'about';
  } else {
    // prepare flash session variables
    $_SESSION['flash_message'] = 'QUERY PROBLEM';
    $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
    $_SESSION['flash_message_class'] = 'danger';
    $_SESSION['flash_message_status'] = false;
    $_SESSION['flash_message_lang_file'] = 'global_';
  }
  // redirect home
  redirect_home(null, $is_back, 0);
} else {
  // include no data founded module
  include_once $globmod . 'no-data-founded.php';
}