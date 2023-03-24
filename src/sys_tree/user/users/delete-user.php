<?php
// check if Get request userid is numeric and get the integer value
$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
// create an object of User class
$user_obj = new User();
// check if user is exist
$is_exist = $user_obj->is_exist("`UserID`", "`users`", $userid);
// if user exist
if ($is_exist == true) {
  // get user name
  $username = $user_obj->select_specific_column("`UserName`", "`users`", "WHERE `UserID` = " . $userid)[0]['UserName'];
  // call delete user function
  $user_obj->delete_user($userid);

  // log message
  $logMsg = "Users dept:: user deleted successfully.";
  createLogs($_SESSION['UserName'], $logMsg);

  // success message
  $msg  = '<div class="alert alert-success text-capitalize"><i class="bi bi-check-circle-fill"></i>&nbsp;'. language('AN USER WAS DELETED SUCCESSFULLY', @$_SESSION['systemLang']) .'</div>';
  ?>
  <!-- start edit profile page -->
  <div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
    <!-- start header -->
    <header class="header">
      <?php redirectHome($msg); ?>
    </header>
  </div>
<?php 
} else {
  // include_once no data founded module
  include_once $globmod .'no-data-founded.php';
}
?>