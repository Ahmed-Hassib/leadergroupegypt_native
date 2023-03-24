<?php

// start output buffering
ob_start();
// start session
session_start();
// regenerate session id
session_regenerate_id();
// title page
$page_title = "Dashboard";
// page category
$page_category = "sys_tree";
// page role
$page_role = "sys_tree";
// folder name of dependendies
$dependencies_folder = "sys_tree/";
// level
$level = 5;
// nav level
$nav_level = 1;
// initial configration of system
include_once str_repeat("../", $level) . "etc/init.php";
// check username in SESSION variable
if (isset($_SESSION['UserName'])) {
    // check the request
    $query = isset($_GET['do']) ? $_GET['do'] : 'manage';
    // check
    if ($query == 'manage') {
        // check the version
        include_once 'dashboard.php';
    } elseif ($query == 'version-info') {
        // check the version
        include_once 'version-info.php';
    }

    // footer
    include_once $tpl . "footer.php"; 
    include_once $tpl . "js-includes.php";
} else {
    header("Location: ../../logout.php");
    exit();
}

ob_end_flush();
?>