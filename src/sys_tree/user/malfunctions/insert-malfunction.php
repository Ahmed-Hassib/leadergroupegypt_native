<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // get piece info from the form
  $mng_id         = $_POST['admin-id'];
  $tech_id        = $_POST['technical-id'];
  $client_id      = $_POST['client-id'];
  $descreption    = $_POST['descreption'];

  // validate the form
  $formErorr = array();   // error array 

  // validate manager id
  if (empty($mng_id)) {
    $formErorr[] = 'manager id cannot be empty';
  }
  // validate technical id
  if (empty($tech_id)) {
    $formErorr[] = 'technical id cannot be empty';
  }
  // validate username
  if (empty($client_id)) {
    $formErorr[] = 'client id cannot be empty';
  }

  // check if empty form error
  if (empty($formErorr)) {
    // array of malfunction information
    $mal_info = array();
    // push info into the array
    array_push($mal_info, $mng_id, $tech_id, $client_id, $descreption, get_date_now(), get_time_now(), $_SESSION['company_id']);
    
    if (!isset($mal_obj)) {
      // create an object of Malfunction class
      $mal_obj = new Malfunction();
    }
    // call insert function
    $is_inserted = $mal_obj->insert_new_malfunction($mal_info);
    // check if malfunction was inserted or not
    if ($is_inserted) {
      // prepare flash session variables
      $_SESSION['flash_message'] = 'MALFUNCTION WAS ADDED SUCCESSFULLY';
      $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
      $_SESSION['flash_message_class'] = 'success';
      $_SESSION['flash_message_status'] = true;
    } else {    
      // prepare flash session variables
      $_SESSION['flash_message'] = 'A PROBLEM WAS HAPPENED WHILE DELETING THE MALFUNCTION';
      $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
      $_SESSION['flash_message_class'] = 'danger';
      $_SESSION['flash_message_status'] = false;
    }
  } else {
    foreach ($formErorr as $key => $error) {
      $_SESSION['flash_message'][$key] = strtoupper($error);
      $_SESSION['flash_message_icon'][$key] = 'bi-exclamation-triangle-fill';
      $_SESSION['flash_message_class'][$key] = 'danger';
      $_SESSION['flash_message_status'][$key] = false;
    }
  }
  // redirect to the previous page
  redirect_home(null, 'back', 0);
} else {
  // include permission error module
  include_once $globmod . 'permission-error.php';
}

?>