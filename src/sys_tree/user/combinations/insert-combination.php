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

      // create an object of Combination class
      $comb_obj = new Combination();

      // push info into the array
      array_push($comb_info, $client_name, $client_phone, $client_addr, $client_notes, $tech_id, $admin_id, $_SESSION['company_id']);
      
      // call insert_new_combination function
      $is_inserted = $comb_obj->insert_new_combination($comb_info);

      // check if inserted
      if ($is_inserted == true) {
        // echo success message
        $msg = '<div class="alert alert-success text-capitalize"><i class="bi bi-check-circle-fill"></i>&nbsp;'. language('COMBINATION WAS INSERTED SUCCESSFULLY', @$_SESSION['systemLang']) .'</div>';
      } else {
        // echo success message
        $msg = '<div class="alert alert-danger text-capitalize"><i class="bi bi-exclamation-triangle-fill"></i>&nbsp;'. language('A PROBLEM WAS HAPPENED WHILE INSERTING A THE COMBINATION', @$_SESSION['systemLang']) .'</div>';
      }
    ?>

    <!-- start edit profile page -->
    <div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
      <!-- start header -->
      <header class="header">
        <?php if (empty($formErorr)) {
          // redirect to add new user
          redirectHome($msg, 'back');
        } else {
          // loop on form error array
          foreach ($formErorr as $error) {
            echo '<div class="alert alert-danger text-capitalize w-50 mx-auto align-left">' . language(strtoupper($error), @$_SESSION['systemLang']) . '</div>';
          }
        }?>
      </header>
    </div>
    <?php
    } else {
      // include missing data module
      include_once $globmod . 'data-error.php';
    }
  } else {
    // include permission error module
    include_once $globmod . 'permission-error.php';
  }
?>