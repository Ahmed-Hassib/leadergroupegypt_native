<?php
// get piece / client id
$pieceid = isset($_GET['pieceid']) && !empty($_GET['pieceid']) ? $_GET['pieceid'] : 0;
// create an object of Malfunction class
$mal_obj = new Malfunction();
// check the piece id 
$is_exist_piece = $mal_obj->is_exist("`id`", "`pieces_info`", $pieceid);
// check if there are malfunctions of this piece / client
$is_exist_mal = $is_exist_piece == true ? $mal_obj->is_exist("`client_id`", "`malfunctions`", $pieceid) : 0;
// check
if ($is_exist_piece) { 
  // get piece info
  $piece_info = $mal_obj->select_specific_column("`is_client`, `full_name`", "`pieces_info`", "WHERE `id` = $pieceid AND `company_id` = " . $_SESSION['company_id']);
  // get piece type
  $piece_type = $piece_info[0]['is_client'] == 1 ? 'clients' : 'pieces';
  // get piece name
  $piece_name = $piece_info[0]['full_name'];
}
?>
<!-- start add new user page -->
<div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
  <div class="mb-3 <?php if ($_SESSION['mal_add'] == 0) {echo 'd-none';} ?>">
    <a href="?do=add-new-malfunction" class="btn btn-outline-primary py-1 shadow-sm">
      <h6 class="h6 mb-0 text-center text-capitalize fs-12">
        <i class="bi bi-plus"></i>
        <?php echo language('ADD NEW MALFUNCTION', @$_SESSION['systemLang']) ?>
      </h6>
    </a>
  </div>
  <!-- start header -->
  <header class="header mb-1">
    <!-- title -->
    <h4 class="h4 text-capitalize text-secondary ">
      <?php echo language('SHOW MALFUNCTIONS OF PIECE/CLIENT', @$_SESSION['systemLang']) ?>
    </h4>
    <!-- piece name and link -->
    <h5 class="h5 text-capitalize text-secondary ">
      <a href="<?php echo $nav_up_level ?>pieces/index.php?name=<?php echo $piece_type ?>&do=edit-piece&piece-id=<?php echo $pieceid ?>"><?php echo $piece_name ?></a>
    </h5>
  </header>
  <!-- end header -->
  <?php if ($is_exist_mal == true) { ?>
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
            <th data-order="asc" data-col-type="string" class="text-center" style="width: 200px"><?php echo language('MALFUNCTION DESCRIPTION', @$_SESSION['systemLang']) ?></th>
            <th data-order="asc" data-col-type="string" class="text-center" style="width: 200px"><?php echo language('TECHNICAL MAN COMMENT', @$_SESSION['systemLang']) ?></th>
            <th data-order="asc" data-col-type="string" class="text-center" style="width: 100px"><?php echo language('ADDED DATE', @$_SESSION['systemLang']) ?></th>
            <th data-order="asc" data-col-type="string" class="text-center" style="width: 100px"><?php echo language('ADDED TIME', @$_SESSION['systemLang']) ?></th>
            <th data-order="asc" data-col-type="string" class="text-center fs-10-sm" style="width: 50px"><?php echo language('STATUS', @$_SESSION['systemLang']) ?></th>
            <th data-order="asc" data-col-type="string" class="text-center fs-10-sm" style="width: 50px"><?php echo language('TECH STATUS', @$_SESSION['systemLang']) ?></th>
            <th class="text-center"><?php echo language('CONTROL', @$_SESSION['systemLang']) ?></th>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach ($rows as $index => $row) {
          ?>
            <tr>
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
                <?php if ($_SESSION['mal_show'] == 1) { ?>
                  <a href="?do=edit-malfunction-info&malid=<?php echo $row['mal_id'] ?>" target="" class="btn btn-outline-primary me-1 fs-12"><i class="bi bi-eye"></i></a>
                <?php } ?>
                <?php if ($_SESSION['comb_delete'] == 1) { ?>
                  <button type="button" class="btn btn-outline-danger text-capitalize form-control bg-gradient fs-12" data-bs-toggle="modal" data-bs-target="#delete-malfunction-modal" id="delete-mal" data-mal-id="<?php echo $row['mal_id'] ?>"><i class="bi bi-trash"></i></button>
                <?php } ?>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  <?php } ?>
</div>

<!-- delete malfunction modal -->
<?php include_once 'delete-malfunction-modal.php' ?>