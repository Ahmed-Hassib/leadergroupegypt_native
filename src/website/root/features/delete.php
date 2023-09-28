<?php
// create an object of Features class
$feature_obj = !isset($feature_obj) ? new Features() : $feature_obj;
// is back flag
$is_back = isset($_GET['back']) ? 'back' : null;
// get feature id
$feature_id = isset($_GET['id']) && !empty($_GET['id']) ? base64_decode($_GET['id']) : null;

// check if feature id exists or not
if ($feature_obj->is_exist("`id`", "`features`", $feature_id)) {
  // get img name
  $img_name = $feature_obj->select_specific_column("`feature_img`", "`features`", "WHERE `id` = $feature_id")[0]['feature_img'];
  // deactivate img
  $is_deleted = $feature_obj->delete_feature($feature_id);
  // check if img exists
  if (file_exists($features_img . $img_name)) {
    // delete profile image from disk
    unlink($features_img . $img_name);
  }

  if (file_exists($features_img . "resized/" . $img_name)) {
    // delete profile image from disk
    unlink($features_img . "resized/" . $img_name);
  }
  // check if img deactivated
  if ($is_deleted) {
    // prepare flash session variables
    $_SESSION['flash_message'] = 'DELETED';
    $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
    $_SESSION['flash_message_class'] = 'success';
    $_SESSION['flash_message_status'] = true;
    $_SESSION['flash_message_lang_file'] = 'features';
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