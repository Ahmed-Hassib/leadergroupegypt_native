<div class="section-block">
  <!-- section header -->
  <div class="section-header">
    <h5 class="text-capitalize "><?php echo lang('MIKROTIK INFO', $lang_file) ?></h5>
    <hr />
  </div>

  <div class="mb-1">
    <form action="?do=change-mikrotik" method="POST" id="mikrotik-settings">
      <div class="ip-port-container">
        <!-- IP -->
        <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
          <input class="form-control" type="text" name="mikrotik-ip" id="mikrotik-ip" value="<?php echo isset($_SESSION['sys']['mikrotik']) && !empty($_SESSION['sys']['mikrotik']['ip']) ? trim($_SESSION['sys']['mikrotik']['ip'], '') : null ?>" placeholder="<?php echo lang('IP') ?>">
          <label for="mikrotik-ip"><?php echo lang('IP') ?></label>
        </div>
        <!-- port -->
        <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
          <input class="form-control" type="number" name="mikrotik-port" id="mikrotik-port" value="<?php echo isset($_SESSION['sys']['mikrotik']) && !empty($_SESSION['sys']['mikrotik']['port']) ? trim($_SESSION['sys']['mikrotik']['port'], '') : null ?>" placeholder="<?php echo lang('PORT') ?>">
          <label for="mikrotik-port"><?php echo lang('PORT') ?></label>
        </div>
      </div>
      <!-- username -->
      <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
        <input class="form-control" type="text" name="mikrotik-username" id="mikrotik-username" value="<?php echo isset($_SESSION['sys']['mikrotik']) && !empty($_SESSION['sys']['mikrotik']['username']) ? trim( $_SESSION['sys']['mikrotik']['username'], '') : null ?>" placeholder="<?php echo lang('USERNAME') ?>">
        <label for="mikrotik-username"><?php echo lang('USERNAME') ?></label>
      </div>
      <!-- password -->
      <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
        <input class="form-control" type="password" name="mikrotik-password" id="mikrotik-password" value="<?php echo isset($_SESSION['sys']['mikrotik']) && !empty($_SESSION['sys']['mikrotik']['password']) ? trim($_SESSION['sys']['mikrotik']['password'], '') : null ?>" placeholder="<?php echo lang('PASSWORD') ?>">
        <i class="bi bi-eye-slash show-pass <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'show-pass-left' : 'show-pass-right' ?>" onclick="show_pass(this)"></i>
        <label for="mikrotik-password"><?php echo lang('PASSWORD') ?></label>
        <div id="passHelp" class="form-text text-warning ">
          <?php echo lang('PASS NOTE') ?>
        </div>
      </div>

      <div class="hstack gap-3">
        <!-- submit button -->
        <button type="submit" class="me-auto btn btn-primary text-capitalize fs-12 py-1"><i class="bi bi-check-all me-1"></i><?php echo lang('SAVE') ?></button>
      </div>
    </form>
  </div>
</div>