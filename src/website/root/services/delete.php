<?php
// create an object of Service class
$service_obj = !isset($service_obj) ? new Service() : $service_obj;
// is back flag
$is_back = isset($_GET['back']) ? 'back' : null;
// get service id
$service_id = isset($_GET['id']) && !empty($_GET['id']) ? base64_decode($_GET['id']) : null;

// check if service id exists or not
if ($service_obj->is_exist("`id`", "`services`", $service_id)) {
  // get img name
  $img_name = $service_obj->select_specific_column("`service_img`", "`services`", "WHERE `id` = $service_id")[0]['service_img'];
  // deactivate img
  $is_deleted = $service_obj->delete_service($service_id);
  // check if img exists
  if (file_exists($services_img . $img_name)) {
    // delete profile image from disk
    unlink($services_img . $img_name);
  }
  // check if img deactivated
  if ($is_deleted) {
    // prepare flash session variables
    $_SESSION['flash_message'] = 'DELETED';
    $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
    $_SESSION['flash_message_class'] = 'success';
    $_SESSION['flash_message_status'] = true;
    $_SESSION['flash_message_lang_file'] = 'services';
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
