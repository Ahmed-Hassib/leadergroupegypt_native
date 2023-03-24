
<?php
$is_contain_table = true;

$techCondition1 = "";
$techCondition2 = "";
// create an object of Malfunction class
$mal_obj = new Malfunction();

// check permissions
if ($_SESSION['mal_show'] == 1) {
  $techCondition1 = $_SESSION['isTech'] == 1 ? "AND `tech_id` = ".$_SESSION['UserID'] : "";
  $techCondition2 = $_SESSION['isTech'] == 1 ? "WHERE `tech_id` = ".$_SESSION['UserID'] : "";
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
      <a href="?do=addMalfunction" class="btn btn-outline-primary py-1 shadow-sm">
        <h6 class="h6 mb-0 text-center text-capitalize fs-12">
          <i class="bi bi-plus"></i>
          <?php echo language('ADD NEW MALFUNCTION', @$_SESSION['systemLang']) ?>
        </h6>
      </a>
    </div>
    <!-- start new design -->
    <div class="mb-3 row row-cols-sm-1 row-cols-md-2 g-3 align-items-stretch justify-content-start">
      <!-- malfunction of today section -->
      <div class="col-12">
        <div class="section-block">
          <header class="section-header">
            <h5 class="h5 text-capitalize"><?php echo language('MALFUNCTIONS TODAY', @$_SESSION['systemLang']) ?></h5>
            <p class="text-muted "><?php echo language("HERE WILL SHOW ALL STATISTICS ABOUT MALFUNCTIONS TODAY", @$_SESSION['systemLang']) ?></p>
            <hr>
          </header>
          <div class="row row-cols-sm-2 g-3">
            <div class="col-6">
              <div class="card card-stat bg-total bg-gradient">
                <?php $all_mal_today = $mal_obj->count_records("`mal_id`", "`malfunctions`", "WHERE `added_date` = CURRENT_DATE() AND `company_id` = ".$_SESSION['company_id'] ." $techCondition1") ?>
                <div class="card-body">
                  <h5 class="card-title text-capitalize"><?php echo language('TOTAL', @$_SESSION['systemLang']) ?></h5>
                  <span class="nums">
                    <a href="?do=showMalfunctionDetails&period=today&malStatus=all" class="num stretched-link" data-goal="<?php echo $all_mal_today; ?>">0</a>
                  </span>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="card card-stat bg-danger bg-gradient">
                <?php $unrep_mal_today = $mal_obj->count_records("`mal_id`", "`malfunctions`", "WHERE (`mal_status` = 0 AND `isAccepted` <> 2) AND `added_date` = CURRENT_DATE() AND `company_id` = ".$_SESSION['company_id'] ." $techCondition1") ?>
                <div class="card-body">
                  <h5 class="card-title text-capitalize"><?php echo language('UNREPAIRED', @$_SESSION['systemLang']) ?></h5>
                  <span class="nums">
                    <a href="?do=showMalfunctionDetails&period=today&malStatus=unrepaired" class="num stretched-link" data-goal="<?php echo $unrep_mal_today; ?>">0</a>
                  </span>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="card card-stat bg-success bg-gradient">
                <?php $rep_mal_today = $mal_obj->count_records("`mal_id`", "`malfunctions`", "WHERE `mal_status` = 1 AND `added_date` = CURRENT_DATE() AND `company_id` = ".$_SESSION['company_id'] ." $techCondition1") ?>
                <div class="card-body">
                  <h5 class="card-title text-capitalize"><?php echo language('REPAIRED', @$_SESSION['systemLang']) ?></h5>
                  <span class="nums">
                    <a href="?do=showMalfunctionDetails&period=today&malStatus=repaired" class="stretched-link num" data-goal="<?php echo $rep_mal_today ?>">0</a>
                  </span>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="card card-stat bg-warning bg-gradient">
                <?php $del_mal_today = $mal_obj->count_records("`mal_id`", "`malfunctions`", "WHERE (`mal_status` = 2 OR `isAccepted` = 2) AND `added_date` = CURRENT_DATE() AND `company_id` = ".$_SESSION['company_id'] ." $techCondition1") ?>
                <div class="card-body">
                  <h5 class="card-title text-capitalize"><?php echo language('DELAYED', @$_SESSION['systemLang']) ?></h5>
                  <span class="nums">
                    <a href="?do=showMalfunctionDetails&period=today&accepted=delayed" class="stretched-link num" data-goal="<?php echo $del_mal_today ?>">0</a>
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- malfunctions of this month -->
      <div class="col-12">
        <div class="section-block">
          <header class="section-header">
            <h5 class="h5 text-capitalize"><?php echo language("MALFUNCTIONS OF THIS MONTH", @$_SESSION['systemLang']) ?></h5>
            <p class="text-muted "><?php echo language("HERE WILL SHOW ALL STATISTICS ABOUT MALFUNCTIONS OF THIS MONTH", @$_SESSION['systemLang']) ?></p>
            <hr>
          </header>
          <?php
            $start_date  = Date('Y-m-1');
            $end_date    = Date('Y-m-30');
          ?>
          <div class="row row-cols-sm-2 g-3">
            <div class="col-6">
              <div class="card card-stat bg-total bg-gradient">
              <?php $all_mal_month = $mal_obj->count_records("`mal_id`", "`malfunctions`", "WHERE `added_date` BETWEEN '".$start_date."' AND '".$end_date."' AND `company_id` = ".$_SESSION['company_id'] ." $techCondition1"); ?>
                <div class="card-body">
                  <h5 class="card-title text-capitalize"><?php echo language('TOTAL', @$_SESSION['systemLang']) ?></h5>
                  <span class="nums">
                    <a href="?do=showMalfunctionDetails&period=month&malStatus=all" class="num stretched-link" data-goal="<?php echo $all_mal_month ?>">0</a>
                  </span>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="card card-stat bg-danger bg-gradient">
                <?php $unrep_mal_month = $mal_obj->count_records("`mal_id`", "`malfunctions`", "WHERE (`mal_status` = 0 AND `isAccepted` <> 2) AND `added_date` BETWEEN '".$start_date."' AND '".$end_date."' AND `company_id` = ".$_SESSION['company_id'] ." $techCondition1"); ?>
                <div class="card-body">
                  <h5 class="card-title text-capitalize"><?php echo language('UNREPAIRED', @$_SESSION['systemLang']) ?></h5>
                  <span class="nums">
                    <a href="?do=showMalfunctionDetails&period=month&malStatus=unrepaired" class="num stretched-link" data-goal="<?php echo $unrep_mal_month ?>">0</a>
                  </span>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="card card-stat bg-success bg-gradient">
                <?php $rep_mal_month = $mal_obj->count_records("`mal_id`", "`malfunctions`", "WHERE `mal_status` = 1 AND `added_date` BETWEEN '".$start_date."' AND '".$end_date."' AND `company_id` = ".$_SESSION['company_id'] ." $techCondition1"); ?>
                <div class="card-body">
                  <h5 class="card-title text-capitalize"><?php echo language('REPAIRED', @$_SESSION['systemLang']) ?></h5>
                  <span class="nums">
                    <a href="?do=showMalfunctionDetails&period=month&malStatus=repaired" class="num stretched-link" data-goal="<?php echo $rep_mal_month ?>">0</a>
                  </span>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="card card-stat bg-warning bg-gradient">
                <?php $del_mal_month = $mal_obj->count_records("`mal_id`", "`malfunctions`", "WHERE (`mal_status` = 2 OR `isAccepted` = 2) AND `added_date` BETWEEN '".$start_date."' AND '".$end_date."' AND `company_id` = ".$_SESSION['company_id'] ." $techCondition1"); ?>
                <div class="card-body">
                  <h5 class="card-title text-capitalize"><?php echo language('DELAYED', @$_SESSION['systemLang']) ?></h5>
                  <span class="nums">
                    <a href="?do=showMalfunctionDetails&period=month&accepted=delayed" class="num stretched-link" data-goal="<?php echo $del_mal_month ?>">0</a>
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- malfunctions of previous month -->
      <div class="col-12">
        <div class="section-block">
          <header class="section-header">
            <h5 class="h5 text-capitalize"><?php echo language("MALFUNCTIONS OF PREVIOUS MONTH", @$_SESSION['systemLang']) ?></h5>
            <p class="text-muted "><?php echo language("HERE WILL SHOW ALL STATISTICS ABOUT MALFUNCTIONS OF PREVIOUS MONTH", @$_SESSION['systemLang']) ?></p>
            <hr>
          </header>
          <?php
            // date of today
            $start = Date("Y-m-1");
            $end = Date("Y-m-30");
            // license period
            $period = ' - 1 months';
            $start_date = Date("Y-m-d", strtotime($start. $period));
            $end_date = Date("Y-m-d", strtotime($end. $period));
          ?>
          <div class="row row-cols-sm-2 g-3">
            <div class="col-6">
              <div class="card card-stat bg-total bg-gradient">
              <?php $all_prev_mal_month = $mal_obj->count_records("`mal_id`", "`malfunctions`", "WHERE `added_date` BETWEEN '".$start_date."' AND '".$end_date."' AND `company_id` = ".$_SESSION['company_id'] ." $techCondition1"); ?>
                <div class="card-body">
                  <h5 class="card-title text-capitalize"><?php echo language('TOTAL', @$_SESSION['systemLang']) ?></h5>
                  <span class="nums">
                    <a href="?do=showMalfunctionDetails&period=previous-month&malStatus=all" class="num stretched-link" data-goal="<?php echo $all_prev_mal_month ?>">0</a>
                  </span>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="card card-stat bg-danger bg-gradient">
                <?php $unrep_prev_month = $mal_obj->count_records("`mal_id`", "`malfunctions`", "WHERE (`mal_status` = 0 AND `isAccepted` <> 2) AND `added_date` BETWEEN '".$start_date."' AND '".$end_date."' AND `company_id` = ".$_SESSION['company_id'] ." $techCondition1"); ?>
                <div class="card-body">
                  <h5 class="card-title text-capitalize"><?php echo language('UNREPAIRED', @$_SESSION['systemLang']) ?></h5>
                  <span class="nums">
                    <a href="?do=showMalfunctionDetails&period=previous-month&malStatus=unrepaired" class="num stretched-link" data-goal="<?php echo $unrep_prev_month ?>">0</a>
                  </span>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="card card-stat bg-success bg-gradient">
                <?php $rep_prev_month = $mal_obj->count_records("`mal_id`", "`malfunctions`", "WHERE `mal_status` = 1 AND `added_date` BETWEEN '".$start_date."' AND '".$end_date."' AND `company_id` = ".$_SESSION['company_id'] ." $techCondition1"); ?>
                <div class="card-body">
                  <h5 class="card-title text-capitalize"><?php echo language('REPAIRED', @$_SESSION['systemLang']) ?></h5>
                  <span class="nums">
                    <a href="?do=showMalfunctionDetails&period=previous-month&malStatus=repaired" class="num stretched-link" data-goal="<?php echo $rep_prev_month ?>">0</a>
                  </span>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="card card-stat bg-warning bg-gradient">
                <?php $del_prev_month = $mal_obj->count_records("`mal_id`", "`malfunctions`", "WHERE (`mal_status` = 2 OR `isAccepted` = 2) AND `added_date` BETWEEN '".$start_date."' AND '".$end_date."' AND `company_id` = ".$_SESSION['company_id'] ." $techCondition1"); ?>
                <div class="card-body">
                  <h5 class="card-title text-capitalize"><?php echo language('DELAYED', @$_SESSION['systemLang']) ?></h5>
                  <span class="nums">
                    <a href="?do=showMalfunctionDetails&period=previous-month&accepted=delayed" class="num stretched-link" data-goal="<?php echo $del_prev_month ?>">0</a>
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- total malfunctions -->
      <div class="col-12">
        <div class="section-block">
          <header class="section-header">
            <h5 class="h5 text-capitalize"><?php echo language("TOTAL MALFUNCTIONS", @$_SESSION['systemLang']) ?></h5>
            <p class="text-muted "><?php echo language("HERE WILL SHOW ALL STATISTICS ABOUT MALFUNCTIONS OVERALL", @$_SESSION['systemLang']) ?></p>
            <hr>
          </header>
          <div class="row row-cols-sm-2 g-3">
            <div class="col-6">
              <div class="card card-stat bg-total bg-gradient">
                <?php $total_mal = $mal_obj->count_records("`mal_id`", "`malfunctions`", "$techCondition2 " . (empty($techCondition2) ? "WHERE `company_id` = ".$_SESSION['company_id'] : "AND `company_id` = ".$_SESSION['company_id'])) ?>
                <div class="card-body">
                  <h5 class="card-title text-capitalize"><?php echo language('TOTAL', @$_SESSION['systemLang']) ?></h5>
                  <span class="nums">
                    <a href="?do=showMalfunctionDetails&period=all&malStatus=all" class="num stretched-link" data-goal="<?php echo $total_mal ?>">0</a>
                  </span>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="card card-stat bg-danger bg-gradient">
                <?php $total_unrep_mal = $mal_obj->count_records("`mal_id`", "`malfunctions`", "WHERE (`mal_status` = 0 AND `isAccepted` <> 2) AND `company_id` = " . $_SESSION['company_id'] ." $techCondition1") ?>
                <div class="card-body">
                  <h5 class="card-title text-capitalize"><?php echo language('UNREPAIRED', @$_SESSION['systemLang']) ?></h5>
                  <span class="nums">
                    <a href="?do=showMalfunctionDetails&period=all&malStatus=unrepaired" class="num stretched-link" data-goal="<?php echo $total_unrep_mal ?>">0</a>
                  </span>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="card card-stat bg-success bg-gradient">
                <?php $total_rep_mal = $mal_obj->count_records("`mal_id`", "`malfunctions`", "WHERE `mal_status` = 1 AND `company_id` = ".$_SESSION['company_id'] ." $techCondition1") ?>
                <div class="card-body">
                  <h5 class="card-title text-capitalize"><?php echo language('REPAIRED', @$_SESSION['systemLang']) ?></h5>
                  <span class="nums">
                    <a href="?do=showMalfunctionDetails&period=all&malStatus=repaired" class="num stretched-link" data-goal="<?php echo $total_rep_mal ; ?>">0</a>
                  </span>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="card card-stat bg-warning bg-gradient">
                <?php $total_del_mal = $mal_obj->count_records("`mal_id`", "`malfunctions`", "WHERE (`mal_status` = 2 OR `isAccepted` = 2) AND `company_id` = ".$_SESSION['company_id'] ." $techCondition1") ?>
                <div class="card-body">
                  <h5 class="card-title text-capitalize"><?php echo language('DELAYED', @$_SESSION['systemLang']) ?></h5>
                  <span class="nums">
                    <a href="?do=showMalfunctionDetails&period=all&accepted=delayed" class="num stretched-link" data-goal="<?php echo $total_del_mal ; ?>">0</a>
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <?php if ($total_mal > 0) { ?>
    <div class="mb-3 row row-cols-sm-1 align-items-center-justify-content-center">
      <!-- total malfunctions -->
      <div class="col-12">
        <div class="section-block">
          <header class="section-header">
            <h5 class="h5 text-capitalize"><?php echo language("MALFUNCTIONS RATING", @$_SESSION['systemLang']) ?></h5>
            <p class="text-muted "><?php echo language("MALFUNCTIONS RATING IS DEPENDING ON COMPARE BETWEEN FINISHED, UNFINISHED AND DELAYED AND ALL MALFUNCTIONS", @$_SESSION['systemLang']) ?></p>
            <hr>
          </header>
          <div class="row row-cols-sm-1 row-cols-md-2 row-cols-lg-3 align-items-center justify-content-center g-5">
            <div class="col-12">
              <?php $rep_rate = round(($total_rep_mal / $total_mal) * 100, 2); ?>
              <h5 class="card-title text-capitalize text-center">
                <?php echo language('REPAIRED', @$_SESSION['systemLang']) ?>
                <div class="badge bg-success p-2 d-inline-block"></div>
              </h5>
              <div class="progress">
                <?php if ($rep_rate < 15) { ?>
                  <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo $rep_rate ?>%" aria-valuenow="<?php echo $rep_rate ?>" aria-valuemin="0" aria-valuemax="<?php echo $total_mal ?>"></div>
                  <div class="progress-value"><?php echo $rep_rate ?>%</div>
                  <?php } else { ?>
                    <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo $rep_rate ?>%" aria-valuenow="<?php echo $rep_rate ?>" aria-valuemin="0" aria-valuemax="<?php echo $total_mal ?>"><?php echo $rep_rate ?>%</div>
                <?php }?>
              </div>
            </div>
            <div class="col-12">
              <?php $unrep_rate = round(($total_unrep_mal / $total_mal) * 100, 2); ?>
              <h5 class="card-title text-capitalize text-center">
                <?php echo language('UNREPAIRED', @$_SESSION['systemLang']) ?>
                <div class="badge bg-danger p-2 d-inline-block"></div>
              </h5>
              <div class="progress">
                <?php if ($unrep_rate < 15) { ?>
                  <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo $unrep_rate ?>%" aria-valuenow="<?php echo $unrep_rate ?>" aria-valuemin="0" aria-valuemax="<?php echo $total_mal ?>"></div>
                  <div class="progress-value"><?php echo $unrep_rate ?>%</div>
                  <?php } else { ?>
                    <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo $unrep_rate ?>%" aria-valuenow="<?php echo $unrep_rate ?>" aria-valuemin="0" aria-valuemax="<?php echo $total_mal ?>"><?php echo $unrep_rate ?>%</div>
                <?php }?>
              </div>
            </div>
            <div class="col-12">
              <?php $del_rate = round(($total_del_mal / $total_mal) * 100, 2); ?>
              <h5 class="card-title text-capitalize text-center">
                <?php echo language('DELAYED', @$_SESSION['systemLang']) ?>
                <div class="badge bg-warning p-2 d-inline-block"></div>
              </h5>
              <div class="progress">
                <?php if ($del_rate < 15) { ?>
                  <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo $del_rate ?>%" aria-valuenow="<?php echo $del_rate ?>" aria-valuemin="0" aria-valuemax="<?php echo $total_mal ?>"></div>
                  <div class="progress-value"><?php echo $del_rate ?>%</div>
                  <?php } else { ?>
                    <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo $del_rate ?>%" aria-valuenow="<?php echo $del_rate ?>" aria-valuemin="0" aria-valuemax="<?php echo $total_mal ?>"><?php echo $del_rate ?>%</div>
                <?php }?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php } ?>
    
    <?php if ($all_mal_today > 0) { ?>
    <div class="mb-3 row">
      <div class="col-12">
        <div class="section-block">
          <header class="section-header">
            <h5 class="h5 text-capitalize"><?php echo language('SOME MALFUNCTIONS TODAY', @$_SESSION['systemLang']) ?></h5>
            <p class="text-muted "><?php echo language("HERE WILL SHOW LATEST 5 ADDED MALFUNCTIONS", @$_SESSION['systemLang']) ?></p>
            <hr>
          </header>
          <?php 
          // get malfunctions of today
          $todayMal = $mal_obj->select_specific_column("*", "`malfunctions`", "WHERE `added_date` = CURRENT_DATE AND `company_id` = ".$_SESSION['company_id'] ." $techCondition1 ORDER BY `added_time` DESC LIMIT 5");
          // check if array not empty
          if (!empty($todayMal)) {
            $index = 0;
          ?>
          <div class="table-responsive-sm">
            <table class="table table-bordered  display compact table-style w-100">
              <thead class="primary text-capitalize">
                <tr>
                  <th style="max-width: 50px;">#</th>
                  <th><?php echo language('PIECE/CLIENT NAME', @$_SESSION['systemLang']) ?></th>
                  <th><?php echo language('THE ADDRESS', @$_SESSION['systemLang']) ?></th>
                  <th><?php echo language('PHONE', @$_SESSION['systemLang']) ?></th>
                  <th><?php echo language('TECHNICAL NAME', @$_SESSION['systemLang']) ?></th>
                  <th><?php echo language('STATUS', @$_SESSION['systemLang']) ?></th>
                  <th><?php echo language('TECH STATUS', @$_SESSION['systemLang']) ?></th>
                  <th><?php echo language('CONTROL', @$_SESSION['systemLang']) ?></th>
                </tr>
              </thead>
              <tbody>
                <?php
                // loop on data
                foreach ($todayMal as $index => $mal) {
                  // get client info
                  $clientName     = $mal_obj->select_specific_column("`full_name`", "`pieces_info`", "WHERE `id` = ".$mal['client_id'])[0]['full_name'];
                  $clientAddr     = $mal_obj->select_specific_column("`address`", "`pieces_addr`", "WHERE `piece_id` = ".$mal['client_id']);
                  $clientPhone    = $mal_obj->select_specific_column("`phone`", "`pieces_phone`", "WHERE `piece_id` = ".$mal['client_id']);
                  $technicalName  = $mal_obj->select_specific_column("`UserName`", "`users`", "WHERE `UserID` = ".$mal['tech_id'])[0]['UserName'];
                ?>
                  <tr>
                    <td><?php echo ++$index; ?></td>
                    <td style="width: 100px">
                      <a href="<?php echo $nav_up_level ?>pieces/index.php?do=edit-piece&piece-id=<?php echo $mal['client_id'] ?>">
                        <?php echo !empty($clientName) ? $clientName : language('NO DATA ENTERED', @$_SESSION['systemLang']) ?>
                      </a>
                    </td>
                    <td style="width: 100px" class="<?php echo empty($clientAddr) ? 'text-danger ' : '' ?>"><?php echo !empty($clientAddr) ? $clientAddr[0]['address'] : language('NO DATA ENTERED', @$_SESSION['systemLang']) ?></td>
                    <td style="width: 100px" class="<?php echo empty($clientPhone) ? 'text-danger ' : '' ?>"><?php echo !empty($clientPhone) ? $clientPhone[0]['phone'] : language('NO DATA ENTERED', @$_SESSION['systemLang']) ?></td>
                    <td style="width: 100px">
                      <a href="<?php echo $nav_up_level ?>users/index.php?do=editUser&userid=<?php echo $mal['tech_id'] ?>">
                        <?php echo !empty($technicalName)   ? $technicalName    : language('NO DATA ENTERED', @$_SESSION['systemLang']) ?>
                      </a>
                    </td>
                    <td style="width: 50px">
                    <?php
                    if ($mal['mal_status'] == 0) {
                      $iconStatus   = "bi-x-circle-fill text-danger";
                      $titleStatus  = language('UNREPAIRED', @$_SESSION['systemLang']);
                    } elseif ($mal['mal_status'] == 1) {
                      $iconStatus   = "bi-check-circle-fill text-success";
                      $titleStatus  = language('REPAIRED', @$_SESSION['systemLang']);
                    } elseif ($mal['mal_status'] == 2) {
                      $iconStatus   = "bi-exclamation-circle-fill text-warning";
                      $titleStatus  = language('DELAYED', @$_SESSION['systemLang']);
                    } else {
                      $iconStatus   = "bi-dash-circle-fill text-info";
                      $titleStatus  = language('NO STATUS', @$_SESSION['systemLang']);
                    }
                    ?>
                    <i class="bi <?php echo $iconStatus ?>" title="<?php echo $titleStatus ?>"></i>
                    </td>
                    <td style="width: 50px">
                    <?php
                      if ($mal['isAccepted'] == 0) {
                        $iconStatus   = "bi-x-circle-fill text-danger";
                        $titleStatus  = language('NOT ACCEPTED', @$_SESSION['systemLang']);
                      } elseif ($mal['isAccepted'] == 1) {
                        $iconStatus   = "bi-check-circle-fill text-success";
                        $titleStatus  = language('ACCEPTED', @$_SESSION['systemLang']);
                      } elseif ($mal['isAccepted'] == 2) {
                        $iconStatus   = "bi-exclamation-circle-fill text-warning";
                        $titleStatus  = language('DELAYED', @$_SESSION['systemLang']);
                      } else {
                        $iconStatus   = "bi-dash-circle-fill text-info";
                        $titleStatus  = language('NO STATUS', @$_SESSION['systemLang']);
                      }
                    ?>
                    <i class="bi <?php echo $iconStatus ?>" title="<?php echo $titleStatus ?>"></i>
                    </td>
                    <td style="width: 50px">
                      <a href="?do=editMalfunction&malid=<?php echo $mal['mal_id'] ?>" target="" class="btn btn-outline-primary me-1 fs-12 <?php if ($_SESSION['mal_show'] == 0) {echo 'disabled';} ?>"><i class="bi bi-eye"></i></a>
                      <button type="button" class="btn btn-outline-danger text-capitalize form-control bg-gradient fs-12 <?php if ($_SESSION['comb_delete'] == 0) {echo 'disabled';} ?>" data-bs-toggle="modal" data-bs-target="#deleteMalModal" id="delete-mal" data-mal-id="<?php echo $mal['mal_id'] ?>"><i class="bi bi-trash"></i></button>
                    </td>
                  </tr>

                <?php } ?>
              </tbody>
            </table>
          </div>
          <?php } else { ?>
            <h5 class="h5 text-danger text-capitalize "><?php echo language('THERE IS NO MALFUNCTIONS TO SHOW', @$_SESSION['systemLang']) ?></h5>
          <?php } ?>
        </div>
      </div>
    </div>
    <?php } ?>

    <?php 
      // get malfunctions of today
      $latestMal = $mal_obj->select_specific_column("*", "`malfunctions`", "WHERE `company_id` = ".$_SESSION['company_id'] ." $techCondition1 ORDER BY `added_time` DESC LIMIT 5");
      // check if array not empty
      if (!empty($latestMal)) {
    ?>
    <div class="mb-3 row">
      <div class="col-12">
        <div class="section-block">
          <header class="section-header">
            <h5 class="h5 text-capitalize"><?php echo language('LATEST ADDED MALFUNCTIONS', @$_SESSION['systemLang']) ?></h5>
            <p class="text-muted "><?php echo language("HERE WILL SHOW LATEST 5 ADDED MALFUNCTIONS", @$_SESSION['systemLang']) ?></p>
            <hr>
          </header>
          <div class="table-responsive-sm">
            <table class="table table-bordered  display compact table-style w-100" id="latest-mal">
              <thead class="primary text-capitalize">
                <tr>
                  <th><?php echo language('PIECE/CLIENT NAME', @$_SESSION['systemLang']) ?></th>
                  <th><?php echo language('THE ADDRESS', @$_SESSION['systemLang']) ?></th>
                  <th><?php echo language('PHONE', @$_SESSION['systemLang']) ?></th>
                  <th><?php echo language('TECHNICAL NAME', @$_SESSION['systemLang']) ?></th>
                  <th><?php echo language('STATUS', @$_SESSION['systemLang']) ?></th>
                  <th><?php echo language('TECH STATUS', @$_SESSION['systemLang']) ?></th>
                  <th><?php echo language('CONTROL', @$_SESSION['systemLang']) ?></th>
                </tr>
              </thead>
              <tbody>
                <?php
                // loop on data
                foreach ($latestMal as $index => $mal) {
                  // get client info
                  $clientName     = $mal_obj->select_specific_column("`full_name`", "`pieces_info`", "WHERE `id` = ".$mal['client_id'])[0]['full_name'];
                  $clientAddr     = $mal_obj->select_specific_column("`address`", "`pieces_addr`", "WHERE `piece_id` = ".$mal['client_id']);
                  $clientPhone    = $mal_obj->select_specific_column("`phone`", "`pieces_phone`", "WHERE `piece_id` = ".$mal['client_id']);
                  $technicalName  = $mal_obj->select_specific_column("`UserName`", "`users`", "WHERE `UserID` = ".$mal['tech_id'])[0]['UserName'];
                ?>
                  <tr>
                    <td style="width: 150px">
                      <a href="<?php echo $nav_up_level ?>pieces/index.php?do=edit-piece&piece-id=<?php echo $mal['client_id'] ?>">
                        <?php echo !empty($clientName) ? $clientName : language('NO DATA ENTERED', @$_SESSION['systemLang']) ?>
                      </a>
                    </td>
                    <td style="width: 200px" class="<?php echo empty($clientAddr) ? 'text-danger ' : '' ?>"><?php echo !empty($clientAddr) ? $clientAddr[0]['address'] : language('NO DATA ENTERED', @$_SESSION['systemLang']) ?></td>
                    <td style="width: 100px" class="<?php echo empty($clientPhone) ? 'text-danger ' : '' ?>"><?php echo !empty($clientPhone) ? $clientPhone[0]['phone'] : language('NO DATA ENTERED', @$_SESSION['systemLang']) ?></td>
                    <td style="width: 50px">
                      <a href="<?php echo $nav_up_level ?>users/index.php?do=editUser&userid=<?php echo $mal['tech_id'] ?>">
                        <?php echo !empty($technicalName)   ? $technicalName    : language('NO DATA ENTERED', @$_SESSION['systemLang']) ?>
                      </a>
                    </td>
                    <td style="width: 25px">
                    <?php
                    if ($mal['mal_status'] == 0) {
                      $iconStatus   = "bi-x-circle-fill text-danger";
                      $titleStatus  = language('UNREPAIRED', @$_SESSION['systemLang']);
                    } elseif ($mal['mal_status'] == 1) {
                      $iconStatus   = "bi-check-circle-fill text-success";
                      $titleStatus  = language('REPAIRED', @$_SESSION['systemLang']);
                    } elseif ($mal['mal_status'] == 2) {
                      $iconStatus   = "bi-exclamation-circle-fill text-warning";
                      $titleStatus  = language('DELAYED', @$_SESSION['systemLang']);
                    } else {
                      $iconStatus   = "bi-dash-circle-fill text-info";
                      $titleStatus  = language('NO STATUS', @$_SESSION['systemLang']);
                    }
                    ?>
                    <i class="bi <?php echo $iconStatus ?>" title="<?php echo $titleStatus ?>"></i>
                    </td>
                    <td style="width: 25px">
                    <?php
                      if ($mal['isAccepted'] == 0) {
                        $iconStatus   = "bi-x-circle-fill text-danger";
                        $titleStatus  = language('NOT ACCEPTED', @$_SESSION['systemLang']);
                      } elseif ($mal['isAccepted'] == 1) {
                        $iconStatus   = "bi-check-circle-fill text-success";
                        $titleStatus  = language('ACCEPTED', @$_SESSION['systemLang']);
                      } elseif ($mal['isAccepted'] == 2) {
                        $iconStatus   = "bi-exclamation-circle-fill text-warning";
                        $titleStatus  = language('DELAYED', @$_SESSION['systemLang']);
                      } else {
                        $iconStatus   = "bi-dash-circle-fill text-info";
                        $titleStatus  = language('NO STATUS', @$_SESSION['systemLang']);
                      }
                    ?>
                    <i class="bi <?php echo $iconStatus ?>" title="<?php echo $titleStatus ?>"></i>
                    </td>
                    <td style="width: 50px">
                      <a href="?do=editMalfunction&malid=<?php echo $mal['mal_id'] ?>" target="" class="btn btn-outline-primary me-1 fs-12 <?php if ($_SESSION['mal_show'] == 0) {echo 'disabled';} ?>"><i class="bi bi-eye"></i></a>
                      <button type="button" class="btn btn-outline-danger text-capitalize form-control bg-gradient fs-12 <?php if ($_SESSION['comb_delete'] == 0) {echo 'disabled';} ?>" data-bs-toggle="modal" data-bs-target="#deleteMalModal" id="delete-mal" data-mal-id="<?php echo $mal['mal_id'] ?>"><i class="bi bi-trash"></i></button>
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

<!-- delete malfunction modal -->
<?php include_once 'delete-malfunction-modal.php' ?>