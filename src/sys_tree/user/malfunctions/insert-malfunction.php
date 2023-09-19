<pre dir="ltr"><?php print_r($_POST) ?></pre>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // get piece info from the form
  $mng_id         = isset($_POST['admin-id']) ? base64_decode($_POST['admin-id']) : null;
  $tech_id        = isset($_POST['technical-id']) ? base64_decode($_POST['technical-id']) : null;
  $client_id      = isset($_POST['client-id']) ? $_POST['client-id'] : null;
  $descreption    = isset($_POST['descreption']) ?$_POST['descreption']:null;

  // validate the form
  $formErorr = array();   // error array 

  // validate manager id
  if (empty($mng_id) || $mng_id == null) {
    $formErorr[] = 'admin null';
  }
  // validate technical id
  if (empty($tech_id) || $tech_id == null) {
    $formErorr[] = 'tech null';
  }
  // validate client
  if (empty($client_id) || $client_id == null) {
    $formErorr[] = 'clt null';
  }
  // validate descreption
  if (empty($descreption) || $descreption == null) {
    $formErorr[] = 'desc null';
  }

  // check if empty form error
  if (empty($formErorr)) {
    // array of malfunction information
    $mal_info = array();
    // push info into the array
    array_push($mal_info, $mng_id, $tech_id, $client_id, $descreption, get_date_now(), get_time_now(), base64_decode($_SESSION['sys']['company_id']));
    
    // create an object of Malfunction class
    $mal_obj = !isset($mal_obj) ? new Malfunction() : $mal_obj;

    // call insert function
    $is_inserted = $mal_obj->insert_new_malfunction($mal_info);
    // check if malfunction was inserted or not
    if ($is_inserted) {
      // prepare flash session variables
      $_SESSION['flash_message'] = 'INSERTED';
      $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
      $_SESSION['flash_message_class'] = 'success';
      $_SESSION['flash_message_status'] = true;
      $_SESSION['flash_message_lang_file'] = 'malfunctions';
    } else {
      // prepare flash session variables
      $_SESSION['flash_message'] = 'QUERY PROBLEM';
      $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
      $_SESSION['flash_message_class'] = 'danger';
      $_SESSION['flash_message_status'] = false;
      $_SESSION['flash_message_status'] = 'global_';
    }
  } else {
    // assign post data to session
    $_SESSION['sys']['request_data'] = $_POST;
    // loop on errors
    foreach ($formErorr as $key => $error) {
      $_SESSION['flash_message'][$key] = strtoupper($error);
      $_SESSION['flash_message_icon'][$key] = 'bi-exclamation-triangle-fill';
      $_SESSION['flash_message_class'][$key] = 'danger';
      $_SESSION['flash_message_status'][$key] = false;
      $_SESSION['flash_message_status'][$key] = 'malfunctions';
    }
  }
  // redirect to the previous page
  redirect_home(null, 'back', 0);
} else {
  // include permission error module
  include_once $globmod . 'permission-error.php';
}
