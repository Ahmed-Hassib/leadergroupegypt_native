<?php
// start output buffering
ob_start();
// start session
session_start();
// regenerate session id
session_regenerate_id();
// get language from get method
$lang = isset($_GET['lang']) ? $_GET['lang'] : "ar";
// check language
$_SESSION['website']['lang'] = $lang;
// no footer flag
$no_footer = 'all';
// boolean variable to check if this page is home
$is_website_pages = true;
// page title
$page_title = "login";
// page category
$page_category = "website";
// page role
$page_role = "website_login";
// folder name of dependendies
$dependencies_folder = "website/";
// language file
$lang_file = 'login';
// level
$level = 2;
// nav level
$nav_level = 0;
// app status and global includes
include_once str_repeat("../", $level) . "etc/app-status.php";
// pre configration of system
include_once str_repeat("../", $level) . "etc/pre-conf.php";
// initial configration of system
include_once str_repeat("../", $level) . "etc/init.php";
// check username in SESSION variable
if (isset($_SESSION['website']['username'])) {
  if ($_SESSION['website']['is_root'] == 1) {
    // redirect to admin page
    header("Location: root/dashboard/index.php");
    exit();
  }
}
// request methos 
if (isset($_POST) && !empty($_POST)) {
  $file_name = 'process-login.php';
} else {
  $file_name = 'login-form.php';
}

// include file name
include_once "login/$file_name";
// include js files
include_once $tpl . "js-includes.php";
ob_end_flush();
