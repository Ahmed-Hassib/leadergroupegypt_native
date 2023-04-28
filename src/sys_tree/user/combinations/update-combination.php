<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // final message
  $msg = '';
  // create an object of Combination class
  $comb_obj = new Combination();
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
      // is updated flag
      $is_updated = false;
      // chekc malfunction status
      if ($comb_info['isFinished'] == 0) {
        // check who is doing the update
        switch ($update_owner_job_id) {
          /**
           * updates for:
          * [1] The Manager
          * [2] Customer Services
          */
          case 1:
          case 3:
          // check who is doing the updates
          if ($update_owner_id == $manager_id || $update_owner_job_id == 1) {
            $is_updated = do_manager_updates($_POST);
          }
          break;
          /**
           * updates for:
           * [1] Technical Man
           */
          case 2:
          // check who is doing the updates
          if ($update_owner_id == $tech_id) {
            $is_updated = do_technical_updates($_POST);
          }
          break;
        }
      } else {
        // check who is doing the update
        if ($update_owner_job_id == 4 || $update_owner_job_id == 1 || $_SESSION['mal_update'] == 1) {
          /**
           * updates for:
           * [1] After Sales Man
           */
          $is_updated = do_after_sales_updates($_POST);
        }
      }
      // check if was updated
      if ($is_updated) {
        $msg = '<div class="alert alert-success text-capitalize"><i class="bi bi-check-circle-fill"></i>&nbsp;'.language("COMBINATION WAS UPDATED SUCCESSFULLY", @$_SESSION['systemLang']).'</div>';
      } else {
        $msg = '<div class="alert alert-danger text-capitalize"><i class="bi bi-exclamation-triangle-fill"></i>&nbsp;'.language("A PROBLEM WAS HAPPENED WHILE UPDATING THE COMBINATION", @$_SESSION['systemLang']).'</div>';
      }
    } ?>
    <!-- start edit profile page -->
    <div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
      <!-- start header -->
      <header class="header">
      <?php  redirectHome($msg, 'back'); ?>
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
  // create an object of Combination class
  $comb_obj = new Combination();
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
  // return updated status
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
  $tech_status = $info['tech-comb-status'];
  // get technical man comment
  $tech_comment = isset($info['comment']) ? $info['comment'] : '';
  // get combination cost
  $cost = $_POST['cost'];
  // create an object of Combination class
  $comb_obj = new Combination();
  // get updated status
  $is_updated = $comb_obj->update_combination_tech(array($is_finished, $tech_status, get_date_now(), get_time_now(), get_date_now(), get_time_now(), $cost, $tech_comment, $comb_id));
  // return updated status
  return $is_updated;
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
    // create an object of Combination class
    $comb_obj = new Combination();
    // get updated status
    $is_updated = $comb_obj->update_combination_review(array(get_date_now(), get_time_now(), $money_review, $service_qty, $tech_qty, $review_comment, $comb_id));
  } else {
    $is_updated = false;
  }
  // return updated status
  return $is_updated;
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
  //       //       $query .= "INSERT INTO `malfunctions_media` (`comb_id`, `media`,`type`) VALUES " . $updatePhoto . ";";
  //       //     }
  //       //   }
  //       // }
  //       // query to update the malfunction
  //       $query .= "UPDATE `malfunctions` SET `mal_status` = ?, `isAccepted` = ?, `cost` = ?, `repaired_date` = CURRENT_DATE, `repaired_time` = now(), `tech_comment` = ? WHERE `comb_id` = ?;";
  ?>