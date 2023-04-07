<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // final message
  $msg = '';
  // create an object of Malfunction class
  $mal_obj = new Malfunction();
  // get update owner id
  $update_owner_id = $_SESSION['UserID'];
  // get update owner type
  $update_owner_type = $_SESSION['isTech'];
  // get update owner job_id
  $update_owner_job_id = $_SESSION['job_title_id'];
  // get malfunction id
  $mal_id = isset($_POST['mal-id']) && !empty($_POST['mal-id']) ? $_POST['mal-id']: 0;

  // check if malfunction is exist or not
  if ($mal_obj->is_exist("`mal_id`", "`malfunctions`", $mal_id)) {
    // get malfunction basics info
    $stored_basics_info = $mal_obj->get_spec_malfunction($mal_id, $_SESSION['company_id']);
    // get is exist boolean value
    $is_exist = $stored_basics_info[0];
    // check if exist again
    if ($is_exist) {
      // get info
      $mal_info = $stored_basics_info[1][0];
      // get new malfunction info
      $manager_id   = $_POST['admin-id'];
      $tech_id      = $_POST['technical-id'];
      // chekc malfunction status
      if ($mal_info['mal_status'] == 0) {
        // check who is doing the update
        switch ($update_owner_job_id) {
          /**
           * updates for:
            * [1] The Manager
            * [2] Customer Services
            */
          case 1:
          case 3:
            do_manager_updates($_POST);
            break;
          /**
           * updates for:
           * [1] Technical Man
           */
          case 2:
            // check who is doing the updates
            if ($update_owner_id == $tech_id) {
              do_technical_updates($_POST);
              // check if upload media
              if (count($_FILES) > 0) {
                $path = $uploads . "//malfunctions/" . $_SESSION['company_id'] . "/";
                upload_malfunction_media($_FILES, $mal_id, $path);
              }
            }
            break;
        }
      } else {
        /**
         * updates for:
         * [1] After Sales Man
         */
        do_after_sales_updates($_POST);
      }
      // success message
      $msg = '<div class="alert alert-success text-capitalize"><i class="bi bi-check-circle-fill"></i>&nbsp;'.language("MALFUNCTION WAS UPDATED SUCCESSFULLY", @$_SESSION['systemLang']).'</div>';
    } ?>

    <!-- start edit profile page -->
    <div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
      <!-- start header -->
      <header class="header">
        <?php redirectHome($msg, 'back'); ?>
      </header>
    </div>
  <?php
  } else {
    // include no data founded
    include_once $globmod . 'no-data-founded.php';
  }
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
  // create an object of Malfunction class
  $mal_obj = new Malfunction();
  // get malfunction id
  $mal_id = $info['mal-id'];
  // get malfunction technical id
  $tech_id = $info['tech-id'];
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
    $mal_obj->reset_malfunction_info(array($tech_id, $descreption, $mal_id));
  }
}
?>

<?php
/**
 * do_technical_updates function
 * used to do only technical updates
 */
function do_technical_updates($info) {
  // get malfunction id
  $mal_id = $info['mal-id'];
  // get malfunction status
  $mal_status = $info['mal-status'];
  // get technical status
  $tech_status = $info['tech-status'];
  // get technical man comment
  $tech_comment = isset($info['comment']) ? $info['comment'] : '';
  // get malfunction cost
  $cost = $_POST['cost'];
  // create an object of Malfunction class
  $mal_obj = new Malfunction();
  // get updated status
  $mal_obj->update_malfunction_tech(array($mal_status, $cost, $tech_comment, $tech_status, $mal_id));
}
?>

<?php 
/**
 * upload_malfunction_media function
 * used to upload media to database
 */
function upload_malfunction_media($media_files, $mal_id, $path) {
  // create an object of Malfunction class
  $mal_obj = new Malfunction();
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

  // loop on it
  for ($i=0; $i < count($files_names); $i++) {
    // media temp
    $media_temp = [];
    // check if not empty
    if (!empty($files_names[$i]) && $files_error[$i] == 0) {
      $media_temp = explode('.', $files_names[$i]);
      $media_temp[0] = date('dmY') .'_'. $mal_id .'_'. rand(00000000, 99999999) .'_'.($i + 1);
      $media_name = join('.',$media_temp);
      move_uploaded_file($files_tmp_name[$i], $path.$media_name);

      // upload files info into database
      $mal_obj->upload_media($mal_id, $media_name, strpos($files_types[$i], 'image') >= 0 ? 'img' : 'video' );
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
  // get malfunction id
  $mal_id = $info['mal-id'];
  // get technical quality
  $tech_qty = isset($info['technical-qty']) ? $info['technical-qty'] : 0;
  // get services quality
  $service_qty = isset($info['service-qty']) ? $info['service-qty'] : 0;
  // get money review
  $money_review = isset($info['money-review']) ? $info['money-review'] : 0;
  // get review comment
  $review_comment = isset($info['review-comment']) ? $info['review-comment'] : '';
  // check if will review
  if ($tech_qty != 0 && $service_qty != 0 && $money_review != 0) {
    // create an object of Malfunction class
    $mal_obj = new Malfunction();
    // get updated status
    $mal_obj->update_malfunction_review(array($money_review, $service_qty, $tech_qty, $review_comment, $mal_id));
  }
}
?>


<?php
  //       //   // loop on form error array
  //       //   foreach ($formErorr as $error) {
  //       //     echo '<div class="alert alert-danger text-capitalize w-50 mx-auto align-left">' . $error . '</div>';
  //       //   }

  //       //   // check if empty form error
  //       //   if (empty($formErorr)) {
  //       //     // values of photos to insert
  //       //     $updatePhoto = "";
  //       //     // check photo array
  //       //     if ($isUploaded) {
  //       //       // loop on photos
  //       //       foreach ($photoName as $key => $photo) {
  //       //         # code...
  //       //         $arrName = explode('.', $photo);
  //       //         $photoExtension = strtolower(end($arrName));
  //       //         // add the date of day and malfunction id to the photo name
  //       //         $phName = strtoupper($photoExtension) . "_". Date('Ymd') . "_" . $malID . "_" . rand() . "." . $photoExtension;
  //       //         // move photo into upload directory
  //       //         move_uploaded_file($photoTmp[$key], $uploads."//malfunctions//".$phName);
  //       //         // check the uploaded type
  //       //         $type = in_array($photoExtension, $imageTypes) ? "img" : "video";
  //       //         // append photos values
  //       //         $updatePhoto .= "(".$malID.", '".$phName."', '".$type."')";
  //       //         // if not last photo add ',' at the end of the values query
  //       //         $updatePhoto .= ($key + 1) == count($photoName) ? "" : ", ";
  //       //       }
  //       //       // 
  //       //       $query .= "INSERT INTO `malfunctions_media` (`mal_id`, `media`,`type`) VALUES " . $updatePhoto . ";";
  //       //     }
  //       //   }
  //       // }
  //       // query to update the malfunction
  //       $query .= "UPDATE `malfunctions` SET `mal_status` = ?, `isAccepted` = ?, `cost` = ?, `repaired_date` = CURRENT_DATE, `repaired_time` = CURRENT_TIME, `tech_comment` = ? WHERE `mal_id` = ?;";
  ?>