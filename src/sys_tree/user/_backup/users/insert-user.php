<!-- start edit profile page -->
<div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
    <!-- start header -->
    <header class="header">
        
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // get personal info from the form
            $fullname    = isset($_POST['fullname'])         && !empty($_POST['fullname'])       ? $_POST['fullname']    : '';
            $username    = isset($_POST['username'])         && !empty($_POST['username'])       ? $_POST['username']    : '';
            $companyid   = $_SESSION['company_id'];
            $pass        = isset($_POST['password'])         && !empty($_POST['password'])       ? $_POST['password']    : '';
            $email       = isset($_POST['email'])                                                ? $_POST['email']       : '';
            $isTech      = isset($_POST['isTech'])           && !empty($_POST['isTech'])         ? $_POST['isTech']      : '';
            $gender      = isset($_POST['gender'])           && !empty($_POST['gender'])         ? $_POST['gender']      : '';
            $address     = isset($_POST['address'])                                              ? $_POST['address']     : '';
            $phone       = isset($_POST['phone'])                                                ? $_POST['phone']       : '';
            $dateOfBirth = isset($_POST['date-of-birth']) && !empty($_POST['date-of-birth'])  ? date_format(date_create($_POST['date-of-birth']), 'Y-m-d') : '';
            $jobTitle    = isset($_POST['job-title'])                                            ? $_POST['job-title']    : '';
            $twitter     = isset($_POST['twitter'])                                              ? $_POST['twitter']     : '';
            $facebook    = isset($_POST['facebook'])                                             ? $_POST['facebook']    : '';

            // get permissions
            $userAdd       = isset($_POST['userAdd'])          ? $_POST['userAdd']         : 0;
            $userUpdate    = isset($_POST['userUpdate'])       ? $_POST['userUpdate']      : 0;
            $userDelete    = isset($_POST['userDelete'])       ? $_POST['userDelete']      : 0;
            $userShow      = isset($_POST['userShow'])         ? $_POST['userShow']        : 0;
            $pcsAdd        = isset($_POST['pcsAdd'])           ? $_POST['pcsAdd']          : 0;
            $pcsUpdate     = isset($_POST['pcsUpdate'])        ? $_POST['pcsUpdate']       : 0;
            $pcsDelete     = isset($_POST['pcsDelete'])        ? $_POST['pcsDelete']       : 0;
            $pcsShow       = isset($_POST['pcsShow'])          ? $_POST['pcsShow']         : 0;
            $dirAdd        = isset($_POST['dirAdd'])           ? $_POST['dirAdd']          : 0;
            $dirUpdate     = isset($_POST['dirUpdate'])        ? $_POST['dirUpdate']       : 0;
            $dirDelete     = isset($_POST['dirDelete'])        ? $_POST['dirDelete']       : 0;
            $dirShow       = isset($_POST['dirShow'])          ? $_POST['dirShow']         : 0;
            $malAdd        = isset($_POST['malAdd'])           ? $_POST['malAdd']          : 0;
            $malUpdate     = isset($_POST['malUpdate'])        ? $_POST['malUpdate']       : 0;
            $malDelete     = isset($_POST['malDelete'])        ? $_POST['malDelete']       : 0;
            $malShow       = isset($_POST['malShow'])          ? $_POST['malShow']         : 0;
            $combAdd       = isset($_POST['combAdd'])          ? $_POST['combAdd']         : 0;
            $combUpdate    = isset($_POST['combUpdate'])       ? $_POST['combUpdate']      : 0;
            $combDelete    = isset($_POST['combDelete'])       ? $_POST['combDelete']      : 0;
            $combShow      = isset($_POST['combShow'])         ? $_POST['combShow']        : 0;
            $suggReplay    = isset($_POST['suggReplay'])       ? $_POST['suggReplay']      : 0;
            $suggDelete    = isset($_POST['suggDelete'])       ? $_POST['suggDelete']      : 0;
            $suggShow      = isset($_POST['suggShow'])         ? $_POST['suggShow']        : 0;
            $pointsAdd     = isset($_POST['pointsAdd'])        ? $_POST['pointsAdd']       : 0;
            $pointsDelete  = isset($_POST['pointsDelete'])     ? $_POST['pointsDelete']    : 0;
            $pointsShow    = isset($_POST['pointsShow'])       ? $_POST['pointsShow']      : 0;
            $reportsShow   = isset($_POST['reportsShow'])      ? $_POST['reportsShow']     : 0;
            $takeBackup    = isset($_POST['takeBackup'])       ? $_POST['takeBackup']      : 0;
            $restoreBackup = isset($_POST['restoreBackup'])    ? $_POST['restoreBackup']   : 0;
            
            // validate the form
            $formErorr = array();   // error array 

            // validate username
            if (strlen($username) < 4) {
                $formErorr[] = 'username cannot be less than <strong>4 characters.</strong>';
            }

            if (empty($username)) {
                $formErorr[] = 'username cannot be <strong>empty.</strong>';
            }

            // validate fullname
            if (empty($fullname)) {
                $formErorr[] = 'full name cannot be <strong>empty.</strong>';
            }

            // validate email
            if (empty($email)) {
                $formErorr[] = 'email cannot be <strong>empty.</strong>';
            }

            // validate password
            if (empty($pass)) {
                $formErorr[] = 'password cannot be <strong>empty.</strong>';
            } else {
                // encrypt password
                $hashedPass = sha1($pass);
            }

            // loop on form error array
            foreach ($formErorr as $error) {
                echo '<div class="alert alert-danger text-capitalize w-50 mx-auto align-left">' . $error . '</div>';
            }

            // check if empty form error
            if (empty($formErorr)) {
                // create an object of User class
                $user_obj = new User();
                // check if user is exist in database or not
                $checkUser  = $user_obj->is_exist("`UserName`", "`users`", $username);
                // check the counter
                if ($checkUser == true) {
                    // show erroe message
                    $msg = '<div class="alert alert-warning text-capitalize"><i class="bi bi-exclamation-triangle-fill"></i>&nbsp;sorry this user is exist..</div>';
                    // redirect to add user page
                    redirectHome($msg, 'back');
                } else {
                    // array of user info
                    $user_info = array();
                    // push user info into array
                    array_push($user_info, $companyid, $username, $hashedPass, $email, $fullname, $isTech, $jobTitle, $gender, $address, $phone, $dateOfBirth, $_SESSION['UserID'], $twitter, $facebook);
                    // call isert function
                    $user_obj->insert_user_info($user_info);
                    // get the new employee ID
                    $newEmpID = $user_obj->get_user_id($username);
                    // array of user permissions
                    $user_permissions = array();
                    // push user`s permissions into array
                    array_push($user_permissions, $newEmpID, $userAdd, $userUpdate, $userDelete, $userShow, $malAdd, $malUpdate, $malDelete, $malShow, $combAdd, $combUpdate, $combDelete, $combShow, $pcsAdd, $pcsUpdate, $pcsDelete, $pcsShow, $dirAdd, $dirUpdate, $dirDelete, $dirShow, $suggReplay, $suggDelete, $suggShow, $pointsAdd, $pointsDelete, $pointsShow, $reportsShow, $takeBackup, $restoreBackup);
                    // call insert permissions function
                    $user_obj->insert_user_permissions($user_permissions);
                    
                    // log message
                    $logMsg = "Users dept:: A new user was added succefully!";
                    createLogs($_SESSION['UserName'], $logMsg);

                    // echo success message
                    $msg = '<div class="alert alert-success text-capitalize"><i class="bi bi-check-circle-fill"></i>&nbsp;'.language('THE NEW EMPLOYEE HAS BEEN SUCCESSFULLY ADDED', @$_SESSION['systemLang']).'</div>';

                    // redirect to add new user
                    redirectHome($msg, 'back');
                }
            } else { ?>
                <div class="my-3">
                    <a class="btn btn-outline-primary text-capitalize" href="?do=addUser">return</a>
                </div>
        <?php }
        } else {

            // include_once permission error module
            include_once $globmod . '/permission-error.php';

        } ?>
    </header>
</div>