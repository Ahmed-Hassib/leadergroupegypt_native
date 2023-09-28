<?php
// create an object of Features class
$feature_obj = !isset($feature_obj) ? new Features() : $feature_obj;
// get detail id
$detail_id = isset($_GET['id']) && !empty($_GET['id']) ? base64_decode($_GET['id']) : null;

// check if detail id exists or not
if ($feature_obj->is_exist("`id`", "`feature_details`", $detail_id)) {
  // deactivate img
  $is_deleted = $feature_obj->delete_feature_detail($detail_id);  
} else {
  $is_deleted = false;
}
// return result
echo json_encode($is_deleted);