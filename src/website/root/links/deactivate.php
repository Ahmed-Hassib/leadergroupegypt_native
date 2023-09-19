<?php
// create an object of Link class
$link_obj = !isset($link_obj) ? new Link() : $link_obj;

// get link id
$link_id = isset($_GET['id']) && !empty($_GET['id']) ? base64_decode($_GET['id']) : null;

// check if link id exists or not
if ($link_obj->is_exist("`id`", "`important_links`", $link_id)) {
  // deactivate link
  $is_deactivated = $link_obj->deactivate_link($link_id);
  // check if link deactivated
  if ($is_deactivated) {
    // prepare flash session variables
    $_SESSION['flash_message'] = 'DEACTIVATED';
    $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
    $_SESSION['flash_message_class'] = 'success';
    $_SESSION['flash_message_status'] = true;
    $_SESSION['flash_message_lang_file'] = 'links';
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