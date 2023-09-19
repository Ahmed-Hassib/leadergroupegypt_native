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
// flag to determine if current page is sys tree page or not
$is_sys_tree_page = true;
// page title
$page_title = "directions";
// page category
$page_category = "sys_tree";
// page role
$page_role = "sys_tree_dir";
// folder name of dependendies
$dependencies_folder = "sys_tree/";
// language file
$lang_file = "directions";
// level
$level = 4;
// nav level
$nav_level = 1;
// app status and global includes
include_once str_repeat("../", $level) . "etc/app-status.php";

$possible_back = false;
$preloader = false;

// check system if under developing or not
if ($is_developing == false) {
  // check username in SESSION variable
  if (isset($_SESSION['sys']['UserName']) && $_SESSION['sys']['isLicenseExpired'] == 0) {
    // check if Get request do is set or not
    $query = isset($_GET['do']) ? $_GET['do'] : 'manage';

    if ($query == 'manage' && $_SESSION['sys']['dir_show'] == 1) {
      $file_name = 'dashboard.php';
      $possible_back = true;
    } elseif ($query == 'insert-new-direction' && $_SESSION['sys']['dir_add'] == 1) {
      $file_name = 'insert-direction.php';
    } elseif ($query == 'show-direction-tree' && $_SESSION['sys']['dir_show'] == 1) {
      $file_name = 'show-direction.php';
      $no_footer = true;
      $preloader = true;
      $possible_back = true;
    } elseif ($query == 'update-direction-info' && $_SESSION['sys']['dir_update'] == 1) {
      $file_name = 'update-direction.php';
    } elseif ($query == 'delete-direction' && $_SESSION['sys']['dir_delete'] == 1) {
      $file_name = 'delete-direction.php';
    } else {
      $file_name = $globmod . 'page-error.php';
      $no_navbar = 'all';
      $no_footer = 'all';
    }
  } else {
    // include permission error page
    $file_name = $globmod . 'permission-error.php';
    $no_navbar = 'all';
    $no_footer = 'all';
  }
  // pre configration of system
  include_once str_repeat('../', $level) . 'etc/pre-conf.php';
  // initial configration of system
  include_once str_repeat('../', $level) . 'etc/init.php';

  // include file name
  include_once $file_name;

  // check if contains no footer variables or not
  if (!isset($no_footer)) {
    // include footer
    include_once $tpl . 'footer.php';
  }
} else {
  include  $globmod . "under-developing.php";
}

include_once $tpl . 'js-includes.php';
// 
ob_end_flush();
