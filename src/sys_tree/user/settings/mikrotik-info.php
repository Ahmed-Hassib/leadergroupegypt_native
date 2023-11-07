<div class="section-block">
  <!-- section header -->
  <div class="section-header">
    <h5 class="text-capitalize ">
      <?php echo lang('MIKROTIK INFO', $lang_file) ?>
    </h5>
    <hr />
  </div>

  <div class="mb-1">
    <form action="?do=change-mikrotik" method="POST" id="mikrotik-settings">
      <div class="ip-port-container">
        <!-- IP -->
        <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
          <input class="form-control" type="text" name="mikrotik-ip" id="mikrotik-ip"
            value="<?php echo isset($_SESSION['sys']['mikrotik']) && !empty($_SESSION['sys']['mikrotik']['ip']) ? trim($_SESSION['sys']['mikrotik']['ip'], '') : null ?>"
            placeholder="<?php echo lang('IP') ?>">
          <label for="mikrotik-ip">
            <?php echo lang('IP') ?>
          </label>
        </div>
        <!-- port -->
        <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
          <input class="form-control" type="number" name="mikrotik-port" id="mikrotik-port"
            value="<?php echo isset($_SESSION['sys']['mikrotik']) && !empty($_SESSION['sys']['mikrotik']['port']) ? trim($_SESSION['sys']['mikrotik']['port'], '') : null ?>"
            placeholder="<?php echo lang('PORT') ?>">
          <label for="mikrotik-port">
            <?php echo lang('PORT') ?>
          </label>
        </div>
      </div>
      <!-- username -->
      <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
        <input class="form-control" type="text" name="mikrotik-username" id="mikrotik-username"
          value="<?php echo isset($_SESSION['sys']['mikrotik']) && !empty($_SESSION['sys']['mikrotik']['username']) ? trim($_SESSION['sys']['mikrotik']['username'], '') : null ?>"
          placeholder="<?php echo lang('USERNAME') ?>">
        <label for="mikrotik-username">
          <?php echo lang('USERNAME') ?>
        </label>
      </div>
      <!-- password -->
      <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
        <input class="form-control" type="password" name="mikrotik-password" id="mikrotik-password"
          value="<?php echo isset($_SESSION['sys']['mikrotik']) && !empty($_SESSION['sys']['mikrotik']['password']) ? trim($_SESSION['sys']['mikrotik']['password'], '') : null ?>"
          placeholder="<?php echo lang('PASSWORD') ?>">
        <i class="bi bi-eye-slash show-pass <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'show-pass-left' : 'show-pass-right' ?>"
          onclick="show_pass(this)"></i>
        <label for="mikrotik-password">
          <?php echo lang('PASSWORD') ?>
        </label>
        <div id="passHelp" class="form-text text-warning ">
          <?php echo lang('PASS NOTE') ?>
        </div>
      </div>

      <div class="hstack gap-3">
        <!-- check mikrotik info -->
        <button type="button" form="mikrotik-settings" class="me-auto btn btn-outline-primary text-capitalize fs-12 py-1"
          onclick="check_mikrotik_info(this, this.form)" data-bs-toggle="modal"
          data-bs-target="#mikrotikCheckInfoModal">
          <span class="button-content">
            <i class="bi bi-arrow-clockwise"></i>
            <?php echo lang('CHECK CONNECTION', $lang_file) ?>
          </span>

          <span class="spinner-border d-none" role="status"></span>
        </button>
        <!-- submit button -->
        <button type="submit" form="mikrotik-settings" class="btn btn-primary text-capitalize fs-12 py-1">
          <i class="bi bi-check-all me-1"></i>
          <?php echo lang('SAVE') ?>
        </button>
      </div>
    </form>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="mikrotikCheckInfoModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="mikrotikCheckInfoModalLabel">
          <?php echo lang('MIKROTIK CONNECTION STATUS', $lang_file) ?>
        </h1>
        <button type="button" class="btn-close btn-close-<?php echo $page_dir == 'rtl' ? 'left' : 'right' ?> d-none"
          data-bs-dismiss="modal" aria-label="Close" onclick="clear_modal_body('#mikrotikCheckInfoModal')"></button>
      </div>
      <div class="modal-body">
        <div class="loader text-center">
          <div class="spinner-border text-primary" role="status"></div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary fs-12 py-1 disabled" data-bs-dismiss="modal"
          onclick="clear_modal_body('#mikrotikCheckInfoModal')">
          <span class="d-none">
            <?php echo lang('CLOSE') ?>
          </span>
          <span class="spinner-border" role="status"></span>
        </button>
      </div>
    </div>
  </div>
</div>