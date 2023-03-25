<?php 

$preloader = false;
$is_sorted = false;

switch($action){
  case 'manage':
    $action_file = 'pieces-conn-types/dashboard.php';
    $preloader = true;
    $is_sorted = true;
    break;
    
  case 'show-pieces-conn':
    // get type of piece
    $type = isset($_GET['type']) && !empty($_GET['type']) ? $_GET['type'] : 0;
    // get type of piece
    $connid = isset($_GET['connid']) && !empty($_GET['connid']) ? $_GET['connid'] : 0;
    $action_file = 'pieces-conn-types/show-pieces-conn.php';
    $is_contain_table = true;
    $preloader = true;
    $is_stored = true;
    break;
    
  case 'insert-piece-conn-type':
    $action_file = 'pieces-conn-types/insert-conn-type.php';
    break;
    
  case 'update-piece-conn-type':
    $action_file = 'pieces-conn-types/update-conn-type.php';
    break;

  case 'delete-piece-conn-type':
    $action_file = 'pieces-conn-types/delete-conn-type.php';
    break;

  default:
    $action_file = $globmod . 'page-error.php';
    break;
}

return $action_file;
?>