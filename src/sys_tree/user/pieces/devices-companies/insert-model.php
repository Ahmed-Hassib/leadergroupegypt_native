<?php 
// chekc request method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // get device name
  $device_id = isset($_POST['device-id']) && !empty($_POST['device-id']) ? $_POST['device-id'] : '';
  // get device models
  $device_models = isset($_POST['model']) && !empty($_POST['model']) ? $_POST['model'] : '';
  // check if company id is not empty
  if (!empty($device_models) && !empty($device_id)) {
    if (!isset($model_obj)) {
      // create an object of PiecesTypes class
      $model_obj = new Models();
    }
    // check if name exist or not
    $is_exist = $model_obj->count_records("`device_id`", "`devices_info`", "WHERE `device_id` = $device_id");
    // check if type is exist or not
    if ($is_exist > 0) {
      // is inserted flag for models
      $is_inserted_models = false;
      // total models
      $total_models = count($device_models);
      // counter
      $counter = 0;
      // loop on models to insert it
      foreach ($device_models as $model) {
        // check model if empty
        if (!empty($model)) {
          // insert model
          $model_obj->insert_new_model($model, get_date_now(), $_SESSION['UserID'], $device_id);
          // counter
          $counter++;
        }
      }

      // check counter
      if ($counter == $total_models) {
        // success message
        $msg = '<div class="alert alert-success text-capitalize" dir=""><i class="bi bi-check-circle-fill"></i>&nbsp;' . language('MODELS WAS ADDED SUCCESSFULLY', @$_SESSION['systemLang']) . '</div>';
      }
      
    } else {
      // echo error message
      $msg = '<div class="alert alert-danger text-capitalize" dir=""><i class="bi bi-check-circle-fill"></i>&nbsp;' . language('THERE IS NO ID LIKE THAT', @$_SESSION['systemLang']) . '</div>';
    }
?>
  <!-- start devices page -->
  <div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
    <!-- start header -->
    <header class="header mb-3">
      <?php redirectHome($msg, "back"); ?>
    </header>
  </div>
<?php
  } else {
    // include_once permission error module
    include_once $globmod . 'missing-data.php';
  }
} else {
  // include_once permission error module
  include_once $globmod . 'permission-error.php';
} ?>
