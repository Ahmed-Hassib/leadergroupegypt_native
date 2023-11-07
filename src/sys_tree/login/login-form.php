<div class="loginPageContainer">
  <div class="imgBox">
    <div class="hero-content">
      <img src="<?php echo $assets ?>images/login-2.svg" alt="" />
    </div>
  </div>
  <div class="contentBox" dir="rtl">
    <div class="formBox">
      <!-- login form -->
      <form class="login-form" id="login-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <div class="mb-3 form-floating">
          <input type="text" class="form-control" id="username" name="username" placeholder="<?php echo lang('USERNAME') ?>" value="<?php echo isset($_GET['username']) && isset($_GET['password']) && isset($_GET['company-code']) ? $username : "" ?>" data-no-astrisk="true" required>
          <label for="username"><?php echo lang('USERNAME') ?></label>
        </div>
        <div class="mb-3 form-floating login">
          <input type="password" class="form-control" id="password" name="password" placeholder="<?php echo lang('PASSWORD') ?>" value="<?php echo isset($_GET['username']) && isset($_GET['password']) && isset($_GET['company-code']) ? $password : "" ?>" data-no-astrisk="true" required>
          <i class="bi bi-eye-slash show-pass show-pass-left text-dark" id="show-pass" onclick="show_pass(this)"></i>
          <label for="password"><?php echo lang('PASSWORD') ?></label>
        </div>
        <div class="mb-3 form-floating login">
          <input type="text" class="form-control" id="company-code-id" name="company-code" placeholder="<?php echo lang('COMPANY CODE') ?>" value="<?php echo isset($_GET['username']) && isset($_GET['password']) && isset($_GET['company-code']) ? $company_code : "" ?>" data-no-astrisk="true" required>
          <label for="company-code-id"><?php echo lang('COMPANY CODE') ?></label>
        </div>
        <div class="mb-3 form-floating login">
          <select class="form-select" name="language" id="language">
            <option value="default" disabled><?php echo lang('SELECT LANG') ?></option>
            <option value="ar" selected><?php echo lang('AR') ?></option>
            <option value="en" disabled>
              <?php echo lang('EN') . "&nbsp;&dash;&nbsp;" . lang('UNDER DEVELOPING') ?></span>
            </option>
          </select>
          <label for="language"><?php echo lang('LANG') ?></label>
        </div>
        <div class="mb-2">
          <button type="submit" class="btn btn-primary w-100 text-capitalize" style="border-radius: 6px"><?php echo lang('LOGIN', $lang_file) ?></button>
        </div>
        <div class="hstack gap-1 my-2" dir="rtl">
          <div>
            <span><?php echo lang("DON`T HAVE ACCOUNT", $lang_file) ?>&nbsp;</span>
            <a href="signup.php" class="text-capitalize" style="border-radius: 6px"><?php echo lang('SIGNUP', $lang_file) ?></a>
          </div>
          <div class="me-auto">
            <a href="?d=<?php echo base64_encode('forget-password') ?>" class="text-capitalize" style="border-radius: 6px">
              <span><?php echo lang("FORGET PASSWORD?") ?></span>
            </a>
          </div>
        </div>
      </form>
      <hr>
      <div class="row g-2">
        <div class="col-10">
          <a href="../../index.php" class="btn btn-outline-primary w-100"><?php echo lang("SPONSOR") ?></a>
        </div>
        <div class="col-2">
          <a href="https://www.facebook.com/LeaderGroupEGYPT" target="_blank" class="btn btn-outline-primary w-100 px-0"><i class="bi bi-facebook"></i></a>
        </div>
      </div>
    </div>
  </div>
</div>
