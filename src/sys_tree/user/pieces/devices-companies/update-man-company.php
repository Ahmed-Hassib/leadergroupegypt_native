
<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
  // get company id
  $company_id = isset($_POST['company-id']) && !empty($_POST['company-id']) ? $_POST['company-id'] : '';
  // get new name
  $new_company_name = isset($_POST['new-company-name']) && !empty($_POST['new-company-name']) ? $_POST['new-company-name'] : '';
  if (!isset($dev_company_obj)) {
    // create an object of PiecesTypes class
    $dev_company_obj = new ManufuctureCompanies();
  }
  // check if name exist or not
  $is_exist = $dev_company_obj->is_exist("`man_company_id`", "`manufacture_companies`", $company_id);
  // check if type is exist or not
  if ($is_exist == true) {
    // type name validation
    if (!empty($new_company_name)) {
      // check if type is exist or not
      if ($dev_company_obj->count_records("`man_company_id`", "`manufacture_companies`", "WHERE `man_company_id` <> $company_id AND `man_company_name` = '$new_company_name'") > 0) {
        // prepare flash session variables
        $_SESSION['flash_message'] = 'THIS NAME IS ALREADY EXIST';
        $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
        $_SESSION['flash_message_class'] = 'danger';
        $_SESSION['flash_message_status'] = false;
      } else {
        // call update_man_company function
        $dev_company_obj->update_man_company($new_company_name, $company_id);
        // prepare flash session variables
        $_SESSION['flash_message'] = 'COMPANY WAS UPDATED SUCCESSFULLY';
        $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
        $_SESSION['flash_message_class'] = 'success';
        $_SESSION['flash_message_status'] = true;
      }
    } else {
      // prepare flash session variables
      $_SESSION['flash_message'] = 'COMPANY NAME CANNOT BE EMPTY';
      $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
      $_SESSION['flash_message_class'] = 'danger';
      $_SESSION['flash_message_status'] = false;
    }
  } else {
    // prepare flash session variables
    $_SESSION['flash_message'] = 'NO DATA FOUNDED';
    $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
    $_SESSION['flash_message_class'] = 'danger';
    $_SESSION['flash_message_status'] = false;
  }
  // redirect to the previous page
  redirectHome($msg, "back");
} else {
  // include_once permission error module
  include_once $globmod . 'permission-error.php';
} ?>