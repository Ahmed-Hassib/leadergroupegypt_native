<?php
// start output buffering
ob_start();
// start session
session_start();
// regenerate session id
session_regenerate_id();
// no navbar
$no_navbar = "all";
$no_footer = "all";
// title page
$page_title = "Login";
// page category
$page_category = "sys_tree";
// page role
$page_role = "sys_tree_login";
// folder name of dependendies
$dependencies_folder = "sys_tree/";
// language file
$lang_file = "login";
// level
$level = 2;
// nav level
$nav_level = 0;
// app status and global includes
include_once str_repeat("../", $level) . "etc/app-status.php";

// check if app is developing now or not
if ($is_developing == false) {
  // check username in SESSION variable
  if (isset($_SESSION['sys']['UserName'])) {
    if ($_SESSION['sys']['isRoot'] == 1) {
      // redirect to admin page
      header("Location: root/dashboard/index.php");
      exit();
    } else {
      // redirect to user page
      header("Location: user/dashboard/index.php");
      exit();
    }
  }

  // get query value if set
  $query = isset($_GET['d']) && !empty($_GET['d']) ? base64_decode(trim($_GET['d'], "\n\t\r\v\x00")) : null;

  // check query value 
  if ($query == null) {
    // check if user comming from http request ..
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)) {
      // include process login form
      $file_name = "process-login.php";
    } else {
      // if GET request isset get its values
      $username = isset($_GET['username']) && !empty($_GET['username']) ? $_GET['username'] : "";
      $password = isset($_GET['password']) && !empty($_GET['password']) ? $_GET['password'] : "";
      $company_code = isset($_GET['company-code']) && !empty($_GET['company-code']) ? $_GET['company-code'] : "";
      // login form
      $file_name = "login-form.php";
    }
  } elseif ($query == 'forget-password') {
    // forget password
    $file_name = "forget-password.php";
  } elseif ($query == 'reset-password') {
    // reset password
    $file_name = "reset-password.php";
  } elseif ($query == 'process-reset-password') {
    // reset password
    $file_name = "process-reset-password.php";
  }
  // include file
  $file_name = "login/$file_name";
} else {
  $file_name = $globmod . "under-developing.php";
}

// pre configration of system
include_once str_repeat("../", $level) . "etc/pre-conf.php";
// initial configration of system
include_once str_repeat("../", $level) . "etc/init.php";

// include file
include_once $file_name;

// include js files
include_once $tpl . "js-includes.php";