<div class="container login-container">
  <div class="form-box">
    <div class="form-box-header">
      <h2 class="h2"><?php echo lang('WEBSITE LOGIN', $lang_file) ?></h2>
    </div>
    <!-- login form -->
    <form class="login-form" id="login-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
      <div class="form-floating">
        <input type="text" class="form-control" id="username" name="username" placeholder="<?php echo lang('USERNAME', $lang_file) ?>" data-no-astrisk="true" required>
        <label for="username"><?php echo lang('USERNAME', $lang_file) ?></label>
      </div>
      <div class="form-floating position-relative login">
        <input type="password" class="form-control" id="password" name="password" placeholder="<?php echo lang('PASSWORD', $lang_file) ?>" data-no-astrisk="true" required>
        <i class="bi bi-eye-slash show-pass show-pass-left text-dark" id="show-pass" onclick="show_pass(this)"></i>
        <label for="password"><?php echo lang('PASSWORD') ?></label>
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
    </form>
  </div>
</div>