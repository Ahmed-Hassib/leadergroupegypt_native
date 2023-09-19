<?php
// create an object of Service class
$service_obj = !isset($service_obj) ? new Service() : $service_obj;

// get service id
$service_id = isset($_GET['id']) && !empty($_GET['id']) ? base64_decode($_GET['id']) : null;

// check if service id exists or not
if ($service_obj->is_exist("`id`", "`services`", $service_id)) {
  // deactivate service
  $is_activated = $service_obj->activate_service($service_id);
  // check if service deactivated
  if ($is_activated) {
    // prepare flash session variables
    $_SESSION['flash_message'] = 'ACTIVATED';
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
  redirect_home(null, 'back', 0);
} else {
  // include no data founded module
  include_once $globmod . 'no-data-founded.php';
}
