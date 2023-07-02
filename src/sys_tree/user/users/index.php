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
  $possible_back = true;
  
  if ($query == 'manage' && $_SESSION['user_show'] == 1) {
    $file_name = 'dashboard.php';
    
  } elseif ($query == 'add-new-user' && $_SESSION['user_add'] == 1) {
    $file_name = 'add-new-user.php';
    
  } elseif ($query == 'insert-user' && $_SESSION['user_add'] == 1) {
    $file_name = 'insert-user.php';
    $preloader = false;
    $possible_back = false;
    
  } elseif ($query == 'show-profile') {
    $file_name = 'show-profile.php';
    
  } elseif ($query == 'edit-user-info') {
    // check if Get request userid is numeric and get the integer value
    $user_id = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
    $file_name = 'edit-profile.php';
    if ($user_id != $_SESSION['UserID'] || $_SESSION['user_show'] != 1) {
      $preloader = false;
    }
    
  } elseif ($query == 'update-user-info') {
    $file_name = 'update-user.php';
    $preloader = false;
    $possible_back = false;
    
  } elseif ($query == 'delete-user-info' && $_SESSION['user_delete'] == 1) {
    $file_name = 'delete-user.php';
    $preloader = false;
    $possible_back = false;
    
  } else {
    $file_name = $globmod . 'page-error.php';
    $preloader = false;
    $possible_back = false;
  }
} else {
  // include permission error module
  $file_name = $globmod . 'permission-error.php';  
  $preloader = false;
  $possible_back = false;
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
