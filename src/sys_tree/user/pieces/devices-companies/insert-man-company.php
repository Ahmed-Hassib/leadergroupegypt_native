<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // get type name
  $company_name = isset($_POST['company-name']) && !empty($_POST['company-name']) ? $_POST['company-name'] : '';
  if (!isset($dev_company_obj)) {
    // create an object of PiecesTypes class
    $dev_company_obj = new ManufuctureCompanies();
  }
  // check if name exist or not
  $is_exist = $dev_company_obj->count_records("`man_company_id`", "`manufacture_companies`", "WHERE `man_company_name` = $company_name AND `company_id` = " . $_SESSION['company_id']);
  // type name validation
  if (!empty($company_name)) {
    // check if type is exist or not
    if ($is_exist > 0) {
      $_SESSION['flash_message'] = 'THIS NAME IS ALREADY EXIST';
      $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
      $_SESSION['flash_message_class'] = 'danger';
      $_SESSION['flash_message_status'] = false;
    } else {
      // call insert_new_type function
      $dev_company_obj->insert_new_man_company(array($company_name, get_date_now(), $_SESSION['UserID'], $_SESSION['company_id']));
      // prepare flash session variables
      $_SESSION['flash_message'] = 'COMPANY WAS ADDED SUCCESSFULLY';
      $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
      $_SESSION['flash_message_class'] = 'success';
      $_SESSION['flash_message_status'] = true;
    }
  } else {
    $_SESSION['flash_message'] = 'PIECE TYPE CANNOT BE EMPTY';
    $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
    $_SESSION['flash_message_class'] = 'danger';
    $_SESSION['flash_message_status'] = false;
  }

  // return to the previous page
  redirect_home(null, "back", 0);
} else {
  // include_once permission error module
  include_once $globmod . 'permission-error.php';
} ?>
