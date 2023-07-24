<?php

// connect to database from configration file
// require_once 'server-conf.php';
require_once 'local-conf.php';
// developer name
$developerName = "ahmed hassib";
// sponsor company
$sponsorCompany = "leader group";
// company name
$appName = "sys tree";
// is app suspended
$isDeveloping = false;
// get user version of system
$curr_version = isset($_SESSION['curr_version_name']) ? $_SESSION['curr_version_name'] : "v1.0.3";

// include routes file
require_once "app-routes.php";
require_once "system-architecture.php";

// include_once the important files
include_once $func   . "functions.php";
include_once $lan    . "language.php";

// check if sys tree pages
if (isset($is_sys_tree_page) && $is_sys_tree_page == true) {
  // include mikrotic api
  include_once $func . "api.php";
}

