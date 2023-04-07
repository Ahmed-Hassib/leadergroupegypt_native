<?php
// check the current users
if ($user_id == $_SESSION['UserID'] || $_SESSION['user_show'] == 1) {
  // create an object of Users class
  $user_obj = new User();
  // get user info from database
  $user_info = $user_obj->get_user_info($user_id, $_SESSION['company_id']);
  // counter
  $counter = $user_info[0];
  // check the row count
  if ($counter > 0) {
    // user data
    $user = $user_info[1];
    // get user permissions
    $stmt = $con->prepare("SELECT *FROM `users_permissions` WHERE `UserID` = ? LIMIT 1");
    $stmt->execute(array($user_id)); // execute query
    $permissions = $stmt->fetch();   // fetch data
  ?>
    <div class="container" dir="<?php echo $_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
      <!-- start edit profile -->
      <div class="row row-cols-sm-1 row-cols-lg-2 g-3">
        <!-- start add new user form -->
        <form class="profile-form" action="?do=update-user-info" method="POST" id="edit-user-info" onchange="form_validation(this)">
          <!-- horzontal stack -->
          <div class="hstack gap-3">
            <h6 class="h6 text-decoration-underline text-capitalize text-danger fw-bold">
              <span><?php echo language('NOTE', @$_SESSION['systemLang']) ?>:</span>&nbsp;
              <span><?php echo language('THIS SIGN * IS REFERE TO REQUIRED FIELDS', @$_SESSION['systemLang']) ?></span>
            </h6>
          </div>
          <!-- start new design -->
          <div class="mb-3 row g-3 justify-content-start align-items-stretch">
            <!-- employee general info -->
            <div class="col-sm-12">
              <div class="section-block">
                <!-- start profile image -->
                <div class="mb-4 row" id="profile-image-container">
                  <?php $profile_img_name = empty($user['profile_img']) ? 'male-avatar.svg' : $user['profile_img']; ?>
                  <img src="<?php echo $uploads . "employees-img/$profile_img_name" ?>" class="profile-img" alt="">
                </div>
                <!-- end profile image -->
                <?php if ($_SESSION['UserID'] == $user['UserID']) { ?>
                <!-- start control buttons -->
                <div class="hstack gap-3">
                  <div class="mx-auto">
                    <!-- edit image button -->
                    <button type="button" role="button" class="btn btn-outline-primary fs-12 py-1 text-capitalize" onclick="change_profile_image()">
                      <i class="bi bi-pencil-square"></i>
                      <?php echo language('CHANGE IMAGE', @$_SESSION['systemLang']) ?>
                    </button>
                    
                    <!-- delete image button -->
                    <button type="button" role="button" class="btn btn-danger fs-12 py-1 text-capitalize" onclick="delete_profile_image()">
                      <i class="bi bi-trash"></i>
                      <?php echo language('DELETE IMAGE', @$_SESSION['systemLang']) ?>
                    </button>
                  </div>
                </div>
                <!-- end control buttons -->
                <?php } ?>
              </div>
            </div>
          </div> 
          
          <div class="mb-3 row g-3 justify-content-start align-items-stretch"> 
            <!-- employee general info -->
            <div class="col-sm-12 col-lg-6">
              <div class="section-block">
                <header class="section-header">
                  <h5 class="h5 text-capitalize"><?php echo language('GENERAL INFO', @$_SESSION['systemLang']) ?></h5>
                  <p class="text-secondary fs-12"></p>
                  <hr>
                </header>
                <!-- user id -->
                <input type="hidden" name="userid" value="<?php echo $user['UserID'] ?>">
                <!-- start full name field -->
                <div class="mb-4 row">
                  <label for="fullname" class="col-sm-12 col-md-3 col-form-label text-capitalize" autocomplete="off"><?php echo language('FULLNAME', @$_SESSION['systemLang']) ?></label>
                  <div class="col-sm-12 col-md-9">
                    <input type="text" class="form-control" name="fullname" id="fullname" placeholder="<?php echo language('FULLNAME WILL APPEAR IN PROFILE PAGE', @$_SESSION['systemLang']) ?>" value="<?php echo $user['Fullname'] ?>"  <?php if ($_SESSION['user_update'] == 0 && $_SESSION['UserID'] != $user['UserID']) {echo 'readonly';} ?> required>
                    <div id="fullNameHelp" class="form-text"><?php echo language('FULLNAME WILL APPEAR IN PROFILE PAGE', @$_SESSION['systemLang']) ?></div>
                  </div>
                </div>
                <!-- end full name field -->
                <!-- start gender field -->
                <div class="mb-4 row">
                  <label for="gender" class="col-sm-12 col-md-3 col-form-label text-capitalize" autocomplete="off"><?php echo language('GENDER', @$_SESSION['systemLang']) ?></label>
                  <div class="col-sm-12 col-md-9">
                    <select class="form-select" name="gender" id="gender" <?php if ($_SESSION['user_update'] == 0 && $_SESSION['UserID'] != $user['UserID']) {echo 'readonly';} ?> required>
                      <option value="default" selected disabled><?php echo language('SELECT GENDER', @$_SESSION['systemLang']) ?></option>
                      <option value="0" <?php echo $user['gender'] == 0 ? 'selected' : '' ?>><?php echo language('MALE', @$_SESSION['systemLang']) ?></option>
                      <option value="1" <?php echo $user['gender'] == 1 ? 'selected' : '' ?>><?php echo language('FEMALE', @$_SESSION['systemLang']) ?></option>
                    </select>
                  </div>
                </div>
                <!-- end gender field -->
                <!-- start address field -->
                <div class="mb-4 row">
                  <label for="address" class="col-sm-12 col-md-3 col-form-label text-capitalize" autocomplete="off"><?php echo language('THE ADDRESS', @$_SESSION['systemLang']) ?></label>
                  <div class="col-sm-12 col-md-9">
                    <input type="text" class="form-control" name="address" id="address" aria-describedby="address" value="<?php echo $user['address'] ?>" placeholder="<?php echo language('NO DATA ENTERED', @$_SESSION['systemLang']) ?>" <?php if ($_SESSION['user_update'] == 0 && $_SESSION['UserID'] != $user['UserID']) {echo 'readonly';} ?>>
                    <!-- <div id="address" class="form-text"><?php echo language('FULLNAME WILL APPEAR IN PROFILE PAGE', @$_SESSION['systemLang']) ?></div> -->
                  </div>
                </div>
                <!-- end address field -->
                <!-- strat phone field -->
                <div class="mb-4 row">
                  <label for="phone" class="col-sm-12 col-md-3 col-form-label text-capitalize"><?php echo language('PHONE', @$_SESSION['systemLang']) ?></label>
                  <div class="col-sm-12 col-md-9">
                    <input type="text" maxlength="11" class="form-control" name="phone" id="phone" placeholder="<?php echo language('NO DATA ENTERED', @$_SESSION['systemLang']) ?>" value="<?php echo $user['phone'] ?>" <?php if ($_SESSION['user_update'] == 0 && $_SESSION['UserID'] != $user['UserID']) {echo 'readonly';} ?>>
                  </div>
                </div>
                <!-- end phone field -->
                <!-- strat date of birth field -->
                <div class="mb-4 row">
                  <label for="date-of-birth" class="col-sm-12 col-md-3 col-form-label text-capitalize"><?php echo language('DATE OF BIRTH', @$_SESSION['systemLang']) ?></label>
                  <div class="col-sm-12 col-md-9">
                      <input type="date" class="form-control px-5" name="date-of-birth" id="date-of-birth"  value="<?php echo $user['date_of_birth'] ?>" <?php if ($_SESSION['user_update'] == 0 && $_SESSION['UserID'] != $user['UserID']) {echo 'readonly';} ?>>
                  </div>
                </div>
                <!-- end date of birth field -->
              </div>
            </div>

            <!-- employee personal info -->
            <div class="col-sm-12 col-lg-6">
              <div class="section-block">
                <header class="section-header">
                  <h5 class="h5 text-capitalize"><?php echo language('PERSONAL INFO', @$_SESSION['systemLang']) ?></h5>
                  <p class="text-secondary fs-12"></p>
                  <hr>
                </header>
                <!-- strat email field -->
                <div class="mb-4 row">
                  <label for="email" class="col-sm-12 col-md-3 col-form-label text-capitalize"><?php echo language('EMAIL', @$_SESSION['systemLang']) ?></label>
                  <div class="col-sm-12 col-md-9">
                    <input type="email" class="form-control" name="email" id="email" placeholder="example@example.com" aria-describedby="emailHelp" value="<?php echo $user['Email'] ?>"  <?php if ($_SESSION['user_update'] == 0 && $_SESSION['UserID'] != $user['UserID']) {echo 'readonly';} ?>>
                    <div id="emailHelp" class="form-text" dir="<?php echo @$_SESSION['systemLang'] == "ar" ? "rtl" : "ltr" ?>"><?php echo language('WE`LL NEVER SHARE YOUR EMAIL WITH ANYONE ELSE', @$_SESSION['systemLang']) ?></div>
                  </div>
                </div>
                <!-- end email field -->
                <!-- start user name field -->
                <div class="mb-4 row">
                  <label for="username" class="col-sm-12 col-md-3 col-form-label text-capitalize"><?php echo language('USERNAME', @$_SESSION['systemLang']) ?></label>
                  <div class="col-sm-12 col-md-9">
                    <input type="text" class="form-control" name="username" id="username" placeholder="<?php echo language('USERNAME TO LOGIN INTO THE SYSTEM', @$_SESSION['systemLang']) ?>" autocomplete="off" value="<?php echo $user['UserName'] ?>"  required readonly>
                    <div id="usernameHelp" class="form-text"><?php echo language('USERNAME TO LOGIN INTO THE SYSTEM', @$_SESSION['systemLang']) ?></div>
                  </div>
                </div>
                <!-- end user name field -->
                <!-- strat password field -->
                <div class="mb-4 row">
                  <label for="password" class="col-sm-12 col-md-3 col-form-label text-capitalize"><?php echo language('PASSWORD', @$_SESSION['systemLang']) ?></label>
                  <div class="col-sm-12 col-md-9">
                    <input type="hidden" name="old-password" value="<?php echo $user['Pass'] ?>">
                    <input type="password" class="form-control" name="password" id="password" placeholder="<?php echo language('ENTER NEW PASSSWORD TO UPDATE IT', @$_SESSION['systemLang']) ?>" aria-describedby="passHelp" autocomplete="new-password"  <?php if ($_SESSION['user_update'] == 0 && $_SESSION['UserID'] != $user['UserID']) {echo 'readonly';} ?>>
                    <i class="bi bi-eye-slash show-pass <?php echo @$_SESSION['systemLang'] == 'ar' ? 'show-pass-left' : 'show-pass-right' ?>" id="show-pass" onclick="showPass(this)"></i>
                    <div id="passHelp" class="form-text"><?php echo language('PASSWORD MUST BE HARD AND COMPLEX', @$_SESSION['systemLang']) ?></div>
                  </div>
                </div>
                <!-- end password field -->
              </div>
            </div>

            <!-- employee job info -->
            <div class="col-sm-12 col-lg-6">
              <div class="section-block">
                <header class="section-header">
                  <h5 class="h5 text-capitalize"><?php echo language('JOB INFO', @$_SESSION['systemLang']) ?></h5>
                  <p class="text-secondary fs-12"></p>
                  <hr>
                </header>
                <!-- start job title field -->
                <div class="mb-4 row">
                  <label for="job_title_id" class="col-sm-12 col-md-3 col-form-label text-capitalize"><?php echo language('JOB TITLE', @$_SESSION['systemLang']) ?></label>
                  <div class="col-sm-12 col-md-9">
                    <select class="form-select" name="job_title_id" id="job_title_id" <?php if ($_SESSION['user_update'] == 0) {echo 'disabled';} ?> required>
                      <?php 
                        $db_obj = new Database();
                        $job_titles = $db_obj->select_specific_column('*', "`users_job_title`", ""); ?>
                      <option value="default" <?php if ($user['job_title_id'] == 0) {echo 'selected';} ?> disabled><?php echo language('JOB TITLE', @$_SESSION['systemLang']) ?></option>
                      <?php foreach ($job_titles as $job_title) { ?>
                        <option value="<?php echo $job_title['job_title_id'] ?>" <?php if ($user['job_title_id'] == $job_title['job_title_id']) {echo 'selected';} ?>><?php echo language($job_title['job_title_name'], @$_SESSION['systemLang']) ?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <?php if ($_SESSION['user_update'] == 0) { ?>
                    <div id="updatePermissionHelp" class="form-text" dir="<?php echo @$_SESSION['systemLang'] == "ar" ? "rtl" : "ltr" ?>">
                      <p>
                        <span class="text-danger text-decoration-underline  text-uppercase"><?php echo language('NOTE', @$_SESSION['systemLang']) ?>:</span>
                        <?php echo language('YOU DON`T HAVE PERMISSION TO UPDATE THIS FIELD', @$_SESSION['systemLang']); ?>
                      </p>
                    </div>
                  <?php } ?>
                </div>
                <!-- end user type field -->
              </div>
            </div>

            <!-- employee social media info -->
            <div class="col-sm-12 col-lg-6">
              <div class="section-block">
                <header class="section-header">
                  <h5 class="h5 text-capitalize"><?php echo language('SOCIAL MEDIA INFO', @$_SESSION['systemLang']) ?></h5>
                  <p class="text-secondary fs-12"></p>
                  <hr>
                </header>
                <!-- strat twitter field -->
                <div class="input-group mb-3">
                  <span class="input-group-text bg-white <?php echo @$_SESSION['systemLang'] == 'ar' ? 'input-group-right' : 'input-group-left' ?>" id="twitter"><i class="bi bi-twitter text-primary"></i></span>
                  <input type="text" class="form-control <?php echo @$_SESSION['systemLang'] == 'ar' ? 'form-control-left' : 'form-control-right' ?>" name="twitter"  value="<?php echo $user['twitter'] ?>" placeholder="<?php echo language('NO DATA ENTERED', @$_SESSION['systemLang']) ?>" aria-label="twitter" aria-describedby="twitter">
                </div>
                <!-- end twitter field -->
                <!-- strat facebook field -->
                <div class="input-group mb-3">
                  <span class="input-group-text bg-white <?php echo @$_SESSION['systemLang'] == 'ar' ? 'input-group-right' : 'input-group-left' ?>" id="facebook"><i class="bi bi-facebook text-primary"></i></span>
                  <input type="text" class="form-control <?php echo @$_SESSION['systemLang'] == 'ar' ? 'form-control-left' : 'form-control-right' ?>" name="facebook" value="<?php echo $user['facebook'] ?>"  placeholder="<?php echo language('NO DATA ENTERED', @$_SESSION['systemLang']) ?>" aria-label="facebook" aria-describedby="facebook">
                </div>
                <!-- end facebook field -->
                <!-- strat whatsapp field -->
                <!-- <div class="input-group mb-3">
                    <span class="input-group-text bg-success border-success <?php echo @$_SESSION['systemLang'] == 'ar' ? 'input-group-right' : 'input-group-left' ?>" id="whatsapp"><i class="bi bi-whatsapp"></i></span>
                    <input type="text" class="form-control border-success <?php echo @$_SESSION['systemLang'] == 'ar' ? 'form-control-left' : 'form-control-right' ?>" name="whatsapp" placeholder="<?php echo language('NO DATA ENTERED', @$_SESSION['systemLang']) ?>" aria-label="whatsapp" aria-describedby="whatsapp">
                </div> -->
                <!-- end whatsapp field -->
              </div>
            </div>

            <!-- employee permission -->
            <div class="col-sm-12">
              <div class="section-block">
                <header class="section-header">
                  <h5 class="text-capitalize "><?php echo language('PERMISSIONS', @$_SESSION['systemLang']) ?></h5>
                  <hr>
                </header>
                <!-- strat user-permission field -->
                <?php include_once 'edit-user-permissions.php' ?>
                <!-- end user-permission field -->
              </div>
            </div>
          </div>
          <!-- end new design -->
          <!-- strat submit -->
          <div class="hstack gap-3">
            <div class="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'me-auto' : 'ms-auto' ?>">
              <!-- edit button -->
              <button type="button" form="edit-user-info" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'ltr' : 'rtl' ?>" class="btn btn-primary text-capitalize fs-12" <?php if ($_SESSION['user_update'] == 0 && $user['UserID'] != $_SESSION['UserID']) {echo 'disabled';} ?> onclick="form_validation(this.form, 'submit')"><i class="bi bi-check-all"></i>&nbsp;<?php echo language('SAVE CHANGES', @$_SESSION['systemLang']) ?></button>
              
              <?php if ($user['isRoot'] != 1 && $user['TrustStatus'] != 1 && $user['job_title_id'] != 1 && $_SESSION['user_delete'] == 1) { ?>
                <!-- delete button -->
                <button type="button" data-bs-toggle="modal" data-bs-target="#deleteUserModal" onclick="show_delete_user_modal(this)" data-username="<?php echo $user['UserName'] ?>" data-user-id="<?php echo $user['UserID'] ?>" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'ltr' : 'rtl' ?>" class="btn btn-outline-danger text-capitalize fs-12" <?php if ($_SESSION['user_delete'] == 0 && $user['UserID'] != $_SESSION['UserID']) {echo 'disabled';} ?>><i class="bi bi-trash"></i>&nbsp;<?php echo language('DELETE', @$_SESSION['systemLang']) ?></button>
              <?php } ?>
            </div>
          </div>
          <!-- end submit -->
        </form>
        <!-- start edit profile form -->
      </div>
      <!-- end edit profile -->
    </div>
<?php
  } else { 
    // include_once no data founded module
    include_once $globmod . 'no-data-founded.php';
  }
} else {
  // include_once permission error module
  include_once $globmod . 'permission-error.php';
}
?>