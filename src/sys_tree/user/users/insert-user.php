<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  // GET EMPLOYEE GENERAL INFO
  // get full name
  $fullname = isset($_POST['fullname']) && !empty($_POST['fullname']) ? $_POST['fullname'] : '';
  // get username
  $username = isset($_POST['username']) && !empty($_POST['username']) ? $_POST['username'] : '';
  // get company id 
  $company_id = $_SESSION['company_id'];
  // get employee password
  $pass = isset($_POST['password']) && !empty($_POST['password']) ? $_POST['password'] : '';
  // get employee email
  $email = isset($_POST['email']) ? $_POST['email'] : '';
  // get employee job id
  $job_title_id = isset($_POST['job_title_id']) && !empty($_POST['job_title_id']) ? $_POST['job_title_id'] : '';
  // check if job title id == 2 then this is technical man
  $isTech = $job_title_id == 2 ? 1 : 0;
  // trust statu
  $trust_status = $job_title_id == 1 ? 1 : 0;
  // get employee gender
  $gender = isset($_POST['gender']) && !empty($_POST['gender']) ? $_POST['gender'] : '';
  // get employee address
  $address = isset($_POST['address']) ? $_POST['address'] : '';
  // get employee phone
  $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
  // get employee date of birth
  $date_of_birth = isset($_POST['date-of-birth']) && !empty($_POST['date-of-birth']) ? date_format(date_create($_POST['date-of-birth']), 'Y-m-d') : '';
  // get employee twitter account link
  $twitter = isset($_POST['twitter']) ? $_POST['twitter'] : '';
  // get employee facebook account link
  $facebook = isset($_POST['facebook']) ? $_POST['facebook'] : '';

  // get permissions
  $userAdd            = isset($_POST['userAdd'])            ? $_POST['userAdd']           : 0;
  $userUpdate         = isset($_POST['userUpdate'])         ? $_POST['userUpdate']        : 0;
  $userDelete         = isset($_POST['userDelete'])         ? $_POST['userDelete']        : 0;
  $userShow           = isset($_POST['userShow'])           ? $_POST['userShow']          : 0;
  $pcsAdd             = isset($_POST['pcsAdd'])             ? $_POST['pcsAdd']            : 0;
  $pcsUpdate          = isset($_POST['pcsUpdate'])          ? $_POST['pcsUpdate']         : 0;
  $pcsDelete          = isset($_POST['pcsDelete'])          ? $_POST['pcsDelete']         : 0;
  $pcsShow            = isset($_POST['pcsShow'])            ? $_POST['pcsShow']           : 0;
  $connectionAdd      = isset($_POST['connectionAdd'])      ? $_POST['connectionAdd']     : 0;
  $connectionUpdate   = isset($_POST['connectionUpdate'])   ? $_POST['connectionUpdate']  : 0;
  $connectionDelete   = isset($_POST['connectionDelete'])   ? $_POST['connectionDelete']  : 0;
  $connectionShow     = isset($_POST['connectionShow'])     ? $_POST['connectionShow']    : 0;
  $dirAdd             = isset($_POST['dirAdd'])             ? $_POST['dirAdd']            : 0;
  $dirUpdate          = isset($_POST['dirUpdate'])          ? $_POST['dirUpdate']         : 0;
  $dirDelete          = isset($_POST['dirDelete'])          ? $_POST['dirDelete']         : 0;
  $dirShow            = isset($_POST['dirShow'])            ? $_POST['dirShow']           : 0;
  $malAdd             = isset($_POST['malAdd'])             ? $_POST['malAdd']            : 0;
  $malUpdate          = isset($_POST['malUpdate'])          ? $_POST['malUpdate']         : 0;
  $malDelete          = isset($_POST['malDelete'])          ? $_POST['malDelete']         : 0;
  $malShow            = isset($_POST['malShow'])            ? $_POST['malShow']           : 0;
  $malReview          = isset($_POST['malReview'])          ? $_POST['malReview']         : 0;
  $malMediaDelete     = isset($_POST['malMediaDelete'])     ? $_POST['malMediaDelete']    : 0;
  $malMediaDownload   = isset($_POST['malMediaDownload'])   ? $_POST['malMediaDownload']  : 0;
  $combAdd            = isset($_POST['combAdd'])            ? $_POST['combAdd']           : 0;
  $combUpdate         = isset($_POST['combUpdate'])         ? $_POST['combUpdate']        : 0;
  $combDelete         = isset($_POST['combDelete'])         ? $_POST['combDelete']        : 0;
  $combShow           = isset($_POST['combShow'])           ? $_POST['combShow']          : 0;
  $combReview         = isset($_POST['combReview'])         ? $_POST['combReview']        : 0;
  $permissionUpdate   = isset($_POST['permissionUpdate'])   ? $_POST['permissionUpdate']  : 0;
  $permissionShow     = isset($_POST['permissionShow'])     ? $_POST['permissionShow']    : 0;
  $changeCompanyImg   = isset($_POST['changeCompanyImg'])   ? $_POST['changeCompanyImg']  : 0;
  // $suggReplay    = isset($_POST['suggReplay'])    ? $_POST['suggReplay']    : 0;
  // $suggDelete    = isset($_POST['suggDelete'])    ? $_POST['suggDelete']    : 0;
  // $suggShow      = isset($_POST['suggShow'])      ? $_POST['suggShow']      : 0;
  // $pointsAdd     = isset($_POST['pointsAdd'])     ? $_POST['pointsAdd']     : 0;
  // $pointsDelete  = isset($_POST['pointsDelete'])  ? $_POST['pointsDelete']  : 0;
  // $pointsShow    = isset($_POST['pointsShow'])    ? $_POST['pointsShow']    : 0;
  // $reportsShow   = isset($_POST['reportsShow'])   ? $_POST['reportsShow']   : 0;
  // $takeBackup    = isset($_POST['takeBackup'])    ? $_POST['takeBackup']    : 0;
  // $restoreBackup = isset($_POST['restoreBackup']) ? $_POST['restoreBackup'] : 0;
    
  // validate the form
  $formErorr = array();   // error array 

  // validate username
  if (strlen($username) < 0) {
    $formErorr[] = 'username cannot be less than 4 characters';
  }

  if (empty($username)) {
    $formErorr[] = 'username cannot be empty';
  }

  // validate fullname
  if (empty($fullname)) {
    $formErorr[] = 'full name cannot be empty';
  }

  // validate password
  if (empty($pass)) {
    $formErorr[] = 'password cannot be empty';
  } else {
    // encrypt password
    $hashedPass = sha1($pass);
  }

  $msg = "";
  
  // check if empty form error
  if (empty($formErorr)) {
    // create an object of User class
    $user_obj = new User();
    // check if user is exist in database or not
    $is_exist_user  = $user_obj->is_exist("`UserName`", "`users`", $username);
    // check the counter
    if ($is_exist_user == true) {
      // show erroe message
      $msg = '<div class="alert alert-warning text-capitalize"><i class="bi bi-exclamation-triangle-fill"></i>&nbsp;'. language('THIS USERNAME IS ALREADY EXIST', @$_SESSION['systemLang']) .'</div>';
    } else {
      // array of user info
      $user_info = array();
      // push user info into array
      array_push($user_info, $company_id, $username, $hashedPass, $email, $fullname, $isTech, $job_title_id, $gender, $address, $phone, $date_of_birth, $trust_status, $_SESSION['UserID'], get_date_now(), $twitter, $facebook);
      // call isert function
      $user_obj->insert_user_info($user_info);
      // get the new employee ID
      $new_emp_id = $user_obj->get_user_id($username);
      // array of user permissions
      $user_permissions = array();
      // push user`s permissions into array
      array_push($user_permissions, $new_emp_id, $userAdd, $userUpdate, $userDelete, $userShow, $malAdd, $malUpdate, $malDelete, $malShow, $malReview, $malMediaDelete, $malMediaDownload, $combAdd, $combUpdate, $combDelete, $combShow, $combReview, $pcsAdd, $pcsUpdate, $pcsDelete, $pcsShow, $dirAdd, $dirUpdate, $dirDelete, $dirShow, $connectionAdd, $connectionUpdate, $connectionDelete, $connectionShow, $permissionUpdate, $permissionShow, $changeCompanyImg);
      // call insert permissions function
      $user_obj->insert_user_permissions($user_permissions);
      
      // log message
      $log_msg = "Users dept:: A new user was added succefully!";
      createLogs($_SESSION['UserName'], $log_msg);

      // echo success message
      $msg = '<div class="alert alert-success text-capitalize"><i class="bi bi-check-circle-fill"></i>&nbsp;'.language('THE NEW EMPLOYEE HAS BEEN SUCCESSFULLY ADDED', @$_SESSION['systemLang']).'</div>';
    }
  } else { ?>
    <?php foreach ($formErorr as $error) {
      $msg .= '<div class="alert alert-danger text-capitalize w-50 mx-auto align-left">' . language(strtoupper($error), @$_SESSION['systemLang']) . '</div>';
    }
  } ?>

  <!-- start edit profile page -->
  <div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
    <!-- start header -->
    <header class="header">
      <?php redirectHome($msg, 'back') ?>
    </header>
  </div>
<?php } else {
    // include_once permission error module
    include_once $globmod . '/permission-error.php';
} ?>