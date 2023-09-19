<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // create an object of Link class
  $link_obj = !isset($link_obj) ? new Link() : $link_obj;

  // create an array of errors
  $err_arr = array();

  // create an array or retrned data
  $returned_data = array();

  // assign POST value to links_info variable
  $links_counter = count($_POST['name-ar']);


  // loop on POST variable array
  for ($i = 0; $i < $links_counter; $i++) {
    // get link info
    $name_ar = $_POST['name-ar'][$i];
    $name_en = $_POST['name-en'][$i];
    $is_active = $_POST['is-active'][$i];
    $link = $_POST['link'][$i];

    // validation on values
    if (empty($name_ar)) {
      $err_arr[] = 'ar name empty';
    }

    if (empty($name_en)) {
      $err_arr[] = 'en name empty';
    }

    if ($is_active != 0 && empty($is_active)) {
      $err_arr[] = 'status empty';
    }

    if (empty($link)) {
      $err_arr[] = 'link empty';
    }

    // success counter
    $succ_counter = 0;
    // failed counter
    $fail_counter = 0;
    // check array of error
    if (empty($err_arr)) {
      // insert new link
      $is_inserted = $link_obj->insert_new_link(array($name_ar, $name_en, $is_active, $link, get_date_now(), get_time_now(), base64_decode($_SESSION['website']['user_id'])));
      // check if inserted
      if ($is_inserted) {
        // success counter
        $succ_counter += 1;
      } else {
        // failed counter
        $fail_counter += 1;
        // assign failed data to returned_data array
        $returned_data[] = array(
          'ar' => $_POST['name-ar'][$i],
          'en' => $_POST['name-en'][$i],
          'status' => $_POST['is-active'][$i],
          'link' => $_POST['link'][$i]
        );
      }
    } else {
      // assign failed data to returned_data array
      $returned_data[] = array(
        'ar' => $_POST['name-ar'][$i],
        'en' => $_POST['name-en'][$i],
        'status' => $_POST['is-active'][$i],
        'link' => $_POST['link'][$i]
      );
    }
    // reset array of error
    $err_arr = [];
  }

  // check success counter
  if ($succ_counter == $links_counter) {
    // prepare flash session variables
    $_SESSION['flash_message'][0] = 'INSERTED';
    $_SESSION['flash_message_icon'][0] = 'bi-check-circle-fill';
    $_SESSION['flash_message_class'][0] = 'success';
    $_SESSION['flash_message_status'][0] = true;
    $_SESSION['flash_message_lang_file'][0] = 'links';
    
  } elseif ($succ_counter < $links_counter && $succ_counter > 0) {
    $_SESSION['flash_message'][0] = 'INSERTED SOME';
    $_SESSION['flash_message_icon'][0] = 'bi-check-circle-fill';
    $_SESSION['flash_message_class'][0] = 'success';
    $_SESSION['flash_message_status'][0] = true;
    $_SESSION['flash_message_lang_file'][0] = 'links';
  }

  // check failed counter
  if ($fail_counter > 0) {
    // prepare flash session variables
    $_SESSION['flash_message'][1] = 'FAILED SOME';
    $_SESSION['flash_message_icon'][1] = 'bi-exclamation-triangle-fill';
    $_SESSION['flash_message_class'][1] = 'danger';
    $_SESSION['flash_message_status'][1] = false;
    $_SESSION['flash_message_lang_file'][1] = 'links';
  }

  // check returned data
  if (!empty($returned_data)) {
    $_SESSION['website']['request_data'] = $returned_data;
    // prepare flash session variables
    $_SESSION['flash_message'][2] = 'SOME EMPTY';
    $_SESSION['flash_message_icon'][2] = 'bi-exclamation-triangle-fill';
    $_SESSION['flash_message_class'][2] = 'danger';
    $_SESSION['flash_message_status'][2] = false;
    $_SESSION['flash_message_lang_file'][2] = 'links';
  }

  // redirect to the previous page
  redirect_home(null, "back", 0);
} else {
  // include permission error module
  include_once $globmod . 'permission-error.php';
}
