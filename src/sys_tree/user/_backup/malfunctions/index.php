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
$page_title = "The malfunctions";
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
    
    // start manage page
    if ($query == "manage" && $_SESSION['mal_show'] == 1) {       // manage page
        
        // include malfunction dashboard page
        include_once 'dashboard.php';
        
    } elseif ($query == "showMalfunctionDetails" && $_SESSION['mal_show'] == 1) {
        
        // include malfunction details page
        include_once 'malfunctions-details.php';
        
    } elseif ($query == "addMalfunction" && $_SESSION['mal_add'] == 1) {
        
        // include malfunction details page
        include_once 'add-malfunction.php';
        
    } elseif ($query == "insertMalfunctions" && $_SESSION['mal_add'] == 1) {     // edit piece page
        
        // include malfunction details page
        include_once 'insert-malfunction.php';
        
    } elseif ($query == 'editMalfunction' && $_SESSION['mal_show'] == 1) {
        
        // include malfunction details page
        include_once 'edit-malfunction.php';
        
    } elseif ($query == 'updateMalfunction' && $_SESSION['mal_update'] == 1) {
        
        // include malfunction details page
        include_once 'update-malfunction.php';
        
    } elseif ($query == 'deleteMal' && $_SESSION['mal_delete'] == 1) {
        
        // include malfunction details page
        include_once 'delete-malfunction.php';
        
    } elseif ($query == 'showPiecesMal' && $_SESSION['mal_show'] == 1) {
        
        // include malfunction details page
        include_once 'piece-malfunctions.php';

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
