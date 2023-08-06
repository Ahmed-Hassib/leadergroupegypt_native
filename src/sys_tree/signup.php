
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
$page_title = "new registration";
// page category
$page_category = "sys_tree";
// page role
$page_role = "sys_tree_signup";
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
} else {
  @$_SESSION['systemLang'] = 'ar';
}
?>

<div class="signupPageContainer">
  <div class="contentBox" dir="rtl">
    <div class="formBox">
      <div class="formBoxHeader">
        <h2 class="h2"><?php echo language('NEW REGISTRATION') ?></h2>
      </div>
      <!-- login form -->
      <form class="signup-form needs-validation" id="signup-form" action="requests/registration.php" method="POST">
        <!-- first row that contain company info -->
        <div class="row row-cols-sm-1">
          <div class="section-header">
            <h4 class="h4"><?php echo language("COMPANY INFO", @$_SESSION['systemLang']) ?></h4>
          </div>
          <div class="row row-cols-sm-1 row-cols-lg-2 g-2">
            <!-- company name -->
            <div class="mb-sm-2 mb-md-3 row">
              <label for="company-name" class="col-sm-12 col-form-label text-capitalize"><?php echo language("COMPANY NAME", @$_SESSION['systemLang']) ?></label>
              <div class="col-sm-12 position-relative">
                <input class="form-control w-100" type="text" name="company-name" id="company-name" placeholder="<?php echo language("COMPANY NAME", @$_SESSION['systemLang']) ?>" onblur="is_valid(this, 'company');" required>
              </div>
            </div>
            <?php
            // flag for check if code is exist or not
            $is_exist_code = false;
            // check if db_obj is created or ot
            if (!isset($db_obj)) {
              // if not created create it
              $db_obj = new Database();
            }
            // loop to generate a code that is not exist in database
            do {
              // generate a code
              // first 4 character -> string
              //  second 4 character -> numbers
              $company_code = generate_random_string(2).random_digits(2);
              // count companies that have same code
              $is_exist_code = $db_obj->is_exist("`company_code`", "`companies`", $company_code);
            } while($is_exist_code);
            ?>
            <!-- company code -->
            <div class="mb-sm-2 mb-md-3 row">
              <label for="company-code" class="col-sm-12 col-form-label text-capitalize"><?php echo language("COMPANY CODE", @$_SESSION['systemLang']) ?></label>
              <div class="col-sm-12 position-relative">
                <input class="form-control w-100" type="text" name="company-code" id="company-code-id" value="<?php echo $company_code; ?>" placeholder="<?php echo language("COMPANY CODE", @$_SESSION['systemLang']) ?>" readonly>
              </div>
            </div>
            <!-- manager name -->
            <div class="mb-sm-2 mb-md-3 row">
              <label for="manager-name" class="col-sm-12 col-form-label text-capitalize"><?php echo language("MANAGER NAME", @$_SESSION['systemLang']) ?></label>
              <div class="col-sm-12 position-relative">
                <input class="form-control w-100" type="text" name="manager-name" id="manager-name" placeholder="<?php echo language("MANAGER NAME", @$_SESSION['systemLang']) ?>" required>
              </div>
            </div>
            <!-- company country -->
            <div class="mb-sm-2 mb-md-3 row">
              <label for="country" class="col-sm-12 col-form-label text-capitalize"><?php echo language("COUNTRY", @$_SESSION['systemLang']) ?></label>
              <div class="col-sm-12 position-relative">
                <?php 
                if (!isset($countries_obj)) {
                  // create an object of Countries class
                  $countries_obj = new Countries();
                }
                // get all countries
                $countries = $countries_obj->get_all_countries(); 
                // countries counter
                $countries_count = $countries[0];
                // countries data
                $countries_data = $countries[1];
                // check counter
                ?>
                <select class="form-select" name="country" id="country" required>
                  <?php if ($countries_count > 0) { ?>
                    <option value="default" disabled selected><?php echo language('SELECT', @$_SESSION['systemLang']) ." ". language('COUNTRY', @$_SESSION['systemLang']) ?></option>
                    <?php foreach ($countries_data as $country) { ?>
                      <option value="<?php echo $country['country_id'] ?>"><?php echo @$_SESSION['systemLang'] == 'ar' ? $country['country_name_ar'] : $country['country_name_en'] ?></option>
                    <?php } ?>
                  <?php } ?>
                </select>
              </div>
            </div>
            <!-- address -->
            <div class="mb-sm-2 mb-md-3 row">
              <label for="address" class="col-sm-12 col-form-label text-capitalize"><?php echo language("THE ADDRESS", @$_SESSION['systemLang']) ?></label>
              <div class="col-sm-12 position-relative">
                <input class="form-control w-100" type="text" name="address" id="address" placeholder="<?php echo language("THE ADDRESS", @$_SESSION['systemLang']) ?>" required>
              </div>
            </div>
            <!-- manager phone -->
            <div class="mb-sm-2 mb-md-3 row">
              <label for="manager-phone" class="col-sm-12 col-form-label text-capitalize"><?php echo language("PHONE", @$_SESSION['systemLang']) ?></label>
              <div class="col-sm-12 position-relative">
                <input class="form-control w-100" type="text"  name="manager-phone" id="manager-phone" placeholder="<?php echo language("PHONE", @$_SESSION['systemLang']) ?>" required>
              </div>
            </div>
          </div>
        </div>
        <!-- second row that contain company info -->
        <div class="row row-cols-sm-1" id="admin-info">
          <div class="section-header">
            <h4 class="h4"><?php echo language("ADMIN LOGIN INFO", @$_SESSION['systemLang']) ?></h4>
          </div>
          <div class="row row-cols-sm-1 row-cols-lg-2 g-2">
            <div class="col">
              <!-- admin username -->
              <div class="mb-sm-2 mb-md-3 row">
                <label for="username" class="col-sm-12 col-form-label text-capitalize"><?php echo language("USERNAME", @$_SESSION['systemLang']) ?></label>
                <div class="col-sm-12 position-relative">
                  <input class="form-control w-100" type="text" name="username" id="username" placeholder="<?php echo language("USERNAME", @$_SESSION['systemLang']) ?>" onblur="is_valid(this, 'username');" required>
                </div>
              </div>
              <!-- admin password -->
              <div class="mb-sm-2 mb-md-3 row">
                <label for="password" class="col-sm-12 col-form-label text-capitalize"><?php echo language("PASSWORD", @$_SESSION['systemLang']) ?></label>
                <div class="col-sm-12 position-relative">
                  <input class="form-control w-100" type="password" name="password" id="password" placeholder="<?php echo language("PASSWORD", @$_SESSION['systemLang']) ?>" onblur="confirm_password(confirm_pass, this)" data-no-validation="true" required>
                  <i class="bi bi-eye-slash show-pass show-pass-left text-dark" id="show-pass" onclick="show_pass(this)"></i>
                </div>
              </div>
              <!-- confirm_pass -->
              <div class="mb-sm-2 mb-md-3 row">
                <label for="confirm_pass" class="col-sm-12 col-form-label text-capitalize"><?php echo language("CONFIRM PASSWORD", @$_SESSION['systemLang']) ?></label>
                <div class="col-sm-12 position-relative">
                  <input class="form-control w-100" type="password" name="confirm_pass" id="confirm_pass" placeholder="<?php echo language("CONFIRM PASSWORD", @$_SESSION['systemLang']) ?>" onblur="confirm_password(this, password)" data-no-validation="true" required>
                  <i class="bi bi-eye-slash show-pass show-pass-left text-dark" id="show-pass" onclick="show_pass(this)"></i>
                </div>
              </div>
            </div>
            <div class="col">
              <!-- admin fullname -->
              <div class="mb-sm-2 mb-md-3 row">
                <label for="fullname" class="col-sm-12 col-form-label text-capitalize"><?php echo language("FULLNAME", @$_SESSION['systemLang']) ?></label>
                <div class="col-sm-12 position-relative">
                  <input class="form-control w-100" type="text" name="fullname" id="fullname" placeholder="<?php echo language("FULLNAME", @$_SESSION['systemLang']) ?>" required>
                </div>
              </div>
              <!-- admin gender -->
              <div class="mb-sm-2 mb-md-3 row">
                <label for="gender" class="col-sm-12 col-form-label text-capitalize"><?php echo language("GENDER", @$_SESSION['systemLang']) ?></label>
                <div class="col-sm-12 position-relative">
                  <select class="form-select" name="gender" id="gender" required>
                    <option value="default" disabled selected><?php echo language("SELECT", @$_SESSION['systemLang']) ." ".language("GENDER", @$_SESSION['systemLang']) ?></option>
                    <option value="0"><?php echo language("MALE", @$_SESSION['systemLang']) ?></option>
                    <option value="1"><?php echo language("FEMALE", @$_SESSION['systemLang']) ?></option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- submit -->
        <button type="button" form="signup-form" class="btn btn-primary text-capitalize bg-gradient py-1 fs-12 <?php echo @$_SESSION['systemLang'] == 'ar' ? 'me-auto' : 'ms-auto' ?>" id="signup-form-btn"  onclick="form_validation(this.form, 'submit')">
          <?php echo language('SIGNUP', @$_SESSION['systemLang']) ?>
        </button>
        <!-- submit -->
        <a href="./login.php" class="btn btn-outline-secondary text-capitalize bg-gradient py-1 fs-12 <?php echo @$_SESSION['systemLang'] == 'ar' ? 'me-auto' : 'ms-auto' ?>" id="login-form-btn">
          <?php echo language('LOGIN', @$_SESSION['systemLang']) ?>
        </a>
      </form>
      <hr>
      <div>
        <p>
          <span>
            <?php echo language('YOU CAN VISIT OUR WEBSITE TO SHOW MOST RECENT EVENTS, ARTICLES AND TOPICS OF INTEREST TO YOU', @$_SESSION['systemLang']) ?>
          </span>
          <a href="../../index.php"><?php echo language('FROM HERE', @$_SESSION['systemLang']) ?>&nbsp;<i class="bi bi-arrow-up-left-square"></i></a>
        </p>
      </div>
    </div>
  </div>
</div>

<?php include_once $tpl . "js-includes.php"; ?>
