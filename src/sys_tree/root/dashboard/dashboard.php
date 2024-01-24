<?php $db_obj = new Database("localhost", "jsl_db") ?>
<!-- start home stats container -->
<div class="container" dir="<?php echo $page_dir ?>">
  <!-- start stats -->
  <div class="stats">
    <div class="dashboard-content">
      <!-- system status -->
      <div class="card shadow-sm border border-1">
        <div class="card-body">
          <?php
          // fetch data from database
          $system_status = $db_obj->select_specific_column("*", "`settings`", "LIMIT 1");
          // get value of seystem status
          $system_status = !empty($system_status) && count($system_status) > 0 ? $system_status[0]['is_developing'] : null;
          ?>
          <h5 class="card-title text-capitalize">
            <?php echo lang('SYSTEM STATUS') ?>
          </h5>
          <span class="bg-primary icon-container <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'icon-container-left' : 'icon-container-right' ?>">
            <i class="bi bi-patch-question"></i>
          </span>
          <form action="?do=system-status" method="post">
            <div class="form-check form-switch <?php echo $page_dir == 'rtl' ? 'form-check-reverse' : '' ?>" style="width: fit-content;margin: auto;">
              <label class="form-check-label" for="system_status"><?php echo $system_status == '0' ? lang('ACTIVE', $lang_file) : lang('UNDER DEVELOPING') ?></label>
              <input class="form-check-input" style="width: 2rem; height: 1rem; cursor: pointer;" type="checkbox" name="system_status_switch" role="switch" id="system_status_switch" <?php echo $system_status == '0' ? 'checked' : '' ?> onclick="document.querySelector('#system_status').value = check_switch_value(this); this.form.submit()">
              <input type="hidden" id="system_status" name="system_status" value="<?php echo $system_status ?>">

              <script>
                function check_switch_value(switch_btn) {
                  return switch_btn.checked ? 0 : 1;
                }
              </script>
            </div>
          </form>
        </div>
      </div>

      <!-- number of companies -->
      <div class="card shadow-sm border border-1">
        <div class="card-body">
          <h5 class="card-title text-capitalize">
            <?php echo lang('#REGISTERED COMPANIES', $lang_file) ?>
          </h5>
          <span class="bg-primary icon-container <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'icon-container-left' : 'icon-container-right' ?>">
            <i class="bi bi-building-exclamation"></i>
          </span>
          <p class="card-text nums">
            <?php $num_of_companies = $db_obj->count_records("*", "`companies`", "WHERE `company_id` <> 1"); ?>
            <span class="num" data-goal="<?php echo $num_of_companies; ?>">0</span>
          </p>
        </div>
      </div>
    </div>
  </div>
  <!-- end stats -->
</div>
<!-- end dashboard page -->

