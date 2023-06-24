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
          $model_obj->insert_new_model(array($model, get_date_now(), $_SESSION['UserID'], $device_id));
          // counter
          $counter++;
        }
      }

      // check counter
      if ($counter == $total_models) {
        // prepare flash session variables
        $_SESSION['flash_message'] = 'MODELS WERE ADDED SUCCESSFULLY';
        $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
        $_SESSION['flash_message_class'] = 'success';
        $_SESSION['flash_message_status'] = true;
      }
    } else {
      // prepare flash session variables
      $_SESSION['flash_message'] = 'NO DATA FOUNDED';
      $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
      $_SESSION['flash_message_class'] = 'danger';
      $_SESSION['flash_message_status'] = false;
    }
    // redirect to the previous page
    redirectHome(null, "back", 0);
  } else {
    // include_once permission error module
    include_once $globmod . 'missing-data.php';
  }
} else {
  // include_once permission error module
  include_once $globmod . 'permission-error.php';
} ?>
