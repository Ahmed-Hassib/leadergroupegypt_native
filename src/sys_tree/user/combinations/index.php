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
// pre-configration of system
include_once str_repeat("../", $level) . "etc/pre-conf.php";

// some page flages
$possible_back = true;
$preloader = true;
$is_contain_table = false;
// refere to that this page have tables
$is_contain_table = false;

// check username in SESSION variable
if (isset($_SESSION['UserName']) && $_SESSION['isLicenseExpired'] == 0) {

  // check if Get request do is set or not
  $query = isset($_GET['do']) ? $_GET['do'] : 'manage';
  
  // start manage page
  if ($query == "manage" && $_SESSION['comb_show'] == 1) {       // manage page
    // include combination dashboard
    $file_name = 'dashboard.php';
    $is_contain_table = true;
    
  } elseif ($query == "show-combination-details" && $_SESSION['comb_show'] == 1) {
    // include combination details page
    $file_name = 'combinations-details.php';
    $is_contain_table = true;
    
  } elseif ($query == "add-new-combination" && $_SESSION['comb_add'] == 1) {
    // include add combination page
    $file_name = 'add-combination.php';
    
  } elseif ($query == "insert-combination-info" && $_SESSION['comb_add'] == 1) {     // edit piece page
    // include isert combination page
    $file_name = 'insert-combination.php';
    $possible_back = false;
    $preloader = false;
    
  } elseif ($query == 'edit-combination' && $_SESSION['comb_show'] == 1) {
    // include edit combination page
    $file_name = 'edit-combination.php';
    
  } elseif ($query == 'update-combination-info' && $_SESSION['comb_update'] == 1) {
    // include update combination page
    $file_name = 'update-combination.php';
    $possible_back = false;
    $preloader = false;
    
  } elseif ($query == 'delete-combination' && $_SESSION['comb_delete'] == 1) {
    // include delete combination page
    $file_name = 'delete-combination.php';
    $possible_back = false;
    $preloader = false;
    
  } else {
    // include page error module
    $file_name = $globmod . 'page-permission-error.php';
    $possible_back = false;
    $preloader = false;
  }
  
} else {
  // include permission error module
  $file_name = $globmod . 'permission-error.php';
  $possible_back = false;
  $preloader = false;
}


// page title
$page_title = "The combinations";
// page category
$page_category = "sys_tree";
// page role
$page_role = "sys_tree_combination";
// folder name of dependendies
$dependencies_folder = "sys_tree/";

// initial configration of system
include_once str_repeat('../', $level) . 'etc/init.php';
// include file name
include_once $file_name;

// include footer
include_once $tpl . "footer.php"; 
include_once $tpl . "js-includes.php";

ob_end_flush();
