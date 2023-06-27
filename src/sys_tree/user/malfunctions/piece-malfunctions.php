<?php
// get piece / client id
$pieceid = isset($_GET['pieceid']) && !empty($_GET['pieceid']) ? $_GET['pieceid'] : 0;
if (!isset($mal_obj)) {
  // create an object of Malfunction class
  $mal_obj = new Malfunction();
}
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
  <?php if ($_SESSION['mal_add'] == 1) { ?>
  <div class="mb-3">
    <a href="?do=add-new-malfunction" class="btn btn-outline-primary py-1 fs-12 shadow-sm">
      <i class="bi bi-plus"></i>
      <?php echo language('ADD NEW MALFUNCTION', @$_SESSION['systemLang']) ?>
    </a>
  </div>
  <?php } ?>
  <!-- start header -->
  <header class="header mb-1">
    <!-- title -->
    <h4 class="h4 text-capitalize text-secondary ">
      <?php echo language('SHOW MALFUNCTIONS OF PIECE/CLIENT', @$_SESSION['systemLang']) ?>
    </h4>
    <!-- piece name and link -->
    <h5 class="h5 text-capitalize text-secondary ">
      <?php if ($_SESSION['pcs_show'] == 1) { ?>
        <?php if ($piece_type == 'clients') { ?>
          <a href="<?php echo $nav_up_level ?>clients/index.php?do=edit-client&client-id=<?php echo $pieceid ?>"><?php echo $piece_name ?></a>
        <?php } else { ?>
          <a href="<?php echo $nav_up_level ?>pieces/index.php?do=edit-piece&piece-id=<?php echo $pieceid ?>"><?php echo $piece_name ?></a>
        <?php } ?>
      <?php } else { ?>
        <span class="text-primary"><?php echo $piece_name ?></span>
      <?php } ?>
    </h5>

    <?php if ($_SESSION['isTech'] == 1) { ?>
      <p class="text-danger"><?php echo language('THERE IS SOME MALFUNCTION YOU CANNOT SEE', @$_SESSION['systemLang']) ?></p>
    <?php } ?>
  </header>
  <!-- end header -->
  <?php if ($is_exist_mal == true) { ?>
    <?php
      // if current emp is technical man
      $tech_condition = $_SESSION['isTech'] == 1 ? 'AND `tech_id` = ' . $_SESSION['UserID'] : '';
      $query = "SELECT *FROM `malfunctions` WHERE `client_id` = $pieceid $tech_condition";
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
      <!-- strst malfunctions table -->
      <table class="table table-striped table-bordered display compact table-style" id="malfunctions">
        <thead class="primary text-capitalize">
          <tr>
            <th class="text-center" style="width: 20px">#</th>
            <th class="text-center" style="width: 150px"><?php echo language('ADMIN NAME', @$_SESSION['systemLang']) ?></th>
            <th class="text-center" style="width: 150px"><?php echo language('TECHNICAL NAME', @$_SESSION['systemLang']) ?></th>
            <th class="text-center" style="width: 250px"><?php echo language('PIECE NAME', @$_SESSION['systemLang'])." / ".language('CLIENT NAME', @$_SESSION['systemLang']) ?></th>
            <th class="text-center" style="width: 200px"><?php echo language('MALFUNCTION DESCRIPTION', @$_SESSION['systemLang']) ?></th>
            <th class="text-center" style="width: 200px"><?php echo language('TECHNICAL MAN COMMENT', @$_SESSION['systemLang']) ?></th>
            <th class="text-center" style="width: 100px"><?php echo language('ADDED DATE', @$_SESSION['systemLang']) ?></th>
            <th class="text-center" style="width: 100px"><?php echo language('ADDED TIME', @$_SESSION['systemLang']) ?></th>
            <th class="text-center fs-10-sm" style="width: 50px"><?php echo language('STATUS', @$_SESSION['systemLang']) ?></th>
            <th class="text-center fs-10-sm" style="width: 200px"><?php echo language('HAVE MEDIA', @$_SESSION['systemLang']) ?></th>
            <th class="text-center" style="width: 70px;"><?php echo language('CONTROL', @$_SESSION['systemLang']) ?></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($rows as $index => $row) { ?>
            <tr>
              <!-- row index -->
              <td class="text-center"><?php echo ($index + 1) ?></td>
              <!-- admin username -->
              <td class="text-center">
                <?php $admin_name = $mal_obj->select_specific_column("`UserName`", "`users`", "WHERE `UserID` = ".$row['mng_id'])[0]['UserName']; ?>
                <a href="<?php echo $nav_up_level ?>users/index.php?do=edit-user-info&userid=<?php echo $row['mng_id'];?>"><?php echo $admin_name ?></a>
              </td>
              <!-- technical username -->
              <td class="text-center">
                <?php $tech_name = $mal_obj->select_specific_column("`UserName`", "`users`", "WHERE `UserID` = ".$row['tech_id'])[0]['UserName']; ?>
                <a href="<?php echo $nav_up_level ?>users/index.php?do=edit-user-info&userid=<?php echo $row['tech_id'];?>"><?php echo $tech_name ?></a>
              </td>
              <!-- piece/client name -->
              <td class="text-center">
                <?php $client_name = $mal_obj->select_specific_column("`full_name`", "`pieces_info`", "WHERE `id` = " . $row['client_id'] . " LIMIT 1")[0]['full_name']; ?>
                <?php $client_type = $mal_obj->select_specific_column("`is_client`", "`pieces_info`", "WHERE `id` = " . $row['client_id'] . " LIMIT 1")[0]['is_client']; ?>
                <a href="<?php echo $nav_up_level ?>pieces/index.php?name=<?php echo $client_type == 1 ? 'clients' : 'pieces' ?>&do=edit-piece&piece-id=<?php echo $row['client_id'];?>"><?php echo $client_name ?></a>
              </td>
              <!-- malfunction description -->
              <td class="text-center">
                <?php if (strlen($row['descreption']) > 40) {
                  echo trim(substr($row['descreption'], 0, 40), '') . "...";
                } else {
                  echo $row['descreption'];
                } ?>
              </td>
              <!-- technical man comment -->
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
              <!-- added date -->
              <td class="text-center"><?php echo date_format(date_create($row['added_date']), "Y-m-d") ?></td>
              <!-- added time -->
              <td class="text-center"><?php echo date_format(date_create($row['added_time']), "h:i a") ?></td>
              <!-- malfunction status -->
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
              <!-- malfunction media status -->
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
              <!-- control buttons -->
              <td class="text-center">
                <?php if ($_SESSION['mal_show'] == 1) { ?>
                  <a href="?do=edit-malfunction-info&malid=<?php echo $row['mal_id'] ?>" target="" class="btn btn-outline-primary me-1 fs-12"><i class="bi bi-eye"></i></a>
                <?php } ?>
                <?php if ($_SESSION['comb_delete'] == 1) { ?>
                  <button type="button" class="btn btn-outline-danger text-capitalize form-control bg-gradient fs-12" data-bs-toggle="modal" data-bs-target="#delete-malfunction-modal" id="delete-mal" data-mal-id="<?php echo $row['mal_id'] ?>" data-mal-id="<?php echo $mal['mal_id'] ?>" onclick="put_mal_data_into_modal(this, true)"><i class="bi bi-trash"></i></button>
                <?php } ?>
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

<!-- delete malfunction modal -->
<?php include_once 'delete-malfunction-modal.php' ?>