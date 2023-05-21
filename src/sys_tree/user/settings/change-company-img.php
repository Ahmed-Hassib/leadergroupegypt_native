<?php 
// check the request post
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // get company id
  $company_id = $_SESSION['company_id'];
  if (!isset($company_obj)) {
    // create an object of Company class
    $company_obj = new Company();
  }
  // get company image info
  $file_name        = $_FILES['company-img-input']['name'];
  $file_type        = $_FILES['company-img-input']['type'];
  $file_error       = $_FILES['company-img-input']['error'];
  $file_size        = $_FILES['company-img-input']['size'];
  $files_tmp_name   = $_FILES['company-img-input']['tmp_name'];

  // check if company image changed
  if ($file_error == 0 && $file_size > 0) {
    // company image path
    $path = $uploads . "//companies-img/$company_id/";
    // check path
    if (!file_exists($path)) {
      mkdir($path);
    }
    // media temp
    $media_temp = [];
    // check if not empty
    if (!empty($file_name)) {
      $media_temp = explode('.', $file_name);
      $media_temp[0] = date('dmY') .'_'. $company_id .'_'. rand(00000000, 99999999);
      $media_name = join('.',$media_temp);
      move_uploaded_file($files_tmp_name, $path.$media_name);

      // upload files info into database
      $is_changed = $company_obj->upload_company_img(array($media_name, $company_id));
    }

    if ($is_changed) {
      // echo success message
      $msg = '<div class="alert alert-success text-capitalize"><i class="bi bi-check-circle-fill"></i>&nbsp;'.language('COMPANY IMAGE WAS UPDATED SUCCESSFULLY', @$_SESSION['systemLang']).'</div>';
      // log message
      $logMsg = "company image was updated successfully by " . $_SESSION['UserName'] . " at " . date('D d/m/Y h:i a');
      if (!isset($session_obj)) {
        // create an object of Session class
        $session_obj = new Session();
      }
      // get user info
      $user_info = $session_obj->get_user_info($_SESSION['UserID']);
      // check if done
      if ($user_info[0] == true) {
        // set user session
        $session_obj->set_user_session($user_info[1]);
      }
    } else {
      // echo warning message
      $msg = '<div class="alert alert-warning text-capitalize"><i class="bi bi-exclamation-triangle-fill"></i>&nbsp;'.language('COMPANY IMAGE WAS NOT UPDATED', @$_SESSION['systemLang']).'</div>';
      // log message
      $logMsg = "company image was not updated because there is a problem while updating it";  
    }
  } else {
    // echo danger message
    $msg = '<div class="alert alert-danger text-capitalize"><i class="bi bi-check-circle-fill"></i>&nbsp;'.language('THERE IS NO IMAGES WAS ADDED TO CHANGE IT', @$_SESSION['systemLang']).'</div>';
    // log message
    $logMsg = "there is no images was added to update company image";  
  } 
  // create a log
  createLogs($_SESSION['UserName'], $logMsg);
  ?>
  <!-- start edit profile page -->
  <div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
    <!-- start header -->
    <header class="header">
      <?php redirectHome($msg, 'back'); ?>
    </header>
  </div>
<?php } else {
  // include_once per
  include_once $globmod . 'permission-error.php';
} ?>