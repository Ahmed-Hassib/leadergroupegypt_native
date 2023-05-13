<?php
$is_contain_table = true;
// create an object of Malfunction class
$mal_obj = new Malfunction();
// period value
$action = isset($_GET['period']) && !empty($_GET['period']) ? $_GET['period'] : 'all';
// malStatus of combination
$malStatus = isset($_GET['malStatus']) && !empty($_GET['malStatus']) ? $_GET['malStatus'] : '-1';
// is accept status of combination
$accepted = isset($_GET['accepted']) && !empty($_GET['accepted']) ? $_GET['accepted'] : '-1';

// title
$title = "SHOW ALL";

// base query
$baseQuery = "SELECT *FROM `malfunctions`";

// switch case to prepare the condition of the cobination
switch($malStatus) {
  case 'unrepaired':
    $title .= " UNREPAIRED";
    $conditionStatus = "`mal_status` = 0 AND `isAccepted` <> 2";
    break;
  case 'repaired':
    $title .= " REPAIRED";
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
switch($accepted) {
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

$title .= " MALFUNCTIONS";

// switch case to prepare period of the query
switch($action) {
  case 'today':
    $title .= " OF TODAY";
    $conditionPeriod = " `added_date` = CURRENT_DATE";
    break;
  case 'month':
    $title .= " OF THIS MONTH";
    $conditionPeriod = " `added_date` BETWEEN '".Date('Y-m-1')."' AND '".Date('Y-m-30')."'";
    break;
  case 'previous-month':
    $title .= " OF PREVIOUS MONTH";
    // date of today
    $start = Date("Y-m-1");
    $end = Date("Y-m-30");
    // license period
    $period = ' - 1 months';
    $startDate = Date("Y-m-d", strtotime($start. $period));
    $endDate = Date("Y-m-d", strtotime($end. $period));
    // period condition
    $conditionPeriod = " `added_date` BETWEEN '$startDate' AND '$endDate'";
    break;
  default:
    $conditionPeriod = "";
}

// check the logged user is tech or not
$userCondition = $_SESSION['isTech'] == 1 ? "`tech_id` = ".$_SESSION['UserID'] : "";
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
$company_condition = empty($conditionStatus) && empty($acceptedStatus) && empty($conditionPeriod) && empty($userCondition) ? ' WHERE `company_id` = '. $_SESSION['company_id'] .' ORDER BY `added_date` ASC' : ' AND `company_id` = '. $_SESSION['company_id'] .' ORDER BY `added_date` ASC';

// query
$malfunction_query = $baseQuery . $company_condition;

// prepaire the query
$stmt = $con->prepare($malfunction_query);
$stmt->execute();               // execute query
$rows = $stmt->fetchAll();      // fetch data
$count = $stmt->rowCount();     // get row count
?>
<div class="container mb-0" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
  <div class="mb-3 <?php if ($_SESSION['mal_add'] == 0) {echo 'd-none';} ?>">
    <a href="?do=add-new-malfunction" class="btn btn-outline-primary py-1 shadow-sm">
      <h6 class="h6 mb-0 text-center text-capitalize fs-12">
        <i class="bi bi-plus"></i>
        <?php echo language('ADD NEW MALFUNCTION', @$_SESSION['systemLang']) ?>
      </h6>
    </a>
  </div>
  <!-- start header -->
  <header class="header mb-3">
    <h4 class="h4 text-capitalize"><?php echo language($title, @$_SESSION['systemLang']) ?></h4>
  </header>
</div>
<!-- start edit profile page -->
<?php if ($count > 0) { ?>
<div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
  <!-- start table container -->
  <div class="table-responsive-sm">
    <div class="fixed-scroll-btn">
      <!-- scroll left button -->
      <button type="button" role="button" class="scroll-button scroll-prev scroll-prev-right">
        <i class="carousel-control-prev-icon"></i>
      </button>
      <!-- scroll right button -->
      <button type="button" role="button" class="scroll-button scroll-next <?php echo $_SESSION['systemLang'] == 'ar' ? 'scroll-next-left' : 'scroll-next-right' ?>">
        <i class="carousel-control-next-icon"></i>
      </button>
    </div>
    <!-- strst users table -->
    <table class="table table-striped table-bordered  display compact table-style" id="malfunctions">
      <thead class="primary text-capitalize">
        <tr>
          <th data-order="asc" data-col-type="number" class="text-center" style="width: 20px">#</th>
          <th data-order="asc" data-col-type="string" class="text-center" style="width: 150px"><?php echo language('ADMIN NAME', @$_SESSION['systemLang']) ?></th>
          <th data-order="asc" data-col-type="string" class="text-center" style="width: 150px"><?php echo language('TECHNICAL NAME', @$_SESSION['systemLang']) ?></th>
          <th data-order="asc" data-col-type="string" class="text-center" style="width: 250px"><?php echo language('PIECE NAME', @$_SESSION['systemLang'])." / ".language('CLIENT NAME', @$_SESSION['systemLang']) ?></th>
          <th data-order="asc" data-col-type="string" class="text-center" style="width: 200px"><?php echo language('MALFUNCTION DESCRIPTION', @$_SESSION['systemLang']) ?></th>
          <th data-order="asc" data-col-type="string" class="text-center" style="width: 200px"><?php echo language('TECHNICAL MAN COMMENT', @$_SESSION['systemLang']) ?></th>
          <th data-order="asc" data-col-type="string" class="text-center" style="width: 100px"><?php echo language('ADDED DATE', @$_SESSION['systemLang']) ?></th>
          <th data-order="asc" data-col-type="string" class="text-center" style="width: 100px"><?php echo language('ADDED TIME', @$_SESSION['systemLang']) ?></th>
          <th data-order="asc" data-col-type="string" class="text-center fs-10-sm" style="width: 50px"><?php echo language('STATUS', @$_SESSION['systemLang']) ?></th>
          <th data-order="asc" data-col-type="string" class="text-center fs-10-sm" style="width: 200px"><?php echo language('HAVE MEDIA', @$_SESSION['systemLang']) ?></th>
          <th class="text-center" style="width: 70px;"><?php echo language('CONTROL', @$_SESSION['systemLang']) ?></th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($rows as $index => $row) {
        ?>
          <tr>
            <td class="text-center"><?php echo ($index + 1) ?></td>

            <td class="text-center">
              <?php $admin_name = $mal_obj->select_specific_column("`UserName`", "`users`", "WHERE `UserID` = ".$row['mng_id'])[0]['UserName']; ?>
              <a href="<?php echo $nav_up_level ?>users/index.php?do=edit-user-info&userid=<?php echo $row['mng_id'];?>"><?php echo $admin_name ?></a>
            </td>

            <td class="text-center">
              <?php $tech_name = $mal_obj->select_specific_column("`UserName`", "`users`", "WHERE `UserID` = ".$row['tech_id'])[0]['UserName']; ?>
              <a href="<?php echo $nav_up_level ?>users/index.php?do=edit-user-info&userid=<?php echo $row['tech_id'];?>"><?php echo $tech_name ?></a>
            </td>

            <td class="text-center">
              <?php $client_name = $mal_obj->select_specific_column("`full_name`", "`pieces_info`", "WHERE `id` = " . $row['client_id'] . " LIMIT 1")[0]['full_name']; ?>
              <?php $client_type = $mal_obj->select_specific_column("`is_client`", "`pieces_info`", "WHERE `id` = " . $row['client_id'] . " LIMIT 1")[0]['is_client']; ?>
              <a href="<?php echo $nav_up_level ?>pieces/index.php?name=<?php echo $client_type == 1 ? 'clients' : 'pieces' ?>&do=edit-piece&piece-id=<?php echo $row['client_id'];?>"><?php echo $client_name ?></a>
            </td>

            <td class="text-center">
              <?php if (strlen($row['descreption']) > 40) {
                echo trim(substr($row['descreption'], 0, 40), '') . "...";
              } else {
                echo $row['descreption'];
              } ?>
            </td>

            <td class="text-center <?php echo empty($row['tech_comment']) ? 'text-danger' : '' ?>">
              <?php if (!empty($row['tech_comment'])) {
                if (strlen($row['tech_comment']) > 40) {
                  echo trim(substr($row['tech_comment'], 0, 40), '') . "...";
                } else {
                  echo $row['tech_comment'];
                }
              } else {
                echo language('THERE IS NO COMMENT OR NOTE TO SHOW', @$_SESSION['systemLang']);
              } ?>
            </td>

            <td class="text-center"><?php echo date_format(date_create($row['added_date']), "Y-m-d") ?></td>

            <td class="text-center"><?php echo date_format(date_create($row['added_time']), "h:i a") ?></td>

            <td class="text-center">
              <?php
              if ($row['mal_status'] == 0) {
                $iconStatus   = "bi-x-circle-fill text-danger";
                $titleStatus  = language('UNREPAIRED', @$_SESSION['systemLang']);
              } elseif ($row['mal_status'] == 1) {
                $iconStatus   = "bi-check-circle-fill text-success";
                $titleStatus  = language('REPAIRED', @$_SESSION['systemLang']);
              } elseif ($row['mal_status'] == 2) {
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
                $have_media = $mal_obj->count_records("`id`", "`malfunctions_media`", "WHERE `mal_id` = ".$row['mal_id']);
                if ($have_media > 0) {
                  echo language('MEDIA HAVE BEEN ATTACHED', @$_SESSION['systemLang']);
                } else {
                  echo language('NO MEDIA HAVE BEEN ATTACHED', @$_SESSION['systemLang']);
                }
              ?>
            </td>

            <td class="text-center">
              <?php if ($_SESSION['mal_show'] == 1) { ?>
                <a href="?do=edit-malfunction-info&malid=<?php echo $row['mal_id'] ?>" target="" class="btn btn-outline-primary me-1 fs-12"><i class="bi bi-eye"></i></a>
              <?php } ?>
              <?php if ($_SESSION['comb_delete'] == 1) { ?>
                <button type="button" class="btn btn-outline-danger text-capitalize form-control bg-gradient fs-12" data-bs-toggle="modal" data-bs-target="#delete-malfunction-modal" id="delete-mal" data-mal-id="<?php echo $row['mal_id'] ?>"><i class="bi bi-trash"></i></button>
              <?php } ?>
            </td>
          </tr>
        <?php
        }
        ?>
      </tbody>
    </table>
  </div>
</div>
<?php } else {
  // include no data founded module
  include_once $globmod . 'no-data-founded-no-redirect.php';
} ?>



<!-- delete malfunction modal -->
<?php include_once 'delete-malfunction-modal.php' ?>