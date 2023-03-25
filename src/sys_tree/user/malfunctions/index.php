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

// level
$level = 4;
// nav level
$nav_level = 1;
// initial configration of system
include_once str_repeat('../', $level) . 'etc/pre-conf.php';

$is_stored = true;

// check username in SESSION variable
if (isset($_SESSION['UserName']) && $_SESSION['isLicenseExpired'] == 0) {
  
  // check if Get request do is set or not
  $query = isset($_GET['do']) ? $_GET['do'] : 'manage';
  
  // start manage page
  if ($query == 'manage' && $_SESSION['mal_show'] == 1) {
    // include malfunction dashboard page
    $file_name = 'dashboard.php';
    // refere to that this page have tables
    $is_contain_table = true;
    
  } elseif ($query == 'show-malfunction-details' && $_SESSION['mal_show'] == 1) {
    // include malfunction details page
    $file_name = 'malfunctions-details.php';
    
  } elseif ($query == 'add-new-malfunction' && $_SESSION['mal_add'] == 1) {
    // include malfunction details page
    $file_name = 'add-malfunction.php';

  } elseif ($query == 'insert-new-malfunctions' && $_SESSION['mal_add'] == 1) {
    // include malfunction details page
    $file_name = 'insert-malfunction.php';
    $is_stored = false;
    
  } elseif ($query == 'edit-malfunction-info' && $_SESSION['mal_show'] == 1) {
    // include malfunction details page
    $file_name = 'edit-malfunction.php';
    
  } elseif ($query == 'update-malfunction-info' && $_SESSION['mal_update'] == 1) {
    // include malfunction details page
    $file_name = 'update-malfunction.php';
    $is_stored = false;
    
  } elseif ($query == 'delete-malfunction' && $_SESSION['mal_delete'] == 1) {
    // include malfunction details page
    $file_name = 'delete-malfunction.php';
    $is_stored = false;
    
  } elseif ($query == 'show-pieces-malfunctions' && $_SESSION['mal_show'] == 1) {
    // include malfunction details page
    $file_name = 'piece-malfunctions.php';
    
  } else {
    // include page error module
    $file_name = $globmod . 'page-error.php';
    $is_stored = false;
  }
} else {
  // include permission error module
  $file_name = $globmod . 'permission-error.php';
  $is_stored = false;
}

// page title
$page_title = 'The malfunctions';
// page category
$page_category = 'sys_tree';
// page role
$page_role = 'sys_tree_user';
// folder name of dependendies
$dependencies_folder = 'sys_tree/';

// initial configration of system
include_once str_repeat('../', $level) . 'etc/init.php';
// include file name
include_once $file_name;

// check if page able to store url or not
if ($is_stored == true) {
  $referer_url = $_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
  // referer url
  $_SESSION['HTTP_REFERER'] = $referer_url;
}

// include footer
include_once $tpl . 'footer.php'; 
include_once $tpl . 'js-includes.php';

ob_end_flush();
