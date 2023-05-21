<?php 
// chekc request method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // get device id
  $device_id = isset($_POST['device-id']) && !empty($_POST['device-id']) ? $_POST['device-id'] : '';
  // get device name
  $device_name = isset($_POST['device-name']) && !empty($_POST['device-name']) ? $_POST['device-name'] : '';
  // get company id
  $company_id = isset($_POST['manufacture-company-id']) && !empty($_POST['manufacture-company-id']) ? $_POST['manufacture-company-id'] : '';
  // check if company id is not empty
  if (!empty($device_id) && !empty($device_name) && !empty($company_id)) {
?>
  <!-- start devices page -->
  <div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
    <!-- start header -->
    <header class="header mb-3">
    <?php
      if (!isset($dev_obj)) {
        // create an object of PiecesTypes class
        $dev_obj = new Devices();
      }
      // check if name exist or not
      $is_exist_device_id   = $dev_obj->is_exist("`device_id`", "`devices_info`", $device_id);
      $is_exist_device_name = $dev_obj->is_exist("`device_id`", "`devices_info`", $device_name);
      $is_exist_company_id  = $dev_obj->is_exist("`man_company_id`", "`manufacture_companies`", $company_id);

      // check if type is exist or not
      if ($is_exist_device_id == true && $is_exist_company_id == true) {
        if ($is_exist_device_name) {
          // echo danger message
          $msg = '<div class="alert alert-danger text-capitalize" dir=""><i class="bi bi-exclamation-triangle-fill"></i>&nbsp;' . language('THIS NAME IS ALREADY EXIST', @$_SESSION['systemLang']) . '</div>';
        } else {
          // call insert_new_type function
          $dev_obj->update_device_info($device_name, $company_id, $device_id);
          // echo success message
          $msg = '<div class="alert alert-success text-capitalize" dir=""><i class="bi bi-check-circle-fill"></i>&nbsp;' . language('DEVICE WAS UPDATED SUCCESSFULLY', @$_SESSION['systemLang']) . '</div>';
        }
        // redirect to home page
        redirectHome($msg, "back");
      } else {
        // include not data founded module
        include_once $globmod . "no-data-founded.php";
      }
      ?>
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
