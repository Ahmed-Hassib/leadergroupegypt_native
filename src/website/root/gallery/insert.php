<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // create an object of Gallery class
  $gallery_obj = new Gallery();

  // create an array of errors
  $err_arr = array();

  // assign POST value to imgs_info variable
  $imgs_counter = count($_POST['is-active']);

  // success counter
  $succ_counter = 0;
  // failed counter
  $fail_counter = 0;

  // loop on POST variable array
  for ($i = 0; $i < $imgs_counter; $i++) {
    // get img info
    $is_active = $_POST['is-active'][$i];
    // get gallery image info
    $file_name        = $_FILES['gallery-img-input']['name'][$i];
    $file_type        = $_FILES['gallery-img-input']['type'][$i];
    $file_error       = $_FILES['gallery-img-input']['error'][$i];
    $file_size        = $_FILES['gallery-img-input']['size'][$i];
    $files_tmp_name   = $_FILES['gallery-img-input']['tmp_name'][$i];

    // validation on values
    if ($is_active != 0 && empty($is_active)) {
      $err_arr[] = 'status empty';
    }

    // check if company image changed
    if ($file_error > 0 && $file_size <= 0) {
      $err_arr[] = 'img empty';
    }
    // check array of error
    if (empty($err_arr)) {
      // website path
      $path = $uploads . "website/";
      // check path
      if (!file_exists($path)) {
        mkdir($path);
      }
      // gallery path
      $path .= "img/";
      // check path
      if (!file_exists($path)) {
        mkdir($path);
      }
      // gallery path
      $path .= "gallery/";
      // check path
      if (!file_exists($path)) {
        mkdir($path);
      }

      // media temp
      $media_temp = [];
      // check if not empty
      if (!empty($file_name)) {
        $media_temp = explode('.', $file_name);
        $media_temp[0] = 'gallery_' . date('dmY') . '_' . rand(00000000, 99999999);
        $media_name = join('.', $media_temp);
        move_uploaded_file($files_tmp_name, $path . $media_name);
        // upload files info into database
        $is_inserted = $gallery_obj->insert_new_img(array($media_name, $is_active, get_date_now(), get_time_now(), base64_decode($_SESSION['website']['user_id'])));
      } else {
        $is_inserted = false;
      }
      // check if inserted
      if ($is_inserted) {
        // success counter
        $succ_counter += 1;
      } else {
        // failed counter
        $fail_counter += 1;
      }
    }
    // reset array of error
    $err_arr = [];
  }

  // check success counter
  if ($succ_counter == $imgs_counter) {
    // prepare flash session variables
    $_SESSION['flash_message'][0] = 'INSERTED';
    $_SESSION['flash_message_icon'][0] = 'bi-check-circle-fill';
    $_SESSION['flash_message_class'][0] = 'success';
    $_SESSION['flash_message_status'][0] = true;
    $_SESSION['flash_message_lang_file'][0] = 'gallery';
  } elseif ($succ_counter < $imgs_counter && $succ_counter > 0) {
    $_SESSION['flash_message'][0] = 'INSERTED SOME';
    $_SESSION['flash_message_icon'][0] = 'bi-check-circle-fill';
    $_SESSION['flash_message_class'][0] = 'success';
    $_SESSION['flash_message_status'][0] = true;
    $_SESSION['flash_message_lang_file'][0] = 'gallery';
  }

  // check failed counter
  if ($fail_counter > 0) {
    // prepare flash session variables
    $_SESSION['flash_message'][1] = 'FAILED SOME';
    $_SESSION['flash_message_icon'][1] = 'bi-exclamation-triangle-fill';
    $_SESSION['flash_message_class'][1] = 'danger';
    $_SESSION['flash_message_status'][1] = false;
    $_SESSION['flash_message_lang_file'][1] = 'gallery';
  }

  // redirect to the previous page
  redirect_home(null, "back", 0);
} else {
  // include permission error module
  include_once $globmod . 'permission-error.php';
}
