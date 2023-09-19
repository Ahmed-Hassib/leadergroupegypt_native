<?php
// create an object of Gallery class
$gallery_obj = !isset($gallery_obj) ? new Gallery() : $gallery_obj;
// is back flag
$is_back = isset($_GET['back']) ? 'back' : null;
// get img id
$img_id = isset($_GET['id']) && !empty($_GET['id']) ? base64_decode($_GET['id']) : null;

// check if img id exists or not
if ($gallery_obj->is_exist("`id`", "`gallery`", $img_id)) {
  // get img name
  $img_name = $gallery_obj->select_specific_column("`img_name`", "`gallery`", "WHERE `id` = $img_id")[0]['img_name'];
  // delete img
  $is_deleted = $gallery_obj->delete_img($img_id);
  // check if img exists
  if (file_exists($gallery_img . $img_name)) {
    // delete profile image from disk
    unlink($gallery_img . $img_name);
  }
  // check if img deleted
  if ($is_deleted) {
    // prepare flash session variables
    $_SESSION['flash_message'] = 'DELETED';
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
  redirect_home(null, $is_back, 0);
} else {
  // include no data founded module
  include_once $globmod . 'no-data-founded.php';
}
