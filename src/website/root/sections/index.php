<?php
// start output buffering
ob_start();
// start session
session_start();
// regenerate session id
session_regenerate_id();
// title page
$page_title = "Dashboard";
// page category
$page_category = "website";
// page role
$page_role = "website_sections";
// folder name of dependendies
$dependencies_folder = "website/";
// language file
$lang_file = "sections";
// level
$level = 4;
// nav level
$nav_level = 1;
// app status and global includes
include_once str_repeat("../", $level) . "etc/app-status.php";
// check username in SESSION variable
if (isset($_SESSION['website']['username'])) {
  // check the request
  $query = isset($_GET['do']) ? $_GET['do'] : 'manage';
  $possible_back = true;
  $preloader = true;
  // check
  if ($query == 'manage') {
    // check the version
    $file_name = 'dashboard.php';
  } elseif ($query == 'all') {
    // all section
    $file_name = 'all.php';
    $is_contain_table = true;
  } elseif ($query == 'activate-section') {
    // activate section
    $file_name = 'activate.php';
    $possible_back = false;
    $preloader = false;
  } elseif ($query == 'deactivate-section') {
    // deactivate section
    $file_name = 'deactivate.php';
    $possible_back = false;
    $preloader = false;
  } else {
    $file_name = $globmod . 'page-error.php';
  }
  
  // pre configration of system
  include_once str_repeat("../", $level) . "etc/pre-conf.php";
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
