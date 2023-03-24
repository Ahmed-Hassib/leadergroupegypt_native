<?php

/**
 * PIECES PAGE
 */
// start output buffering
ob_start();
// start session
session_start();
// regenerate session id
session_regenerate_id();
// page title
$page_title = "complaints & suggestions";
// level
$level = 5;
// nav level
$nav_level = 1;
// refere to that this page have tables
$is_contain_table = true;
// initial configration of system
include_once str_repeat("../", $level) . "etc/init.php";
// check username in SESSION variable
if (isset($_SESSION['UserName']) && $_SESSION['isLicenseExpired'] == 0) {
    // check if Get request do is set or not
    $query = isset($_GET['do']) ? $_GET['do'] : 'manage';
    // get type of the query
    $type = isset($_GET['type']) ? intval($_GET['type']) : -1;
    // condition
    $condition = $type != -1 ? " WHERE `type` = " . $type : "";
    // start manage page
    if ($query == "manage") {       // manage page
    
        // include comp & sugg dashboard page
        include_once 'dashboard.php';
        
    } elseif ($query == 'personalCompSugg') {

        // include personal comp & sugg page
        include_once 'personal-comp-sugg.php';
        
    } elseif ($query == 'showCompSugg' && $_SESSION['sugg_show'] == 1) { 
        
        // include show comp & sugg page
        include_once 'show-comp-sugg.php';
        
    } elseif ($query == 'deleteCompSugg' && $_SESSION['sugg_delete'] == 1) {
        
        // include delete comp & sugg page
        include_once 'delete-comp-sugg.php';
        
    } elseif ($query == 'activateSugg' && $_SESSION['sugg_replay'] == 1) {
        
        // include activate comp & sugg page
        include_once 'activate-comp-sugg.php';
        
    } elseif ($query == 'addNewComSugg') {
        
        // include add comp & sugg page
        include_once 'add-comp-sugg.php';
        
    } elseif ($query == "insertCompSugg") {
        
        // include insert comp & sugg page
        include_once 'insert-comp-sugg.php';
        
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
