<?php

/**
 * USERS PAGE
 */
// start output buffering
ob_start();
// start session
session_start();
// regenerate session id
session_regenerate_id();
// page title
$page_title = "reports";
// page category
$page_category = "sys_tree";
// page role
$page_role = "sys_tree_reports";
// folder name of dependendies
$dependencies_folder = "sys_tree/";
// laguage file
$lang_file = "reports";
// level
$level = 4;
// nav level
$nav_level = 1;
// app status and global includes
include_once str_repeat("../", $level) . "etc/app-status.php";

// check system if under developing or not
if ($is_developing == false) {
  // check username in SESSION variable
  if (isset($_SESSION['sys']['UserName']) && $_SESSION['sys']['isLicenseExpired'] == 0) {
    // check if Get request do is set or not
    $query = isset($_GET['do']) ? $_GET['do'] : 'manage';
    $preloader = true;
    $possible_back = true;

    if ($query == 'manage') {
      // flag for chart dependancies
      $is_contain_chart = true;
      $file_name = 'dashboard.php';
      
    } else {
      $file_name = $globmod . 'page-error.php';
      $preloader = false;
      $possible_back = false;
      $no_navbar = 'all';
      $no_footer = 'all';
    }
  } else {
    // include permission error module
    $file_name = $globmod . 'permission-error.php';
    $preloader = false;
    $possible_back = false;
    $no_navbar = 'all';
    $no_footer = 'all';
  }
} else {
  $file_name = $globmod . "under-developing.php";
}


// initial configration of system
include_once str_repeat("../", $level) . "etc/pre-conf.php";
// initial configration of system
include_once str_repeat("../", $level) . "etc/init.php";
// alerts of system
include_once str_repeat("../", $level) . "etc/system-alerts.php";

// include file name
include_once $file_name;

// include footer
include_once $tpl . "footer.php";
include_once $tpl . "js-includes.php";

ob_end_flush();