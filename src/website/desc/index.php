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
$_SESSION['lang'] = $lang;
// boolean variable to check if this page is home
$is_website_pages = true;
// page title
$page_title = "SPONSOR";
// page category
$page_category = "website";
// page role
$page_role = "website_desc";
// folder name of dependendies
$dependencies_folder = "website/";
// language file
$lang_file = "description";
// level
$level = 3;
// nav level
$nav_level = 1;
// pre configration of system
include_once str_repeat("../", $level) . "etc/pre-conf.php";
// initial configration of system
include_once str_repeat("../", $level) . "etc/init.php";

// get query value
$query = isset($_GET['do']) && !empty($_GET['do']) ? $_GET['do']: null;

// check query
if ($query == 'systree') {
  $file_name = 'abstract.php';
}

// include file name
include_once $file_name;

// include js files
include_once $tpl . "js-includes.php";

ob_end_flush();
?>