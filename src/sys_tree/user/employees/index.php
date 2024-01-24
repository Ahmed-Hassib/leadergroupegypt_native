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
$page_title = "the employees";
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
  if (isset($_SESSION['sys']['username'])) {
    // check if Get request do is set or not
    $query = isset($_GET['do']) ? $_GET['do'] : 'manage';
    $preloader = true;
    $possible_back = true;

    if ($query == 'manage' && $_SESSION['sys']['user_show'] == 1) {
      $file_name = 'dashboard.php';
      $page_subtitle = "list";
      
    } elseif ($query == 'add-new-user' && $_SESSION['sys']['user_add'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) {
      $file_name = 'add-new.php';
      $page_subtitle = "add new";
      
    } elseif ($query == 'insert-user' && $_SESSION['sys']['user_add'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) {
      $file_name = 'insert-user.php';
      $page_subtitle = "add new";
      $preloader = false;
      $possible_back = false;
      
    } elseif ($query == 'show-profile') {
      $file_name = 'show-profile.php';
      $page_subtitle = "profile";
      
    } elseif ($query == 'edit-user-info') {
      $file_name = 'edit-profile.php';
      $page_subtitle = "edit";
      
    } elseif ($query == 'update-user-info' && $_SESSION['sys']['isLicenseExpired'] == 0) {
      $file_name = 'update-user.php';
      $page_subtitle = "edit";
      $preloader = false;
      $possible_back = false;
      
    } elseif ($query == 'delete-user-info' && $_SESSION['sys']['user_delete'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) {
      $file_name = 'delete-user.php';
      $page_subtitle = "delete";
      $preloader = false;
      $possible_back = false;
      
    } elseif ($query == 'activate-phone') {
      $file_name = 'activate-phone.php';
      $page_subtitle = "activate phone";

    } else {
      $file_name = $globmod . 'page-permission-error.php';
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

// check if license was ended
if (isset($_SESSION['sys']['isLicenseExpired']) && $_SESSION['sys']['isLicenseExpired'] == 1 && !isset($no_navbar)) {
  // license file
  include_once $globmod . 'systree-license-ended.php';
}

// include file name
include_once $file_name;

// include footer
include_once $tpl . "footer.php";
include_once $tpl . "js-includes.php";

ob_end_flush();