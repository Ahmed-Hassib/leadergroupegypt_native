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
// page title
$page_title = "The malfunctions";
// page category
$page_category = "sys_tree";
// page role
$page_role = "sys_tree_user";
// folder name of dependendies
$dependencies_folder = "sys_tree/";
// level
$level = 4;
// nav level
$nav_level = 1;
// refere to that this page have tables
$is_contain_table = true;
// initial configration of system
include_once str_repeat("../", $level) . "etc/pre-conf.php";
// check username in SESSION variable
if (isset($_SESSION['UserName']) && $_SESSION['isLicenseExpired'] == 0) {
  // check if Get request do is set or not
  $query = isset($_GET['do']) ? $_GET['do'] : 'manage';
  
  switch($query) {
    // start manage page
    case "manage":       // manage page
      // include malfunction dashboard page
      $file_name = 'dashboard.php';
      break;

    case "showMalfunctionDetails":
      // include malfunction details page
      $file_name = 'malfunctions-details.php';
      break;

    case "addMalfunction":
      // include malfunction details page
      $file_name = 'add-malfunction.php';
      break;

    case "insertMalfunctions":     // edit piece page
      // include malfunction details page
      $file_name = 'insert-malfunction.php';
      break;

    case 'editMalfunction':
      // include malfunction details page
      $file_name = 'edit-malfunction.php';
      break;

    case 'updateMalfunction':
      // include malfunction details page
      $file_name = 'update-malfunction.php';
      break;

    case 'deleteMal':
      // include malfunction details page
      $file_name = 'delete-malfunction.php';
      break;

    case 'showPiecesMal':
      // include malfunction details page
      $file_name = 'piece-malfunctions.php';
      break;

    default:
      // include page error module
      $file_name = $globmod . 'page-error.php';
      break;
  }
  
} else {
  
  // include permission error module
  $file_name = $globmod . 'permission-error.php';
  
}

// initial configration of system
include_once str_repeat("../", $level) . "etc/init.php";
// include file name
include_once $file_name;

// include footer
include_once $tpl . "footer.php"; 
include_once $tpl . "js-includes.php";

ob_end_flush();
