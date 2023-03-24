<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') { ?>
  <!-- start pieces type page -->
  <div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
    <!-- start header -->
    <header class="header mb-3">
      <?php
      // get type name
      $company_name = isset($_POST['company-name']) && !empty($_POST['company-name']) ? $_POST['company-name'] : '';
      // create an object of PiecesTypes class
      $dev_company_obj = new ManufuctureCompanies();
      // check if name exist or not
      $is_exist = $dev_company_obj->is_exist("`man_company_name`", "`manufacture_companies`", $company_name);
      // type name validation
      if (!empty($company_name)) {
        // check if type is exist or not
        if ($is_exist == true) {
          // echo danger message
          $msg = '<div class="alert alert-danger text-capitalize" dir=""><i class="bi bi-exclamation-triangle-fill"></i>&nbsp;' . language('THIS NAME IS ALREADY EXIST', @$_SESSION['systemLang']) . '</div>';
        } else {
          // call insert_new_type function
          $dev_company_obj->insert_new_man_company($company_name, $_SESSION['UserID'], $_SESSION['company_id']);
          // echo success message
          $msg = '<div class="alert alert-success text-capitalize" dir=""><i class="bi bi-check-circle-fill"></i>&nbsp;' . language('COMPANY WAS ADDED SUCCESSFULLY', @$_SESSION['systemLang']) . '</div>';
        }
      } else {
        // data missed
        $msg = '<div class="alert alert-warning text-capitalize" dir=""><i class="bi bi-check-circle-fill"></i>&nbsp;' . language('PIECE TYPE CANNOT BE EMPTY', @$_SESSION['systemLang']) . '</div>';
      }
      // redirect to home page
      redirectHome($msg, "back");
      ?>
    </header>
  </div>
<?php } else {
  // include_once permission error module
  include_once $globmod . 'permission-error.php';
} ?>
