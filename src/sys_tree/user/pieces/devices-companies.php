<?php

$preloader = false;

// chekc action
switch($action) {
  case 'manage':
    // include pieces types dashboard
    $action_file = 'devices-companies/dashboard.php';
    $preloader = true;
    break;
    
  case 'insert-man-company':
    // include insert pieces types module
    $action_file = 'devices-companies/insert-man-company.php';
    break;

  case 'update-man-company':
    // include update pieces types module
    $action_file = 'devices-companies/update-man-company.php';
    break;

  case 'delete-man-company':
    // include delete pieces types module
    $action_file = 'devices-companies/delete-man-company.php';
    break;  
    
  case 'insert-device':
    // include delete pieces types module
    $action_file = 'devices-companies/insert-device.php';
    break;
    
  case 'show-devices':
    // get type of piece
    $company_id = isset($_GET['dev-company-id']) && !empty($_GET['dev-company-id']) ? $_GET['dev-company-id'] : 0;
    // check entered data
    if ($company_id == 0) {
      // data missing
      $action_file = $globmod . "no-data-founded-no-redirect.php";
    } else {
      // include sho pieces types module
      $action_file = 'devices-companies/show-devices-companies.php';
    }

    $preloader = true;
    break;
  
  case 'show-device':
    // get device id
    $device_id = isset($_GET['device-id']) && !empty($_GET['device-id']) ? $_GET['device-id'] : 0;
    // check entered data
    if ($device_id == 0) {
      // data missing
      $action_file = $globmod . "no-data-founded-no-redirect.php";
    } else {
      // include sho pieces types module
      $action_file = 'devices-companies/show-device.php';
    }

    $preloader = true;
    break;
    
  case 'update-device':
    // include sho pieces types module
    $action_file = 'devices-companies/update-device.php';
    break;
  
  case 'delete-device':
    // include sho pieces types module
    $action_file = 'devices-companies/delete-device.php';
    break;
  
  case 'insert-model':
    // include sho pieces types module
    $action_file = 'devices-companies/insert-model.php';
    break;
  
  case 'update-model':
    // include sho pieces types module
    $action_file = 'devices-companies/update-model.php';
    break;
  
  case 'delete-model':
    // include sho pieces types module
    $action_file = 'devices-companies/delete-model.php';
    break;

  default:
    // include page not founded module
    $action_file = $globmod . 'page-error.php';
}

// include action file 
return $action_file;
?>