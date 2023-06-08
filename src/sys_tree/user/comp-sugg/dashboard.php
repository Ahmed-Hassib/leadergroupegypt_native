<!-- start home stats container -->
<div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
  <!-- start new design -->
  <div class="mb-3 row row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3 justify-content-sm-center">
    <div class="col-6">
      <div class="card card-stat bg-gradient">
        <div class="card-body">
          <span class="icon-container <?php echo @$_SESSION['systemLang'] == 'ar' ? 'icon-container-left' : 'icon-container-right' ?>"><i class="bi bi-people"></i></span>
          <span>
            <a href="<?php echo $nav_up_level ?>users/index.php" class="stretched-link text-capitalize">
              <?php echo language('THE EMPLOYEES', @$_SESSION['systemLang']) ?>
            </a>
          </span>
        </div>
        <?php $newEmpCounter = $db_obj->count_records("`UserID`", "`users`", "WHERE `joinedDate` = '".get_date_now()."' AND `company_id` = ".$_SESSION['company_id']); ?>
        <?php if ($newEmpCounter > 0) { ?>
          <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill border border-light bg-danger">
            <span><?php echo $newEmpCounter ?></span>
          </span>
        <?php } ?>
      </div>
    </div>
    <div class="col-6 <?php if ($_SESSION['dir_show'] == 0) {echo 'd-none';} ?>">
      <div class="card card-stat bg-gradient">
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
          <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill border border-light bg-danger">
            <span><?php echo $newDirCounter ?></span>
          </span>
        <?php } ?>
      </div>
    </div>
  </div>
</div>