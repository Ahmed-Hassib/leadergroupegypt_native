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
// check username in SESSION variable
if (isset($_SESSION['UserName'])) {
  // check the request
  $query = isset($_GET['do']) ? $_GET['do'] : 'manage';
  $possible_back = true;
  $preloader = true;
  // check
  if ($query == 'manage') {
    // check the version
    $file_name = 'dashboard.php';

  } elseif ($query == 'version-info') {
    // check the version
    $file_name = 'version-info.php';
  } else {
    $file_name = $globmod . 'page-error.php';
  }

  // title page
  $page_title = "Dashboard";
  // page category
  $page_category = "sys_tree";
  // page role
  $page_role = "sys_tree_dash";
  // folder name of dependendies
  $dependencies_folder = "sys_tree/";

  // initial configration of system
  include_once str_repeat("../", $level) . "etc/init.php";
  // include file name
  include_once $file_name;

  // footer
  include_once $tpl . "footer.php"; 
  include_once $tpl . "js-includes.php";
} else {
  header("Location: ../../logout.php");
  exit();
}

ob_end_flush();
?>