<?php
// create an object of TeamMember class
$member_obj = !isset($member_obj) ? new TeamMember() : $member_obj;
// is back flag
$is_back = isset($_GET['back']) ? 'back' : null;
// get member id
$member_id = isset($_GET['id']) && !empty($_GET['id']) ? base64_decode($_GET['id']) : null;

// check if member id exists or not
if ($member_obj->is_exist("`id`", "`team_members`", $member_id)) {
  // get img name
  $img_name = $member_obj->select_specific_column("`img`", "`team_member`", "WHERE `id` = $member_id")[0]['img'];
  // deactivate img
  $is_deleted = $member_obj->delete_member($member_id);
  // check if img exists
  if (file_exists($members_img . $img_name)) {
    // delete profile image from disk
    unlink($members_img . $img_name);
  }
  // check if img deactivated
  if ($is_deleted) {
    // prepare flash session variables
    $_SESSION['flash_message'] = 'DELETED';
    $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
    $_SESSION['flash_message_class'] = 'success';
    $_SESSION['flash_message_status'] = true;
    $_SESSION['flash_message_lang_file'] = $lang_file;
  } else {
    // prepare flash session variables
    $_SESSION['flash_message'] = 'QUERY PROBLEM';
    $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
    $_SESSION['flash_message_class'] = 'danger';
    $_SESSION['flash_message_status'] = false;
    $_SESSION['flash_message_lang_file'] = 'global_';
  }
  // redirect home
  redirect_home(null, $is_back, 0);
} else {
  // include no data founded module
  include_once $globmod . 'no-data-founded.php';
}
