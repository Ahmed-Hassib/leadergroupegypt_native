<?php

// connect to database from configration file
// require_once 'server-conf.php';
require_once 'local-conf.php';
// is app suspended
$is_developing = $db_obj->select_specific_column("`is_developing`", "`settings`", "LIMIT 1")[0]['is_developing'];

// check session
if ($page_category == 'sys_tree' && isset($_SESSION['sys'])) {
  // get user version of system
  $curr_version = isset($_SESSION['sys']['curr_version_name']) ? $_SESSION['sys']['curr_version_name'] : "v1.0.3";
  // check system language
  $page_dir = $_SESSION['sys']['lang'] == 'ar' ? 'rtl' : 'ltr';
} elseif ($page_category == 'website' && isset($_SESSION['website'])) {
  // check system language
  $page_dir = $_SESSION['website']['lang'] == 'ar' ? 'rtl' : 'ltr';
} else {
  // default
  $page_dir = 'rtl';
}

// include routes file
require_once "check-version.php";
require_once "app-routes.php";
require_once "system-architecture.php";

// include_once the important files
include_once $func . "functions.php";
include_once $lan . "lang.php";
