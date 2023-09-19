<?php
// start output buffering
ob_start();
// start session
session_start();
// regenerate session id
session_regenerate_id();
// check username in SESSION variable
// title page
$page_title = "Archive";
// page category
$page_category = "sys_tree";
// page role
$page_role = "sys_tree_user";
// folder name of dependendies
$dependencies_folder = "sys_tree/";
// level
$level = 4;
// nav level
$nav_level = 1;
// refere to that this page have tables
$is_contain_table = true;
// initial configration of system
include_once str_repeat("../", $level) . "etc/init.php";

if (isset($_SESSION['sys']['UserName']) && $_SESSION['sys']['isLicenseExpired'] == 0 && $_SESSION['sys']['archive_show'] == 1) {
    
    // check if Get request do is set or not
    $query = isset($_GET['do']) && !empty($_GET['do']) ? $_GET['do'] : 'manage';
    
    // start dashboard page
    // start manage page
    if ($query == "manage") {       // manage page
    
        // include archive`s dashboard page
        include_once 'dashboard.php';
        
    } elseif ($query == "piecesArchive") {

        // include pieces archive page
        include_once 'pieces-archive.php';
        
    } elseif ($query == "malfunctionsArchive") {
    } elseif ($query == "combinationsArchive") {
    } else {
        
        // include page error module
        include_once $globmod . 'page-error.php';
        
    }
    
} else {
    
    // include permission error module
    include_once $globmod . 'permission-error.php';
    
}

// include footer
include_once $tpl . "footer.php"; 
include_once $tpl . "js-includes.php";

ob_end_flush();
