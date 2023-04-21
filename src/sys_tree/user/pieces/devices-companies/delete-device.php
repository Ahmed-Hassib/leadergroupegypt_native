
<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
  // get device id
  $device_id = isset($_POST['deleted-device-id']) && !empty($_POST['deleted-device-id']) ? $_POST['deleted-device-id'] : '';      
  // create an object of PiecesTypes class
  $device_obj = new Devices();
  // create an object of Model class
  $model_obj = new Models();
  // check if name exist or not
  $is_exist = $device_obj->is_exist("`device_id`", "`devices_info`", $device_id);
  // check if company is exist or not
  if (!empty($device_id) && $is_exist == true) {
    // delete all device models
    $model_obj->delete_device_models($device_id);
    // call delete_device function
    $device_obj->delete_device($device_id);
    // echo success message
    $msg = '<div class="alert alert-success text-capitalize" dir=""><i class="bi bi-check-circle-fill"></i>&nbsp;' . language('DEVICE WAS DELETED SUCCESSFULLY', @$_SESSION['systemLang']) . '</div>';
?>
  <!-- start device page -->
  <div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
    <!-- start header -->
    <header class="header mb-3">
      <?php redirectHome($msg, "back"); ?>
    </header>
  </div>
<?php } else {
    // include no data founded
    include_once $globmod . 'no-data-founded-no-redirect.php';
  }
} else {
  include_once $globmod . 'permission-error.php';
} ?>