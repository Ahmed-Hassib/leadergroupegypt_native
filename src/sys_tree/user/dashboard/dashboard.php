<?php
  // check if system write a log for login into system
  if ($_SESSION['log'] == 0) {
    // log message
    $msg = "loginning to system";
    createLogs($_SESSION['UserName'], $msg);
    $_SESSION['log'] = 1;
  }

  // check if the current user is technical man
  if ($_SESSION['mal_show'] == 1 && $_SESSION['isTech'] == 1) {
    $techMalCondition = "AND `tech_id` = " . $_SESSION['UserID'];
  } else {
    $techMalCondition = "";
  }
  
  // check if the current user is technical man
  if ($_SESSION['comb_show'] == 1 && $_SESSION['isTech'] == 1) {
    $techCombCondition = "AND `UserID` = " . $_SESSION['UserID'];
  } else {
    $techCombCondition = "";
  }
?>

  <!-- start home stats container -->
  <div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
    <!-- start stats -->
    <div class="stats">
      <?php if ($_SESSION['isLicenseExpired'] == 0) { ?>
        <!-- check if application suspended or not -->
        <?php if ($isDeveloping) { ?>
          <div class="mb-3 row row-cols-md-3 g-3 justify-content-center">
            <div class="col">
              <div class="card card-stat bg-info py-4 px-1">
                <div class="card-body text-white">
                  <span class="" dir="<?php echo @$_SESSION['systemLang'] == "ar" ? "rtl" : "ltr"; ?>">
                    <i class="bi bi-info-circle-fill"></i>
                    <br>&nbsp;
                    <?php echo language("SORRY, THE APP IS SUSPENDED TODAY DUE TO DEVELOPMENT WORK", @$_SESSION['systemLang']) ?>
                  </span>
                </div>
              </div>
            </div>
          </div>
        <?php } else { ?>
          <?php 
            if (!isset($db_obj)) {
              $db_obj = new Database(); 
            }
          ?>
          <!-- start new design -->
          <div class="mb-3 row row-cols-sm-2 row-cols-md-3 row-cols-lg-4 gx-3 gy-5 justify-content-sm-center">
            <?php if ($_SESSION['user_show'] == 1) { ?>
            <div class="col-6 echo 'd-none';} ?>">
              <div class="card card-stat <?php if ($_SESSION['system_theme'] == 2) { echo 'card-effect '; echo @$_SESSION['systemLang'] == "ar" ? "card-effect-right":"card-effect-left"; } ?> bg-gradient">
                <div class="card-body">
                  <span class="icon-container <?php echo @$_SESSION['systemLang'] == 'ar' ? 'icon-container-left' : 'icon-container-right' ?>"><i class="bi bi-people"></i></span>
                  <span class="d-block">
                    <a href="<?php echo $nav_up_level ?>users/index.php" class="stretched-link text-capitalize">
                      <?php echo language('THE EMPLOYEES', @$_SESSION['systemLang']) ?>
                    </a>
                  </span>
                </div>
                <?php $newEmpCounter = $db_obj->count_records("`UserID`", "`users`", "WHERE `joinedDate` = '".get_date_now()."' AND `company_id` = ".$_SESSION['company_id']); ?>
                <?php if ($newEmpCounter > 0) { ?>
                  <div class="card-footer">
                    <span class="badge bg-danger fs-12">
                      <span><?php echo $newEmpCounter ?></span>
                      <?php echo language('NEW', @$_SESSION['systemLang']) ?>
                    </span>
                  </div>
                <?php } ?>
              </div>
            </div>
            <?php } ?>
            <?php if ($_SESSION['dir_show'] == 1) { ?>
            <div class="col-6 ">
              <div class="card card-stat <?php if ($_SESSION['system_theme'] == 2) { echo 'card-effect '; echo @$_SESSION['systemLang'] == "ar" ? "card-effect-right":"card-effect-left"; } ?> bg-gradient">
                <div class="card-body">
                  <span class="icon-container <?php echo @$_SESSION['systemLang'] == 'ar' ? 'icon-container-left' : 'icon-container-right' ?>"><i class="bi bi-diagram-3"></i></span>
                  <span>
                    <a href="<?php echo $nav_up_level ?>directions/index.php" class="stretched-link text-capitalize">
                      <?php echo language('THE DIRECTIONS', @$_SESSION['systemLang']) ?>
                    </a>
                  </span>
                </div>
                <?php $newDirCounter = $db_obj->count_records("`direction_id`", "`direction`", "WHERE `added_date` = '".get_date_now()."' AND `company_id` = ".$_SESSION['company_id']); ?>
                <?php if ($newDirCounter > 0) { ?>
                  <div class="card-footer">
                    <span class="badge bg-danger fs-12">
                      <?php echo $newDirCounter ?>
                      <?php echo language('NEW', @$_SESSION['systemLang']) ?>
                    </span>
                  </div>
                <?php } ?>
              </div>
            </div>
            <?php } ?>
            <?php if ($_SESSION['pcs_show'] == 1) { ?>
            <div class="col-6">
              <div class="card card-stat <?php if ($_SESSION['system_theme'] == 2) { echo 'card-effect '; echo @$_SESSION['systemLang'] == "ar" ? "card-effect-right":"card-effect-left"; } ?> bg-gradient">
                <div class="card-body">
                  <span class="icon-container <?php echo @$_SESSION['systemLang'] == 'ar' ? 'icon-container-left' : 'icon-container-right' ?>"><i class="bi bi-hdd-rack"></i></span>
                  <span>
                    <a href="<?php echo $nav_up_level ?>pieces/index.php" class="stretched-link text-capitalize">
                      <?php echo language('PIECES', @$_SESSION['systemLang']) ?>
                    </a>
                  </span>
                </div>
                <?php $newPcsCounter = $db_obj->count_records("`id`", "`pieces_info`", "WHERE `is_client` = 0 AND `added_date` = '".get_date_now()."' AND `company_id` = ".$_SESSION['company_id']); ?>
                <?php if ($newPcsCounter > 0) { ?>
                  <div class="card-footer">
                    <span class="badge bg-danger fs-12">
                      <?php echo $newPcsCounter ?>
                      <?php echo language('NEW', @$_SESSION['systemLang']) ?>
                    </span>
                  </div>
                <?php } ?>
              </div>
            </div>
            <?php } ?>
            <?php if ($_SESSION['clients_show'] == 1) { ?>
            <div class="col-6">
              <div class="card card-stat <?php if ($_SESSION['system_theme'] == 2) { echo 'card-effect '; echo @$_SESSION['systemLang'] == "ar" ? "card-effect-right":"card-effect-left"; } ?> bg-gradient">
                <div class="card-body">
                  <span class="icon-container <?php echo @$_SESSION['systemLang'] == 'ar' ? 'icon-container-left' : 'icon-container-right' ?>"><i class="bi bi-people"></i></span>
                  <span>
                    <a href="<?php echo $nav_up_level ?>clients/index.php" class="stretched-link text-capitalize">
                      <?php echo language('CLIENTS', @$_SESSION['systemLang']) ?>
                    </a>
                  </span>
                </div>
                <?php $newClientsCounter = $db_obj->count_records("`id`", "`pieces_info`", "WHERE `is_client` = 1 AND `added_date` = '".get_date_now()."' AND `company_id` = ".$_SESSION['company_id']); ?>
                <?php if ($newClientsCounter > 0) { ?>
                  <div class="card-footer">
                    <span class="badge bg-danger fs-12">
                      <?php echo $newClientsCounter ?>
                      <?php echo language('NEW', @$_SESSION['systemLang']) ?>
                    </span>
                  </div>
                <?php } ?>
              </div>
            </div>
            <?php } ?>
            <?php if ($_SESSION['mal_show'] == 1) { ?>
            <div class="col-6">
              <div class="card card-stat <?php if ($_SESSION['system_theme'] == 2) { echo 'card-mal card-effect '; echo @$_SESSION['systemLang'] == "ar" ? "card-effect-right":"card-effect-left"; } else { echo 'bg-danger';} ?> bg-gradient">
                <div class="card-body">
                  <span class="icon-container <?php echo @$_SESSION['systemLang'] == 'ar' ? 'icon-container-left' : 'icon-container-right' ?> bg-warning"><i class="bi bi-folder-x"></i></span>
                  <span>
                    <a href="<?php echo $nav_up_level ?>malfunctions/index.php" class="stretched-link text-capitalize">
                      <?php echo language('THE MALFUNCTIONS', @$_SESSION['systemLang']) ?>
                    </a>
                  </span>
                </div>
                <?php $newMalCounter = $db_obj->count_records("`mal_id`", "`malfunctions`", "WHERE `added_date` = '".get_date_now()."' AND `mal_status` = 0 AND `company_id` = ".$_SESSION['company_id'] . " $techMalCondition"); ?>
                <?php if ($newMalCounter > 0) { ?>
                  <div class="card-footer">
                    <span class="badge bg-warning fs-12">
                      <?php echo $newMalCounter ?>
                      <?php echo language('NEW', @$_SESSION['systemLang']) ?>
                    </span>
                  </div>
                <?php } ?>
              </div>
            </div>
            <?php } ?>
            <?php if ($_SESSION['comb_show'] == 1) { ?>
            <div class="col-6">
              <div class="card card-stat <?php if ($_SESSION['system_theme'] == 2) { echo 'card-comb card-effect '; echo @$_SESSION['systemLang'] == "ar" ? "card-effect-right":"card-effect-left"; } else { echo 'bg-success';} ?> bg-gradient">
                <div class="card-body">
                  <span class="icon-container <?php echo @$_SESSION['systemLang'] == 'ar' ? 'icon-container-left' : 'icon-container-right' ?> bg-warning"><i class="bi bi-terminal"></i></span>
                  <span>
                    <a href="<?php echo $nav_up_level ?>combinations/index.php" class="stretched-link text-capitalize">
                      <?php echo language('THE COMBINATIONS', @$_SESSION['systemLang']) ?>
                    </a>
                  </span>
                </div>
                <?php $newCombCounter = $db_obj->count_records("`comb_id`", "`combinations`", "WHERE `added_date` = '".get_date_now()."' AND `isFinished` = 0 AND `company_id` = ".$_SESSION['company_id'] . " $techCombCondition"); ?>
                <?php if ($newCombCounter > 0) { ?>
                  <div class="card-footer">
                    <span class="badge bg-warning fs-12">
                      <?php echo $newCombCounter ?>
                      <?php echo language('NEW', @$_SESSION['systemLang']) ?>
                    </span>
                  </div>
                <?php } ?>
              </div>
            </div>
            <?php } ?>
          </div>
        <?php } ?>
      <?php } else { ?>
        <div class="mb-3 row row-cols-md-3 g-3 justify-content-center">
          <div class="col">
            <div class="card bg-danger py-4 px-1">
              <div class="pt-0 card-body text-white">
                <span class="" dir="<?php echo @$_SESSION['systemLang'] == "ar" ? "rtl" : "ltr"; ?>">
                  <i class="bi bi-exclamation-triangle-fill" style="font-size: 3.5rem"></i>
                  <br>&nbsp;
                  <?php echo language("YOUR LICENSE HAD BEEN ENDED, PLEASE CALL THE TECHNICAL SUPPORT", @$_SESSION['systemLang']) ?>
                </span>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
    <!-- end stats -->
  </div>
  <!-- end dashboard page -->