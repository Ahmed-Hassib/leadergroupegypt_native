<?php
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

$possible_back = false;
$preloader = false;

// check username in SESSION variable
if (isset($_SESSION['UserName']))  {

  // start dashboard page
  // check if Get request do is set or not
  $query = isset($_GET['do']) ? $_GET['do'] : 'manage';
  
  // start manage page
  if ($query == 'manage') {
    // include dashboard
    $file_name = "dashboard.php";
    $possible_back = true;
    $is_stored = true;
    $preloader = true;

  } elseif ($query == "change-lang") {
    // include change-language file
    $file_name = "change-language.php";
  
  } elseif ($query == "change-company-img" && $_SESSION['change_company_img']) {
    // include change company file
    $file_name = "change-company-img.php";
  
  } elseif ($query == "others") {
    // include change other settings file
    $file_name = "change-others.php";

  } else {
    // include page not founded module
    $file_name = $globmod . 'page-error.php';
  }
} else { 
  // include permission error module
  $file_name = $globmod . 'permission-error';
}

// title page
$page_title = "Settings";
// page category
$page_category = "sys_tree";
// page role
$page_role = "sys_tree_settings";
// folder name of dependendies
$dependencies_folder = "sys_tree/";
// initial configration of system
include_once str_repeat("../", $level) . "etc/init.php";
// include file name
include_once $file_name;

include_once $tpl . "footer.php"; 
include_once $tpl . "js-includes.php";
ob_end_flush();
?>