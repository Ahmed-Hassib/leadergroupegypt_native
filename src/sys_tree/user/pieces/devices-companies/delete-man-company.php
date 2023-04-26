
<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
  // get company id
  $company_id = isset($_POST['company-id']) && !empty($_POST['company-id']) ? $_POST['company-id'] : '';      
  // create an object of PiecesTypes class
  $dev_company_obj = new ManufuctureCompanies();
  // check if name exist or not
  $is_exist = $dev_company_obj->is_exist("`man_company_id`", "`manufacture_companies`", $company_id);
  // check if company is exist or not
  if (!empty($company_id) && $is_exist == true) {
    // create an object of Devices clas
    $dev_obj = new Devices();
    // get all devices of this company
    $company_devices_info = $dev_obj->get_all_company_devices($company_id);
    // counter
    $devices_counter = $company_devices_info[0];
    // counter
    $devices_data = $company_devices_info[1];
    // check if it not empty
    if (!empty($devices_data)) {
      // create an object of Model class
      $model_obj = new Models();
      // loop on it to delete all devices` models
      foreach ($devices_data as $key => $device) {
        // delete all models of this device
        $model_obj->delete_device_models($device['device_id']);
        // delete all devices of this company
        $dev_obj->delete_device($device['device_id']);
      }
    }
    // call delete_man_company function
    $dev_company_obj->delete_man_company($company_id);
    // echo success message
    $msg = '<div class="alert alert-success text-capitalize" dir=""><i class="bi bi-check-circle-fill"></i>&nbsp;' . language('COMPANY WAS DELETED SUCCESSFULLY', @$_SESSION['systemLang']) . '</div>';
?>
    <!-- start device company page -->
    <div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
      <!-- start header -->
      <header class="header mb-3">
        <?php redirectHome($msg, "back"); ?>
      </header>
    </div>
<?php 
  } else {
    // include no data founded
    include_once $globmod . 'no-data-founded-no-redirect.php';
  }
} else {
  // include_once permission error module
  include_once $globmod . 'permission-error.php';
} ?>