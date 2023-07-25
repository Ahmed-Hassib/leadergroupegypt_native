<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (!isset($comb_obj)) {
    // create an object of Combination
    $comb_obj = new Combination();
  }
  // get update owner id
  $update_owner_id = $_SESSION['UserID'];
  // get update owner type
  $update_owner_type = $_SESSION['isTech'];
  // get update owner job_id
  $update_owner_job_id = $_SESSION['job_title_id'];
  // get combination id
  $comb_id = isset($_POST['comb-id']) && !empty($_POST['comb-id']) ? $_POST['comb-id']: 0;
  // check if combination is exist or not
  if ($comb_obj->is_exist("`comb_id`", "`combinations`", $comb_id)) {
    // get combination basics info
    $stored_basics_info = $comb_obj->get_spec_combination($comb_id, $_SESSION['company_id']);
    // get is exist boolean value
    $is_exist = $stored_basics_info[0];
    // check if exist again
    if ($is_exist) {
      // get info
      $comb_info = $stored_basics_info[1][0];
      // get new malfunction info
      $manager_id   = $_POST['admin-id'];
      $tech_id      = $_POST['technical-id'];
      
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
          if ($comb_info['isFinished'] != 1) {
            $is_updated = do_manager_updates($_POST);
          } else {
            $is_updated = do_after_sales_updates($_POST);
          }
          break;
        /**
         * updates for:
         * [1] Technical Man
         */
        case 2:
          // check who is doing the updates
          if ($update_owner_id == $tech_id && $comb_info['isFinished'] != 1) {
            $is_updated = do_technical_updates($_POST);
          }
          // check if upload media
          if (count($_FILES) > 0) {
            $path = $uploads . "combinations/";
            upload_combination_media($_FILES, $comb_id, $path);
          }
          break;
      }
      // prepare flash session variables
      $_SESSION['flash_message'] = 'COMBINATION WAS UPDATED SUCCESSFULLY';
      $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
      $_SESSION['flash_message_class'] = 'success';
      $_SESSION['flash_message_status'] = true;
    } else {
      // prepare flash session variables
      $_SESSION['flash_message'] = 'NO DATA FOUNDED';
      $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
      $_SESSION['flash_message_class'] = 'danger';
      $_SESSION['flash_message_status'] = false;
    }
  } else {
    foreach ($formErorr as $key => $error) {
      $_SESSION['flash_message'][$key] = strtoupper($error);
      $_SESSION['flash_message_icon'][$key] = 'bi-exclamation-triangle-fill';
      $_SESSION['flash_message_class'][$key] = 'danger';
      $_SESSION['flash_message_status'][$key] = false;
    }
  }
  // return to the previous page
  redirect_home(null, 'back', 0);
} else {
  // include no data founded
  include_once $globmod . 'permission-error.php';
}
?>



<?php
/**
 * do_manager_updates function
 * used to do only manager updates
 */
function do_manager_updates($info) {
  if (!isset($comb_obj)) {
    // create an object of Combination
    $comb_obj = new Combination();
  }
  // get combination id
  $comb_id = $info['comb-id'];
  // get combination technical id
  $tech_id = $info['technical-id'];
  // get client name
  $client_name = $info['client-name'];
  // get client phone
  $client_phone = $info['client-phone'];
  // get client address
  $client_address = $info['client-address'];
  // get combination description
  $comment = $_POST['client-notes'];
  // get previous combination tecnical id
  $prev_tech_id = $comb_obj->select_specific_column("`UserID`", "`combinations`", "WHERE `comb_id` = $comb_id")[0]['UserID'];
  // compare new tech with the old
  if ($tech_id == $prev_tech_id) {
    // update all compination info
    $is_updated = $comb_obj->update_compination_mng(array($client_name, $client_phone, $client_address, $comment, $tech_id, get_date_now(), get_time_now(), $comb_id));
  } else {
    // reset compination info
    $is_updated = $comb_obj->reset_compination_info($tech_id, get_date_now(), get_time_now(), $comb_id);
  }
  return $is_updated;
}
?>

<?php
/**
 * do_technical_updates function
 * used to do only technical updates
 */
function do_technical_updates($info) {
  // get combination id
  $comb_id = $info['comb-id'];
  // get combination status
  $is_finished = $info['comb-status'];
  // get technical status
  $tech_status = $info['comb-status'];
  // get technical man comment
  $tech_comment = isset($info['comment']) ? $info['comment'] : '';
  // get combination cost
  $cost = $_POST['cost'];
  if (!isset($comb_obj)) {
    // create an object of Combination
    $comb_obj = new Combination();
  }
  // get updated status
  $is_updated = $comb_obj->update_combination_tech(array($is_finished, $tech_status, get_date_now(), get_time_now(), get_date_now(), get_time_now(), $cost, $tech_comment, $comb_id));
  return $is_updated;
}
?>

<?php 
/**
 * upload_combination_media function
 * used to upload media to database
 */
function upload_combination_media($media_files, $comb_id, $path) {
  if (!isset($comb_obj)) {
    // create an object of Combination class
    $comb_obj = new Combination();
  }
  // files names
  $files_names = $media_files['comb-media']['name'];
  // files tmp name
  $files_tmp_name = $media_files['comb-media']['tmp_name'];
  // files types
  $files_types = $media_files['comb-media']['type'];
  // files error
  $files_error = $media_files['comb-media']['error'];
  // files size
  $files_size = $media_files['comb-media']['size'];

  if (!file_exists($path) && !is_dir($path)) {
    mkdir($path);
  }
  
  $path .= $_SESSION['company_id'] . "/";

  if (!file_exists($path) && !is_dir($path)) {
    mkdir($path);
  }
  
  // loop on it
  for ($i=0; $i < count($files_names); $i++) {
    // media temp
    $media_temp = [];
    // check if not empty
    if (!empty($files_names[$i]) && $files_error[$i] == 0) {
      $media_temp = explode('.', $files_names[$i]);
      $media_temp[0] = date('dmY') .'_'. $comb_id .'_'. rand(00000000, 99999999) .'_'.($i + 1);
      $media_name = join('.',$media_temp);
      move_uploaded_file($files_tmp_name[$i], $path.$media_name);

      // upload files info into database
      $comb_obj->upload_media($comb_id, $media_name, strpos($files_types[$i], 'image') !== false ? 'img' : 'video' );
    }
  }
}
?>

<?php
/**
 * do_after_sales_updates function
 * used to do only after_sales updates
 */
function do_after_sales_updates($info) {
  // get combination id
  $comb_id = $info['comb-id'];
  // get technical quality
  $tech_qty = isset($info['technical-qty']) ? $info['technical-qty'] : 0;
  // get services quality
  $service_qty = isset($info['service-qty']) ? $info['service-qty'] : 0;
  // get money review
  $money_review = isset($info['money-review']) ? $info['money-review'] : 0;
  // get review comment
  $review_comment = isset($info['review-comment']) ? $info['review-comment'] : '';
  // check if will review
  if ($tech_qty != 0 && $service_qty != 0 && $money_review != 0 && !empty($review_comment)) {
    if (!isset($comb_obj)) {
      // create an object of Combination
      $comb_obj = new Combination();
    }
    // get updated status
    $is_updated = $comb_obj->update_combination_review(array(get_date_now(), get_time_now(), $money_review, $service_qty, $tech_qty, $review_comment, $comb_id));
  }

  return $is_updated;
}
?>