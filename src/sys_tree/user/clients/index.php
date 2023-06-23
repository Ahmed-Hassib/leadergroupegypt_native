<?php
/**
 * clientS PAGE
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

$possible_back = true;

// check username in SESSION variable
if (isset($_SESSION['UserName']) && $_SESSION['isLicenseExpired'] == 0) {
  // check if Get request do is set or not
  $query = isset($_GET['do']) && !empty($_GET['do']) ? $_GET['do'] : 'manage';
  $preloader = true;

  // start manage page
  if ($query == 'manage' && $_SESSION['clients_show'] == 1){
    $file_name = 'dashboard.php';
    $is_contain_table = true;
    
  } elseif ($query == 'show-all-clients' && $_SESSION['clients_show'] == 1) {
    $file_name = 'show-all-clients.php';
    $is_contain_table = true;
    
  } elseif ($query == 'add-new-client' && $_SESSION['clients_add'] == 1) {
    $file_name = 'add-new-client.php';
    
  } elseif ($query == 'insert-client-info' && $_SESSION['clients_add'] == 1) {
    $file_name = 'insert-client-info.php';
    $preloader = false;
    $possible_back = false;
    
  } elseif ($query == 'edit-client' && ($_SESSION['clients_update'] == 1 || $_SESSION['clients_show'] == 1)) {
    $file_name = 'edit-client.php';
    
  } elseif ($query == 'update-client-info' && $_SESSION['clients_update'] == 1) {
    $file_name = 'update-client-info.php';
    $preloader = false;
    $possible_back = false;
    
  } elseif ($query == 'delete-client' && $_SESSION['clients_delete'] == 1) {
    $file_name = 'delete-client.php';
    $preloader = false;
    $possible_back = false;

  } elseif ($query == 'show-dir-clients' && $_SESSION['clients_show'] == 1) {
    $file_name = 'show-dir-clients.php';
    $is_contain_table = true;

  } else {
    $file_name = $globmod . 'page-permission-error.php';
    $possible_back = false;
    $preloader = false;
  }    
  
} else {
  $file_name = $globmod . 'permission-error.php';
  $possible_back = false;
  $preloader = false;
}

// page title
$page_title = 'clients';
// page category
$page_category = "sys_tree";
// page role
$page_role = "sys_tree_pieces";
// folder name of dependendies
$dependencies_folder = "sys_tree/";

// initial configration of system
include_once str_repeat("../", $level) . "etc/init.php";

// include file name
include_once $file_name;
// include confirmation delete modal
include_once 'delete-client-modal.php';

// include footer
include_once $tpl . "footer.php"; 
include_once $tpl . "js-includes.php";

ob_end_flush();
