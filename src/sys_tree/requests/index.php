<?php
// set the default timezone to use.
date_default_timezone_set('Africa/Cairo'); 
// start output buffering
ob_start();
// start session
session_start();
// regenerate session id
session_regenerate_id();

// no header
$noHeader = true;
// no navbar
$noNavBar = "any";
// page title
$page_title = "";
// level
$level = 3;
// nav level
$nav_level = 1;
// pre configration of system
include_once str_repeat("../", $level) . "etc/pre-conf.php";
// initial configration of system
include_once str_repeat("../", $level) . "etc/init.php";

// check if Get request do is set or not
$query = isset($_GET['do']) ? $_GET['do'] : '';

// global connection to database
global $con;

// if search for company name
if ($query == "search-company") {
  // include file
  include_once "search-company.php";

// if search for username
} elseif ($query == "search-username") {
  // include file
  include_once "search-username.php";

} elseif ($query == "update-expire") {
  // include file
  include_once "update-expire.php";

} elseif ($query == 'check-username') {
  // include file
  include_once "check-username.php";

} elseif ($query == 'check-company-name') {
  // include file
  include_once "check-company-name.php";

}