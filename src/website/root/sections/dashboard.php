<?php $sec_obj = isset($sec_obj) ? $sec_obj : new Section(); ?>
<div class="container page-container" dir="<?php echo $page_dir ?>">
  <div class="dashboard-buttons">
    <a href="?do=add-new" class="btn btn-outline-primary py-1">
      <i class="bi bi-plus"></i>
      <span><?php echo lang('ADD NEW', $lang_file) ?></span>
    </a>
  </div>
  <div class="dashboard-content stats">
    <div class="dashboard-card card <?php echo isset($card_class) ? $card_class : ''; ?> <?php echo isset($card_position) ? $card_position : ''; ?> bg-gradient">
      <div class="card-body">
        <span class="icon-container <?php echo @$_SESSION['website']['lang'] == 'ar' ? 'icon-container-left' : 'icon-container-right' ?> nums">
          <?php $sec = $sec_obj->count_records("`id`", "`website_sections`", ""); ?>
          <span class="num" data-goal="<?php echo $sec ?>">0</span>
        </span>
        <span class="d-block">
          <?php echo lang('#SEC', $lang_file) ?>
        </span>
      </div>
    </div>
    <div class="dashboard-card card <?php echo isset($card_class) ? $card_class : ''; ?> <?php echo isset($card_position) ? $card_position : ''; ?> bg-gradient">
      <div class="card-body">
        <span class="icon-container bg-success <?php echo @$_SESSION['website']['lang'] == 'ar' ? 'icon-container-left' : 'icon-container-right' ?> nums">
          <?php $active_sec = $sec_obj->count_records("`id`", "`website_sections`", "WHERE `is_active` = 1"); ?>
          <span class="num" data-goal="<?php echo $active_sec ?>">0</span>
        </span>
        <span class="d-block">
          <?php echo lang('ACTIVE') ?>
        </span>
      </div>
    </div>
    <div class="dashboard-card card <?php echo isset($card_class) ? $card_class : ''; ?> <?php echo isset($card_position) ? $card_position : ''; ?> bg-gradient">
      <div class="card-body">
        <span class="icon-container bg-danger <?php echo @$_SESSION['website']['lang'] == 'ar' ? 'icon-container-left' : 'icon-container-right' ?> nums">
          <?php $inactive_sec = $sec_obj->count_records("`id`", "`website_sections`", "WHERE `is_active` = 0"); ?>
          <span class="num" data-goal="<?php echo $inactive_sec ?>">0</span>
        </span>
        <span class="d-block">
          <?php echo lang('INACTIVE') ?>
        </span>
      </div>
    </div>
  </div>
</div>
</div>