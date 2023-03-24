<?php 
$page_title = "new registration";
// no navbar
$noNavBar = "all";
// title page
$page_title = "new registration";
// page category
$page_category = "sys_tree";
// page role
$page_role = "sys_tree_signup";
// folder name of dependendies
$dependencies_folder = "sys_tree/";
// level
$level = 3;
// nav level
$nav_level = 1;
// initial configration of system
include_once str_repeat("../", $level) . "etc/pre-conf.php";
// initial configration of system
include_once str_repeat("../", $level) . "etc/init.php";
// check request method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // get next company id and next user id
  $company_id = $db_obj->get_next_id('companies');
  $user_id = $db_obj->get_next_id('users');
  
  // company info
  $company_name   = trim($_POST['company-name'], ' ');
  $company_alias  = trim($_POST['company-alias'], ' ');
  $manager_name   = trim($_POST['manager-name'], ' ');
  $manager_phone  = trim($_POST['manager-phone'], ' ');

  // admin of this company info
  $full_name    = trim($_POST['fullname'], ' ');
  $username     = trim($_POST['username'], ' ') . "@$company_alias";
  $password     = $_POST['password'];
  $enc_password = sha1($password);
  $gender       = $_POST['gender'];
  
  // empty message
  $msg = '';

  // check company name is exists
  $is_exist_company_name = $db_obj->is_exist("`company_name`", "`companies`", $company_name);
  
  if (!$is_exist_company_name) {
    // insertion query for company data
    $company_query = "INSERT INTO `companies`(`company_name`, `company_alias`, `company_manager`, `company_phone`, `version`, `joined_date`) VALUES (?, ?, ?, ?, 3, now())";
    $company_stmt = $con->prepare($company_query);
    $company_stmt->execute(array($company_name, $company_alias, $manager_name, $manager_phone));
    $is_inserted_company = $company_stmt->rowCount() > 0 ? true : false;

    // calculate expire date after one month
    // date of today
    $today = Date("Y-m-d");
    // license period
    $period = ' + 1months';
    // expire date
    $expire_date = Date("Y-m-d", strtotime($today. $period));

    // activate license with month trial
    $license_info_query = "INSERT INTO `license` (`company_id`, `type`, `start_date`, `expire_date`, `isTrial`) VALUES (?, 1, now(), ?, 1)";
    $license_info_stmt = $con->prepare($license_info_query);
    $license_info_stmt->execute(array($company_id, $expire_date));
    $is_inserted_license = $license_info_stmt->rowCount() > 0 ? true : false;

    // // check username
    $is_exist_admin_username = $db_obj->is_exist("`UserName`", "`users`", $username);
    
    if (!$is_exist_admin_username) {
      // insert admin info
      $admin_info_query = "INSERT INTO `users` (`company_id`, `UserName`, `Pass`, `Fullname`, `isTech`, `job_title_id`, `gender`, `TrustStatus`, `addedBy`,  `joinedDate`, `systemLang`) VALUES (?, ?, ?, ?, 0, 1, ?, 1, 1, now(), 0)";
      $admin_info_stmt = $con->prepare($admin_info_query);
      $admin_info_stmt->execute(array($company_id, $username, $enc_password, $full_name, $gender));
      $is_inserted_admin_info = $admin_info_stmt->rowCount() > 0 ? true : false;
      
      // insert admin info
      $admin_permissions_query = "INSERT INTO  `users_permissions`(`UserID`, `user_add`, `user_update`, `user_delete`, `user_show`, `mal_add`, `mal_update`, `mal_delete`, `mal_show`, `mal_review`, `comb_add`, `comb_update`, `comb_delete`, `comb_show`, `comb_review`, `pcs_add`, `pcs_update`, `pcs_delete`, `pcs_show`, `dir_add`, `dir_update`, `dir_delete`, `dir_show`, `sugg_replay`, `sugg_delete`, `sugg_show`, `points_add`, `points_delete`, `points_show`, `reports_show`, `archive_show`, `take_backup`, `restore_backup`) VALUES (?, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1)";
      $admin_permissions_stmt = $con->prepare($admin_permissions_query);
      $admin_permissions_stmt->execute(array($user_id));
      $is_inserted_admin_permission = $admin_permissions_stmt->rowCount() > 0 ? true : false;
    
    } else {
      // failed message
      $msg .= '<div class="alert alert-danger text-capitalize fw-bolder text-center">' . language('THIS USERNAME IS ALREADY EXIST') . '</div>';
    }

    // check if inserted company
    if ($is_inserted_company) {
      // echo success message
      $msg .= '<div class="alert alert-success text-capitalize fw-bolder text-center">' . language("YOUR COMPANY IS CREATED SUCCESSFULLY!") . '</div>';
    } else {
      // failed message
      $msg .= '<div class="alert alert-danger text-capitalize fw-bolder text-center">' . language('COMPANY IS NOT INSERTED PLEASE, TRY AGAIN OR CALL TECH SUPPORT!') . '</div>';
    }

    // check if inserted license
    if ($is_inserted_license) {
      // echo success message
      $msg .= '<div class="alert alert-success text-capitalize fw-bolder text-center">' . language("ONE MONTH FREE SUBSCRIPTION ACTIVATED SUCCESSFULLY!") . '</div>';
    } else {
      // failed message
      $msg .= '<div class="alert alert-danger text-capitalize fw-bolder text-center">' . language('LICENSE IS NOT INSERTED PLEASE, TRY AGAIN OR CALL TECH SUPPORT!') . '</div>';
    }

    // check if admin info is inserted
    if ($is_inserted_admin_info) {
      // success message
      $msg .= '<div class="alert alert-success text-capitalize fw-bolder text-center">' . language("YOUR ADMIN ACCOUNT IS CREATED SUCCESSFULLY!") . '</div>';
    } else {
      // failed message
      $msg .= '<div class="alert alert-danger text-capitalize fw-bolder text-center">' . language('ADMIN IS NOT INSERTED PLEASE, TRY AGAIN OR CALL TECH SUPPORT!') . '</div>';
    }


    // check if admin permisssion was inserted
    if ($is_inserted_admin_permission) {
      // success message
      $msg .= '<div class="alert alert-success text-capitalize fw-bolder text-center">' . language("YOUR ADMIN ACCOUNT PERMISSIONS IS CREATED SUCCESSFULLY!") . '</div>';
    } else {
      // failed message
      $msg .= '<div class="alert alert-danger text-capitalize fw-bolder text-center">' . language('ADMIN PERMISSION IS NOT INSERTED PLEASE, TRY AGAIN OR CALL TECH SUPPORT!') . '</div>';
    }
    
  } else {
    // success message
    $msg .= '<div class="alert alert-danger text-capitalize fw-bolder text-center">' . language('COMPANY NAME IS ALREADY EXIST!') . '</div>';
  }

  // check all insertion operation
  if ($is_inserted_company && $is_inserted_license && $is_inserted_admin_info && $is_inserted_admin_permission) {
    $header_content = "refresh: 3;url=../login.php?username=$username&password=$password";
  } else {
    $header_content = "refresh: 3;url=../signup.php";
  }

  // success message
  $msg .= '<div class="alert alert-success text-capitalize fw-bolder text-center">' . language('YOU WILL BE AUTOMATICALLY REDIRECTED AFTER') . " 3 " . language('SECOND') . '</div>';
?>

      <!-- start edit profile page -->
  <div class="container">
    <!-- start header -->
    <header class="header">
      <?php
        echo $msg;
        header($header_content);
      ?>
    </header>
  </div>
<?php } else {
  include $globmod . 'permission-error.php';
}
// include_once $tpl . "footer.php"; 
include_once $tpl . "js-includes.php";
?>