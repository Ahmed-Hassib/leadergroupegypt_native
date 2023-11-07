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
$page_title = 'connection types';
// page category
$page_category = "sys_tree";
// page role
$page_role = "sys_tree_pieces";
// folder name of dependendies
$dependencies_folder = "sys_tree/";
// language file
$lang_file = 'pcs_conn';
// level
$level = 4;
// nav level
$nav_level = 1;
// app status and global includes
include_once str_repeat("../", $level) . "etc/app-status.php";

$possible_back = true;
$preloader = false;
$is_sorted = false;
$is_contain_table = false;

// check system if under developing or not
if ($is_developing == false) {
  // check username in SESSION variable
  if (isset($_SESSION['sys']['UserName']) && $_SESSION['sys']['isLicenseExpired'] == 0) {
    // check if Get request do is set or not
    $query = isset($_GET['do']) ? $_GET['do'] : 'manage';

    // start manage page
    if ($query == 'manage' && $_SESSION['sys']['connection_show'] == 1) {
      $file_name = 'dashboard.php';
      $preloader = true;
      $is_sorted = true;

    } elseif ($query == 'show-pieces-conn' && $_SESSION['sys']['connection_show'] == 1) {
      // get type of piece
      $type = isset($_GET['type']) && !empty($_GET['type']) ? $_GET['type'] : 0;
      // get type of piece
      $connid = isset($_GET['connid']) && !empty($_GET['connid']) ? $_GET['connid'] : 0;
      $file_name = 'show-pieces-conn.php';
      $is_contain_table = true;
      $preloader = true;
      $is_stored = true;

    } elseif ($query == 'insert-piece-conn-type' && $_SESSION['sys']['connection_add'] == 1) {
      $file_name = 'insert-conn-type.php';
      $possible_back = false;

    } elseif ($query == 'update-piece-conn-type' && $_SESSION['sys']['connection_update'] == 1) {
      $file_name = 'update-conn-type.php';
      $possible_back = false;

    } elseif ($query == 'delete-piece-conn-type' && $_SESSION['sys']['connection_delete'] == 1) {
      $file_name = 'delete-conn-type.php';
      $possible_back = false;

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

  // include ping modal
  include_once $globmod . 'ping-modal.php';
  // include confirmation delete modal
  include_once 'delete-conn-type-modal.php';
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