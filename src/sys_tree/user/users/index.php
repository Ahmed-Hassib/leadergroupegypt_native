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
// level
$level = 4;
// nav level
$nav_level = 1;
// initial configration of system
include_once str_repeat("../", $level) . "etc/pre-conf.php";

// check username in SESSION variable
if (isset($_SESSION['UserName']) && $_SESSION['isLicenseExpired'] == 0) {
  // check if Get request do is set or not
  $query = isset($_GET['do']) ? $_GET['do'] : 'manage';
  $preloader = true;

  switch ($query) {
    case 'manage':
      $file_name = 'dashboard.php';
      break;
    
    case 'add-new-user':
      $file_name = 'add-new-user.php';
      break;
      
    case 'insert-user':
      $file_name = 'insert-user.php';
      $preloader = false;
      break;

    case 'show-profile':
      $file_name = 'show-profile.php';
      break;

    case 'edit-user-info':
      $file_name = 'edit-profile.php';
      break;

    case 'update-user-info':
      $file_name = 'update-user.php';
      $preloader = false;
      break;

    case 'delete-user-info':
      $file_name = 'delete-user.php';
      $preloader = false;
      break;
      
    default:
      $file_name = $globmod . 'page-error.php';
      $preloader = false;
      break;
  }
} else {
  // include permission error module
  $file_name = $globmod . 'permission-error.php';  
  $preloader = false;
}


// page title
$page_title = "The employees";
// page category
$page_category = "sys_tree";
// page role
$page_role = "sys_tree_user";
// folder name of dependendies
$dependencies_folder = "sys_tree/";
// initial configration of system
include_once str_repeat("../", $level) . "etc/init.php";

// include file name
include_once $file_name;

// include footer
include_once $tpl . "footer.php"; 
include_once $tpl . "js-includes.php";

ob_end_flush();
