<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
  // get model id
  $model_id = isset($_POST['deleted-model-id']) && !empty($_POST['deleted-model-id']) ? base64_decode($_POST['deleted-model-id']) : '';
  // get back flag value
  $is_back = isset($_GET['back']) && !empty($_GET['back']) ? 'back' : null;

  // create an object of Model class
  $model_obj = !isset($model_obj) ? new Models() : $model_obj;
  // check if name exist or not
  $is_exist = $model_obj->is_exist("`model_id`", "`devices_model`", $model_id);
  // check if company is exist or not
  if (!empty($model_id) && $is_exist == true) {
    // call delete_model function
    $model_obj->delete_model($model_id);
    // prepare flash session variables
    $_SESSION['flash_message'] = 'MODEL DELETED';
    $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
    $_SESSION['flash_message_class'] = 'success';
    $_SESSION['flash_message_status'] = true;
    $_SESSION['flash_message_lang_file'] = 'pieces';
    // redirect to previous page
    redirect_home(null, "back", 0);
  } else {
    include_once $globmod . 'no-data-founded-no-redirect.php';
  }
} else {
  // include_once permission error module
  include_once $globmod . 'permission-error.php';
} ?>