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
$no_header = true;
// no navbar
$no_navbar = true;
// page category
$page_category = "website";
// page title
$page_title = "";
// lang file
$lang_file = "";
// level
$level = 4;
// nav level
$nav_level = 1;
$possible_back = false;
// app status and global includes
include_once str_repeat("../", $level) . "etc/app-status.php";
// pre configration of system
include_once str_repeat('../', $level) . 'etc/pre-conf.php';
// initial configration of system
include_once str_repeat('../', $level) . 'etc/init.php';

// check if Get request do is set or not
$query = isset($_GET['do']) ? $_GET['do'] : '';

switch ($query) {
  case 'delete-detail':
    $file_name = 'delete-detail.php';
    break;
}

include_once $file_name;