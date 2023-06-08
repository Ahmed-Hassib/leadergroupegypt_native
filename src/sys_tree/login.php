<?php
// start output buffering
ob_start();
// start session
session_start();
// regenerate session id
session_regenerate_id();
// no navbar
$noNavBar = "all";
// title page
$page_title = "Login";
// page category
$page_category = "sys_tree";
// page role
$page_role = "sys_tree_login";
// folder name of dependendies
$dependencies_folder = "sys_tree/";
// level
$level = 2;
// nav level
$nav_level = 0;
// pre configration of system
include_once str_repeat("../", $level) . "etc/pre-conf.php";
// initial configration of system
include_once str_repeat("../", $level) . "etc/init.php";
// check username in SESSION variable
if (isset($_SESSION['UserName'])) {
  if ($_SESSION['isRoot'] == 1) {
    // redirect to admin page
    header("Location: root/dashboard/index.php");
    exit();
  } else {
    // redirect to user page
    header("Location: user/dashboard/index.php");  
    exit();
  }
} 
// check if user comming from http request ..
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)) {
  // get request info
  $username       = $_POST["username"];
  $pass           = $_POST["pass"];
  // $company_code   = $_POST["company-code"];
  $hashed_pass = sha1($pass);
  
  // columns to select
  $users_permission_columns = "`users_permissions`.`user_add`,`users_permissions`.`user_update`,`users_permissions`.`user_delete`,`users_permissions`.`user_show`,`users_permissions`.`mal_add`,`users_permissions`.`mal_update`,`users_permissions`.`mal_delete`,`users_permissions`.`mal_show`,`users_permissions`.`mal_review`,`users_permissions`.`mal_media_delete`,`users_permissions`.`mal_media_download`,`users_permissions`.`comb_add`,`users_permissions`.`comb_update`,`users_permissions`.`comb_delete`,`users_permissions`.`comb_show`,`users_permissions`.`comb_review`,`users_permissions`.`comb_media_delete`,`users_permissions`.`comb_media_download`,`users_permissions`.`pcs_add`,`users_permissions`.`pcs_update`,`users_permissions`.`pcs_delete`,`users_permissions`.`pcs_show`,`users_permissions`.`dir_add`,`users_permissions`.`dir_update`,`users_permissions`.`dir_delete`,`users_permissions`.`dir_show`,`users_permissions`.`sugg_replay`,`users_permissions`.`sugg_delete`,`users_permissions`.`sugg_show`,`users_permissions`.`points_add`,`users_permissions`.`points_delete`,`users_permissions`.`points_show`,`users_permissions`.`reports_show`,`users_permissions`.`archive_show`,`users_permissions`.`take_backup`,`users_permissions`.`restore_backup`,`users_permissions`.`connection_add`,`users_permissions`.`connection_update`,`users_permissions`.`connection_delete`,`users_permissions`.`connection_show`,`users_permissions`.`permission_update`,`users_permissions`.`permission_show`,`users_permissions`.`change_company_img`";
  // get company info
  $company_info_columns = "`companies`.`company_name`,`companies`.`company_code`,`companies`.`company_img`";
  // query select
  $query = "SELECT 
              `users`.*,
              $users_permission_columns,
              $company_info_columns
          FROM `users` 
          LEFT JOIN `users_permissions` ON `users`.`UserID` = `users_permissions`.`UserID`
          LEFT JOIN `companies` ON `companies`.`company_id` = `users`.`company_id`
          WHERE `users`.`UserName` = ? AND `users`.`Pass` = ? LIMIT 1";
          // WHERE `users`.`UserName` = ? AND `users`.`Pass` = ? AND `companies`.`company_code` = ? LIMIT 1";
          
  // check if user exist in database
  $stmt = $con->prepare($query);
  $stmt->execute(array($username, $hashed_pass));
  // $stmt->execute(array($username, $hashed_pass, $company_code));
  $userInfo = $stmt->fetch();
  $count = $stmt->rowCount();
  
  // if count > 0 this mean that user exist
  if ($count > 0) {
    if (!isset($session_obj)) {
      // create an object of Session class to set session
      $session_obj = new Session();
    }
    // set session
    $session_obj->set_user_session($userInfo);
    // check license expiration
    if (isset($_SESSION['isLicenseExpired']) && $_SESSION['isLicenseExpired'] == 1) {
      // query statement
      $query = "UPDATE `license` SET `isEnded`= 1 WHERE `ID` = ?";
      // prepare statement
      $stmt = $con->prepare($query);
      $stmt->execute(array($_SESSION['license_id']));
    }
    // set system language
    @$_SESSION['systemLang'] = $_POST['language'];
    $lang = $_POST['language'] == 'ar' ? 0 : 1;
    if (!isset($user_obj)) {
      // create an object of User class
      $user_obj = new User();
    }
    // call change_user_langugae
    $is_changed = $user_obj->change_user_language($lang, $_SESSION['UserID']);
    // reset login error variable
    $_SESSION['loginError'] = 0;
    // check logined user
    if ($_SESSION['isRoot'] == 1) {
      // redirect to admin page
      // header("Location: root/$curr_version/dashboard/index.php"); 
      header("Location: root/dashboard/index.php"); 
      exit();
    } else {
      // redirect to user page
      header("Location: user/dashboard/index.php");
      exit();
    }
  } else {
    $_SESSION['loginError'] = 1;
  }
}

// check if user comming from signup page..
if ($_SERVER['REQUEST_METHOD'] == 'GET' && !empty($_GET)) {
  // nwe username
  $username = isset($_GET['username']) && !empty($_GET['username']) ? $_GET['username'] : "";
  $password = isset($_GET['password']) && !empty($_GET['password']) ? $_GET['password'] : "";
  // $company_code = isset($_GET['company-code']) && !empty($_GET['company-code']) ? $_GET['company-code'] : "";
}
?>

<div class="loginPageContainer">
  <div class="imgBox">
    <div class="hero-content">
      <img src="<?php echo $assets ?>images/login-2.svg" alt="" />
      <!-- <img src="<?php echo $assets ?>leadergroupegypt-eid-said.jpg" alt="" /> -->
    </div>
  </div>
  <div class="contentBox" dir="rtl">
    <div class="formBox">
      <div class="formBoxHeader">
        <h2 class="h2"><?php echo language('LOGIN') ?></h2>
      </div>
      <!-- login form -->
      <form class="login-form" id="login-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <div class="mb-4">
          <input type="text" class="form-control" id="username" name="username" placeholder="<?php echo language('USERNAME') ?>" value="<?php echo isset($_GET['username']) && isset($_GET['password']) && isset($_GET['company-code']) ? $username : "" ?>" data-no-astrisk="true" required>
        </div>
        <div class="mb-4 position-relative login">
          <input type="password" class="form-control" id="password" name="pass" placeholder="<?php echo language('PASSWORD') ?>" value="<?php echo isset($_GET['username']) && isset($_GET['password']) && isset($_GET['company-code']) ? $password : "" ?>" data-no-astrisk="true" required>
          <i class="bi bi-eye-slash show-pass show-pass-left text-dark" id="show-pass" onclick="showPass(this)"></i>
        </div>
        <!-- <div class="mb-4 position-relative login">
          <input type="text" class="form-control" id="company-code-id" name="company-code" placeholder="<?php echo language('COMPANY CODE') ?>" value="<?php echo isset($_GET['username']) && isset($_GET['password']) && isset($_GET['company-code']) ? $company_code : "" ?>" data-no-astrisk="true" required>
        </div> -->
        <div class="mb-4 position-relative login">
          <select class="form-select" name="language" id="language">
            <option value="ar" selected><?php echo language('ARABIC') ?></option>
            <option value="en" disabled>
              <?php echo language('ENGLISH') . "&nbsp;&dash;&nbsp;" . language('UNDER DEVELOPING') ?></span>
            </option>
          </select>
        </div>
        <div class="mb-2">
          <button type="submit" class="btn btn-primary w-100 text-capitalize <?php # echo $_SESSION['loginErrorCounter'] > 3 ? 'disabled' : '' ?>" style="border-radius: 6px"><?php echo language('LOGIN') ?></button>
        </div>
        <div class="hstack gap-1 my-2" dir="rtl">
          <div>
            <span><?php echo language("DON`T HAVE AN ACCOUNT?") ?>&nbsp;</span>
            <a href="signup.php" class="text-capitalize <?php # echo $_SESSION['loginErrorCounter'] > 3 ? 'disabled' : '' ?>" style="border-radius: 6px"><?php echo language('SIGNUP') ?></a>
          </div>
          <div class="me-auto">
            <a href="<?php echo $website_pages_desc ?>sys_tree/index.php" class="text-capitalize" style="border-radius: 6px">
              <span><?php echo language("SYS TREE DESCRIPTION") ?>&nbsp;</span>
              <i class="bi bi-arrow-up-left-square"></i>
            </a>
          </div>
        </div>
        <div class="mb-4">
        <?php if (isset($_SESSION['loginError']) && $_SESSION['loginError'] == 1) { ?>
          <span class='text-danger text-capitalize'><?php echo language("SORRY, USERNAME OR PASSWORD IS WRONG PLEASE TRY LATER") ?></span>
        <?php } ?>
        </div>
      </form>
      <hr>

      <div class="row g-2">
        <div class="col-10">
          <a href="../../index.php" class="btn btn-outline-primary w-100"><?php echo language("LEADER GROUP EGYPT AR") ?></a>
        </div>
        <div class="col-2">
          <a href="https://www.facebook.com/LeaderGroupEGYPT" target="_blank" class="btn btn-outline-primary w-100 px-0"><i class="bi bi-facebook"></i></a>
        </div>
      </div>
    </div>
  </div>
</div>
<?php 
  include_once $tpl . "js-includes.php";
?>