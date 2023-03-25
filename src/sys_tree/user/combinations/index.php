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
$page_title = "The combinations";
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
include_once str_repeat("../", $level) . "etc/init.php";
// check username in SESSION variable
if (isset($_SESSION['UserName']) && $_SESSION['isLicenseExpired'] == 0) {

  // check if Get request do is set or not
  $query = isset($_GET['do']) ? $_GET['do'] : 'manage';
  
  // start manage page
  if ($query == "manage" && $_SESSION['comb_show'] == 1) {       // manage page

    // include combination dashboard
    include_once 'dashboard.php';
    
  } elseif ($query == "showCombinationDetails" && $_SESSION['comb_show'] == 1) {

    // include combination details page
    include_once 'combinations-details.php';
    
  } elseif ($query == "addCombinations" && $_SESSION['comb_add'] == 1) {
    
    // include add combination page
    include_once 'add-combination.php';
    
  } elseif ($query == "insertCombination" && $_SESSION['comb_add'] == 1) {     // edit piece page
    
    // include isert combination page
    include_once 'insert-combination.php';
    
  } elseif ($query == 'editCombination' && $_SESSION['comb_show'] == 1) {
    
    // include edit combination page
    include_once 'edit-combination.php';
    
  } elseif ($query == 'updateCombination' && $_SESSION['comb_update'] == 1) {
    
    // include update combination page
    include_once 'update-combination.php';
    
  } elseif ($query == 'deleteComb' && $_SESSION['comb_delete'] == 1) {
    
    // include delete combination page
    include_once 'delete-combination.php';
    
  } else {
    
    // include page error module
    include_once $globmod . 'page-error.php';
    
  }
  
} else {
  
  // include permission error module
  include_once $globmod . 'permission-error.php';
  
}

// include footer
include_once $tpl . "footer.php"; 
include_once $tpl . "js-includes.php";

ob_end_flush();
