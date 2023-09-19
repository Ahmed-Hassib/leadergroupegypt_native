<?php
// check if system write a log for login into system
if ($_SESSION['sys']['log'] == 0) {
  // log message
  $msg = "loginning to system";
  create_logs($_SESSION['sys']['UserName'], $msg);
  $_SESSION['sys']['log'] = 1;
}

// check if current user is technical man
if ($_SESSION['sys']['mal_show'] == 1 && $_SESSION['sys']['isTech'] == 1) {
  $techMalCondition = "AND `tech_id` = " . base64_decode($_SESSION['sys']['UserID']);
} else {
  $techMalCondition = "";
}

// check if current user is technical man
if ($_SESSION['sys']['comb_show'] == 1 && $_SESSION['sys']['isTech'] == 1) {
  $techCombCondition = "AND `UserID` = " . base64_decode($_SESSION['sys']['UserID']);
} else {
  $techCombCondition = "";
}
?>

<!-- start home stats container -->
<div class="container" dir="<?php echo $page_dir ?>">
  <!-- start stats -->
  <div class="stats">
    <?php $db_obj = !isset($db_obj) ? new Database() : $db_obj; ?>
    <?php
    // check system theme
    if ($_SESSION['sys']['system_theme'] == 2) {
      $card_class = 'card-effect';
      $card_position = @$_SESSION['sys']['lang'] == "ar" ? "card-effect-right" : "card-effect-left";
    }
    ?>
    <!-- start new design -->
    <div class="dashboard-content">
      <?php if ($_SESSION['sys']['user_show'] == 1) { ?>
        <div class="dashboard-card card card-stat <?php echo isset($card_class) ? $card_class : ''; ?> <?php echo isset($card_position) ? $card_position : ''; ?> bg-gradient">
          <div class="card-body">
            <span class="icon-container <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'icon-container-left' : 'icon-container-right' ?>"><i class="bi bi-people"></i></span>
            <span class="d-block">
              <a href="<?php echo $nav_up_level ?>users/index.php" class="stretched-link text-capitalize">
                <?php echo lang('EMPLOYEES') ?>
              </a>
            </span>
          </div>
          <?php $newEmpCounter = $db_obj->count_records("`UserID`", "`users`", "WHERE `joinedDate` = '" . get_date_now() . "' AND `company_id` = " . base64_decode($_SESSION['sys']['company_id'])); ?>
          <?php if ($newEmpCounter > 0) { ?>
            <div class="card-footer">
              <span class="badge bg-danger fs-12">
                <span><?php echo $newEmpCounter ?></span>
                <?php echo lang('NEW') ?>
              </span>
            </div>
          <?php } ?>
        </div>
      <?php } ?>
      <?php if ($_SESSION['sys']['dir_show'] == 1) { ?>
        <div class="dashboard-card card card-stat <?php echo isset($card_class) ? $card_class : ''; ?> <?php echo isset($card_position) ? $card_position : ''; ?> bg-gradient">
          <div class="card-body">
            <span class="icon-container <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'icon-container-left' : 'icon-container-right' ?>"><i class="bi bi-diagram-3"></i></span>
            <span>
              <a href="<?php echo $nav_up_level ?>directions/index.php" class="stretched-link text-capitalize">
                <?php echo lang('DIRECTIONS') ?>
              </a>
            </span>
          </div>
          <?php $newDirCounter = $db_obj->count_records("`direction_id`", "`direction`", "WHERE `added_date` = '" . get_date_now() . "' AND `company_id` = " . base64_decode($_SESSION['sys']['company_id'])); ?>
          <?php if ($newDirCounter > 0) { ?>
            <div class="card-footer">
              <span class="badge bg-danger fs-12">
                <?php echo $newDirCounter ?>
                <?php echo lang('NEW') ?>
              </span>
            </div>
          <?php } ?>
        </div>
      <?php } ?>
      <?php if ($_SESSION['sys']['pcs_show'] == 1) { ?>
        <div class="dashboard-card card card-stat <?php echo isset($card_class) ? $card_class : ''; ?> <?php echo isset($card_position) ? $card_position : ''; ?> bg-gradient">
          <div class="card-body">
            <span class="icon-container <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'icon-container-left' : 'icon-container-right' ?>"><i class="bi bi-hdd-rack"></i></span>
            <span>
              <a href="<?php echo $nav_up_level ?>pieces/index.php" class="stretched-link text-capitalize">
                <?php echo lang('PIECES') ?>
              </a>
            </span>
          </div>
          <?php $newPcsCounter = $db_obj->count_records("`id`", "`pieces_info`", "WHERE `is_client` = 0 AND `added_date` = '" . get_date_now() . "' AND `company_id` = " . base64_decode($_SESSION['sys']['company_id'])); ?>
          <?php if ($newPcsCounter > 0) { ?>
            <div class="card-footer">
              <span class="badge bg-danger fs-12">
                <?php echo $newPcsCounter ?>
                <?php echo lang('NEW') ?>
              </span>
            </div>
          <?php } ?>
        </div>
      <?php } ?>
      <?php if ($_SESSION['sys']['clients_show'] == 1) { ?>
        <div class="dashboard-card card card-stat <?php echo isset($card_class) ? $card_class : ''; ?> <?php echo isset($card_position) ? $card_position : ''; ?> bg-gradient">
          <div class="card-body">
            <span class="icon-container <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'icon-container-left' : 'icon-container-right' ?>"><i class="bi bi-people"></i></span>
            <span>
              <a href="<?php echo $nav_up_level ?>clients/index.php" class="stretched-link text-capitalize">
                <?php echo lang('CLIENTS') ?>
              </a>
            </span>
          </div>
          <?php $newClientsCounter = $db_obj->count_records("`id`", "`pieces_info`", "WHERE `is_client` = 1 AND `added_date` = '" . get_date_now() . "' AND `company_id` = " . base64_decode($_SESSION['sys']['company_id'])); ?>
          <?php if ($newClientsCounter > 0) { ?>
            <div class="card-footer">
              <span class="badge bg-danger fs-12">
                <?php echo $newClientsCounter ?>
                <?php echo lang('NEW') ?>
              </span>
            </div>
          <?php } ?>
        </div>
      <?php } ?>
      <?php if ($_SESSION['sys']['mal_show'] == 1) { ?>
        <div class="dashboard-card card card-stat <?php echo isset($card_class) ? $card_class . ' card-mal' : 'bg-danger'; ?> <?php echo isset($card_position) ? $card_position : ''; ?> bg-gradient">
          <div class="card-body">
            <span class="icon-container <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'icon-container-left' : 'icon-container-right' ?> bg-warning"><i class="bi bi-folder-x"></i></span>
            <span>
              <a href="<?php echo $nav_up_level ?>malfunctions/index.php" class="stretched-link text-capitalize">
                <?php echo lang('MALS') ?>
              </a>
            </span>
          </div>
          <?php $newMalCounter = $db_obj->count_records("`mal_id`", "`malfunctions`", "WHERE `added_date` = '" . get_date_now() . "' AND `mal_status` = 0 AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']) . " $techMalCondition"); ?>
          <?php if ($newMalCounter > 0) { ?>
            <div class="card-footer">
              <span class="badge bg-warning fs-12">
                <?php echo $newMalCounter ?>
                <?php echo lang('NEW') ?>
              </span>
            </div>
          <?php } ?>
        </div>
      <?php } ?>
      <?php if ($_SESSION['sys']['comb_show'] == 1) { ?>
        <div class="dashboard-card card card-stat <?php echo isset($card_class) ? $card_class . ' card-comb' : 'bg-success'; ?> <?php echo isset($card_position) ? $card_position : ''; ?> bg-gradient">
          <div class="card-body">
            <span class="icon-container <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'icon-container-left' : 'icon-container-right' ?> bg-warning"><i class="bi bi-terminal"></i></span>
            <span>
              <a href="<?php echo $nav_up_level ?>combinations/index.php" class="stretched-link text-capitalize">
                <?php echo lang('COMBS') ?>
              </a>
            </span>
          </div>
          <?php $newCombCounter = $db_obj->count_records("`comb_id`", "`combinations`", "WHERE `added_date` = '" . get_date_now() . "' AND `isFinished` = 0 AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']) . " $techCombCondition"); ?>
          <?php if ($newCombCounter > 0) { ?>
            <div class="card-footer">
              <span class="badge bg-warning fs-12">
                <?php echo $newCombCounter ?>
                <?php echo lang('NEW') ?>
              </span>
            </div>
          <?php } ?>
        </div>
      <?php } ?>
    </div>
  </div>
  <!-- end stats -->
</div>
<!-- end dashboard page -->