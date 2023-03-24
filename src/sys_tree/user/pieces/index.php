<?php
/**
 * PIECES PAGE
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
// pre configration of system
include_once str_repeat("../", $level) . "etc/pre-conf.php";
// check username in SESSION variable
if (isset($_SESSION['UserName']) && $_SESSION['isLicenseExpired'] == 0) {
  // check if Get request do is set or not
  $query = isset($_GET['do']) ? $_GET['do'] : 'manage';
  $preloader = true;

  // start manage page
  switch ($query) {
    case 'manage':
      $file_name = 'dashboard.php';
      break;

    case 'show-all-pieces':
      $file_name = 'show-all-pieces.php';
      $is_contain_table = true;
      break;
      
    case 'show-all-clients':
      $file_name = 'show-all-clients.php';
      $is_contain_table = true;
      break;
  
    case 'add-new-piece':
      $file_name = 'add-new-piece.php';
      break;
  
    case 'insert-piece-info':
      $file_name = 'insert-piece-info.php';
      $preloader = false;
      break;
  
    case 'edit-piece':
      $file_name = 'edit-piece.php';
      break;
  
    case 'update-piece-info':
      $file_name = 'update-piece-info.php';
      $preloader = false;
      break;
  
    case 'delete-piece':
      $file_name = 'delete-piece.php';
      $preloader = false;
      break;
  
    case 'show-piece':
      $file_name = 'show-piece.php';
      $is_contain_table = true;
      break;

    case 'devices-companies':
      // cehck if action is set or not
      $action = isset($_GET['action']) & !empty($_GET['action']) ? $_GET['action'] : 'manage';
      $file_name = include_once 'devices-companies.php';
      break;

    case 'show-connections-types':
      // cehck if action is set or not
      $action = isset($_GET['action']) & !empty($_GET['action']) ? $_GET['action'] : 'manage';
      $file_name = include_once 'pieces-connection-types.php';
      break;

    default:    
      $file_name = $globmod . 'page-error.php';
  }
} else {
  $file_name = $globmod . 'permission-error.php';
}

// page title
$page_title = isset($_GET['name']) ? $_GET['name'] : 'NOT ASSIGNED';
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
