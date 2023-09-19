<?php
// start output buffering
ob_start();
// start session
session_start();
// regenerate session id
session_regenerate_id();
// title page
$page_title = "gallery";
// page category
$page_category = "website";
// page role
$page_role = "website_gallery";
// folder name of dependendies
$dependencies_folder = "website/";
// language file
$lang_file = "gallery";
// level
$level = 4;
// nav level
$nav_level = 1;
// app status and global includes
include_once str_repeat("../", $level) . "etc/app-status.php";
// check the request
$query = isset($_GET['do']) ? $_GET['do'] : 'manage';
$possible_back = true;
$preloader = true;
// check
if ($query == 'manage') {
  // check the version
  $file_name = 'dashboard.php';
} else {
  $file_name = $globmod . 'page-error.php';
  $no_navbar = 'all';
  $no_footer = 'all';
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

ob_end_flush();