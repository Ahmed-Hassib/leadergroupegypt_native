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
$page_title = "pieces";
// page category
$page_category = "sys_tree";
// page role
$page_role = "sys_tree_pieces";
// folder name of dependendies
$dependencies_folder = "sys_tree/";
// language file
$lang_file = "pieces";
// level
$level = 4;
// nav level
$nav_level = 1;
// flag to determine if current page is sys tree page or not
$is_sys_tree_page = true;
// flag if page has a map
$having_map = false;
// app status and global includes
include_once str_repeat("../", $level) . "etc/app-status.php";

$possible_back = true;
// check system if under developing or not
if ($is_developing == false) {
  // check username in SESSION variable
  if (isset($_SESSION['sys']['UserName']) && $_SESSION['sys']['isLicenseExpired'] == 0) {
    // check if Get request do is set or not
    $query = isset($_GET['do']) && !empty($_GET['do']) ? $_GET['do'] : 'manage';
    $preloader = true;

    // start manage page
    if ($query == 'manage' && $_SESSION['sys']['pcs_show'] == 1) {
      $file_name = 'dashboard.php';
      $is_contain_table = true;
    } elseif ($query == 'show-all-pieces' && $_SESSION['sys']['pcs_show'] == 1) {
      $file_name = 'show-all-pieces.php';
      $is_contain_table = true;
    } elseif ($query == 'show-all-clients' && $_SESSION['sys']['pcs_show'] == 1) {
      $file_name = 'show-all-clients.php';
      $is_contain_table = true;
    } elseif ($query == 'add-new-piece' && $_SESSION['sys']['pcs_add'] == 1) {
      $file_name = 'add-new-piece.php';
      $having_map = true;
    } elseif ($query == 'insert-piece-info' && $_SESSION['sys']['pcs_add'] == 1) {
      $file_name = 'insert-piece-info.php';
      $preloader = false;
      $possible_back = false;
    } elseif ($query == 'edit-piece' && ($_SESSION['sys']['pcs_update'] == 1 || $_SESSION['sys']['pcs_show'] == 1)) {
      $file_name = 'edit-piece.php';
      $having_map = true;
    } elseif ($query == 'update-piece-info' && $_SESSION['sys']['pcs_update'] == 1) {
      $file_name = 'update-piece-info.php';
      $preloader = false;
      $possible_back = false;
    } elseif ($query == 'delete-piece' && $_SESSION['sys']['pcs_delete'] == 1) {
      $file_name = 'delete-piece.php';
      $preloader = false;
      $possible_back = false;
    } elseif ($query == 'show-piece' && $_SESSION['sys']['pcs_show'] == 1) {
      $file_name = 'show-piece.php';
      $is_contain_table = true;
    } elseif ($query == 'show-dir-pieces' && $_SESSION['sys']['pcs_show'] == 1) {
      $file_name = 'show-dir-pieces.php';
      $is_contain_table = true;
    } elseif ($query == 'devices-companies' && $_SESSION['sys']['pcs_show'] == 1) {
      // cehck if action is set or not
      $action = isset($_GET['action']) & !empty($_GET['action']) ? $_GET['action'] : 'manage';
      $file_name = include_once 'devices-companies.php';
    } elseif ($query == 'prepare-ip' && $_SESSION['sys']['pcs_show'] == 1) {
      $file_name = 'prepare-ip.php';
      $possible_back = false;
      $preloader = false;
    } else {
      $file_name = $globmod . 'page-error.php';
      $possible_back = false;
      $preloader = false;
      $no_navbar = 'all';
      $no_footer = 'all';
    }
  } else {
    $file_name = $globmod . 'permission-error.php';
    $possible_back = false;
    $preloader = false;
    $no_navbar = 'all';
    $no_footer = 'all';
  }

  
  // check delete permission
  if ($_SESSION['sys']['pcs_delete'] == 1) {
    // include confirmation delete modal
    include_once 'delete-piece-modal.php';
  }
  // include ping modal
  include_once $globmod . 'ping-modal.php';
} else {
  $file_name = $globmod . "under-developing.php";
}
// pre configration of system
include_once str_repeat("../", $level) . "etc/pre-conf.php";
// initial configration of system
include_once str_repeat("../", $level) . "etc/init.php";

// include file name
include_once $file_name;
// include footer
include_once $tpl . "footer.php";
include_once $tpl . "js-includes.php";

ob_end_flush();
