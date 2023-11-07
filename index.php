<?php
// start output buffering
ob_start();
// start session
session_start();
// regenerate session id
session_regenerate_id();
// get language from get method
$lang = isset($_GET['lang']) ? $_GET['lang'] : "ar";
// check language
$_SESSION['website']['lang'] = $lang;
// boolean variable to check if this page is home
$is_website_pages = true;
// page title
$page_title = "sponsor";
// page category
$page_category = "website";
// page role
$page_role = "website";
// folder name of dependendies
$dependencies_folder = "website/";
// lang file
$lang_file = 'index';
// allow preloader
$preloader = true;
// level
$level = 0;
// nav level
$nav_level = 0;
// app status and global includes
include_once str_repeat("../", $level) . "etc/app-status.php";

// get query param value
$query = isset($_GET['d']) && !empty($_GET['d']) ? base64_decode(trim($_GET['d'], "\n\r\t\v")) : null;
// check query if set
if ($query != null) {
  // no navbar
  $no_navbar = "all";
  $no_footer = "all";
  // check query value
  // if equal to 'end'
  if ($query === 'end') {
    // include end package module
    $file_name = $globmod . "end-package.php";
  } elseif ($query == 'deadline') {
    // include payment deadline module
    $file_name = $globmod . "deadline-payment.php";
  }
} else {
  // website files
  $file_name = [
    "landing" => [
      'file_name' => 'landing.php',
      'status' => true
    ],
    "artiicles" => [
      'file_name' => 'artiicles.php',
      'status' => false
    ],
    "about-us" => [
      'file_name' => 'about-us.php',
      'status' => true
    ],
    "gallery" => [
      'file_name' => 'gallery.php',
      'status' => true
    ],
    "features" => [
      'file_name' => 'features.php',
      'status' => true
    ],
    "services" => [
      'file_name' => 'services.php',
      'status' => true
    ],
    "team-members" => [
      'file_name' => 'team-members.php',
      'status' => true
    ],
    "testimonials" => [
      'file_name' => 'testimonials.php',
      'status' => false
    ],
    "map" => [
      'file_name' => 'map.php',
      'status' => true
    ],
  ];
}

// pre configration of system
include_once str_repeat("../", $level) . "etc/pre-conf.php";
// initial configration of system
include_once str_repeat("../", $level) . "etc/init.php";

// get type of file_name variable
$file_name_type = strtolower(gettype($file_name));
// check file name type
switch ($file_name_type) {
  case 'string':
    include_once $file_name;
    break;
    
  case 'array':
  default:
    // loop on file name array to include all modules
    foreach ($file_name as $key => $file) {
      // check status of file
      if ($file['status']) {
        include_once $website_user . "landing/" . $file['file_name'];
      }
    }
    break;
}

// include js files
include_once $tpl . "js-includes.php";

ob_end_flush();
?>