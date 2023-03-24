<!-- start edit profile page -->
<div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
    <!-- start header -->
    <header class="header">
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // get piece info from the form
            $adminID        = $_POST['admin-id'];
            $adminName      = $_POST['admin-name'];
            $techID         = $_POST['technical-id'];
            $clientName     = $_POST['client-name'];
            $clientPhone    = $_POST['client-phone'];
            $clientAddr     = $_POST['client-address'];
            $clientNotes    = $_POST['client-notes'];

            // validate the form
            $formErorr = array();   // error array 

            // validate client name
            if (empty($clientName)) {
                $formErorr[] = 'client name cannot be <strong>empty</strong>';
            }
            // validate technical id
            if (empty($clientPhone)) {
                $formErorr[] = 'client address cannot be <strong>empty.</strong>';
            }
            // validate username
            if (empty($clientAddr)) {
                $formErorr[] = 'client address cannot be <strong>empty.</strong>';
            }
            
            // loop on form error array
            foreach ($formErorr as $error) {
                echo '<div class="alert alert-danger text-capitalize w-50 mx-auto align-left">' . $error . '</div>';
            }

            // check if empty form error
            if (empty($formErorr)) {
                // create an empty array of comination info
                $comb_info = array();

                // create an object of Combination class
                $comb_obj = new Combination();

                // push info into the array
                $array_push($comb_info, $clientName, $clientPhone, $clientAddr, $clientNotes, $techID, $adminID, $_SESSION['company_id']);
                
                // call insert_new_combination function
                $is_inserted = $comb_obj->insert_new_combination($comb_info);

                // check if inserted
                if ($is_inserted == true) {
                    // log message
                    $logMsg = "Added a new combination -> added by: " . $adminName . ".";
                    // createLogs($_SESSION['UserName'], $logMsg);
    
                    // echo success message
                    $msg = '<div class="alert alert-success text-capitalize"><i class="bi bi-check-circle-fill"></i>&nbsp;'. language('COMBINATION WAS INSERTED SUCCESSFULLY', @$_SESSION['systemLang']) .'</div>';
                } else {
                    // echo success message
                    $msg = '<div class="alert alert-danger text-capitalize"><i class="bi bi-exclamation-triangle-fill"></i>&nbsp;'. language('A PROBLEM WAS HAPPENED WHILE INSERTING A THE COMBINATION', @$_SESSION['systemLang']) .'</div>';
                }


                // redirect to add new user
                redirectHome($msg, 'back');
            } else {
                // include missing data module
                include_once $globmod . '/data-error.php';
            }
        } else {
            // include permission error module
            include_once $globmod . '/permission-error.php';
        }

        ?>
    </header>
</div>