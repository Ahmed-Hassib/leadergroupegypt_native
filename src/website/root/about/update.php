<?php
// check request method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // create an object of AboutUs class
  $about_obj = !isset($about_obj) ? new AboutUs() : $about_obj;

  // array of error
  $err_arr = array();

  // get text id
  $text_id = isset($_POST['id']) && !empty($_POST['id']) ? base64_decode($_POST['id']) : null;
  $text_ar = isset($_POST['text-ar']) && !empty($_POST['text-ar']) ? $_POST['text-ar'] : null;
  $text_en = isset($_POST['text-en']) && !empty($_POST['text-en']) ? $_POST['text-en'] : null;
  $is_active = isset($_POST['is-active']) && !empty($_POST['is-active']) ? $_POST['is-active'] : null;

  // validation on values
  if (empty($text_ar) || $text_ar == null) {
    $err_arr[] = 'ar name empty';
  }

  if (empty($text_en) || $text_en == null) {
    $err_arr[] = 'en name empty';
  }

  if ($is_active != 0 && empty($is_active)) {
    $err_arr[] = 'status empty';
  }

  // check errors
  if (empty($err_arr)) {

    // check if text id exists or not
    if ($about_obj->is_exist("`id`", "`about_us`", $text_id)) {
      // update text
      $is_updated = $about_obj->update_text(array($text_ar, $text_en, $is_active, $text_id));
      // check if text updated
      if ($is_updated) {
        // prepare flash session variables
        $_SESSION['flash_message'] = 'UPDATED';
        $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
        $_SESSION['flash_message_class'] = 'success';
        $_SESSION['flash_message_status'] = true;
        $_SESSION['flash_message_lang_file'] = 'about';
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
      $_SESSION['flash_message_lang_file'][$key] = 'about';
    }
    // redirect home
    redirect_home(null, 'back', 0);
  }
} else {
  // include permission error module
  include_once $globmod . 'permission-error.php';
}
