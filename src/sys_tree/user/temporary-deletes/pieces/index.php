<?php

// check action
$action = isset($_GET['action']) && !empty($_GET['action']) ? trim($_GET['action'], ' ') : 'dashboard';

// choose file
switch ($action) {
  case 'dashboard':
    $subfile_name = 'dashboard.php';
    $page_subtitle = "deleted pieces";
    break;

  case 'restore':
    $subfile_name = 'restore.php';
    $page_subtitle = "restore pieces";
    break;

  default:
    $subfile_name = 'dashboard.php';
}


return $subfile_name;