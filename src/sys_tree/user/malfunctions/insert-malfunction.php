<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') { ?>
  <!-- start edit profile page -->
  <div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
    <!-- start header -->
    <header class="header">
    
    <?php
      // // print $_POST request variables
      // print_r($_POST);

      // get piece info from the form
      $mng_id         = $_POST['admin-id'];
      $tech_id        = $_POST['technical-id'];
      $client_id      = $_POST['client-id'];
      $descreption    = $_POST['descreption'];
    

      // validate the form
      $formErorr = array();   // error array 

      // validate manager id
      if (empty($mng_id)) {
        $formErorr[] = 'manager id cannot be <strong>empty</strong>';
      }
      // validate technical id
      if (empty($tech_id)) {
        $formErorr[] = 'technical id cannot be <strong>empty.</strong>';
      }
      // validate username
      if (empty($client_id)) {
        $formErorr[] = 'client id cannot be <strong>empty.</strong>';
      }

      // loop on form error array
      foreach ($formErorr as $error) {
        echo '<div class="alert alert-danger text-capitalize w-50 mx-auto align-left">' . $error . '</div>';
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
        $mal_obj->insert_new_malfunction($mal_info);

        // echo success message
        $msg = '<div class="alert alert-success text-capitalize"><i class="bi bi-check-circle-fill"></i>&nbsp;'. language('MALFUNCTION WAS ADDED SUCCESSFULLY', @$_SESSION['systemLang']) .'</div>';

        // redirect to add new user
        redirectHome($msg, 'back');
      } else {
        // include permission error module
        include_once $globmod . 'no-data-founded.php';
      ?>
    </header>
  </div>
<?php
  }
} else {
  // include permission error module
  include_once $globmod . 'permission-error.php';
}

?>