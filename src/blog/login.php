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
@$_SESSION['blog']['lang'] = $lang;
// boolean variable to check if this page is home
$is_website_pages = true;
// page title
$page_title = "The Blog";
// page category
$page_category = "blog";
// page role
$page_role = "blog_login";
// folder name of dependendies
$dependencies_folder = "blog/";
// level
$level = 2;
// nav level
$nav_level = 1;
// initial configration of system
include_once str_repeat("../", $level) . "etc/init.php";

// include login file
include_once "global/login.php";

// include js files
include_once $tpl . "js-includes.php";

ob_end_flush();
?>