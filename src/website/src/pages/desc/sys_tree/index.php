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
@$_SESSION['systemLang'] = $lang;
// boolean variable to check if this page is home
$is_website_pages = true;
// page title
$page_title = "Leader Group Egypt";
// page category
$page_category = "website";
// page role
$page_role = "website_desc";
// folder name of dependendies
$dependencies_folder = "website/";
// level
$level = 6;
// nav level
$nav_level = 0;
// pre configration of system
include_once str_repeat("../", $level) . "etc/pre-conf.php";
// initial configration of system
include_once str_repeat("../", $level) . "etc/init.php";

// include landing section
include_once "contents/landing.php";
include_once "contents/abstract.php";

// include js files
include_once $tpl . "js-includes.php";

ob_end_flush();
?>