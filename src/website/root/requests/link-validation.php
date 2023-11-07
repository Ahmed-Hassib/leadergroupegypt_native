<?php

// get type
$type = $_GET['type'];
// get link
$link = $_GET['link'];

switch ($type) {
  case 'facebook':
    $is_valid = facebook_validation($link);
    break;

  case 'instagram':
    $is_valid = instagram_validation($link);
    break;

  case 'twitter':
    $is_valid = twitter_validation($link);
    break;

  case 'linkedin':
    $is_valid = linkedin_validation($link);
    break;

  case 'youtube':
    $is_valid = youtube_validation($link);
    break;
  
  default:
  $is_valid = false;
    break;
}

echo json_encode($is_valid);