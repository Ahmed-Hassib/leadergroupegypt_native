<!-- <pre dir="ltr"><?php print_r($_POST) ?></pre>
<br>
<pre dir="ltr"><?php print_r($_FILES) ?></pre> -->

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // create an object of Features class
  $features_obj = new Features();
  // get next id
  $next_id = $features_obj->get_next_id('leadergroup_website', 'features');

  // create an array of errors
  $err_arr = array();

  // get feature info
  $feature_name_ar = isset($_POST['ar-name']) && !empty($_POST['ar-name']) ? $_POST['ar-name'] : null;
  $feature_name_en = isset($_POST['en-name']) && !empty($_POST['en-name']) ? $_POST['en-name'] : null;
  $feature_desc_ar = isset($_POST['ar-desc']) && !empty($_POST['ar-desc']) ? $_POST['ar-desc'] : null;
  $feature_desc_en = isset($_POST['en-desc']) && !empty($_POST['en-desc']) ? $_POST['en-desc'] : null;
  $is_active = isset($_POST['is-active']) ? $_POST['is-active'] : 0;

  // get image info
  $file_name = $_FILES['feature-img-input']['name'];
  $file_type = $_FILES['feature-img-input']['type'];
  $file_error = $_FILES['feature-img-input']['error'];
  $file_size = $_FILES['feature-img-input']['size'];
  $files_tmp_name = $_FILES['feature-img-input']['tmp_name'];

  // success counter
  $succ_counter = 0;
  // failed counter
  $fail_counter = 0;

  // basic info validations
  if ($feature_name_ar == null) {
    $err_arr[] = 'ar name feature empty';
  }

  if ($feature_name_en == null) {
    $err_arr[] = 'en name feature empty';
  }

  if ($feature_desc_en == null) {
    $err_arr[] = 'en desc feature empty';
  }

  if ($feature_desc_en == null) {
    $err_arr[] = 'en desc feature empty';
  }

  // validation on values
  if ($is_active != 0 && empty($is_active)) {
    $err_arr[] = 'status empty';
  }

  // check if company image changed
  if ($file_error > 0 && $file_size <= 0) {
    $err_arr[] = 'img empty';
  }

  // get feature details counter
  $deatils_counter = count($_POST['ar-detail-name']);

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
    // features path
    $path .= "//" . $features_obj->SECTION_CONTENT_FOLDER . "/";
    // check path
    if (!file_exists($path)) {
      mkdir($path);
    }

    // media temp
    $media_temp = [];

    // check if not empty
    if (!empty($file_name)) {
      $media_temp = explode('.', $file_name);
      $media_temp[0] = 'features_' . date('dmY') . '_' . rand(00000000, 99999999);
      $media_name = join('.', $media_temp);
      move_uploaded_file($files_tmp_name, $path . $media_name);
      // upload files info into database
      $is_inserted = $features_obj->insert_new_feature(array($feature_name_ar, $feature_name_en, $feature_desc_ar, $feature_desc_en, $media_name, $is_active, get_date_now(), get_time_now(), base64_decode($_SESSION['website']['user_id'])));
    } else {
      $is_inserted = false;
    }

    // loop on feature details
    for ($i = 0; $i < $deatils_counter; $i++) {
      // get feature details
      $detail_name_ar = $_POST['ar-detail-name'][$i];
      $detail_name_en = $_POST['en-detail-name'][$i];
      $detail_text_ar = $_POST['ar-text'][$i];
      $detail_text_en = $_POST['en-text'][$i];
      // insert feature detail
      $is_inserted_2 = $features_obj->insert_new_feature_details(array($next_id, $detail_name_ar, $detail_name_en, $detail_text_ar, $detail_text_en, get_date_now(), get_time_now(), base64_decode($_SESSION['website']['user_id'])));
      // check if inserted
      if ($is_inserted_2) {
        // success counter
        $succ_counter += 1;
      } else {
        // failed counter
        $fail_counter += 1;
      }
    }
  }

  // check success counter
  if ($succ_counter == $deatils_counter) {
    // prepare flash session variables
    $_SESSION['flash_message'][0] = 'INSERTED';
    $_SESSION['flash_message_icon'][0] = 'bi-check-circle-fill';
    $_SESSION['flash_message_class'][0] = 'success';
    $_SESSION['flash_message_status'][0] = true;
    $_SESSION['flash_message_lang_file'][0] = 'features';
  } elseif ($succ_counter < $deatils_counter && $succ_counter > 0) {
    $_SESSION['flash_message'][0] = 'INSERTED SOME';
    $_SESSION['flash_message_icon'][0] = 'bi-check-circle-fill';
    $_SESSION['flash_message_class'][0] = 'success';
    $_SESSION['flash_message_status'][0] = true;
    $_SESSION['flash_message_lang_file'][0] = 'features';
  }

  // check failed counter
  if ($fail_counter > 0) {
    // prepare flash session variables
    $_SESSION['flash_message'][1] = 'FAILED SOME';
    $_SESSION['flash_message_icon'][1] = 'bi-exclamation-triangle-fill';
    $_SESSION['flash_message_class'][1] = 'danger';
    $_SESSION['flash_message_status'][1] = false;
    $_SESSION['flash_message_lang_file'][1] = 'features';
    // assign data into session
    $_SESSION['request_data'] = $_POST;
  }

  // redirect to the previous page
  redirect_home(null, "back", 0);
} else {
  // include permission error module
  include_once $globmod . 'permission-error.php';
}