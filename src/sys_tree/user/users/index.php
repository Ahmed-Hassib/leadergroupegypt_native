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
$page_title = "employees";
// page category
$page_category = "sys_tree";
// page role
$page_role = "sys_tree_user";
// folder name of dependendies
$dependencies_folder = "sys_tree/";
// laguage file
$lang_file = "employees";
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

    if ($query == 'manage' && $_SESSION['sys']['user_show'] == 1) {
      $file_name = 'dashboard.php';
    } elseif ($query == 'add-new-user' && $_SESSION['sys']['user_add'] == 1) {
      $file_name = 'add-new-user.php';
    } elseif ($query == 'insert-user' && $_SESSION['sys']['user_add'] == 1) {
      $file_name = 'insert-user.php';
      $preloader = false;
      $possible_back = false;
    } elseif ($query == 'show-profile') {
      $file_name = 'show-profile.php';
    } elseif ($query == 'edit-user-info') {
      $file_name = 'edit-profile.php';
    } elseif ($query == 'update-user-info') {
      $file_name = 'update-user.php';
      $preloader = false;
      $possible_back = false;
    } elseif ($query == 'delete-user-info' && $_SESSION['sys']['user_delete'] == 1) {
      $file_name = 'delete-user.php';
      $preloader = false;
      $possible_back = false;
    } elseif ($query == 'activate-phone') {
      $file_name = 'activate-phone.php';
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