<?php
// create an object of Link class
$gallery_obj = !isset($gallery_obj) ? new Gallery() : $gallery_obj;

// get link id
$img_id = isset($_GET['id']) && !empty($_GET['id']) ? base64_decode($_GET['id']) : null;

// check if link id exists or not
if ($gallery_obj->is_exist("`id`", "`gallery`", $img_id)) {
  // deactivate link
  $is_deactivated = $gallery_obj->deactivate_img($img_id);
  // check if link deactivated
  if ($is_deactivated) {
    // prepare flash session variables
    $_SESSION['flash_message'] = 'DEACTIVATED';
    $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
    $_SESSION['flash_message_class'] = 'success';
    $_SESSION['flash_message_status'] = true;
    $_SESSION['flash_message_lang_file'] = 'gallery';
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