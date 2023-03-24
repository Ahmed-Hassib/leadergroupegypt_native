<?php

/**
 * DIRECTIONS PAGE
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
  // start manage page
  switch($query) {
    case 'manage':
      $file_name = 'dashboard.php';
      break;

    case'insert-new-direction':
      $file_name = 'insert-direction.php';
      break;

    case 'show-direction-tree':
      $file_name = 'show-direction.php';
      $no_footer = true;
      $preloader = true;
      break;

    case "update-direction-info":
      $file_name = 'update-direction.php';
      break;

    case "delete-direction":
      $file_name = 'delete-direction.php';
      break;

    default:
      $file_name = $globmod . 'page-error.php';
  }
} else {
  // include permission error page
  $file_name = $globmod . 'permission-error.php';
}

// page title
$page_title = "the directions";
// page category
$page_category = "sys_tree";
// page role
$page_role = "sys_tree_dir";
// folder name of dependendies
$dependencies_folder = "sys_tree/";
// initial configration of system
include_once str_repeat("../", $level) . "etc/init.php";
// include file name
include_once $file_name;

// check if contains no footer variables or not
if (!isset($no_footer)) {
  // include footer
  include_once $tpl . "footer.php"; 
}

include_once $tpl . "js-includes.php";
// 
ob_end_flush();
?>