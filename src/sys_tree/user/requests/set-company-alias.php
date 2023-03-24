<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // empty message
  $msg = '';
  // get company alias
  $company_alias = $_POST['company-alias'];

  // update company alias
  $alias_query = "UPDATE `companies` SET `company_alias` = ? WHERE `company_id` = ?";
  $stmt = $con->prepare($alias_query);
  $stmt->execute(array($company_alias, $_SESSION['company_id']));
  $count = $stmt->rowCount() ;    // all count of data
  
  // success message
  $msg .= '<div class="alert alert-success text-capitalize"><i class="bi bi-check-circle-fill"></i>&nbsp;'.language('COMPANY ALIAS NAME WAS ADDED SUCCESSFULLY', @$_SESSION['systemLang']).'</div>';
  
  // create an object of User class
  $user_obj = new User();
  // get all users of this company
  $users = $user_obj->get_all_users($_SESSION['company_id'])[1];
  
  // loop on users
  foreach ($users as $key => $user_data) {
    // get user id
    $user_id = $user_data['UserID'];
    // get the new username with the new company alias
    $username = explode("@", $user_data['UserName'])[0] . "@$company_alias";
    // check user name if == current employee to update its username
    if ($user_id == $_SESSION['UserID']) {
      // update session
      $_SESSION['UserName'] = $username;
    }
    // update query
    $username_query = "UPDATE `users` SET `UserName` = ? WHERE `UserID` = ?";
    $username_stmt = $con->prepare($username_query);
    $username_stmt->execute(array($username, $user_id));
  }
  // success message
  $msg .= '<div class="alert alert-success text-capitalize"><i class="bi bi-check-circle-fill"></i>&nbsp;'.language('ALL EMPLOYEES` USERNAME WERE UPDATED SUCCESSFULLY', @$_SESSION['systemLang']).'</div>';

  // update company alias name in SESSION
  $_SESSION['company_alias'] = $company_alias;

?>

<!-- start edit profile page -->
  <div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
    <!-- start header -->
    <header class="header">
      <?php redirectHome($msg, 'back') ?>
    </header>
  </div>

<?php } else {
  // include permission error 
  include_once $globmod . "permission-error.php";
}
?>