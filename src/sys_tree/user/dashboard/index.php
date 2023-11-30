<?php

// start output buffering
ob_start();
// start session
session_start();
// regenerate session id
session_regenerate_id();
// title page
$page_title = "Dashboard";
// page category
$page_category = "sys_tree";
// page role
$page_role = "sys_tree_dash";
// folder name of dependendies
$dependencies_folder = "sys_tree/";
// language file
$lang_file = "dashboard";
// level
$level = 4;
// nav level
$nav_level = 1;
// app status and global includes
include_once str_repeat("../", $level) . "etc/app-status.php";

// check system if under developing or not
if ($is_developing == false) {
  // check username in SESSION variable
  if (isset($_SESSION['sys']['UserName'])) {
    // check if license was ended
    if ($_SESSION['sys']['isLicenseExpired'] == 0) {
      // check if app under developing
      // check the request
      $query = isset($_GET['do']) ? $_GET['do'] : 'manage';
      $possible_back = true;
      $preloader = true;
      // check
      if ($query == 'manage') {
        // check the version
        $file_name = 'dashboard.php';
      } elseif ($query == 'version-info') {
        // check the version
        $file_name = 'version-info.php';
      } else {
        $file_name = $globmod . 'page-error.php';
        $no_navbar = 'all';
        $no_footer = 'all';
      }
    } else {
      // license file
      $file_name = 'license-ended.php';
    }
  } else {
    header("Location: ../../logout.php");
    exit();
  }
} else {
  $file_name = $globmod . "under-developing.php";
}
// pre configration of system
include_once str_repeat("../", $level) . "etc/pre-conf.php";
// initial configration of system
include_once str_repeat("../", $level) . "etc/init.php";
// alerts of system
include_once str_repeat("../", $level) . "etc/system-alerts.php";
// include file name
include_once $file_name;
// footer
include_once $tpl . "footer.php";
include_once $tpl . "js-includes.php";

ob_end_flush();
