<?php $db_obj = new Database("localhost", "jsl_db") ?>
<!-- start home stats container -->
<div class="container" dir="<?php # echo $page_dir ?>">
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
          <span
            class="bg-primary icon-container <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'icon-container-left' : 'icon-container-right' ?>">
            <i class="bi bi-patch-question"></i>
          </span>
          <p class="card-text">
            <span
              class="badge p-2 d-inline-block <?php echo $system_status == '0' ? 'bg-success' : 'bg-danger' ?>"></span>
            <?php echo $system_status == '0' ? lang('WORKING', $lang_file) : lang('UNDER DEVELOPING') ?>
          </p>
        </div>
      </div>

      <!-- number of companies -->
      <div class="card shadow-sm border border-1">
        <div class="card-body">
          <h5 class="card-title text-capitalize">
            <?php echo lang('#REGISTERED COMPANIES', $lang_file) ?>
          </h5>
          <span
            class="bg-primary icon-container <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'icon-container-left' : 'icon-container-right' ?>">
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