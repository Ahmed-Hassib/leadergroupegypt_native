<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // create an object of TeamMember class
  $members_obj = !isset($members_obj) ? new TeamMember() : $members_obj;

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
    $member_name = $_POST['name'][$i];
    $job_title = $_POST['job-title'][$i];
    $facebook = $_POST['facebook'][$i];
    $instagram = $_POST['instagram'][$i];
    $twitter = $_POST['twitter'][$i];
    $linkedin = $_POST['linkedin'][$i];
    $youtube = $_POST['youtube'][$i];
    $is_active = $_POST['is-active'][$i];
    // get member image info
    $file_name = $_FILES['member-img-input']['name'][$i];
    $file_type = $_FILES['member-img-input']['type'][$i];
    $file_error = $_FILES['member-img-input']['error'][$i];
    $file_size = $_FILES['member-img-input']['size'][$i];
    $files_tmp_name = $_FILES['member-img-input']['tmp_name'][$i];

    // validation on values
    if ($is_active != 0 && empty($is_active)) {
      $err_arr[] = 'status empty';
    }

    // name validation
    if (empty($member_name)) {
      $err_arr[] = 'name empty';
    }

    // job title validation
    if (empty($job_title)) {
      $err_arr[] = 'job empty';
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
      // img path
      $path .= "//img/";
      // check path
      if (!file_exists($path)) {
        mkdir($path);
      }
      // members path
      $path .= "//members/";
      // check path
      if (!file_exists($path)) {
        mkdir($path);
      }

      // media temp
      $media_temp = [];
      // check if not empty
      if (!empty($file_name)) {
        $media_temp = explode('.', $file_name);
        $media_temp[0] = 'members_' . date('dmY') . '_' . rand(00000000, 99999999);
        $media_name = join('.', $media_temp);
        move_uploaded_file($files_tmp_name, $path . $media_name);
        // upload files info into database
        $is_inserted = $members_obj->insert_new_member(array($member_name, $job_title, $media_name, $facebook, $instagram, $twitter, $linkedin, $youtube, $is_active, get_date_now(), base64_decode($_SESSION['website']['user_id'])));
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
    $_SESSION['flash_message_lang_file'][0] = $lang_file;
  } elseif ($succ_counter < $imgs_counter && $succ_counter > 0) {
    $_SESSION['flash_message'][0] = 'INSERTED SOME';
    $_SESSION['flash_message_icon'][0] = 'bi-check-circle-fill';
    $_SESSION['flash_message_class'][0] = 'success';
    $_SESSION['flash_message_status'][0] = true;
    $_SESSION['flash_message_lang_file'][0] = $lang_file;
  }

  // check failed counter
  if ($fail_counter > 0) {
    // prepare flash session variables
    $_SESSION['flash_message'][1] = 'FAILED SOME';
    $_SESSION['flash_message_icon'][1] = 'bi-exclamation-triangle-fill';
    $_SESSION['flash_message_class'][1] = 'danger';
    $_SESSION['flash_message_status'][1] = false;
    $_SESSION['flash_message_lang_file'][1] = $lang_file;
  }

  // redirect to the previous page
  redirect_home(null, "back", 0);
} else {
  // include permission error module
  include_once $globmod . 'permission-error.php';
}