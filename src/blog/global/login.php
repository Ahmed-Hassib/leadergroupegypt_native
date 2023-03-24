<!-- START LOGIN SECTION -->
<div class="login-section">
  <div class="container">
    <h4 class="main-title"><?php echo language('BLOG LOGIN') ?></h4>
      <!-- START LOGIN CONTAINER -->
      <div class="blog-login-container">
        
        <!-- START LOGIN FORM -->
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" class="blog-login-form" id="blog-login-form">
          <!-- START EMAIL -->
          <div class="mb-4 row">
            <label for="email" class="form-label col-sm-12"><?php echo language('EMAIL') ?></label>
            <div class="col-sm-12">
              <input type="email" class="form-control" id="email" name="email" required>
            </div>
          </div>
          <!-- END EMAIL -->
          <!-- START PASSWORD -->
          <div class="mb-2 row">
            <label for="password" class="form-label col-sm-12"><?php echo language('PASSWORD') ?></label>
            <div class="col-sm-12 position-relative">
              <input type="password" class="form-control" id="password" name="password" required>
              <i class="bi bi-eye-slash show-pass text-dark" id="show-pass" onclick="showPass(this)"></i>
            </div>
          </div>
          <!-- END PASSWORD -->
          <div class="mb-4" dir="rtl">
            <span><?php echo languageEn("DON`T HAVE AN ACCOUNT?") ?>&nbsp;</span>
            <a href="signup.php" class="text-capitalize"><?php echo language('SIGNUP') ?></a>
          </div>
          <!-- START SUBMIT BUTTON -->
          <div class="mb-4">
            <button type="button" class="btn btn-outline-primary w-100" onclick="validate_form(this.form)"><?php echo language('LOGIN') ?></button>
          </div>
          <!-- END SUBMIT BUTTON -->
        </form>
        <!-- END LOGIN FORM -->
      </div>
      <!-- END LOGIN CONTAINER -->
  </div>
</div>
<!-- END LOGIN SECTION -->