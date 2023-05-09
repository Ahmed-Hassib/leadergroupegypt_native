<?php 
$page_title = "new registration";
// level
$level = 3;
// nav level
$nav_level = 1;
// pre-configration of system
include_once str_repeat("../", $level) . "etc/pre-conf.php";
// initial configration of system
include_once str_repeat("../", $level) . "etc/init.php";
// check request method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // final message
  $msg = '';
  $url = "../signup.php";
  // get next company id and next user id
  $company_id = $db_obj->get_next_id('companies');
  $user_id = $db_obj->get_next_id('users');
  // get company info
  $company_name = $_POST['company-name'];
  $manager_name = $_POST['manager-name'];
  $manager_phone = $_POST['manager-phone'];
  // check company name is exists
  $is_exist_company_name = $db_obj->is_exist("`company_name`", "`companies`", $company_name);
  // if not exist add it
  if (!$is_exist_company_name) {
    // create an object of Registration class
    $reg_obj = new Registration();
    // add new company
    $is_inserted_company = $reg_obj->add_new_company(array($company_name, $manager_name, $manager_phone, get_date_now()));
    // echo success message
    $msg = '<div class="alert alert-success text-capitalize fw-bolder text-center">' . language("YOUR COMPANY IS CREATED SUCCESSFULLY!") . '</div>';
    // check if inserted company
    if ($is_inserted_company) {
      // admin of this company info
      $full_name = $_POST['fullname'];
      $username = $_POST['username'];
      $password = $_POST['password'];
      $enc_password = sha1($password);
      $gender = $_POST['gender'];      
      // calculate expire date after one month
      // date of today
      $today = Date("Y-m-d");
      // license period
      $period = ' + 1months';
      // expire date
      $expire_date = Date("Y-m-d", strtotime($today. $period));
      // add license
      $is_inserted_license = $reg_obj->add_company_license(array($company_id, get_date_now(), $expire_date));
      // check if inserted license
      if ($is_inserted_license) {
        // echo success message
        $msg .= '<div class="alert alert-success text-capitalize fw-bolder text-center">' . language("ONE MONTH FREE SUBSCRIPTION ACTIVATED SUCCESSFULLY!") . '</div>';
        // if company was inserted
        // and license was inserted
        if ($is_inserted_company && $is_inserted_license) {
          // insert admin info
          $is_inserted_admin_info = $reg_obj->add_company_admin(array($company_id, $username, $enc_password, $full_name, $gender, get_date_now()));
          // check if admin info is inserted
          if ($is_inserted_admin_info) {
            // success message
            $msg .= '<div class="alert alert-success text-capitalize fw-bolder text-center">' . language("YOUR ADMIN ACCOUNT IS CREATED SUCCESSFULLY!") . '</div>';
            // add admin permission
            $is_inserted_admin_permission = $reg_obj->add_admin_permission($user_id);
            // check if admin permisssion was inserted
            if ($is_inserted_admin_permission) {
              // success message
              $msg .= '<div class="alert alert-success text-capitalize fw-bolder text-center">' . language("YOUR ADMIN ACCOUNT PERMISSIONS IS CREATED SUCCESSFULLY!") . '</div>';
              // redirect to url
              $url = "../login.php?username=$username&password=$password";
            } else {
              // failed message
              $msg .= '<div class="alert alert-danger text-capitalize fw-bolder text-center">' . language('ADMIN PERMISSION IS NOT INSERTED PLEASE, TRY AGAIN OR CALL TECH SUPPORT!') . '</div>';
            }
          } else {
            // failed message
            $msg .= '<div class="alert alert-danger text-capitalize fw-bolder text-center">' . language('ADMIN IS NOT INSERTED PLEASE, TRY AGAIN OR CALL TECH SUPPORT!') . '</div>';
          }
        } else {
          // failed message
          $msg .= '<div class="alert alert-danger text-capitalize fw-bolder text-center">' . language('THIS USERNAME IS ALREADY EXIST') . '</div>';
        }
      } else {
        // failed message
        $msg .= '<div class="alert alert-danger text-capitalize fw-bolder text-center">' . language('LICENSE IS NOT INSERTED PLEASE, TRY AGAIN OR CALL TECH SUPPORT!') . '</div>';
      }
    } else {
      // failed message
      $msg .= '<div class="alert alert-danger text-capitalize fw-bolder text-center">' . language('COMPANY IS NOT INSERTED PLEASE, TRY AGAIN OR CALL TECH SUPPORT!') . '</div>';
    }
  } else {
    // success message
    $msg .= '<div class="alert alert-danger text-capitalize fw-bolder text-center">' . language('COMPANY NAME IS ALREADY EXIST!') . '</div>';
  }

  // success message
  $msg .= '<div class="alert alert-success text-capitalize fw-bolder text-center">' . language('YOU WILL BE AUTOMATICALLY REDIRECTED AFTER') . " 5 " . language('SECOND') . '</div>';
?>

  <!-- start edit profile page -->
  <div class="my-3 container">
    <!-- start header -->
    <header class="header">
      <?php 
      echo $msg; 
      header("refresh:5;url=$url");
      exit();
      ?>
    </header>
  </div>
<?php } else {
  // include permission error
  include_once $globmod . 'permisssion-error.php';
}?>

<?php include_once $tpl . "js-includes.php"; ?>

