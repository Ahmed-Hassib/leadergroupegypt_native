<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // create an object of AboutUs class
  $about_obj = !isset($about_obj) ? new AboutUs() : $about_obj;

  // create an array of errors
  $err_arr = array();

  // create an array or retrned data
  $returned_data = array();

  // assign POST value to text_info variable
  $text_counter = count($_POST['text-ar']);


  // loop on POST variable array
  for ($i = 0; $i < $text_counter; $i++) {
    // get text info
    $text_ar = $_POST['text-ar'][$i];
    $text_en = $_POST['text-en'][$i];
    $is_active = $_POST['is-active'][$i];

    // validation on values
    if (empty($text_ar)) {
      $err_arr[] = 'ar name empty';
    }

    if (empty($text_en)) {
      $err_arr[] = 'en name empty';
    }

    if ($is_active != 0 && empty($is_active)) {
      $err_arr[] = 'status empty';
    }

    // success counter
    $succ_counter = 0;
    // failed counter
    $fail_counter = 0;
    // check array of error
    if (empty($err_arr)) {
      // insert new text
      $is_inserted = $about_obj->insert_new_text(array($text_ar, $text_en, $is_active, get_date_now(), base64_decode($_SESSION['website']['user_id'])));
      // check if inserted
      if ($is_inserted) {
        // success counter
        $succ_counter += 1;
      } else {
        // failed counter
        $fail_counter += 1;
        // assign failed data to returned_data array
        $returned_data[] = array(
          'ar' => $_POST['text-ar'][$i],
          'en' => $_POST['text-en'][$i],
          'status' => $_POST['is-active'][$i],
        );
      }
    } else {
      // assign failed data to returned_data array
      $returned_data[] = array(
        'ar' => $_POST['text-ar'][$i],
        'en' => $_POST['text-en'][$i],
        'status' => $_POST['is-active'][$i],
      );
    }
    // reset array of error
    $err_arr = [];
  }

  // check success counter
  if ($succ_counter == $text_counter) {
    // prepare flash session variables
    $_SESSION['flash_message'][0] = 'INSERTED';
    $_SESSION['flash_message_icon'][0] = 'bi-check-circle-fill';
    $_SESSION['flash_message_class'][0] = 'success';
    $_SESSION['flash_message_status'][0] = true;
    $_SESSION['flash_message_lang_file'][0] = 'about';
    
  } elseif ($succ_counter < $text_counter && $succ_counter > 0) {
    $_SESSION['flash_message'][0] = 'INSERTED SOME';
    $_SESSION['flash_message_icon'][0] = 'bi-check-circle-fill';
    $_SESSION['flash_message_class'][0] = 'success';
    $_SESSION['flash_message_status'][0] = true;
    $_SESSION['flash_message_lang_file'][0] = 'about';
  }

  // check failed counter
  if ($fail_counter > 0) {
    // prepare flash session variables
    $_SESSION['flash_message'][1] = 'FAILED SOME';
    $_SESSION['flash_message_icon'][1] = 'bi-exclamation-triangle-fill';
    $_SESSION['flash_message_class'][1] = 'danger';
    $_SESSION['flash_message_status'][1] = false;
    $_SESSION['flash_message_lang_file'][1] = 'about';
  }

  // check returned data
  if (!empty($returned_data)) {
    $_SESSION['website']['request_data'] = $returned_data;
    // prepare flash session variables
    $_SESSION['flash_message'][2] = 'SOME EMPTY';
    $_SESSION['flash_message_icon'][2] = 'bi-exclamation-triangle-fill';
    $_SESSION['flash_message_class'][2] = 'danger';
    $_SESSION['flash_message_status'][2] = false;
    $_SESSION['flash_message_lang_file'][2] = 'about';
  }

  // redirect to the previous page
  redirect_home(null, "back", 0);
} else {
  // include permission error module
  include_once $globmod . 'permission-error.php';
}
