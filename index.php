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
// boolean variable to check if this page is home
$is_website_pages = true;
// page title
$page_title = "sponsor";
// page category
$page_category = "website";
// page role
$page_role = "website";
// folder name of dependendies
$dependencies_folder = "website/";
// lang file
$lang_file = 'index';
// allow preloader
$preloader = true;
// level
$level = 0;
// nav level
$nav_level = 0;
// app status and global includes
include_once str_repeat("../", $level) . "etc/app-status.php";

// pre configration of system
include_once str_repeat("../", $level) . "etc/pre-conf.php";
// initial configration of system
include_once str_repeat("../", $level) . "etc/init.php";

// include landing page content
include_once $website_user . "landing/landing.php";
// include_once $website_user . "landing/articles.php";
include_once $website_user . "landing/about-us.php";
include_once $website_user . "landing/gallery.php";
include_once $website_user . "landing/features.php";
include_once $website_user . "landing/services.php";
include_once $website_user . "landing/team-members.php";
include_once $website_user . "landing/testimonials.php";
include_once $website_user . "landing/map.php";


// include js files
include_once $tpl . "js-includes.php";

ob_end_flush();
?>