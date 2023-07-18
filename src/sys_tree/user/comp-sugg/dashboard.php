<?php if (!isset($comp_sugg_obj)) {$comp_sugg_obj = new CompSugg(); } ?>
<!-- start home stats container -->
<div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
  <div class="stats">
    <!-- start new design -->
    <div class="mb-3 row row-cols-sm-2 row-cols-md-3 g-3 justify-content-sm-center">
      <div class="col-6">
        <div class="card card-stat bg-gradient">
          <div class="card-body">
            <span class="icon-container <?php echo @$_SESSION['systemLang'] == 'ar' ? 'icon-container-left' : 'icon-container-right' ?>"><i class="bi bi-journal-x"></i></span>
            <h5 class="h5 card-title text-uppercase"><?php echo language('THE COMPLAINTS', @$_SESSION['systemLang']) ?></h5>
          </div>
          <?php $start_date = Date('Y-m-1'); ?>
          <?php $end_date   = Date('Y-m-30'); ?>
          <?php $today_complaints = $comp_sugg_obj->count_records("`id`", "`comp_sugg`", "WHERE `type` = 0 AND `company_id` = " . $_SESSION['company_id'] . " AND `added_by` = " . $_SESSION['UserID']. " AND `added_date` = '".get_date_now()."'"); ?>
          <?php $month_complaints = $comp_sugg_obj->count_records("`id`", "`comp_sugg`", "WHERE `type` = 0 AND `company_id` = " . $_SESSION['company_id'] . " AND `added_by` = " . $_SESSION['UserID']. " AND `added_date` BETWEEN '$start_date' AND '$end_date' "); ?>
          <div class="card-footer text-dark fs-12">
            <div class="nums">
              <span><?php echo language('TODAY', @$_SESSION['systemLang']) ?>: </span>
              <span class="num" data-goal="0"><?php echo $today_complaints ?></span>
            </div>
            <div class="nums">
              <span><?php echo language('MONTH', @$_SESSION['systemLang']) ?>: </span>
              <span class="num" data-goal="0"><?php echo $month_complaints ?></span>
            </div>
          </div>
          <a href="?do=personal-comp-sugg&type=0" class="stretched-link"></a>
        </div>
      </div>
      <div class="col-6"> 
        <div class="card card-stat bg-gradient">
          <div class="card-body">
            <span class="icon-container <?php echo @$_SESSION['systemLang'] == 'ar' ? 'icon-container-left' : 'icon-container-right' ?>"><i class="bi bi-mailbox"></i></span>
            <h5 class="h5 card-title text-uppercase"><?php echo language('THE SUGGESTIONS', @$_SESSION['systemLang']) ?></h5>
          </div>
          <?php $start_date = Date('Y-m-1'); ?>
          <?php $end_date   = Date('Y-m-30'); ?>
          <?php $today_suggestions = $comp_sugg_obj->count_records("`id`", "`comp_sugg`", "WHERE `type` = 1 AND `company_id` = " . $_SESSION['company_id'] . " AND `added_by` = " . $_SESSION['UserID']. " AND `added_date` = '".get_date_now()."'"); ?>
          <?php $month_suggestions = $comp_sugg_obj->count_records("`id`", "`comp_sugg`", "WHERE `type` = 1 AND `company_id` = " . $_SESSION['company_id'] . " AND `added_by` = " . $_SESSION['UserID']. " AND `added_date` BETWEEN '$start_date' AND '$end_date' "); ?>
          <div class="card-footer text-dark fs-12">
            <div class="nums">
              <span><?php echo language('TODAY', @$_SESSION['systemLang']) ?>: </span>
              <span class="num" data-goal="0"><?php echo $today_suggestions ?></span>
            </div>
            <div class="nums">
              <span><?php echo language('MONTH', @$_SESSION['systemLang']) ?>: </span>
              <span class="num" data-goal="0"><?php echo $month_suggestions ?></span>
            </div>
          </div>
          <a href="?do=personal-comp-sugg&type=1" class="stretched-link text-capitalize"></a>
        </div>
        </div>
      </div>
    </div>
  </div>
</div>