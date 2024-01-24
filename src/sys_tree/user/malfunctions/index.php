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
$page_title = "the mals";
// page category
$page_category = "sys_tree";
// page role
$page_role = "sys_tree_malfunction";
// folder name of dependendies
$dependencies_folder = "sys_tree/";
// language file
$lang_file = "malfunctions";
// level
$level = 4;
// nav level
$nav_level = 1;
// app status and global includes
include_once str_repeat("../", $level) . "etc/app-status.php";

$possible_back = false;
$preloader = false;
$is_contain_table = false;

// check system if under developing or not
if ($is_developing == false) {
  // check username in SESSION variable
  if (isset($_SESSION['sys']['username'])) {
    // check if Get request do is set or not
    $query = isset($_GET['do']) ? $_GET['do'] : 'manage';

    // start manage page

    if ($query == 'manage' && $_SESSION['sys']['mal_show'] == 1) {
      // include malfunction dashboard page
      $file_name = 'dashboard.php';
      $page_subtitle = "dashboard";
      // refere to that this page have tables
      $is_contain_table = true;
      $possible_back = true;
      $preloader = true;
    } elseif ($query == 'show-malfunction-details' && $_SESSION['sys']['mal_show'] == 1) {
      // include malfunction details page
      $file_name = 'malfunctions-details.php';
      $page_subtitle = "mals details";
      $is_contain_table = true;
      $possible_back = true;
      $preloader = true;
    } elseif ($query == 'add-new-malfunction' && $_SESSION['sys']['mal_add'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) {
      // include malfunction details page
      $file_name = 'add-malfunction.php';
      $page_subtitle = "add new";
      $possible_back = true;
      $preloader = true;
    } elseif ($query == 'insert-new-malfunction' && $_SESSION['sys']['mal_add'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) {
      // include malfunction details page
      $file_name = 'insert-malfunction.php';
      $page_subtitle = "add new";
    } elseif ($query == 'edit-malfunction-info' && $_SESSION['sys']['mal_show'] == 1) {
      // include malfunction details page
      $file_name = 'edit-malfunction.php';
      $page_subtitle = "edit";
      $possible_back = true;
      $preloader = true;
    } elseif ($query == 'update-malfunction-info') {
      // include malfunction details page
      $file_name = 'update-malfunction.php';
      $page_subtitle = "edit";
    } elseif ($query == 'delete-malfunction' && $_SESSION['sys']['mal_delete'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) {
      // include malfunction details page
      $file_name = 'delete-malfunction.php';
      $page_subtitle = "delete mal";
    } elseif ($query == 'show-malfunctions' && $_SESSION['sys']['mal_show'] == 1) {
      // include malfunction details page
      $file_name = 'malfunctions.php';
      $page_subtitle = "mals details";
      $is_contain_table = true;
      $possible_back = true;
      $preloader = true;
    } else {
      // include page error module
      $file_name = $globmod . 'page-error.php';
      $no_navbar = 'all';
      $no_footer = 'all';
    }
  } else {
    // include permission error module
    $file_name = $globmod . 'permission-error.php';
    $no_navbar = 'all';
    $no_footer = 'all';
  }
} else {
  $file_name = $globmod . "under-developing.php";
}
// initial configration of system
include_once str_repeat('../', $level) . 'etc/pre-conf.php';
// initial configration of system
include_once str_repeat('../', $level) . 'etc/init.php';
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
include_once $tpl . 'footer.php';
include_once $tpl . 'js-includes.php';

ob_end_flush();
