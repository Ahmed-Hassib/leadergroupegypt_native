<?php 
$is_contain_table = true;
if (!isset($comb_obj)) {
  // create an object of Combin class
  $comb_obj = new Combination();
}
// period value
$period = isset($_GET['period']) && !empty($_GET['period']) ? $_GET['period'] : 'all';
// combStatus of combination
$combStatus = isset($_GET['combStatus']) && !empty($_GET['combStatus']) ? $_GET['combStatus'] : '-1';
// is accept status of combination
$accepted = isset($_GET['accepted']) && !empty($_GET['accepted']) ? $_GET['accepted'] : '-1';

// title
$title = "SHOW ALL";

// base query
$baseQuery = "SELECT *FROM `combinations`";

// switch case to prepare the condition of the cobination
switch($combStatus) {
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
    $acceptedStatus = "(`isAccepted` = 2 OR `isFinished` = 2)";
    break;
  default:
    $acceptedStatus = "";
}

$title .= " COMBINATIONS";

// switch case to prepare period of the query
switch($period) {
  case 'today':
    $title .= " OF TODAY";
    $conditionPeriod = " `added_date` = '".get_date_now()."'";
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

// switch case for the logged user is tech or not
$userCondition = $_SESSION['isTech'] == 1 ? "`UserID` = ".$_SESSION['UserID'] : "";

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
$combination_query = $baseQuery . $company_condition;

// prepaire the query
$stmt = $con->prepare($combination_query);
$stmt->execute();               // execute query
$rows = $stmt->fetchAll();      // fetch data
$count = $stmt->rowCount();     // get row count

?>
<!-- start edit profile page -->
<div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
  <?php if ($_SESSION['comb_add'] == 1) { ?>
  <div class="mb-3">
    <a href="?do=add-new-combination" class="btn btn-outline-primary py-1 shadow-sm fs-12">
      <span class="bi bi-plus"></span>
      <?php echo language("ADD NEW COMBINATION", @$_SESSION['systemLang']) ?>
    </a>
  </div>
  <?php } ?>
  <!-- start header -->
  <header class="header mb-3">
    <h5 class="h5 text-capitalize text-success "><?php echo language($title, @$_SESSION['systemLang']); ?></h5>
    <!-- if no malfunction today -->
    <?php if ($count == 0) { ?>
      <h6 class="h6 text-capitalize text-danger "><?php echo language('THERE IS NO COMBINATIONS TO SHOW', @$_SESSION['systemLang']) ?></h6>
    <?php } ?>
  </header>
  <?php if ($count > 0) {  ?>
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
      <table class="table table-striped table-bordered display compact table-style" id="combinations">
        <thead class="primary text-capitalize">
          <tr>
            <th class="d-none">id</th>
            <th class="text-center" style="width: 20px">#</th>
            <th class="text-center" style="width: 150px"><?php echo language('ADMIN NAME', @$_SESSION['systemLang']) ?></th>
            <th class="text-center" style="width: 150px"><?php echo language('TECHNICAL NAME', @$_SESSION['systemLang']) ?></th>
            <th class="text-center" style="width: 200px"><?php echo language('CLIENT NAME', @$_SESSION['systemLang']) ?></th>
            <th class="text-center" style="width: 200px"><?php echo language('THE ADDRESS', @$_SESSION['systemLang']) ?></th>
            <th class="text-center" style="width: 100px"><?php echo language('PHONE', @$_SESSION['systemLang']) ?></th>
            <!-- <th class="text-center" style="width: 100px"><?php echo language('THE NOTES', @$_SESSION['systemLang']) ?></th> -->
            <th class="text-center" style="width: 300px"><?php echo language('TECHNICAL MAN COMMENT', @$_SESSION['systemLang']) ?></th>
            <th class="text-center" style="width: 50px"><?php echo language('STATUS', @$_SESSION['systemLang']) ?></th>
            <th class="text-center fs-10-sm" style="width: 200px"><?php echo language('HAVE MEDIA', @$_SESSION['systemLang']) ?></th>
            <th class="text-center" style="width: 70px;"><?php echo language('CONTROL', @$_SESSION['systemLang']) ?></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($rows as $index => $row) { ?>
            <tr>
              <td class="d-none"><?php echo $row['comb_id'] ?></td>
              <td><?php echo ($index + 1) ?></td>
              <td>
                <?php $admin_name = $comb_obj->select_specific_column("`UserName`", "`users`", "WHERE `UserID` = ".$row['addedBy'])[0]['UserName']; ?>
                <a href="<?php echo $nav_up_level ?>users/index.php?do=edit-user-info&userid=<?php echo $row['addedBy'];?>"><?php echo $admin_name ?></a>
              </td>
              <td>
                <?php $tech_name = $comb_obj->select_specific_column("`UserName`", "`users`", "WHERE `UserID` = ".$row['UserID'])[0]['UserName']; ?>
                <a href="<?php echo $nav_up_level ?>users/index.php?do=edit-user-info&userid=<?php echo $row['UserID'];?>"><?php echo $tech_name ?></a>
              </td>
              <td><?php echo $row['client_name'] ?></td>
              <td>
                <?php $client_addr = $row['address'];
                if (!empty($client_addr) && strlen($client_addr) > 50) {
                  echo trim(substr($client_addr, 0, 50), '') . "...";
                } else {
                  echo $client_addr;
                }
                ?>
              </td>
              <td>
                <?php $client_phone = $row['phone'];
                if (!empty($client_phone) && strlen($client_phone) > 50) {
                  echo trim(substr($$client_phone, 0, 11), '') . "...";
                } else {
                  echo $client_phone;
                }
                ?>
              </td>
              <!-- <td>
                <?php 
                // $comment = $row['comment'];
                // if (!empty($comment) && strlen($comment) > 50) {
                //   echo trim(substr($comment, 0, 50), '') . "...";
                // } else {
                //   echo $comment;
                // }
                ?>
              </td> -->
              <td class="text-center <?php echo empty($row['tech_comment']) ? 'text-danger ' : '' ?>">
                <?php $tech_comment = !empty($row['tech_comment']) ? $row['tech_comment'] : language('THERE IS NO COMMENT OR NOTE TO SHOW', @$_SESSION['systemLang']);
                if (!empty($tech_comment) && strlen($tech_comment) > 50) {
                  echo trim(substr($tech_comment, 0, 50), '') . "...";
                } else {
                  echo $tech_comment;
                }
                ?>
              </td>
              <td>
                <?php
                  if ($row['isFinished'] == 0) {
                    $icon   = "bi-x-circle-fill text-danger";
                    $title  = language('UNFINISHED COMBINATION', @$_SESSION['systemLang']);
                  } elseif ($row['isFinished'] == 1) {
                    $icon   = "bi-check-circle-fill text-success";
                    $title  = language('FINISHED COMBINATION', @$_SESSION['systemLang']);
                  } else {
                    $icon   = "bi-dash-circle-fill text-info";
                    $title  = language('NO STATUS', @$_SESSION['systemLang']);
                  }
                ?>
                <i class="bi <?php echo $icon ?>" title="<?php echo $title ?>"></i>
              </td>
              <td>
              <?php 
                $have_media = $comb_obj->count_records("`id`", "`combinations_media`", "WHERE `comb_id` = ".$row['comb_id']);
                if ($have_media > 0) {
                  echo language('MEDIA HAVE BEEN ATTACHED', @$_SESSION['systemLang']);
                } else {
                  echo language('NO MEDIA HAVE BEEN ATTACHED', @$_SESSION['systemLang']);
                }
              ?>
              </td>
              <td>
                <?php if ($_SESSION['comb_show'] == 1 || $_SESSION['comb_delete'] == 1) { ?>
                  <?php if ($_SESSION['comb_show'] == 1) { ?>
                  <a href="?do=edit-combination&combid=<?php echo $row['comb_id'] ?>" class="btn btn-outline-primary fs-12"><i class="bi bi-eye"></i></a>
                  <?php } ?>
                  <?php if ($_SESSION['comb_delete'] == 1) {?>
                    <button type="button" class="btn btn-outline-danger text-capitalize form-control bg-gradient fs-12" data-bs-toggle="modal" data-bs-target="#deleteCombModal" id="delete-comb" data-comb-id="<?php echo $row['comb_id'] ?>"><i class="bi bi-trash"></i></button>
                  <?php } ?>
                <?php } ?>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
    <!-- delete combination modal -->
    <?php include_once 'delete-combination-modal.php' ?>
  <?php } ?>
</div>