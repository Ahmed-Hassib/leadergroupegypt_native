<?php 
$is_contain_table = true;

$techCondition1 = "";
$techCondition2 = "";

// create an object of Combination
$comb_obj = new Combination();

if ($_SESSION['comb_show'] == 1 && $_SESSION['isTech'] == 1) {
  $techCondition1 = "AND `UserID` = " . $_SESSION['UserID'];
  $techCondition2 = "WHERE `UserID` = " . $_SESSION['UserID'];
} else {
  $techCondition1 = "";
  $techCondition2 = "";
}
?>
<!-- start home stats container -->
<div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
  <!-- start stats -->
  <div class="stats">
    <div class="mb-3 <?php if ($_SESSION['mal_add'] == 0) {echo 'd-none';} ?>">
      <a href="?do=add-new-combination" class="btn btn-outline-primary py-1 shadow-sm fs-12">
        <span class="bi bi-plus"></span>
        <?php echo language("ADD NEW COMBINATION", @$_SESSION['systemLang']) ?>
      </a>
    </div>
    <!-- start new design -->
    <div class="mb-3 row row-cols-sm-1 row-cols-md-2 g-3 align-items-stretch justify-content-start">
      <!-- combinations of today -->
      <div class="col-12">
        <div class="section-block">
          <header class="section-header">
            <h5 class="h5 text-capitalize"><?php echo language('COMBINATIONS TODAY', @$_SESSION['systemLang']) ?></h5>
            <p class="text-muted "><?php echo language('HERE WILL SHOW ALL STATISTICS ABOUT COMBINATIONS TODAY', @$_SESSION['systemLang']) ?></p>
            <hr>
          </header>
          <div class="row row-cols-sm-2 g-3">
            <div class="col-6">
              <div class="card card-stat bg-total bg-gradient">
                <div class="card-body">
                  <?php $all_comb_today = $comb_obj->count_records("`comb_id`", "`combinations`", "WHERE `added_date` = CURRENT_DATE AND `company_id` = ".$_SESSION['company_id'] ." $techCondition1") ?>
                  <h5 class="card-title text-capitalize"><?php echo language('TOTAL', @$_SESSION['systemLang']) ?></h5>
                  <span class="nums">
                    <a href="?do=show-combination-details&period=today&combStatus=-1" class="num stretched-link" data-goal="<?php echo $all_comb_today ?>">0</a>
                  </span>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="card card-stat bg-danger bg-gradient">
                <div class="card-body">
                  <?php $unfinished_comb_today = $comb_obj->count_records("`comb_id`", "`combinations`", "WHERE (`isFinished` = 0 AND `isAccepted` <> 2) AND added_date = CURRENT_DATE AND `company_id` = ".$_SESSION['company_id'] ." $techCondition1") ?>
                  <h5 class="card-title text-capitalize"><?php echo language('UNFINISHED', @$_SESSION['systemLang']) ?></h5>
                  <span class="nums">
                    <a href="?do=show-combination-details&period=today&combStatus=unfinished" class="num stretched-link" data-goal="<?php echo $unfinished_comb_today ?>">0</a>
                  </span>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="card card-stat bg-success bg-gradient">
                <div class="card-body">
                  <?php $finished_comb_today = $comb_obj->count_records("`comb_id`", "`combinations`", "WHERE `isFinished` = 1 AND added_date = CURRENT_DATE AND `company_id` = ".$_SESSION['company_id'] ." $techCondition1") ?>
                  <h5 class="card-title text-capitalize"><?php echo language('FINISHED', @$_SESSION['systemLang']) ?></h5>
                  <span class="nums">
                    <a href="?do=show-combination-details&period=today&combStatus=finished" class="num stretched-link" data-goal="<?php echo $finished_comb_today ?>">0</a>
                  </span>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="card card-stat bg-warning bg-gradient">
                <div class="card-body">
                  <?php $delayed_comb_today = $comb_obj->count_records("`comb_id`", "`combinations`", "WHERE (`isAccepted` = 2 OR `isFinished` = 2) AND added_date = CURRENT_DATE AND `company_id` = ".$_SESSION['company_id'] ." $techCondition1") ?>
                  <h5 class="card-title text-capitalize"><?php echo language('DELAYED', @$_SESSION['systemLang']) ?></h5>
                  <span class="nums">
                    <a href="?do=show-combination-details&period=today&accepted=delayed" class="num stretched-link" data-goal="<?php echo $delayed_comb_today ?>">0</a>
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- combinations of this month -->
      <div class="col-12">
        <div class="section-block">
          <header class="section-header">
            <h5 class="h5 text-capitalize"><?php echo language('COMBINATIONS OF THIS MONTH', @$_SESSION['systemLang']) ?></h5>
            <p class="text-muted "><?php echo language('HERE WILL SHOW ALL STATISTICS ABOUT COMBINATIONS OF THIS MONTH', @$_SESSION['systemLang']) ?></p>
            <hr>
          </header>
          <?php $startDate  = Date('Y-m-1'); ?>
          <?php $endDate    = Date('Y-m-31'); ?>        
          <div class="row row-cols-sm-2 g-3">
            <div class="col-6">
              <div class="card card-stat bg-total bg-gradient">
                <div class="card-body">
                  <?php $all_comb_month = $comb_obj->count_records("`comb_id`", "`combinations`", "WHERE `added_date` BETWEEN '".$startDate."' AND '".$endDate."' AND `company_id` = ".$_SESSION['company_id'] ." $techCondition1"); ?>
                  <h5 class="card-title text-capitalize"><?php echo language('TOTAL', @$_SESSION['systemLang']) ?></h5>
                  <span class="nums">
                    <a href="?do=show-combination-details&period=month&combStatus=-1" class="num stretched-link" data-goal="<?php echo $all_comb_month ?>">0</a>
                  </span>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="card card-stat bg-danger bg-gradient">
                <div class="card-body">
                  <?php $unfinished_comb_month = $comb_obj->count_records("`comb_id`", "`combinations`", "WHERE `added_date` BETWEEN '".$startDate."' AND '".$endDate."' AND `isFinished` = 0 AND `isAccepted` <> 2 AND `company_id` = ".$_SESSION['company_id'] ." $techCondition1"); ?>
                  <h5 class="card-title text-capitalize"><?php echo language('UNFINISHED', @$_SESSION['systemLang']) ?></h5>
                  <span class="nums">
                    <a href="?do=show-combination-details&period=month&combStatus=unfinished" class="num stretched-link" data-goal="<?php echo $unfinished_comb_month ?>">0</a>
                  </span>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="card card-stat bg-success bg-gradient">
                <div class="card-body">
                  <?php $finished_comb_month = $comb_obj->count_records("`comb_id`", "`combinations`", "WHERE `added_date` BETWEEN '".$startDate."' AND '".$endDate."' AND `isFinished` = 1 AND `company_id` = ".$_SESSION['company_id'] ." $techCondition1"); ?>
                  <h5 class="card-title text-capitalize"><?php echo language('FINISHED', @$_SESSION['systemLang']) ?></h5>
                  <span class="nums">
                    <a href="?do=show-combination-details&period=month&combStatus=finished" class="num stretched-link" data-goal="<?php echo $finished_comb_month ?>">0</a>
                  </span>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="card card-stat bg-warning bg-gradient">
                <div class="card-body">
                  <?php $delayed_comb_month = $comb_obj->count_records("`comb_id`", "`combinations`", "WHERE `added_date` BETWEEN '".$startDate."' AND '".$endDate."' AND (`isAccepted` = 2 OR `isFinished` = 2) AND `company_id` = ".$_SESSION['company_id'] ." $techCondition1"); ?>
                  <h5 class="card-title text-capitalize"><?php echo language('DELAYED', @$_SESSION['systemLang']) ?></h5>
                  <span class="nums">
                    <a href="?do=show-combination-details&period=month&accepted=delayed" class="num stretched-link" data-goal="<?php echo $delayed_comb_month ?>">0</a>
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- combinations of previous month -->
      <div class="col-12">
        <div class="section-block">
          <header class="section-header">
            <h5 class="h5 text-capitalize"><?php echo language('COMBINATIONS OF PREVIOUS MONTH', @$_SESSION['systemLang']) ?></h5>
            <p class="text-muted "><?php echo language('HERE WILL SHOW ALL STATISTICS ABOUT COMBINATIONS OF PREVIOUS MONTH', @$_SESSION['systemLang']) ?></p>
            <hr>
          </header>
          <?php
            // date of today
            $start = Date("Y-m-1");
            $end = Date("Y-m-30");
            // license period
            $period = ' - 1 months';
            $startDate = Date("Y-m-d", strtotime($start. $period));
            $endDate = Date("Y-m-d", strtotime($end. $period));
          ?>
          <div class="row row-cols-sm-2 g-3">
            <div class="col-6">
              <div class="card card-stat bg-total bg-gradient">
                <div class="card-body">
                  <?php $all_comb_prev_month = $comb_obj->count_records("`comb_id`", "`combinations`", "WHERE `added_date` BETWEEN '".$startDate."' AND '".$endDate."' AND `company_id` = ".$_SESSION['company_id'] ." $techCondition1"); ?>
                  <h5 class="card-title text-capitalize"><?php echo language('TOTAL', @$_SESSION['systemLang']) ?></h5>
                  <span class="nums">
                    <a href="?do=show-combination-details&period=previous-month&combStatus=-1" class="num stretched-link" data-goal="<?php echo $all_comb_prev_month ?>">0</a>
                  </span>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="card card-stat bg-danger bg-gradient">
                <div class="card-body">
                  <?php $unfinished_comb_prev_month = $comb_obj->count_records("`comb_id`", "`combinations`", "WHERE `added_date` BETWEEN '".$startDate."' AND '".$endDate."' AND `isFinished` = 0 AND `isAccepted` <> 2 AND `company_id` = ".$_SESSION['company_id'] ." $techCondition1"); ?>
                  <h5 class="card-title text-capitalize"><?php echo language('UNFINISHED', @$_SESSION['systemLang']) ?></h5>
                  <span class="nums">
                    <a href="?do=show-combination-details&period=previous-month&combStatus=unfinished" class="num stretched-link" data-goal="<?php echo $unfinished_comb_prev_month ?>">0</a>
                  </span>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="card card-stat bg-success bg-gradient">
                <div class="card-body">
                  <?php $finished_comb_prev_month = $comb_obj->count_records("`comb_id`", "`combinations`", "WHERE `added_date` BETWEEN '".$startDate."' AND '".$endDate."' AND `isFinished` = 1 AND `company_id` = ".$_SESSION['company_id'] ." $techCondition1"); ?>
                  <h5 class="card-title text-capitalize"><?php echo language('FINISHED', @$_SESSION['systemLang']) ?></h5>
                  <span class="nums">
                    <a href="?do=show-combination-details&period=previous-month&combStatus=finished" class="num stretched-link" data-goal="<?php echo $finished_comb_prev_month ?>">0</a>
                  </span>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="card card-stat bg-warning bg-gradient">
                <div class="card-body">
                  <?php $delayed_comb_prev_month = $comb_obj->count_records("`comb_id`", "`combinations`", "WHERE `added_date` BETWEEN '".$startDate."' AND '".$endDate."' AND (`isAccepted` = 2 OR `isFinished` = 2) AND `company_id` = ".$_SESSION['company_id'] ." $techCondition1"); ?>
                  <h5 class="card-title text-capitalize"><?php echo language('DELAYED', @$_SESSION['systemLang']) ?></h5>
                  <span class="nums">
                    <a href="?do=show-combination-details&period=previous-month&accepted=delayed" class="num stretched-link" data-goal="<?php echo $delayed_comb_prev_month ?>">0</a>
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- total combinations -->
      <div class="col-12">
        <div class="section-block">
          <header class="section-header">
            <h5 class="h5 text-capitalize"><?php echo language('TOTAL COMBINATIONS', @$_SESSION['systemLang']) ?></h5>
            <p class="text-muted "><?php echo language('HERE WILL SHOW ALL STATISTICS ABOUT COMBINATIONS OVERALL', @$_SESSION['systemLang']) ?></p>
            <hr>
          </header>
          <div class="row row-cols-sm-2 g-3">
            <div class="col-6">
              <div class="card card-stat bg-total bg-gradient">
                <div class="card-body">
                  <?php $all_comb = $comb_obj->count_records("`comb_id`", "`combinations`", "$techCondition2 " . (empty($techCondition2) ?  "WHERE `company_id` = ".$_SESSION['company_id'] :  "AND `company_id` = ".$_SESSION['company_id'] )); ?>
                  <h5 class="card-title text-capitalize"><?php echo language('TOTAL', @$_SESSION['systemLang']) ?></h5>
                  <span class="nums">
                    <a href="?do=show-combination-details" class="stretched-link num" data-goal="<?php echo $all_comb ?>">0</a>
                  </span>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="card card-stat bg-danger bg-gradient">
                <div class="card-body">
                  <?php $all_unfinished_comb = $comb_obj->count_records("`comb_id`", "`combinations`", "WHERE `isFinished` = 0 AND `isAccepted` <> 2 AND `company_id` = ".$_SESSION['company_id'] ." $techCondition1"); ?>
                  <h5 class="card-title text-capitalize"><?php echo language('UNFINISHED', @$_SESSION['systemLang']) ?></h5>
                  <span class="nums">
                    <a href="?do=show-combination-details&combStatus=unfinished" class="stretched-link num" data-goal="<?php echo $all_unfinished_comb ?>">0</a>
                  </span>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="card card-stat bg-success bg-gradient">
                <div class="card-body">
                  <?php $all_finished_comb = $comb_obj->count_records("`comb_id`", "`combinations`", "WHERE `isFinished` = 1 AND `company_id` = ".$_SESSION['company_id'] ." $techCondition1"); ?>
                  <h5 class="card-title text-capitalize"><?php echo language('FINISHED', @$_SESSION['systemLang']) ?></h5>
                  <span class="nums">
                    <a href="?do=show-combination-details&combStatus=finished" class="stretched-link num" data-goal="<?php echo $all_finished_comb ?>">0</a>
                  </span>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="card card-stat bg-warning bg-gradient">
                <div class="card-body">
                  <?php $all_delayed_comb = $comb_obj->count_records("`comb_id`", "`combinations`", "WHERE (`isAccepted` = 2 OR `isFinished` = 2) AND `company_id` = ".$_SESSION['company_id'] ." $techCondition1"); ?>
                  <h5 class="card-title text-capitalize"><?php echo language('DELAYED', @$_SESSION['systemLang']) ?></h5>
                  <span class="nums">
                    <a href="?do=show-combination-details&accepted=delayed" class="stretched-link num" data-goal="<?php echo $all_delayed_comb ?>">0</a>
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php if ($all_comb > 0) { ?>
    <div class="mb-3 row row-cols-sm-1 align-items-center-justify-content-center">
      <!-- combinations rating -->
      <div class="col-12">
        <div class="section-block">
          <header class="section-header">
            <h5 class="h5 text-capitalize"><?php echo language("COMBINATIONS RATING", @$_SESSION['systemLang']) ?></h5>
            <p class="text-muted "><?php echo language("COMBINATIONS RATING IS DEPENDING ON COMPARE BETWEEN REPAIRED, UNREPAIRED AND DELAYED AND ALL COMBINATIONS", @$_SESSION['systemLang']) ?></p>
            <hr>
          </header>
          <div class="row row-cols-sm-1 row-cols-md-2 row-cols-lg-3 align-items-center justify-content-center g-5">
            <div class="col-12">
              <?php $rep_rate = round(($all_finished_comb / $all_comb) * 100, 2); ?>
              <h5 class="card-title text-capitalize text-center">
                <?php echo language('FINISHED', @$_SESSION['systemLang']) ?>
                <div class="badge bg-success p-2 d-inline-block"></div>
              </h5>
              <div class="progress">
                <?php if ($rep_rate < 15) { ?>
                  <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo $rep_rate ?>%" aria-valuenow="<?php echo $rep_rate ?>" aria-valuemin="0" aria-valuemax="<?php echo $all_comb ?>"></div>
                  <div class="progress-value"><?php echo $rep_rate ?>%</div>
                  <?php } else { ?>
                    <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo $rep_rate ?>%" aria-valuenow="<?php echo $rep_rate ?>" aria-valuemin="0" aria-valuemax="<?php echo $all_comb ?>"><?php echo $rep_rate ?>%</div>
                <?php }?>
              </div>
            </div>
            <div class="col-12">
              <?php $unrep_rate = round(($all_unfinished_comb / $all_comb) * 100, 2); ?>
              <h5 class="card-title text-capitalize text-center">
                <?php echo language('UNFINISHED', @$_SESSION['systemLang']) ?>
                <div class="badge bg-danger p-2 d-inline-block"></div>
              </h5>
              <div class="progress">
                <?php if ($unrep_rate < 15) { ?>
                  <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo $unrep_rate ?>%" aria-valuenow="<?php echo $unrep_rate ?>" aria-valuemin="0" aria-valuemax="<?php echo $all_comb ?>"></div>
                  <div class="progress-value"><?php echo $unrep_rate ?>%</div>
                  <?php } else { ?>
                    <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo $unrep_rate ?>%" aria-valuenow="<?php echo $unrep_rate ?>" aria-valuemin="0" aria-valuemax="<?php echo $all_comb ?>"><?php echo $unrep_rate ?>%</div>
                <?php }?>
              </div>
            </div>
            <div class="col-12">
              <?php $del_rate = round(($all_delayed_comb / $all_comb) * 100, 2); ?>
              <h5 class="card-title text-capitalize text-center">
                <?php echo language('DELAYED', @$_SESSION['systemLang']) ?>
                <div class="badge bg-warning p-2 d-inline-block"></div>
              </h5>
              <div class="progress">
                <?php if ($del_rate < 15) { ?>
                  <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo $del_rate ?>%" aria-valuenow="<?php echo $del_rate ?>" aria-valuemin="0" aria-valuemax="<?php echo $all_comb ?>"></div>
                  <div class="progress-value"><?php echo $del_rate ?>%</div>
                  <?php } else { ?>
                    <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo $del_rate ?>%" aria-valuenow="<?php echo $del_rate ?>" aria-valuemin="0" aria-valuemax="<?php echo $all_comb ?>"><?php echo $del_rate ?>%</div>
                <?php }?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php } ?>

    <?php if ($all_comb_today > 0) { ?>
    <!-- some combinations of today -->
    <div class="mb-3 row row-cols-sm-1 align-items-center-justify-content-center">
      <div class="col-12">
        <div class="section-block">
          <header class="section-header">
            <h5 class="h5 text-capitalize"><?php echo language('SOME COMBINATIONS TODAY', @$_SESSION['systemLang']) ?></h5>
            <p class="text-muted "><?php echo language('HERE WILL SHOW LATEST 5 ADDED COMBINATIONS', @$_SESSION['systemLang']) ?></p>
            <hr>
          </header>
          <?php
          // get `combinations` of today of the cureent employee
          $today_comb = $comb_obj->select_specific_column("*", "`combinations`", "WHERE `added_date` = CURRENT_DATE AND `company_id` = ".$_SESSION['company_id'] . "  " . $techCondition1." ORDER BY `added_date` DESC LIMIT 5");
          ?>
          <div class="table-responsive-sm">
            <table class="table table-striped table-bordered  display compact w-100">
              <thead class="primary text-capitalize">
                <tr>
                  <th><?php echo language('CLIENT NAME', @$_SESSION['systemLang']) ?></th>
                  <!-- <th><?php echo language('THE ADDRESS', @$_SESSION['systemLang']) ?></th> -->
                  <!-- <th><?php echo language('PHONE', @$_SESSION['systemLang']) ?></th> -->
                  <th><?php echo language('TECHNICAL NAME', @$_SESSION['systemLang']) ?></th>
                  <th><?php echo language('STATUS', @$_SESSION['systemLang']) ?></th>
                  <th><?php echo language('TECH STATUS', @$_SESSION['systemLang']) ?></th>
                  <th><?php echo language('CONTROL', @$_SESSION['systemLang']) ?></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($today_comb as $index => $comb) { ?>
                  <tr>
                    <td style="width: 150px"><?php echo $comb['client_name'] ?></td>
                    <!-- <td style="width: 100px"><?php echo $comb['address'] ?></td> -->
                    <!-- <td style="width: 100px"><?php echo $comb['phone'] ?></td> -->
                    <td style="width: 100px">
                      <?php $techName = $comb_obj->select_specific_column("`UserName`", "`users`", "WHERE `UserID` = ".$comb['UserID'])[0]['UserName']; ?>
                      <a href="<?php echo $nav_up_level ?>users/index.php?do=edit-user-info&userid=<?php echo $comb['UserID'];?>"><?php echo $techName ?></a>
                    </td>
                    <td style="width: 50px">
                      <?php
                        if ($comb['isFinished'] == 0) {
                          $icon   = "bi-x-circle-fill text-danger";
                          $title  = language('UNFINISHED COMBINATION', @$_SESSION['systemLang']);
                        } elseif ($comb['isFinished'] == 1) {
                          $icon   = "bi-check-circle-fill text-success";
                          $title  = language('FINISHED COMBINATION', @$_SESSION['systemLang']);
                        } else {
                          $icon   = "bi-dash-circle-fill text-info";
                          $title  = language('NO STATUS', @$_SESSION['systemLang']);
                        }
                      ?>
                      <i class="bi <?php echo $icon ?>" title="<?php echo $title ?>"></i>
                    </td>
                    <td style="width: 50px">
                      <?php
                        if ($comb['isAccepted'] == 0) {
                          $iconStatus   = "bi-x-circle-fill text-danger";
                          $titleStatus  = language('NOT ACCEPTED', @$_SESSION['systemLang']);
                        } elseif ($comb['isAccepted'] == 1) {
                          $iconStatus   = "bi-check-circle-fill text-success";
                          $titleStatus  = language('ACCEPTED', @$_SESSION['systemLang']);
                        } elseif ($comb['isAccepted'] == 2) {
                          $iconStatus   = "bi-exclamation-circle-fill text-warning";
                          $titleStatus  = language('DELAYED COMBINATION', @$_SESSION['systemLang']);
                        } else {
                          $iconStatus   = "bi-dash-circle-fill text-info";
                          $titleStatus  = language('NO STATUS', @$_SESSION['systemLang']);
                        }
                      ?>
                      <i class="bi <?php echo $iconStatus ?>" title="<?php echo $titleStatus ?>"></i>
                    </td>
                    <td style="width: 50px">
                      <a href="?do=edit-combination&combid=<?php echo $comb['comb_id'] ?>" target="" class="btn btn-outline-primary me-1 fs-12 <?php if ($_SESSION['comb_show'] == 0) {echo 'disabled';} ?>"><i class="bi bi-eye"></i></a>
                      <button type="button" class="btn btn-outline-danger text-capitalize form-control bg-gradient fs-12 <?php if ($_SESSION['comb_delete'] == 0) {echo 'disabled';} ?>" data-bs-toggle="modal" data-bs-target="#deleteCombModal" id="delete-comb" data-comb-id="<?php echo $comb['comb_id'] ?>"><i class="bi bi-trash"></i></button>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <?php } ?>

    
    <?php
    // get latest added combinations of the cureent employee
    $latest_comb = $comb_obj->get_latest_records("*", "`combinations`", "$techCondition2 " . (empty($techCondition2) ?  "WHERE `company_id` = ".$_SESSION['company_id'] :  "AND `company_id` = ".$_SESSION['company_id'] ), "`added_date`");
    
    // check if array not empty
    if (!empty($latest_comb)) {
    ?>
    <div class="mb-3 row row-cols-sm-1 align-items-center-justify-content-center">
      <!-- latest added combinations -->
      <div class="col-12">
        <div class="section-block">
          <header class="section-header">
            <h5 class="h5 text-capitalize"><?php echo language('LATEST ADDED COMBINATIONS', @$_SESSION['systemLang']) ?></h5>
            <p class="text-muted "><?php echo language("HERE WILL SHOW LATEST 5 ADDED MALFUNCTIONS", @$_SESSION['systemLang']) ?></p>
            <hr>
          </header>
          <div class="table-responsive-sm">
            <table class="table table-striped table-bordered  display compact w-100">
              <thead class="primary text-capitalize">
                <tr>
                  <th><?php echo language('CLIENT NAME', @$_SESSION['systemLang']) ?></th>
                  <!-- <th><?php echo language('THE ADDRESS', @$_SESSION['systemLang']) ?></th> -->
                  <!-- <th><?php echo language('PHONE', @$_SESSION['systemLang']) ?></th> -->
                  <th><?php echo language('TECHNICAL NAME', @$_SESSION['systemLang']) ?></th>
                  <th><?php echo language('STATUS', @$_SESSION['systemLang']) ?></th>
                  <th><?php echo language('TECH STATUS', @$_SESSION['systemLang']) ?></th>
                  <th><?php echo language('CONTROL', @$_SESSION['systemLang']) ?></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($latest_comb as $index => $comb) { ?>
                  <tr>
                    <td style="width: 150px"><?php echo $comb['client_name'] ?></td>
                    <!-- <td style="width: 100px"><?php echo $comb['address'] ?></td> -->
                    <!-- <td style="width: 100px"><?php echo $comb['phone'] ?></td> -->
                    <td style="width: 100px">
                      <?php $techName = $comb_obj->select_specific_column("`UserName`", "`users`", "WHERE `UserID` = ".$comb['UserID'])[0]['UserName']; ?>
                      <a href="<?php echo $nav_up_level ?>users/index.php?do=edit-user-info&userid=<?php echo $comb['UserID'];?>"><?php echo $techName ?></a>
                    </td>
                    <td style="width: 50px">
                      <?php
                        if ($comb['isFinished'] == 0) {
                          $icon   = "bi-x-circle-fill text-danger";
                          $title  = language('UNFINISHED COMBINATION', @$_SESSION['systemLang']);
                        } elseif ($comb['isFinished'] == 1) {
                          $icon   = "bi-check-circle-fill text-success";
                          $title  = language('FINISHED COMBINATION', @$_SESSION['systemLang']);
                        } else {
                          $icon   = "bi-dash-circle-fill text-info";
                          $title  = language('NO STATUS', @$_SESSION['systemLang']);
                        }
                      ?>
                      <i class="bi <?php echo $icon ?>" title="<?php echo $title ?>"></i>
                    </td>
                    <td style="width: 50px">
                      <?php
                        if ($comb['isAccepted'] == 0) {
                          $iconStatus   = "bi-x-circle-fill text-danger";
                          $titleStatus  = language('NOT ACCEPTED', @$_SESSION['systemLang']);
                        } elseif ($comb['isAccepted'] == 1) {
                          $iconStatus   = "bi-check-circle-fill text-success";
                          $titleStatus  = language('ACCEPTED', @$_SESSION['systemLang']);
                        } elseif ($comb['isAccepted'] == 2) {
                          $iconStatus   = "bi-exclamation-circle-fill text-warning";
                          $titleStatus  = language('DELAYED COMBINATION', @$_SESSION['systemLang']);
                        } else {
                          $iconStatus   = "bi-dash-circle-fill text-info";
                          $titleStatus  = language('NO STATUS', @$_SESSION['systemLang']);
                        }
                      ?>
                      <i class="bi <?php echo $iconStatus ?>" title="<?php echo $titleStatus ?>"></i>
                    </td>
                    <td style="width: 50px">
                      <a href="?do=edit-combination&combid=<?php echo $comb['comb_id'] ?>" target="" class="btn btn-outline-primary me-1 fs-12 <?php if ($_SESSION['comb_show'] == 0) {echo 'disabled';} ?>"><i class="bi bi-eye"></i></a>
                      <button type="button" class="btn btn-outline-danger text-capitalize form-control bg-gradient fs-12 <?php if ($_SESSION['comb_delete'] == 0) {echo 'disabled';} ?>" data-bs-toggle="modal" data-bs-target="#deleteCombModal" id="delete-comb" data-comb-id="<?php echo $comb['comb_id'] ?>"><i class="bi bi-trash"></i></button>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <?php } ?>
    <!-- end new design -->
  </div>
  <!-- end stats -->
</div>
<!-- end home stats container -->

<?php include_once 'delete-combination-modal.php' ?>