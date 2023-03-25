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

$is_stored = true;

// check username in SESSION variable
if (isset($_SESSION['UserName']) && $_SESSION['isLicenseExpired'] == 0) {
  // check if Get request do is set or not
  $query = isset($_GET['do']) ? $_GET['do'] : 'manage';
  $preloader = true;

  // start manage page
  if ($query == 'manage' && $_SESSION['pcs_show'] == 1){
    $file_name = 'dashboard.php';
    $is_contain_table = true;
    
  } elseif ($query == 'show-all-pieces' && $_SESSION['pcs_show'] == 1) {
    $file_name = 'show-all-pieces.php';
    $is_contain_table = true;
    
  } elseif ($query == 'show-all-clients' && $_SESSION['pcs_show'] == 1) {
    $file_name = 'show-all-clients.php';
    $is_contain_table = true;
    
  } elseif ($query == 'add-new-piece' && $_SESSION['pcs_add'] == 1) {
    $file_name = 'add-new-piece.php';
    
  } elseif ($query == 'insert-piece-info' && $_SESSION['pcs_add'] == 1) {
    $file_name = 'insert-piece-info.php';
    $preloader = false;
    $is_stored = false;
    
  } elseif ($query == 'edit-piece' && $_SESSION['pcs_update'] == 1) {
    $file_name = 'edit-piece.php';
    
  } elseif ($query == 'update-piece-info' && $_SESSION['pcs_update'] == 1) {
    $file_name = 'update-piece-info.php';
    $preloader = false;
    $is_stored = false;
    
  } elseif ($query == 'delete-piece' && $_SESSION['pcs_delete'] == 1) {
    $file_name = 'delete-piece.php';
    $preloader = false;
    $is_stored = false;
    
  } elseif ($query == 'show-piece' && $_SESSION['pcs_show'] == 1) {
    $file_name = 'show-piece.php';
    $is_contain_table = true;
    
  } elseif ($query == 'devices-companies' && $_SESSION['pcs_show'] == 1) {
    // cehck if action is set or not
    $action = isset($_GET['action']) & !empty($_GET['action']) ? $_GET['action'] : 'manage';
    $file_name = include_once 'devices-companies.php';
    
  } elseif ($query == 'show-connections-types' && $_SESSION['pcs_show'] == 1) {
    // cehck if action is set or not
    $action = isset($_GET['action']) & !empty($_GET['action']) ? $_GET['action'] : 'manage';
    $file_name = include_once 'pieces-connection-types.php';
    
  } else {
    $file_name = $globmod . 'page-error.php';
    $is_stored = false;
  }    
  
} else {
  $file_name = $globmod . 'permission-error.php';
  $is_stored = false;
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

// check if page able to store url or not
if ($is_stored == true) {
  $referer_url = $_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
  // referer url
  $_SESSION['HTTP_REFERER'] = $referer_url;
}

// include footer
include_once $tpl . "footer.php"; 
include_once $tpl . "js-includes.php";

ob_end_flush();
