<?php
// create an object of Malfunction class
$mal_obj = !isset($mal_obj) ? new Malfunction() : $mal_obj;
// period value
$action = isset($_GET['period']) && !empty($_GET['period']) ? $_GET['period'] : 'all';
// malStatus of combination
$malStatus = isset($_GET['malStatus']) && !empty($_GET['malStatus']) ? $_GET['malStatus'] : '-1';
// is accept status of combination
$accepted = isset($_GET['accepted']) && !empty($_GET['accepted']) ? $_GET['accepted'] : '-1';

// title
$title = "MALS";

// base query
$baseQuery = "SELECT *FROM `malfunctions`";

// switch case to prepare the condition of the cobination
switch ($malStatus) {
  case 'unrepaired':
    $title .= " UNFINISHED";
    $conditionStatus = "`mal_status` = 0 AND `isAccepted` <> 2";
    break;
  case 'repaired':
    $title .= " FINISHED";
    $conditionStatus = "`mal_status` = 1";
    break;
  case 'delayed':
    $title .= " DELAYED";
    $conditionStatus = "(`mal_status` = 2 OR `isAccepted` = 2)";
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
    $acceptedStatus = "(`mal_status` = 2 OR `isAccepted` = 2)";
    break;
  default:
    $acceptedStatus = "";
}

// switch case to prepare period of the query
switch ($action) {
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

// check the logged user is tech or not
$userCondition = $_SESSION['sys']['isTech'] == 1 ? "`tech_id` = " . base64_decode($_SESSION['sys']['UserID']) : "";
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
$malfunction_query = $baseQuery . $company_condition;

// prepaire the query
$stmt = $con->prepare($malfunction_query);
$stmt->execute();               // execute query
$rows = $stmt->fetchAll();      // fetch data
$count = $stmt->rowCount();     // get row count
?>
<div class="container mb-0" dir="<?php echo $page_dir ?>">
  <?php if ($_SESSION['sys']['mal_add'] == 1) { ?>
    <div class="mb-3">
      <a href="?do=add-new-malfunction" class="btn btn-outline-primary py-1 fs-12 shadow-sm">
        <i class="bi bi-plus"></i>
        <?php echo lang('ADD NEW', $lang_file) ?>
      </a>
    </div>
  <?php } ?>
  <!-- start header -->
  <header class="header mb-3">
    <h4 class="h4 text-capitalize"><?php echo lang($title, $lang_file) ?></h4>
  </header>
</div>
<!-- start edit profile page -->
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
        <button type="button" role="button" class="scroll-button scroll-next <?php echo $_SESSION['sys']['lang'] == 'ar' ? 'scroll-next-left' : 'scroll-next-right' ?>">
          <i class="carousel-control-next-icon"></i>
        </button>
      </div>
      <!-- strst malfunctions table -->
      <table class="table table-striped table-bordered display compact table-style" id="malfunctions">
        <thead class="primary text-capitalize">
          <tr>
            <th class="text-center" style="width: 20px">#</th>
            <th class="text-center" style="width: 150px"><?php echo lang('ADMIN NAME', $lang_file) ?></th>
            <th class="text-center" style="width: 150px"><?php echo lang('TECH NAME', $lang_file) ?></th>
            <th class="text-center" style="width: 250px"><?php echo lang('NAME', $lang_file) ?></th>
            <th class="text-center" style="width: 200px"><?php echo lang('MAL DESC', $lang_file) ?></th>
            <th class="text-center" style="width: 200px"><?php echo lang('TECH COMMENT', $lang_file) ?></th>
            <th class="text-center" style="width: 100px"><?php echo lang('ADDED DATE') ?></th>
            <th class="text-center" style="width: 100px"><?php echo lang('ADDED TIME') ?></th>
            <th class="text-center" style="width: 50px"><?php echo lang('STATUS', $lang_file) ?></th>
            <th class="text-center" style="width: 150px"><?php echo lang('MEDIA', $lang_file) ?></th>
            <th class="text-center" style="width: 70px;"><?php echo lang('CONTROL') ?></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($rows as $index => $row) { ?>
            <tr>
              <!-- row index -->
              <td><?php echo ($index + 1) ?></td>
              <!-- admin username -->
              <td>
                <?php
                // check if exist
                $is_exist_admin = $mal_obj->is_exist("`UserID`", "`users`", $row['mng_id']);
                // if exist
                if ($is_exist_admin) {
                  $admin_name = $mal_obj->select_specific_column("`UserName`", "`users`", "WHERE `UserID` = " . $row['mng_id'])[0]['UserName'];
                ?>
                  <a href="<?php echo $nav_up_level ?>users/index.php?do=edit-user-info&userid=<?php echo base64_encode($row['mng_id']); ?>"><?php echo $admin_name ?></a>
                <?php } else { ?>
                  <span class="text-danger"><?php echo lang('WAS DELETED', $lang_file) ?></span>
                <?php } ?>
              </td>
              <!-- technical username -->
              <td>
                <?php
                // check if exist
                $is_exist_tech = $mal_obj->is_exist("`UserID`", "`users`", $row['tech_id']);
                // if exist
                if ($is_exist_tech) {
                  $tech_name = $mal_obj->select_specific_column("`UserName`", "`users`", "WHERE `UserID` = " . $row['tech_id'])[0]['UserName']; ?>
                  <a href="<?php echo $nav_up_level ?>users/index.php?do=edit-user-info&userid=<?php echo base64_encode($row['tech_id']); ?>"><?php echo $tech_name ?></a>
                <?php } else { ?>
                  <span class="text-danger"><?php echo lang('WAS DELETED', $lang_file) ?></span>
                <?php } ?>
              </td>
              <!-- piece/client name -->
              <td>
                <?php
                // check if exist
                $is_exist_device = $mal_obj->is_exist("`id`", "`pieces_info`", $row['client_id']);
                // if exist
                if ($is_exist_device) {
                  // get info
                  $info = $mal_obj->select_specific_column("`full_name`, `is_client`", "`pieces_info`", "WHERE `id` = " . $row['client_id'] . " LIMIT 1")[0];
                  // get name
                  $name = $info['full_name'];
                  // get type
                  $is_client = $info['is_client'];
                  // prepare url
                  if ($is_client == 1) {
                    $url = $nav_up_level . "clients/index.php?do=edit-client&client-id=" . base64_encode($row['client_id']);
                  } else {
                    $url = "?do=edit-piece&piece-id=" . base64_encode($row['client_id']);
                  }
                ?>
                  <a href="<?php echo $url ?>"><?php echo $name ?></a>
                <?php } else { ?>
                  <span class="text-danger"><?php echo lang('WAS DELETED', $lang_file) ?></span>
                <?php } ?>
              </td>
              <!-- malfunction description -->
              <td>
                <?php
                if (strlen($row['descreption']) > 0 && !empty($row['descreption'])) {
                  if (strlen($row['descreption']) > 40) {
                    echo trim(substr($row['descreption'], 0, 40), '') . "...";
                  } else {
                    echo $row['descreption'];
                  }
                } else { ?>
                  <span class="text-danger"><?php echo lang('NO DATA') ?></span>
                <?php } ?>
              </td>
              <!-- technical man comment -->
              <td class="<?php echo empty($row['tech_comment']) ? 'text-danger' : '' ?>">
                <?php if (!empty($row['tech_comment'])) {
                  if (strlen($row['tech_comment']) > 40) {
                    echo trim(substr($row['tech_comment'], 0, 40), '') . "...";
                  } else {
                    echo $row['tech_comment'];
                  }
                } else {
                  echo lang('NOT ASSIGNED');
                } ?>
              </td>
              <!-- added date -->
              <td class="text-center"><?php echo date_format(date_create($row['added_date']), "Y-m-d") ?></td>
              <!-- added time -->
              <td class="text-center"><?php echo date_format(date_create($row['added_time']), "h:i a") ?></td>
              <!-- malfunction status -->
              <td class="text-center">
                <?php
                if ($row['mal_status'] == 0) {
                  $iconStatus   = "bi-x-circle-fill text-danger";
                  $titleStatus  = lang('UNFINISHED', $lang_file);
                } elseif ($row['mal_status'] == 1) {
                  $iconStatus   = "bi-check-circle-fill text-success";
                  $titleStatus  = lang('FINISHED', $lang_file);
                } elseif ($row['mal_status'] == 2) {
                  $iconStatus   = "bi-exclamation-circle-fill text-warning";
                  $titleStatus  = lang('DELAYED', $lang_file);
                } else {
                  $iconStatus   = "bi-dash-circle-fill text-info";
                  $titleStatus  = lang('NOT ASSIGNED');
                }
                ?>
                <i class="bi <?php echo $iconStatus ?>" title="<?php echo $titleStatus ?>"></i>
              </td>
              <!-- malfunction media status -->
              <td style="width: 50px" class="text-center">
                <?php
                $have_media = $mal_obj->count_records("`id`", "`malfunctions_media`", "WHERE `mal_id` = " . $row['mal_id']);
                if ($have_media > 0) {
                  $icon   = "bi-check-circle-fill text-success";
                  $title = lang('HAVE MEDIA', $lang_file);
                } else {
                  $icon = "bi-x-circle-fill text-danger";
                  $title = lang('NO MEDIA', $lang_file);
                }
                ?>
                <i class="bi <?php echo $icon ?>" title="<?php echo $title ?>"></i>
              </td>
              <!-- control buttons -->
              <td class="text-center">
                <?php if ($_SESSION['sys']['mal_show'] == 1) { ?>
                  <a href="?do=edit-malfunction-info&malid=<?php echo base64_encode($row['mal_id']) ?>" target="" class="btn btn-outline-primary me-1 fs-12"><i class="bi bi-eye"></i></a>
                <?php } ?>
                <?php if ($_SESSION['sys']['comb_delete'] == 1) { ?>
                  <button type="button" class="btn btn-outline-danger text-capitalize form-control bg-gradient fs-12" data-bs-toggle="modal" data-bs-target="#delete-malfunction-modal" id="delete-mal" data-mal-id="<?php echo base64_encode($row['mal_id']) ?>" onclick="put_mal_data_into_modal(this, true)"><i class="bi bi-trash"></i></button>
                <?php } ?>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
  <!-- delete malfunction modal -->
  <?php if ($count > 0 && $_SESSION['sys']['mal_delete'] == 1) {
    include_once 'delete-malfunction-modal.php';
  } ?>
<?php } else {
  // include no data founded module
  include_once $globmod . 'no-data-founded-no-redirect.php';
} ?>