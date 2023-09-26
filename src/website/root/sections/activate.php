<?php
// get section id
$section_id = isset($_GET['id']) && !empty($_GET['id']) ? base64_decode($_GET['id']) : null;

// check section id
if ($section_id == null) {
  $err_arr[] = 'query problem';
}

// array of error
$err_arr = array();

// check errors
if (empty($err_arr)) {
  // create an object of Direction class
  $sec_obj = !isset($sec_obj) ? new Section() : $sec_obj;
  // check if section was exist
  $is_exist = $sec_obj->count_records("`id`", "`sections`", "WHERE `id` = $section_id");
  // check if direction is exist or not
  if ($is_exist > 0) {
    // activate section
    $is_activated = $sec_obj->activate_section($section_id);
    // check if activated
    if ($is_activated) {
      // prepare flash session variables
      $_SESSION['flash_message'] = 'ACTIVATED';
      $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
      $_SESSION['flash_message_class'] = 'success';
      $_SESSION['flash_message_status'] = true;
      $_SESSION['flash_message_lang_file'] = 'sections';
    } else {
      // prepare flash session variables
      $_SESSION['flash_message'] = 'QUERY PROBLEM';
      $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
      $_SESSION['flash_message_class'] = 'danger';
      $_SESSION['flash_message_status'] = false;
      $_SESSION['flash_message_lang_file'] = 'global_';
    }
  } else {
    // prepare flash session variables
    $_SESSION['flash_message'] = 'NO DATA FOUNDED';
    $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
    $_SESSION['flash_message_class'] = 'danger';
    $_SESSION['flash_message_status'] = false;
    $_SESSION['flash_message_lang_file'] = 'global_';
  }
} else {
  // prepare flash session variables
  foreach ($err_arr as $key => $err) {
    $_SESSION['flash_message'][$key] = strtoupper($err);
    $_SESSION['flash_message_icon'][$key] = 'bi-exclamation-triangle-fill';
    $_SESSION['flash_message_class'][$key] = 'danger';
    $_SESSION['flash_message_status'][$key] = false;
    $_SESSION['flash_message_lang_file'][$key] = 'sections';
  }
}
// redirect to the previous page
redirect_home(null, "back", 0);