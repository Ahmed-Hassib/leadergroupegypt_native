<?php
// create an object of Combin class
$comb_obj = !isset($comb_obj) ? new Combination() : $comb_obj;
// period value
$period = isset($_GET['period']) && !empty($_GET['period']) ? $_GET['period'] : 'all';
// combStatus of combination
$combStatus = isset($_GET['combStatus']) && !empty($_GET['combStatus']) ? $_GET['combStatus'] : '-1';
// is accept status of combination
$accepted = isset($_GET['accepted']) && !empty($_GET['accepted']) ? $_GET['accepted'] : '-1';

// title
$title = "COMBS";

// base query
$baseQuery = "SELECT *FROM `combinations`";

// switch case to prepare the condition of the cobination
switch ($combStatus) {
  case 'unfinished':
    $title .= " UNFINISHED";
    $conditionStatus = "`isFinished` = 0 AND `isAccepted` <> 2";
    break;
  case 'finished':
    $title .= " FINISHED";
    $conditionStatus = "`isFinished` = 1";
    break;
  case 'delayed':
    $title .= " DELAYED";
    $conditionStatus = "`isAccepted` = 2 OR `isFinished` = 2";
    break;
  default:
    $conditionStatus = "";
}

// switch case to prepare the condition of the cobination
switch ($accepted) {
  case 'notAccepted':
    $title .= " NOT ACCEPTED";
    $acceptedStatus = "`isAccepted` = 0";
    break;
  case 'accepted':
    $title .= " ACCEPTED";
    $acceptedStatus = "`isAccepted` = 1";
    break;
  case 'delayed':
    $title .= " DELAYED";
    $acceptedStatus = "(`isAccepted` = 2 OR `isFinished` = 2)";
    break;
  default:
    $acceptedStatus = "";
}

// switch case to prepare period of the query
switch ($period) {
  case 'today':
    $title .= " TODAY";
    $conditionPeriod = " `added_date` = '" . get_date_now() . "'";
    break;
  case 'month':
    $title .= " MONTH";
    $conditionPeriod = " `added_date` BETWEEN '" . Date('Y-m-1') . "' AND '" . Date('Y-m-30') . "'";
    break;
  case 'previous-month':
    $title .= " PREV MONTH";
    // date of today
    $start = Date("Y-m-1");
    $end = Date("Y-m-30");
    // license period
    $period = ' - 1 months';
    $startDate = Date("Y-m-d", strtotime($start . $period));
    $endDate = Date("Y-m-d", strtotime($end . $period));
    // period condition
    $conditionPeriod = " `added_date` BETWEEN '$startDate' AND '$endDate'";
    break;
  default:
    $conditionPeriod = "";
}

// switch case for the logged user is tech or not
$userCondition = $_SESSION['sys']['isTech'] == 1 ? "`UserID` = " . base64_decode($_SESSION['sys']['UserID']) : "";

// check the combination status condition
if (!empty($conditionStatus)) {
  // append combination status condition
  $baseQuery .= ' WHERE ' . $conditionStatus;
  // check type of combinations
  if (!empty($acceptedStatus)) {
    $baseQuery .= ' AND ' . $acceptedStatus;
    // check the condition period
    if (!empty($conditionPeriod)) {
      $baseQuery .= ' AND ' . $conditionPeriod;
      // check user condition
      if (!empty($userCondition)) {
        $baseQuery .= ' AND ' . $userCondition;
      }
    } else {
      // check user condition
      if (!empty($userCondition)) {
        $baseQuery .= ' AND ' . $userCondition;
      }
    }
  } else {
    // check the condition period
    if (!empty($conditionPeriod)) {
      $baseQuery .= ' AND ' . $conditionPeriod;
      // check user condition
      if (!empty($userCondition)) {
        $baseQuery .= ' AND ' . $userCondition;
      }
    } else {
      // check user condition
      if (!empty($userCondition)) {
        $baseQuery .= ' AND ' . $userCondition;
      }
    }
  }
} else {
  // check type of combinations
  if (!empty($acceptedStatus)) {
    $baseQuery .= ' WHERE ' . $acceptedStatus;
    // check the condition period
    if (!empty($conditionPeriod)) {
      $baseQuery .= ' AND ' . $conditionPeriod;
      // check user condition
      if (!empty($userCondition)) {
        $baseQuery .= ' AND ' . $userCondition;
      }
    } else {
      // check user condition
      if (!empty($userCondition)) {
        $baseQuery .= ' AND ' . $userCondition;
      }
    }
  } else {
    // check the condition period
    if (!empty($conditionPeriod)) {
      $baseQuery .= ' WHERE ' . $conditionPeriod;
      // check user condition
      if (!empty($userCondition)) {
        $baseQuery .= ' AND ' . $userCondition;
      }
    } else {
      // check user condition
      if (!empty($userCondition)) {
        $baseQuery .= ' WHERE ' . $userCondition;
      }
    }
  }
}

// company condition
$company_condition = empty($conditionStatus) && empty($acceptedStatus) && empty($conditionPeriod) && empty($userCondition) ? ' WHERE `company_id` = ' . base64_decode($_SESSION['sys']['company_id']) . ' ORDER BY `added_date` ASC' : ' AND `company_id` = ' . base64_decode($_SESSION['sys']['company_id']) . ' ORDER BY `added_date` ASC';


// query
$combination_query = $baseQuery . $company_condition;

// prepaire the query
$stmt = $con->prepare($combination_query);
$stmt->execute(); // execute query
$rows = $stmt->fetchAll(); // fetch data
$count = $stmt->rowCount(); // get row count

?>
<!-- start edit profile page -->
<div class="container" dir="<?php echo $page_dir ?>">
  <?php if ($_SESSION['sys']['comb_add'] == 1) { ?>
    <div class="mb-3">
      <a href="?do=add-new-combination" class="btn btn-outline-primary py-1 shadow-sm fs-12">
        <span class="bi bi-plus"></span>
        <?php echo lang("ADD NEW", $lang_file) ?>
      </a>
    </div>
  <?php } ?>
  <!-- start header -->
  <header class="header mb-3">
    <h4 class="h4 text-capitalize">
      <?php echo lang($title, $lang_file); ?>
    </h4>
  </header>
</div>
<?php if ($count > 0) { ?>
  <div class="container" dir="<?php echo $page_dir ?>">
    <!-- start table container -->
    <div class="table-responsive-sm">
      <div class="fixed-scroll-btn">
        <!-- scroll left button -->
        <button type="button" role="button" class="scroll-button scroll-prev scroll-prev-right">
          <i class="carousel-control-prev-icon"></i>
        </button>
        <!-- scroll right button -->
        <button type="button" role="button"
          class="scroll-button scroll-next <?php echo $_SESSION['sys']['lang'] == 'ar' ? 'scroll-next-left' : 'scroll-next-right' ?>">
          <i class="carousel-control-next-icon"></i>
        </button>
      </div>
      <!-- strst users table -->
      <table class="table table-striped table-bordered display compact table-style" id="combinations">
        <thead class="primary text-capitalize">
          <tr>
            <th class="d-none">id</th>
            <th class="text-center" style="width: 20px">#</th>
            <th class="text-center">
              <?php echo lang('ADMIN NAME', $lang_file) ?>
            </th>
            <th class="text-center">
              <?php echo lang('TECH NAME', $lang_file) ?>
            </th>
            <th class="text-center">
              <?php echo lang('BENEFICIARY NAME', $lang_file) ?>
            </th>
            <th class="text-center">
              <?php echo lang('ADDR', $lang_file) ?>
            </th>
            <th class="text-center">
              <?php echo lang('PHONE', $lang_file) ?>
            </th>
            <th class="text-center">
              <?php echo lang('TECH COMMENT', $lang_file) ?>
            </th>
            <th class="text-center">
              <?php echo lang('STATUS', $lang_file) ?>
            </th>
            <th class="text-center">
              <?php echo lang('MEDIA', $lang_file) ?>
            </th>
            <th class="text-center">
              <?php echo lang('CONTROL') ?>
            </th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($rows as $index => $row) { ?>
            <tr>
              <td class="d-none">
                <?php echo $row['comb_id'] ?>
              </td>
              <td class="text-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                <?php echo ($index + 1) ?>
              </td>
              <!-- admin username -->
              <td>
                <?php
                // check if exist
                $is_exist_admin = $comb_obj->is_exist("`UserID`", "`users`", $row['addedBy']);
                // if exist
                if ($is_exist_admin) {
                  $admin_name = $comb_obj->select_specific_column("`UserName`", "`users`", "WHERE `UserID` = " . $row['addedBy'])[0]['UserName'];
                  ?>
                  <a
                    href="<?php echo $nav_up_level ?>users/index.php?do=edit-user-info&userid=<?php echo base64_encode($row['addedBy']); ?>">
                    <?php echo $admin_name ?>
                  </a>
                <?php } else { ?>
                  <span class="text-danger">
                    <?php echo lang('WAS DELETED', $lang_file) ?>
                  </span>
                <?php } ?>
              </td>
              <!-- technical username -->
              <td>
                <?php
                // check if exist
                $is_exist_tech = $comb_obj->is_exist("`UserID`", "`users`", $row['UserID']);
                // if exist
                if ($is_exist_tech) {
                  $tech_name = $comb_obj->select_specific_column("`UserName`", "`users`", "WHERE `UserID` = " . $row['UserID'])[0]['UserName']; ?>
                  <a
                    href="<?php echo $nav_up_level ?>users/index.php?do=edit-user-info&userid=<?php echo base64_encode($row['UserID']); ?>">
                    <?php echo $tech_name ?>
                  </a>
                <?php } else { ?>
                  <span class="text-danger">
                    <?php echo lang('WAS DELETED', $lang_file) ?>
                  </span>
                <?php } ?>
              </td>

              <td class="text-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                <?php echo $row['client_name'] ?>
              </td>
              <td class="text-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                <?php if (!empty($row['address'])) { ?>
                  <span>
                    <?php echo $row['address'] ?>
                  </span>
                <?php } else { ?>
                  <span class="text-danger">
                    <?php echo lang('NO DATA') ?>
                  </span>
                <?php } ?>
              </td>
              <td class="text-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                <?php if (!empty($row['phone'])) { ?>
                  <span>
                    <?php echo $row['phone'] ?>
                  </span>
                <?php } else { ?>
                  <span class="text-danger">
                    <?php echo lang('NO DATA') ?>
                  </span>
                <?php } ?>
              </td>
              <td
                class="text-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?> <?php echo empty($row['tech_comment']) ? 'text-danger ' : '' ?>">
                <?php if (!empty($row['tech_comment'])) { ?>
                  <span>
                    <?php echo $row['tech_comment'] ?>
                  </span>
                <?php } else { ?>
                  <span class="text-danger">
                    <?php echo lang('NO DATA') ?>
                  </span>
                <?php } ?>
              </td>
              <td class="text-center">
                <?php
                if ($row['isFinished'] == 0) {
                  $icon = "bi-x-circle-fill text-danger";
                  $title = lang('UNFINISHED', $lang_file);
                } elseif ($row['isFinished'] == 1) {
                  $icon = "bi-check-circle-fill text-success";
                  $title = lang('FINISHED', $lang_file);
                } else {
                  $icon = "bi-dash-circle-fill text-info";
                  $title = lang('NOT ASSIGNED');
                }
                ?>
                <i class="bi <?php echo $icon ?>" title="<?php echo $title ?>"></i>
              </td>
              <td style="min-width: 100px" class="text-center">
                <?php
                $have_media = $comb_obj->count_records("`id`", "`combinations_media`", "WHERE `comb_id` = " . $row['comb_id']);
                if ($have_media > 0) {
                  $icon = "bi-check-circle-fill text-success";
                  $title = lang('HAVE MEDIA', $lang_file);
                } else {
                  $icon = "bi-x-circle-fill text-danger";
                  $title = lang('NO MEDIA', $lang_file);
                }
                ?>
                <i class="bi <?php echo $icon ?>" title="<?php echo $title ?>"></i>
              </td>
              <td>
                <?php if ($_SESSION['sys']['comb_show'] == 1 || $_SESSION['sys']['comb_delete'] == 1) { ?>
                  <?php if ($_SESSION['sys']['comb_show'] == 1) { ?>
                    <a href="?do=edit-combination&combid=<?php echo base64_encode($row['comb_id']) ?>"
                      class="btn btn-outline-primary m-1 fs-12">
                      <i class="bi bi-eye"></i>
                      <?php echo lang('SHOW DETAILS') ?>
                    </a>
                  <?php } ?>
                  <?php if ($_SESSION['sys']['comb_delete'] == 1) { ?>
                    <button type="button" class="btn btn-outline-danger text-capitalize form-control bg-gradient fs-12"
                      data-bs-toggle="modal" data-bs-target="#deleteCombModal" id="delete-comb"
                      data-comb-id="<?php echo base64_encode($row['comb_id']) ?>"
                      onclick="put_comb_data_into_modal(this, true)">
                      <i class="bi bi-trash"></i>
                      <?php echo lang('DELETE') ?>
                    </button>
                  <?php } ?>
                <?php } ?>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
    <!-- delete combination modal -->
    <?php if ($_SESSION['sys']['comb_delete'] == 1) {
      include_once 'delete-combination-modal.php';
    } ?>
  </div>
<?php } else {
  // include no data founded module
  include_once $globmod . 'no-data-founded-no-redirect.php';
} ?>