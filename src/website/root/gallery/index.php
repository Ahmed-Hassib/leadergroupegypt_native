<?php
// start output buffering
ob_start();
// start session
session_start();
// regenerate session id
session_regenerate_id();
// title page
$page_title = "gallery";
// page category
$page_category = "website";
// page role
$page_role = "website_gallery";
// folder name of dependendies
$dependencies_folder = "website/";
// language file
$lang_file = "gallery";
// level
$level = 4;
// nav level
$nav_level = 1;
// app status and global includes
include_once str_repeat("../", $level) . "etc/app-status.php";
// check username in SESSION variable
if (isset($_SESSION['website']['username'])) {
  // check the request
  $query = isset($_GET['do']) ? $_GET['do'] : 'manage';
  $possible_back = true;
  $preloader = true;
  // check
  if ($query == 'manage') {
    // check the version
    $file_name = 'dashboard.php';
    $is_contain_table = true;
  } elseif ($query == 'add-new') {
    // add new img
    $file_name = 'add-new.php';
  } elseif ($query == 'insert-img') {
    // insert img
    $file_name = 'insert.php';
    $possible_back = false;
  } elseif ($query == 'activate-img') {
    // activate img
    $file_name = 'activate.php';
    $possible_back = false;
  } elseif ($query == 'deactivate-img') {
    // deactivate img
    $file_name = 'deactivate.php';
    $possible_back = false;
  } elseif ($query == 'delete-img') {
    // delete img
    $file_name = 'delete.php';
    $possible_back = false;
  } elseif ($query == 'edit-img') {
    // edit img
    $file_name = 'edit.php';
  } elseif ($query == 'update-img') {
    // update img
    $file_name = 'update.php';
    $possible_back = false;
  } elseif ($query == 'update-settings') {
    // update settings
    $file_name = 'update-settings.php';
    $possible_back = false;
  } else {
    $file_name = $globmod . 'page-error.php';
  }
  
  // pre configration of system
  include_once str_repeat("../", $level) . "etc/pre-conf.php";
  // initial configration of system
  include_once str_repeat("../", $level) . "etc/init.php";
  // include file name
  include_once $file_name;

  // footer
  include_once $tpl . "footer.php";
  include_once $tpl . "js-includes.php";
} else {
  header("Location: ../../logout.php");
  exit();
}

ob_end_flush();
