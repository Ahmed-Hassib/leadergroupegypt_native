<!-- <pre dir="ltr"><?php print_r($_POST) ?></pre> -->
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // create an object of Malfunction class
  $mal_obj = !isset($mal_obj) ? new Malfunction() : $mal_obj;
  // get update owner id
  $update_owner_id = base64_decode($_SESSION['sys']['UserID']);
  // get update owner type
  $update_owner_type = $_SESSION['sys']['isTech'];
  // get update owner job_id
  $update_owner_job_id = base64_decode($_SESSION['sys']['job_title_id']);
  // get malfunction id
  $mal_id = isset($_POST['mal-id']) && !empty($_POST['mal-id']) ? base64_decode($_POST['mal-id']) : 0;

  // check if malfunction is exist or not
  if ($mal_obj->is_exist("`mal_id`", "`malfunctions`", $mal_id)) {
    // get malfunction basics info
    $stored_basics_info = $mal_obj->get_spec_malfunction($mal_id, base64_decode($_SESSION['sys']['company_id']));
    // get is exist boolean value
    $is_exist = $stored_basics_info[0];
    // check if exist again
    if ($is_exist) {
      // get info
      $mal_info = $stored_basics_info[1][0];
      // get new malfunction info
      $manager_id   = base64_decode($_POST['admin-id']);
      $tech_id      = base64_decode($_POST['technical-id-value']);

      // check who is doing the update
      switch ($update_owner_job_id) {
          /**
         * updates for:
         * [1] The Manager
         * [2] Customer Services
         */
        case 1:
        case 3:
        case 4:
          if ($mal_info['mal_status'] != 1) {
            do_manager_updates($_POST);
          } else {
            do_after_sales_updates($_POST);
          }
          break;
          /**
           * updates for:
           * [1] Technical Man
           */
        case 2:
          // check who is doing the updates
          if ($update_owner_id == $tech_id && $mal_info['mal_status'] != 1) {
            do_technical_updates($_POST);
          }

          // check if upload media
          if (count($_FILES) > 0) {
            $path = $uploads . "malfunctions/";
            upload_malfunction_media($_FILES, $mal_id, $path);
          }
          break;
      }
      // prepare flash session variables
      $_SESSION['flash_message'] = 'UPDATED';
      $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
      $_SESSION['flash_message_class'] = 'success';
      $_SESSION['flash_message_status'] = true;
      $_SESSION['flash_message_lang_file'] = 'malfunctions';
    } else {
      // prepare flash session variables
      $_SESSION['flash_message'] = 'NO DATA';
      $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
      $_SESSION['flash_message_class'] = 'danger';
      $_SESSION['flash_message_status'] = false;
      $_SESSION['flash_message_lang_file'] = 'global_';
    }
  } else {
    // prepare flash session variables
    $_SESSION['flash_message'] = 'NO DATA';
    $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
    $_SESSION['flash_message_class'] = 'danger';
    $_SESSION['flash_message_status'] = false;
    $_SESSION['flash_message_lang_file'] = 'global_';
  }
  // redirect to the previous page
  redirect_home(null, 'back', 0);
} else {
  // include no data founded
  include_once $globmod . 'permission-error.php';
}

/**
 * do_manager_updates function
 * used to do only manager updates
 */
function do_manager_updates($info)
{
  // create an object of Malfunction class
  $mal_obj = !isset($mal_obj) ?new Malfunction():$mal_obj;
  // get malfunction id
  $mal_id = base64_decode($info['mal-id']);
  // get malfunction technical id
  $tech_id = base64_decode($info['technical-id-value']);
  // get malfunction description
  $descreption = $info['descreption'];
  // get previous malfunction tecnical id
  $prev_tech_id = $mal_obj->select_specific_column("`tech_id`", "`malfunctions`", "WHERE `mal_id` = $mal_id")[0]['tech_id'];
  // compare new tech with the old
  if ($tech_id == $prev_tech_id) {
    // update all malfunction info
    $mal_obj->update_malfunction_mng(array($descreption, $mal_id));
  } else {
    // reset malfunction info
    $mal_obj->reset_malfunction_info(array($tech_id, $descreption, get_date_now(), get_time_now(), $mal_id));
  }
}

/**
 * do_technical_updates function
 * used to do only technical updates
 */
function do_technical_updates($info)
{
  // return $info['mal-status'] == 1 ? true : false; 
  // get malfunction id
  $mal_id = base64_decode($info['mal-id']);
  // get malfunction status
  $mal_status = base64_decode($info['mal-status']);
  // get technical status
  $tech_status = base64_decode($info['mal-status']);
  // get technical man comment
  $tech_comment = isset($info['comment']) ? $info['comment'] : '';
  // get technical man status comment
  $tech_comment_status = isset($info['tech-status-comment']) ? $info['tech-status-comment'] : '';
  // get malfunction cost
  $cost = $_POST['cost'];
  if (!isset($mal_obj)) {
    // create an object of Malfunction class
    $mal_obj = new Malfunction();
  }
  // get updated status
  $mal_obj->update_malfunction_tech(array($mal_status, $cost, get_date_now(), get_time_now(), $tech_comment, $tech_comment_status, $tech_status, $mal_id));
}

/**
 * upload_malfunction_media function
 * used to upload media to database
 */
function upload_malfunction_media($media_files, $mal_id, $path)
{
  if (!isset($mal_obj)) {
    // create an object of Malfunction class
    $mal_obj = new Malfunction();
  }
  // files names
  $files_names = $media_files['mal-media']['name'];
  // files tmp name
  $files_tmp_name = $media_files['mal-media']['tmp_name'];
  // files types
  $files_types = $media_files['mal-media']['type'];
  // files error
  $files_error = $media_files['mal-media']['error'];
  // files size
  $files_size = $media_files['mal-media']['size'];

  if (!file_exists($path)) {
    mkdir($path);
  }

  $path .= base64_decode($_SESSION['sys']['company_id']) . "/";

  if (!file_exists($path)) {
    mkdir($path);
  }
  // loop on it
  for ($i = 0; $i < count($files_names); $i++) {
    // media temp
    $media_temp = [];
    // check if not empty
    if (!empty($files_names[$i]) && $files_error[$i] == 0) {
      $media_temp = explode('.', $files_names[$i]);
      $media_temp[0] = date('dmY') . '_' . $mal_id . '_' . rand(00000000, 99999999) . '_' . ($i + 1);
      $media_name = join('.', $media_temp);
      move_uploaded_file($files_tmp_name[$i], $path . $media_name);

      // // upload files info into database
      $mal_obj->upload_media($mal_id, $media_name, strpos($files_types[$i], 'image') !== false ? 'img' : 'video');
    }
  }
}


/**
 * do_after_sales_updates function
 * used to do only after_sales updates
 */
function do_after_sales_updates($info)
{
  // get malfunction id
  $mal_id = base64_decode($info['mal-id']);
  // get technical quality
  $tech_qty = isset($info['technical-qty']) ? base64_decode($info['technical-qty']) : 0;
  // get services quality
  $service_qty = isset($info['service-qty']) ? base64_decode($info['service-qty']) : 0;
  // get money review
  $money_review = isset($info['money-review']) ? base64_decode($info['money-review']) : 0;
  // get review comment
  $review_comment = isset($info['review-comment']) ? $info['review-comment'] : '';
  // check if will review
  if ($tech_qty != 0 && $service_qty != 0 && $money_review != 0) {
    if (!isset($mal_obj)) {
      // create an object of Malfunction class
      $mal_obj = new Malfunction();
    }
    // get updated status
    $mal_obj->update_malfunction_review(array(get_date_now(), get_time_now(), $money_review, $service_qty, $tech_qty, $review_comment, $mal_id));
  }
}
