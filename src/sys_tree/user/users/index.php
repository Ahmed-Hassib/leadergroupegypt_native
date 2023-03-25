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
  $is_stored = true;
  
  if ($query == 'manage' && $_SESSION['user_show'] == 1) {
    $file_name = 'dashboard.php';
    
  } elseif ($query == 'add-new-user' && $_SESSION['user_add'] == 1) {
    $file_name = 'add-new-user.php';
    
  } elseif ($query == 'insert-user' && $_SESSION['user_add'] == 1) {
    $file_name = 'insert-user.php';
    $preloader = false;
    $is_stored = false;
    
  } elseif ($query == 'show-profile' && $_SESSION['user_show'] == 1) {
    $file_name = 'show-profile.php';
    
  } elseif ($query == 'edit-user-info' && $_SESSION['user_update'] == 1) {
    $file_name = 'edit-profile.php';
    
  } elseif ($query == 'update-user-info' && $_SESSION['user_update'] == 1) {
    $file_name = 'update-user.php';
    $preloader = false;
    $is_stored = false;
    
  } elseif ($query == 'delete-user-info' && $_SESSION['user_delete'] == 1) {
    $file_name = 'delete-user.php';
    $preloader = false;
    $is_stored = false;
    
  } else {
    $file_name = $globmod . 'page-error.php';
    $preloader = false;
    $is_stored = false;
  }
} else {
  // include permission error module
  $file_name = $globmod . 'permission-error.php';  
  $preloader = false;
  $is_stored = false;
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

// check if page able to store url or not
if ($is_stored == true) {
  $referer_url = $_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
  // referer
  $_SESSION['HTTP_REFERER'] = $referer_url;
}

// include footer
include_once $tpl . "footer.php"; 
include_once $tpl . "js-includes.php";

ob_end_flush();
