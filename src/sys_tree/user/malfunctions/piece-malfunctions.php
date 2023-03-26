<?php
$is_contain_table = true;
// get piece / client id
$pieceid = isset($_GET['pieceid']) && !empty($_GET['pieceid']) ? $_GET['pieceid'] : 0;
// check the piece id 
$pieceIsExist = checkItem("`id`", "`pieces_info`", $pieceid);
// check if there are malfunctions of this piece / client
$malIsExist = $pieceIsExist > 0 ? checkItem("`client_id`", "`malfunctions`", $pieceid) : 0;
?>
<!-- start add new user page -->
<div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
  <!-- start header -->
  <header class="header mb-5">
    <h4 class="h4 text-capitalize text-secondary ">
      <?php echo language('SHOW MALFUNCTIONS OF PIECE/CLIENT', @$_SESSION['systemLang']) ?>
    </h4>
    <?php if ($pieceIsExist > 0) { ?>
    <h5 class="h5 text-capitalize text-secondary ">
      <a href="<?php echo $nav_up_level ?>pieces/index.php?do=edit-piece&piece-id=<?php echo $pieceid ?>">
        <?php echo selectSpecificColumn("`full_name`", "`pieces_info`", "WHERE `id` = $pieceid")[0]['full_name'] ?>
      </a>
    </h5>
      <?php if ($malIsExist == 0) { ?>
        <h6 class="h6 text-capitalize text-danger "><?php echo language('THERE IS NO MALFUNCTIONS TO SHOW', @$_SESSION['systemLang']) ?></h6>
      <?php } ?>
    <?php } else { ?>
      <h6 class="h6 text-capitalize text-danger ">
        <?php echo language("THERE IS NO ID LIKE THAT", @$_SESSION['systemLang'])?>
      </h6>
      <a href="index.php"><?php echo language("BACK", @$_SESSION['systemLang']) ?></a>
    <?php } ?>
  </header>
  <!-- end header -->
  <?php if ($malIsExist > 0) { ?>
    <?php
      $query = "SELECT *FROM `malfunctions` WHERE `client_id` = $pieceid";
      // prepaire the query
      $stmt = $con->prepare($query);
      $stmt->execute();               // execute query
      $rows = $stmt->fetchAll();      // fetch data
      $count = $stmt->rowCount();     // get row count
    ?>

    <!-- start table container -->
    <div class="table-responsive-sm">
      <!-- strst users table -->
      <table class="table table-striped table-bordered  display compact table-style" id="malfunctions">
        <thead class="primary text-capitalize">
          <tr>
            <th class="text-center d-none">id</th>
            <th data-order="asc" data-col-type="number" class="text-center" style="max-width: 50px">#</th>
            <th data-order="asc" data-col-type="string" class="text-center" style="width: 150px"><?php echo language('ADMIN NAME', @$_SESSION['systemLang']) ?></th>
            <th data-order="asc" data-col-type="string" class="text-center" style="width: 150px"><?php echo language('TECHNICAL NAME', @$_SESSION['systemLang']) ?></th>
            <!-- <th data-order="asc" data-col-type="string" class="text-center" style="width: 150px"><?php echo language('PIECE NAME', @$_SESSION['systemLang'])." / ".language('CLIENT NAME', @$_SESSION['systemLang']) ?></th> -->
            <th data-order="asc" data-col-type="string" class="text-center" style="max-width: 200px"><?php echo language('MALFUNCTION DESCRIPTION', @$_SESSION['systemLang']) ?></th>
            <th data-order="asc" data-col-type="string" class="text-center" style="width: 200px"><?php echo language('TECHNICAL MAN COMMENT', @$_SESSION['systemLang']) ?></th>
            <th data-order="asc" data-col-type="string" class="text-center" style="width: 100px"><?php echo language('ADDED DATE', @$_SESSION['systemLang']) ?></th>
            <th data-order="asc" data-col-type="string" class="text-center" style="width: 100px"><?php echo language('ADDED TIME', @$_SESSION['systemLang']) ?></th>
            <th data-order="asc" data-col-type="string" class="text-center" style="width: 70px"><?php echo language('STATUS', @$_SESSION['systemLang']) ?></th>
            <th data-order="asc" data-col-type="string" class="text-center fs-10-sm" style="width: 70px"><?php echo language('TECH STATUS', @$_SESSION['systemLang']) ?></th>
            <th class="text-center "><?php echo language('CONTROL', @$_SESSION['systemLang']) ?></th>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach ($rows as $index => $row) {
          ?>
            <tr>
              <td class="d-none"><?php echo $row['mal_id'] ?></td>
              <td class="text-center"><?php echo ($index + 1) ?></td>
              <td class="text-center">
                <?php $adminName = selectSpecificColumn("`UserName`", "`users`", "WHERE `UserID` = ".$row['mng_id'])[0]['UserName']; ?>
                <a href="<?php echo $nav_up_level ?>users/index.php?do=edit-user-info&userid=<?php echo $row['mng_id'];?>"><?php echo $adminName ?></a>
              </td>
              <td class="text-center">
                <?php $techName = selectSpecificColumn("`UserName`", "`users`", "WHERE `UserID` = ".$row['tech_id'])[0]['UserName']; ?>
                <a href="<?php echo $nav_up_level ?>users/index.php?do=edit-user-info&userid=<?php echo $row['tech_id'];?>"><?php echo $techName ?></a>
              </td>
              <!-- <td class="text-center">
                <?php $clientnName = selectSpecificColumn("`full_name`", "`pieces_info`", "WHERE `id` = '" . $row['client_id'] . "' LIMIT 1")[0]['full_name']; ?>
                <a href="<?php echo $nav_up_level ?>pieces/index.php?do=edit-piece&piece-id=<?php echo $row['client_id'];?>"><?php echo $clientnName ?></a>
              </td> -->
              <td class="text-center"><?php echo $row['descreption'] ?></td>
              <td class="text-center <?php echo empty($row['tech_comment']) ? 'text-danger ' : '' ?>"><?php echo !empty($row['tech_comment']) ? $row['tech_comment'] : language('THERE IS NO COMMENT OR NOTE TO SHOW', @$_SESSION['systemLang']) ?></td>
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
              <td class="text-center">
                <?php
                  if ($row['isAccepted'] == 0) {
                    $iconStatus   = "bi-x-circle-fill text-danger";
                    $titleStatus  = language('NOT ACCEPTED', @$_SESSION['systemLang']);
                  } elseif ($row['isAccepted'] == 1) {
                    $iconStatus   = "bi-check-circle-fill text-success";
                    $titleStatus  = language('ACCEPTED', @$_SESSION['systemLang']);
                  } elseif ($row['isAccepted'] == 2) {
                    $iconStatus   = "bi-exclamation-circle-fill text-warning";
                    $titleStatus  = language('DELAYED COMBINATION', @$_SESSION['systemLang']);
                  } else {
                    $iconStatus   = "bi-dash-circle-fill text-info";
                    $titleStatus  = language('NO STATUS', @$_SESSION['systemLang']);
                  }
                ?>
                <i class="bi <?php echo $iconStatus ?>" title="<?php echo $titleStatus ?>"></i>
              </td>
              <td class="text-center">
                <a href="?do=edit-malfunction-info&malid=<?php echo $row['mal_id'] ?>" class="btn btn-outline-primary fs-12 <?php if ($_SESSION['mal_show'] == 0) {echo 'disabled';} ?>"><i class="bi bi-eye"></i></a>
              </td>
            </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
    </div>
  <?php } ?>
</div>