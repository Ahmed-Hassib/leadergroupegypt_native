
<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
  // get company id
  $company_id = isset($_POST['company-id']) && !empty($_POST['company-id']) ? $_POST['company-id'] : '';
  // get new name
  $new_company_name = isset($_POST['new-company-name']) && !empty($_POST['new-company-name']) ? $_POST['new-company-name'] : '';
  
  // create an object of PiecesTypes class
  $dev_company_obj = new ManufuctureCompanies();
  // check if name exist or not
  $is_exist = $dev_company_obj->is_exist("`man_company_id`", "`manufacture_companies`", $company_id);
  // check if type is exist or not
  if ($is_exist == true) {
    // type name validation
    if (!empty($new_company_name)) {
      // check if type is exist or not
      if ($dev_company_obj->count_records("`man_company_id`", "`manufacture_companies`", "WHERE `man_company_id` <> $company_id AND `man_company_name` = '$new_company_name'") > 0) {
        // echo danger message
        $msg = '<div class="alert alert-danger text-capitalize" dir=""><i class="bi bi-exclamation-triangle-fill"></i>&nbsp;' . language('THIS NAME IS ALREADY EXIST', @$_SESSION['systemLang']) . '</div>';
      } else {
        // call update_man_company function
        $dev_company_obj->update_man_company($new_company_name, $company_id);
        // echo success message
        $msg = '<div class="alert alert-success text-capitalize" dir=""><i class="bi bi-check-circle-fill"></i>&nbsp;' . language('COMPANY WAS UPDATED SUCCESSFULLY', @$_SESSION['systemLang']) . '</div>';
      }
    } else {
      // data missed
      $msg = '<div class="alert alert-warning text-capitalize" dir=""><i class="bi bi-check-circle-fill"></i>&nbsp;' . language('COMPANY NAME CANNOT BE EMPTY', @$_SESSION['systemLang']) . '</div>';
    }
  } else {
    $msg = '<div class="page-error">';
    $msg .= '<img src="' .$assets . '"images/no-data-founded.svg" class="img-fluid" alt="' . language("NO DATA FOUNDED", @$_SESSION['systemLang']) . '">';
    $msg .= '</div>';
    // error message
    $msg .= '<div class="alert alert-danger text-capitalize"><i class="bi bi-exclamation-triangle-fill"></i>&nbsp;'. language('NO DATA FOUNDED', @$_SESSION['systemLang']) .'</div>';
  }
?>
  <!-- start pieces type page -->
  <div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
    <!-- start header -->
    <header class="header mb-3">
      <?php redirectHome($msg, "back"); ?>
    </header>
  </div>
<?php } else {
    // include_once permission error module
    include_once $globmod . 'permission-error.php';
} ?>