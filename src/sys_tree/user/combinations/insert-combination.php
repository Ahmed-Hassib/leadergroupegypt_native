<?php
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // get piece info from the form
    $admin_id        = $_POST['admin-id'];
    $tech_id         = $_POST['technical-id'];
    $client_name     = $_POST['client-name'];
    $client_phone    = $_POST['client-phone'];
    $client_addr     = $_POST['client-address'];
    $client_notes    = $_POST['client-notes'];

    // validate the form
    $formErorr = array();   // error array 

    // validate client name
    if (empty($client_name)) {
      $formErorr[] = 'client name cannot be empty';
    }
    // validate technical id
    if (empty($client_phone)) {
      $formErorr[] = 'client address cannot be empty';
    }
    // validate username
    if (empty($client_addr)) {
      $formErorr[] = 'client address cannot be empty';
    }

    // check if empty form error
    if (empty($formErorr)) {
      // create an empty array of comination info
      $comb_info = array();

      if (!isset($comb_obj)) {
        // create an object of Combination
        $comb_obj = new Combination();
      }

      // push info into the array
      array_push($comb_info, $client_name, $client_phone, $client_addr, get_date_now(), get_time_now(), $client_notes, $tech_id, $admin_id, $_SESSION['company_id']);
      
      // call insert_new_combination function
      $is_inserted = $comb_obj->insert_new_combination($comb_info);

      // check if inserted
      if ($is_inserted == true) {
        // prepare flash session variables
        $_SESSION['flash_message'] = 'COMBINATION WAS INSERTED SUCCESSFULLY';
        $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
        $_SESSION['flash_message_class'] = 'success';
        $_SESSION['flash_message_status'] = true;
      } else {    
        // prepare flash session variables
        $_SESSION['flash_message'] = 'A PROBLEM WAS HAPPENED WHILE INSERTING A THE COMBINATION';
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
} else {
  // include permission error module
  include_once $globmod . 'permission-error.php';
}