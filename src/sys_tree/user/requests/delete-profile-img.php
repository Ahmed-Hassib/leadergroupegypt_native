<?php
// get user id to delete his profile image
$user_id = $_SESSION['UserID'];
// create an object of User class
$user_obj = new User();
// delete profile image from disk
unlink($uploads . "//employees-img/" . $_SESSION['company_id'] . "/" . $_SESSION['profile_img']);
// delete profile image
echo json_encode($user_obj->delete_profile_img($user_id));