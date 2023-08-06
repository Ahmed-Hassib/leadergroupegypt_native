<?php
// start output buffering
ob_start();
// start session
session_start();
// regenerate session id
session_regenerate_id();
// get language from get method
$lang = isset($_GET['lang']) ? $_GET['lang'] : "ar";
// check language
@$_SESSION['systemLang'] = $lang;
// boolean variable to check if this page is home
$is_website_pages = true;
// page title
$page_title = "login";
// page category
$page_category = "website";
// page role
$page_role = "website_login";
// folder name of dependendies
$dependencies_folder = "website/";
// level
$level = 4;
// nav level
$nav_level = 0;
// initial configration of system
include_once str_repeat("../", $level) . "etc/init.php";
?>
<div class="loginPageContainer website-login">
    <div class="imgBox">
        <div class="hero-content">
            <img src="<?php echo $assets ?>images/login-2.svg" alt="" />
        </div>
    </div>
    <div class="contentBox">
        <div class="formBox">
            <div class="formBoxHeader">
                <h2 class="h2"><?php echo language('WEBSITE LOGIN') ?></h2>
            </div>
            <!-- login form -->
            <form class="login-form" id="login-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <div class="mb-4">
                    <label class="mb-2" for="username"><?php echo language('USERNAME') .' - '. language('EMAIL') ?></label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="<?php echo language('USERNAME') .' - '. language('EMAIL') ?>" value="<?php echo isset($_GET['username']) && isset($_GET['password']) ? $username : "" ?>" data-no-astrisk="true" required>
                </div>
                <div class="mb-4 position-relative login">
                    <label class="mb-2" for="password"><?php echo language('PASSWORD') ?></label>
                    <input type="password" class="form-control" id="password" name="pass" placeholder="<?php echo language('PASSWORD') ?>" value="<?php echo isset($_GET['username']) && isset($_GET['password']) ? $password : "" ?>" data-no-astrisk="true" required>
                    <i class="bi bi-eye-slash show-pass show-pass-left text-dark" id="show-pass" onclick="show_pass(this)"></i>
                </div>
                <div class="mb-2">
                    <button type="submit" class="btn btn-primary w-100 text-capitalize <?php # echo $_SESSION['loginErrorCounter'] > 3 ? 'disabled' : '' ?>" style="border-radius: 6px"><?php echo language('LOGIN') ?></button>
                </div>
                <div class="mb-1" dir="rtl">
                    <span><?php echo language("DON`T HAVE AN ACCOUNT?") ?>&nbsp;</span>
                    <a href="signup.php" class="text-capitalize <?php # echo $_SESSION['loginErrorCounter'] > 3 ? 'disabled' : '' ?>" style="border-radius: 6px"><?php echo language('SIGNUP') ?></a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
// include js files
include_once $tpl . "js-includes.php";
ob_end_flush();
?>