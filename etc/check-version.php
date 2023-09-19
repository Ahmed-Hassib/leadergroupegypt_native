<?php
if (isset($_SESSION['sys']['UserID'])) {
  // create an object of Database class
  $db_obj = !isset($db_obj) ? new Database() : $db_obj;
  // check if the current version is up to date or not
  $latest_version = $db_obj->get_latest_records("*", "`versions`", "WHERE `is_working` = 1 AND `is_developing` = 0", "`v_id`", 1)[0];
  // check the count
  if (count($latest_version) > 0) {
    // get latest version id
    $latest_version_id = $latest_version['v_id'];
    $latest_version_name = $latest_version['v_name'];
    // check the value of latest version with the current version of the system
    if ($latest_version_id > $_SESSION['sys']['curr_version_id']) {
    }
  }
}
