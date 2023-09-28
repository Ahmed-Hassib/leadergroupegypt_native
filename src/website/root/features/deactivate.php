<?php
// create an object of Features class
$features_obj = !isset($features_obj) ? new Features() : $features_obj;

// get feature id
$feature_id = isset($_GET['id']) && !empty($_GET['id']) ? base64_decode($_GET['id']) : null;

// check if feature id exists or not
if ($features_obj->is_exist("`id`", "`features`", $feature_id)) {
  // deactivate feature
  $is_deactivated = $features_obj->deactivate_feature($feature_id);
  // check if feature deactivated
  if ($is_deactivated) {
    // prepare flash session variables
    $_SESSION['flash_message'] = 'DEACTIVATED';
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
  redirect_home(null, 'back', 0);
} else {
  // include no data founded module
  include_once $globmod . 'no-data-founded.php';
}