<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') { ?>
  <!-- start edit profile page -->
  <div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
    <!-- start header -->
    <header class="header">
      <?php
      // get company id
      $company_id = $_POST['company-id'];
      // get company name
      $company_name = $_POST['company-name'];
      // get license type
      $license_type = $_POST['license-type'];
      // root password
      $root_password_input = sha1($_POST['root-password']);

      if (!isset($cmp_obj)) {
        // create an object of Company class
        $cmp_obj = new Company();
      }

      // root password
      $root_password = $cmp_obj->select_specific_column("`Pass`", "`users`", "WHERE `UserID` = 1")[0]['Pass'];

      // check root password
      $is_correct_pass =  $root_password == $root_password_input ? true : false;

      if ($is_correct_pass) {
        // check if company exist
        $is_exist_cmp = $cmp_obj->is_exist("`company_id`", "`companies`", $company_id);
  
        // if exist
        if ($is_exist_cmp == true) {
          // get number of months depending on license type
          switch ($license_type) {
            case 1:
              $months = 1;
              break;
            case 2:
              $months = 3;
              break;
            case 3:
              $months = 6;
              break;
            case 4:
              $months = 12;
              break;
          }
          // date of today
          $today = Date("Y-m-d");
          // license period
          $period = ' + ' . $months . ' months';
          $expire_date = Date("Y-m-d", strtotime($today. $period));
          
          // get `isEnded` value
          $count_isEnded = count($cmp_obj->select_specific_column("`isEnded`", "`license`", "WHERE `company_id` = $company_id"));
          
          // check the value
          if ($count_isEnded > 0) {
            // call renew_license function
            $cmp_obj->update_previous_license($company_id);
          }
          
          // insert a new record
          $cmp_obj->renew_license($license_type, $expire_date, $company_id);

          // success message
          $msg = '<div class="alert alert-success text-capitalize fw-bolder">' . language("LICENSE RENEWED SUCCESSFULLY", @$_SESSION['systemLang']) . '</div>';
          
          // redirect to home page
          redirectHome($msg, 'back');
  
        } else {
          // include no data founded module
          include_once './global-modules/no-data-founded.php';
        }
      } else {
        // include password wrong module
        include_once './global-modules/password-wrong.php';
      }
      ?>
    </header>
  </div>
<?php } else {
  // include permission error
  include_once './global-modules/permission-error.php';
} ?>
