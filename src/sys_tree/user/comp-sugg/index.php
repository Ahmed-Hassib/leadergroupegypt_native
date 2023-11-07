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
$page_title = "complaints & suggestions";
// page category
$page_category = "sys_tree";
// page role
$page_role = "sys_tree_comp";
// folder name of dependendies
$dependencies_folder = "sys_tree/";
// level
$level = 4;
// nav level
$nav_level = 1;
// some page flages
$possible_back = true;
$preloader = true;
$is_contain_table = false;
// app status and global includes
include_once str_repeat("../", $level) . "etc/app-status.php";


// check system if under developing or not
if ($is_developing == false) {
  // check username in SESSION variable
  if (isset($_SESSION['sys']['UserName']) && $_SESSION['sys']['isLicenseExpired'] == 0) {
    // check if Get request do is set or not
    $query = isset($_GET['do']) ? $_GET['do'] : 'manage';
    // start manage page
    if ($query == "manage") {       // manage page
      // include comp & sugg dashboard page
      $file_name = 'dashboard.php';
    } elseif ($query == 'personal-comp-sugg') {
      // include personal comp & sugg page
      $file_name = 'personal-comp-sugg.php';
      $is_contain_table = true;
    } elseif ($query == 'add-comp-sugg') {
      // include add comp & sugg page
      $file_name = 'add-comp-sugg.php';
    } elseif ($query == "insert-comp-sugg") {
      // include insert comp & sugg page
      $file_name = 'insert-comp-sugg.php';
      $possible_back = false;
      $preloader = false;
    } elseif ($query == 'show-comp-sugg') {
      // include show comp & sugg page
      $file_name = 'show-comp-sugg.php';
      $is_contain_table = true;

      // } elseif ($query == 'delete-comp-sugg') {
      //   // include delete comp & sugg page
      //   $file_name = 'delete-comp-sugg.php';
      //   $possible_back = false;
      //   $preloader = false;
    } else {
      // include page error module
      $file_name = $globmod . 'page-error.php';
      $possible_back = false;
      $preloader = false;
      $no_navbar = 'all';
      $no_footer = 'all';
    }
  } else {
    // include permission error module
    $file_name = $globmod . 'permission-error.php';
    $possible_back = false;
    $preloader = false;
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

// include file name
include_once $file_name;

// include footer
include_once $tpl . "footer.php";
include_once $tpl . "js-includes.php";

ob_end_flush();
