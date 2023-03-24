<!-- <div class="overlay emp-overlay">
  <div class="overlay-container">
    <img src="" alt="">
  </div>
</div> -->

<!-- start add new user page -->
<div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
  <!-- start add new user form -->
  <form class="profile-form" action="?do=insert-user" method="POST" id="add-new-user" enctype="multipart/form-data" onchange="form_validation(this)">
    <!-- horzontal stack -->
    <div class="hstack gap-3">
      <h6 class="h6 text-decoration-underline text-capitalize text-danger fw-bold">
        <span><?php echo language('NOTE', @$_SESSION['systemLang']) ?>:</span>&nbsp;
        <span><?php echo language('THIS SIGN * IS REFERE TO REQUIRED FIELDS', @$_SESSION['systemLang']) ?></span>
      </h6>
    </div>
    <!-- start new design -->
    <div class="mb-3 row g-3 justify-content-start align-items-stretch">
      <!-- employee image -->
      <!-- <div class="col-sm-12 text-center">
        <div class="section-block">
          <img src="<?php echo $uploads."employees-img/male-avatar.svg" ?>" alt="" class="employee-avater img-fluid">
          <div class="img-container bg-gradient">
            <input type="file" name="employee-img" id="employee-img" class="form-control" onchange="upload_image(this)">
            <i class="bi bi-camera"></i>
          </div>
        </div>
      </div> -->

      <!-- employee general info -->
      <div class="col-sm-12 col-lg-6">
        <div class="section-block">
          <header class="section-header">
            <h5 class="h5 text-capitalize"><?php echo language('GENERAL INFO', @$_SESSION['systemLang']) ?></h5>
            <p class="text-secondary fs-12"></p>
            <hr>
          </header>
          <!-- start full name field -->
          <div class="mb-4 row">
              <label for="fullname" class="col-sm-12 col-md-3 col-form-label text-capitalize" autocomplete="off"><?php echo language('FULLNAME', @$_SESSION['systemLang']) ?></label>
              <div class="col-sm-12 col-md-9">
                  <input type="text" class="form-control" name="fullname" id="fullname" placeholder="<?php echo language('FULLNAME', @$_SESSION['systemLang']) ?>" aria-describedby="fullNameHelp" required>
                  <div id="fullNameHelp" class="form-text"><?php echo language('FULLNAME WILL APPEAR IN PROFILE PAGE', @$_SESSION['systemLang']) ?></div>
              </div>
          </div>
          <!-- end full name field -->
          <!-- start gender field -->
          <div class="mb-4 row">
            <label for="gender" class="col-sm-12 col-md-3 col-form-label text-capitalize" autocomplete="off"><?php echo language('GENDER', @$_SESSION['systemLang']) ?></label>
            <div class="col-sm-12 col-md-9">
              <select class="form-select" name="gender" id="gender" required>
                <option value="default" selected disabled><?php echo language('SELECT GENDER', @$_SESSION['systemLang']) ?></option>
                <option value="0"><?php echo language('MALE', @$_SESSION['systemLang']) ?></option>
                <option value="1"><?php echo language('FEMALE', @$_SESSION['systemLang']) ?></option>
              </select>
            </div>
          </div>
          <!-- end gender field -->
          <!-- start address field -->
          <div class="mb-4 row">
            <label for="address" class="col-sm-12 col-md-3 col-form-label text-capitalize" autocomplete="off"><?php echo language('THE ADDRESS', @$_SESSION['systemLang']) ?></label>
            <div class="col-sm-12 col-md-9">
              <input type="text" class="form-control" name="address" id="address" aria-describedby="address" placeholder="<?php echo language('THE ADDRESS', @$_SESSION['systemLang']) ?>">
              <!-- <div id="address" class="form-text"><?php echo language('FULLNAME WILL APPEAR IN PROFILE PAGE', @$_SESSION['systemLang']) ?></div> -->
            </div>
          </div>
          <!-- end address field -->
          <!-- strat phone field -->
          <div class="mb-4 row">
            <label for="phone" class="col-sm-12 col-md-3 col-form-label text-capitalize"><?php echo language('PHONE', @$_SESSION['systemLang']) ?></label>
            <div class="col-sm-12 col-md-9">
              <input type="text" maxlength="11" class="form-control" name="phone" id="phone" placeholder="<?php echo language('PHONE', @$_SESSION['systemLang']) ?>">
            </div>
          </div>
          <!-- end phone field -->
          <!-- strat date of birth field -->
          <div class="mb-4 row">
            <label for="date-of-birth" class="col-sm-12 col-md-3 col-form-label text-capitalize"><?php echo language('DATE OF BIRTH', @$_SESSION['systemLang']) ?></label>
            <div class="col-sm-12 col-md-9">
              <input type="date" class="form-control px-5" name="date-of-birth" id="date-of-birth"  placeholder="">
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
              <input type="email" class="form-control" name="email" id="email" placeholder="example@example.com">
              <div id="emailHelp" class="form-text"><?php echo language('WE`LL NEVER SHARE YOUR EMAIL WITH ANYONE ELSE', @$_SESSION['systemLang']) ?></div>
            </div>
          </div>
          <!-- end email field -->
          <!-- start user name field -->
          <div class="mb-4 row">
            <label for="username" class="col-sm-12 col-md-3 col-form-label text-capitalize"><?php echo language('USERNAME', @$_SESSION['systemLang']) ?></label>
            <div class="col-sm-12 col-md-9">
              <input type="text" class="form-control" name="username" id="username" placeholder="<?php echo language('USERNAME', @$_SESSION['systemLang']) ?>" autocomplete="off" aria-describedby="usernameHelp" required>
              <div id="usernameHelp" class="form-text"><?php echo language('USERNAME TO LOGIN INTO THE SYSTEM', @$_SESSION['systemLang']) ?></div>
            </div>
          </div>
          <!-- end user name field -->
          <!-- strat password field -->
          <div class="mb-4 row">
            <label for="password" class="col-sm-12 col-md-3 col-form-label text-capitalize"><?php echo language('PASSWORD', @$_SESSION['systemLang']) ?></label>
            <div class="col-sm-12 col-md-9">
              <input type="password" class="form-control" name="password" id="password" placeholder="" autocomplete="new-password" aria-describedby="passHelp" required>
              <i class="bi bi-eye-slash show-pass <?php echo @$_SESSION['systemLang'] == 'ar' ? 'show-pass-left' : 'show-pass-right' ?>" onclick="showPass(this)" id="show-pass"></i>
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
            <label for="job-title" class="col-sm-12 col-md-3 col-form-label text-capitalize"><?php echo language('JOB TITLE', @$_SESSION['systemLang']) ?></label>
            <div class="col-sm-12 col-md-9">
              <select class="form-select" name="job_title_id" id="job_title_id" <?php if ($_SESSION['user_update'] == 0) {echo 'disabled';} ?> required>
                <option value="default" selected disabled><?php echo language('JOB TITLE', @$_SESSION['systemLang']) ?></option>
                <?php 
                  $db_obj = new Database();
                  $job_titles = $db_obj->select_specific_column('*', "`users_job_title`", ""); ?>
                <?php foreach ($job_titles as $job_title) { ?>
                  <option value="<?php echo $job_title['job_title_id'] ?>"><?php echo language($job_title['job_title_name'], @$_SESSION['systemLang']) ?></option>
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
            <input type="text" class="form-control <?php echo @$_SESSION['systemLang'] == 'ar' ? 'form-control-left' : 'form-control-right' ?>" name="twitter" placeholder="twitter" aria-label="twitter" aria-describedby="twitter">
          </div>
          <!-- end twitter field -->
          <!-- strat facebook field -->
          <div class="input-group mb-3">
            <span class="input-group-text bg-white <?php echo @$_SESSION['systemLang'] == 'ar' ? 'input-group-right' : 'input-group-left' ?>" id="facebook"><i class="bi bi-facebook text-primary"></i></span>
            <input type="text" class="form-control <?php echo @$_SESSION['systemLang'] == 'ar' ? 'form-control-left' : 'form-control-right' ?>" name="facebook" placeholder="facebook" aria-label="facebook" aria-describedby="facebook">
          </div>
          <!-- end facebook field -->
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
          <?php include_once 'add-user-permissions.php' ?>
          <!-- end user-permission field -->
        </div>
      </div>
    </div>

    <!-- start buttons section -->
    <div class="hstack gap-2">
        <!-- submit button -->
        <button type="button" form="add-new-user" class="btn btn-primary text-capitalize fs-12 <?php echo @$_SESSION['systemLang'] == 'ar' ? 'me-auto' : 'ms-auto' ?>" <?php if ($_SESSION['user_add'] == 0) {echo 'disabled';} ?> onclick="form_validation(this.form, 'submit')">
            <span><?php echo language('ADD THE EMPLOYEE', @$_SESSION['systemLang']) ?></span>&nbsp;<i class="bi bi-person-plus"></i>
        </button>
        <!-- submit button -->
        <a href="?do=manage" class="btn btn-outline-secondary text-capitalize fs-12 <?php if ($_SESSION['user_show'] == 0) {echo 'disabled';} ?>">
            <span><?php echo language('ALL THE EMPLOYEES', @$_SESSION['systemLang']) ?></span>&nbsp;<i class="bi bi-people"></i>
        </a>
    </div>
    <!-- end submit -->
  </form>
</div>