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
$page_title = "The companies";
// is admin == true
$is_admin = true;
// page category
$page_category = "sys_tree";
// page role
$page_role = "sys_tree_root";
// folder name of dependendies
$dependencies_folder = "sys_tree/";
// level
$level = 4;
// nav level
$nav_level = 1;
// 
$is_contain_table = true;
// initial configration of system
include_once str_repeat("../", $level) . "etc/init.php";
// check username in SESSION variable
if (isset($_SESSION['UserName']) && $_SESSION['isLicenseExpired'] == 0) {
    // check if Get request do is set or not
    $query = isset($_GET['do']) ? $_GET['do'] : 'manage';

    // FILTER_SANITIZE_STRING
    // start manage page
    if ($query == "manage") {       // manage page
        
        // include companies` dashboard page
        include_once 'dashboard.php';

    } elseif ($query == "companies-list") {
        
        // include companies list page
        include_once 'companies-list.php';
        
    } elseif ($query == "add-new-company") {

        // include renew license page
        include_once 'add-new-company.php';

    } elseif ($query == "edit-company") {

        // include renew license page
        include_once 'edit-company.php';
    
    } elseif ($query == "show-company-details") {

        // include renew license page
        include_once 'show-company-details.php';

    } elseif ($query == "renew-license") {
        
        // include renew license page
        include_once 'renew-license.php';

    } else {
        
        // include page error module
        include_once $globmod . "page-error.php";
        
    }
    
} else {
    
    // include permission error module
    include_once $globmod . "permission-error.php";
    
}

// include footer
include_once $tpl . "footer.php"; 
include_once $tpl . "js-includes.php";

ob_end_flush();
