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
$page_title = "The Blog";
// page category
$page_category = "blog";
// page role
$page_role = "blog";
// folder name of dependendies
$dependencies_folder = "blog/";
// level
$level = 3;
// nav level
$nav_level = 1;
// initial configration of system
include_once str_repeat("../", $level) . "etc/init.php";
// get url query
$query = isset($_GET['do']) && !empty($_GET['do']) ? $_GET['do'] : 'dashboard';
// check query
if ($query == 'dashboard') {
  // include dashboard page
  include_once "dashboard.php";

} elseif ($query == 'show-topics') {
  // include topics page
  include_once "topics.php";
  
} elseif ($query == 'show-articles') {
  // include articles page
  include_once "articles.php";

} elseif ($query == 'show-categories') {
  // include categories page
  include_once "categories.php";

} else {
  // include page not found
  include_once $blog_global . "page-not-found.php";
}


// include js files
include_once $tpl . "js-includes.php";

ob_end_flush();
?>