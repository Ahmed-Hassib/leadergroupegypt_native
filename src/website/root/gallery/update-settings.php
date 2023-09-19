<?php
// check request method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // create an object of Gallery class
  $gallery_obj = new Gallery();
  // get number of images
  $img_num = $_POST['num-of-img'] ?? null;
  // check number
  if ($img_num != null) {
    // is updated flag
    $is_updated = false;
    // check if gallery settings exists or not
    $is_exists = $gallery_obj->is_exist("`section_id`", "`sections`", "2");
    $is_exists = $gallery_obj->count_records("`section_id`", "`sections`", "WHERE `section_id` = 2");
    // if exists
    if (!$is_exists) {
      // update it
      $is_updated = $gallery_obj->insert_settings(array($img_num, get_date_now(), get_time_now(), base64_decode($_SESSION['website']['user_id'])));
    } else {
      $is_updated = $gallery_obj->update_settings($img_num, 2);
    }
    // check if settings updated
    if ($is_updated) {
      // prepare flash session variables
      $_SESSION['flash_message'] = 'UPDATED SETTINGS';
      $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
      $_SESSION['flash_message_class'] = 'success';
      $_SESSION['flash_message_status'] = true;
      $_SESSION['flash_message_lang_file'] = 'gallery';
    } else {
      // prepare flash session variables
      $_SESSION['flash_message'] = 'NO CHANGES';
      $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
      $_SESSION['flash_message_class'] = 'info';
      $_SESSION['flash_message_status'] = false;
      $_SESSION['flash_message_lang_file'] = 'global_';
    }
  } else {
    // prepare flash session variables
    $_SESSION['flash_message'] = 'NUM ERROR';
    $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
    $_SESSION['flash_message_class'] = 'danger';
    $_SESSION['flash_message_status'] = false;
    $_SESSION['flash_message_lang_file'] = 'global_';
  }
  // redirect back
  redirect_home(null, 'back', 0);
} else {
  // include permission error module
  include_once $globmod . 'permission-error.php';
}
