
<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
  // get device id
  $device_id = isset($_POST['deleted-device-id']) && !empty($_POST['deleted-device-id']) ? $_POST['deleted-device-id'] : '';  
  // get back flag value
  $is_back = isset($_GET['back']) && !empty($_GET['back']) ? 'back' : null;
  if (!isset($device_obj)) {
    // create an object of PiecesTypes class
    $device_obj = new Devices();
  }
  if (!isset($model_obj)) {
    // create an object of Model class
    $model_obj = new Models();
  }
  // check if name exist or not
  $is_exist = $device_obj->is_exist("`device_id`", "`devices_info`", $device_id);
  // check if company is exist or not
  if (!empty($device_id) && $is_exist == true) {
    // delete all device models
    $model_obj->delete_device_models($device_id);
    // call delete_device function
    $device_obj->delete_device($device_id);

    // prepare flash session variables
    $_SESSION['flash_message'] = 'DEVICE WAS DELETED SUCCESSFULLY';
    $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
    $_SESSION['flash_message_class'] = 'success';
    $_SESSION['flash_message_status'] = true;
    
    // redirect to previous page
    redirectHome(null, $is_back, 0); 
  } else {
    // include no data founded
    include_once $globmod . 'no-data-founded-no-redirect.php';
  }
} else {
  include_once $globmod . 'permission-error.php';
} ?>