<?php

/**
 * USERS PAGE
 */
// start output buffering
ob_start();
// start session
session_start();
// regenerate session id
session_regenerate_id();
// page title
$page_title = "companies";
// is admin == true
$is_admin = true;
// page category
$page_category = "sys_tree";
// page role
$page_role = "sys_tree_root_companies";
// folder name of dependendies
$dependencies_folder = "sys_tree/";
// language file
$lang_file = "companies_root";
// level
$level = 4;
// nav level
$nav_level = 1;
// flag for table dependancies
$is_contain_table = false;

// app status and global includes
include_once str_repeat("../", $level) . "etc/app-status.php";

// check username in SESSION variable
if (isset($_SESSION['sys']['UserName']) && $_SESSION['sys']['isLicenseExpired'] == 0) {
  // check if Get request do is set or not
  $query = isset($_GET['do']) && !empty($_GET['do']) ? $_GET['do'] : 'manage';

  // start manage page
  if ($query == "manage") {       // manage page
    $file_name = 'dashboard.php';

  } elseif ($query == "list") {
    $file_name = 'list.php';
    $is_contain_table = true;

  } elseif ($query == "add-new-company") {
    $file_name = 'add-new-company.php';

  } elseif ($query == "edit-company") {
    $file_name = 'edit-company.php';

  } elseif ($query == "show-company-details") {
    $file_name = 'show-company-details.php';

  } elseif ($query == "renew-license") {
    $file_name = 'renew-license.php';

  } else {
    // include page error module
    $file_name = $globmod . "page-error.php";
  }

} else {
  // include permission error module
  $file_name = $globmod . "permission-error.php";
}
// pre-configration of system
include_once str_repeat("../", $level) . "etc/pre-conf.php";
// initial configration of system
include_once str_repeat("../", $level) . "etc/init.php";

// include file name
include_once $file_name;

// include footer
include_once $tpl . "footer.php";
include_once $tpl . "js-includes.php";

ob_end_flush();
