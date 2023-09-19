<?php
// check request method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // create an object of Link class
  $link_obj = !isset($link_obj) ? new Link() : $link_obj;

  // array of error
  $err_arr = array();

  // get link id
  $link_id = isset($_POST['id']) && !empty($_POST['id']) ? base64_decode($_POST['id']) : null;
  $name_ar = isset($_POST['name-ar']) && !empty($_POST['name-ar']) ? $_POST['name-ar'] : null;
  $name_en = isset($_POST['name-en']) && !empty($_POST['name-en']) ? $_POST['name-en'] : null;
  $is_active = isset($_POST['is-active']) && !empty($_POST['is-active']) ? $_POST['is-active'] : null;
  $link = isset($_POST['link']) && !empty($_POST['link']) ? $_POST['link'] : null;

  // validation on values
  if (empty($name_ar) || $name_ar == null) {
    $err_arr[] = 'ar name empty';
  }

  if (empty($name_en) || $name_en == null) {
    $err_arr[] = 'en name empty';
  }

  if ($is_active != 0 && empty($is_active)) {
    $err_arr[] = 'status empty';
  }

  if (empty($link) || $link == null) {
    $err_arr[] = 'link empty';
  }

  // check errors
  if (empty($err_arr)) {

    // check if link id exists or not
    if ($link_obj->is_exist("`id`", "`important_links`", $link_id)) {
      // update link
      $is_updated = $link_obj->update_link(array($name_ar, $name_en, $is_active, $link, $link_id));
      // check if link updated
      if ($is_updated) {
        // prepare flash session variables
        $_SESSION['flash_message'] = 'UPDATED';
        $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
        $_SESSION['flash_message_class'] = 'success';
        $_SESSION['flash_message_status'] = true;
        $_SESSION['flash_message_lang_file'] = 'links';
      } else {
        // prepare flash session variables
        $_SESSION['flash_message'] = 'NO CHANGES';
        $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
        $_SESSION['flash_message_class'] = 'info';
        $_SESSION['flash_message_status'] = false;
        $_SESSION['flash_message_lang_file'] = 'global_';
      }
      // redirect home
      redirect_home(null, 'back', 0);
    } else {
      // include no data founded module
      include_once $globmod . 'no-data-founded.php';
    }
  } else {
    // prepare flash session variables
    foreach ($err_arr as $key => $err) {
      $_SESSION['flash_message'][$key] = strtoupper($err);
      $_SESSION['flash_message_icon'][$key] = 'bi-exclamation-triangle-fill';
      $_SESSION['flash_message_class'][$key] = 'danger';
      $_SESSION['flash_message_status'][$key] = false;
      $_SESSION['flash_message_lang_file'][$key] = 'links';
    }
    // redirect home
    redirect_home(null, 'back', 0);
  }
} else {
  // include permission error module
  include_once $globmod . 'permission-error.php';
}
