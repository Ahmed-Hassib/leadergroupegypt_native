<?php
// set the default timezone to use.
date_default_timezone_set('Africa/Cairo'); 
// start output buffering
ob_start();
// start session
session_start();
// regenerate session id
session_regenerate_id();

// no header
$noHeader = true;
// no navbar
$noNavBar = true;
// page title
$page_title = "";
// level
$level = 4;
// nav level
$nav_level = 1;
// initial configration of system
include_once str_repeat("../", $level) . "etc/init.php";

// check if Get request do is set or not
$query = isset($_GET['do']) ? $_GET['do'] : '';

global $con;

// check if the $_GET is set
if ($query == 'ping') {
  // get piece ip
  $ip = $_GET['ip'];
  // do ping command 
  $ping = getPing($ip);
  // convert the result into json format
  echo json_encode($ping);

} elseif ($query == 'get-source') {
  // get dir id
  $dirId = $_GET['dir-id'];
  // select all pieces in this dir
  $q = "SELECT `pieces`.`id`, `pieces`.`piece_ip`, `pieces`.`piece_name` FROM `pieces` WHERE `pieces`.`type_id` <> 4 AND `pieces`.`direction_id` = ? ORDER BY `pieces`.`direction_id` ASC, `pieces`.`id` ASC";
  // prepare the query
  $stmt = $con->prepare($q);
  $stmt->execute(array($dirId));      // execute query
  $rows = $stmt->fetchAll();          // fetch data
  // convert the result into json format
  echo json_encode($rows);

} elseif ($query == "search") {
  // get client name
  $clientName = $_GET['client-name'];
  // query statement
  $query = "SELECT `id`, `piece_name` FROM `pieces` WHERE `piece_name` LIKE :keysearch";
  // prepare statement
  $stmt = $con->prepare($query);
  $stmt->bindValue('keysearch', '%' . $clientName . '%');
  $stmt->execute();
  // get all rows
  $result = $stmt->fetchAll();
  // send the result as a json formate
  echo json_encode($result);

} elseif ($query == "changeLang") {
  // get user id
  $userid = isset($_POST['id']) ? intval($_POST['id']) : 0; 
  if (!isset($user_obj)) {
    // create an object of User class
    $user_obj = new User();
  }
  // check user if exist or not
  $check = $user_obj->is_exist("`UserID`", "`users`", $userid);
  // check
  if ($check == true) {
    // get language
    $lang = isset($_POST['language']) ? intval($_POST['language']) : 0;
    // call change_user_langugae
    $is_changed = $user_obj->change_user_language($lang, $userid);
    // check if language is changed
    if ($is_changed) {
      if (!isset($session_obj)) {
        // create an object of Session class
        $session_obj = new Session();
      }
      // get user info
      $user_details = $session_obj->get_user_info($userid);
      // check if exist
      if ($user_details[0] == true) {
        $session_obj->set_user_session($user_details[1]);
      }
    }
    // redirect to home page
    redirect_home("", 'back', 0);
  }


} elseif ($query == "getSuggComp") {
  // get sugg or comp id
  $id = intval($_GET['id']);
  // select it
  $query = "SELECT *FROM `comp_sugg` WHERE `id` = ?";
  $stmt = $con->prepare($query);
  $stmt->execute(array($id));
  $rows = $stmt->fetch();
  // return data
  echo json_encode($rows);

} elseif ($query == "updateSession") {
  // include update session file
  include_once 'update-session.php';

} else if ($query == "noti") {

  // select it
  $query = "SELECT COUNT(`mal_id`) FROM `malfunctions` WHERE `added_date` = CURRENT_DATE";
  $stmt = $con->prepare($query);
  $stmt->execute();
  $rows = $stmt->fetch();
  // return data
  echo json_encode($rows);

} else if ($query == "backup") {
  
  // get backup
  include_once $func . 'autobackup.php';

} else if ($query == "updateBackupInfo") {
  

} else if ($query == "versionControl") {
  // get theme id
  $version = isset($_POST['version']) && !empty($_POST['version']) ? $_POST['version'] : "v1.0.2";
  // 
  $curr_version = $version; 
  // redirect to previous page
  redirect_home("", "back", 0);
}