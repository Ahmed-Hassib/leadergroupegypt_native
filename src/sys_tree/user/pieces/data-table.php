<?php
// array of error
$errorArray = array();
// query condition
if ($query == 'showPiece') {
  // show all pieces of specific dir and specific source
  $condition = "WHERE `company_id` = ".$_SESSION['company_id'] ." AND `pieces`.`direction_id` = $dirId AND `pieces`.`source_id` = $srcId";    // query condition
  $tableID = "allChildPieces";                                                                // table id
  
} elseif ($query == 'piecesTypes' && $action == 'showPiecesType') {
  // show all pieces of specific type
  $condition = "WHERE `company_id` = ".$_SESSION['company_id'] ." AND `pieces`.`type_id` = $typeid";              // query condition
  // page subtitle
  $subTitle = language('SHOW ALL PIECES OF THE TYPE', @$_SESSION['systemLang']) .": ". ($typeid == 0 ? language('NOT ASSIGNED', @$_SESSION['systemLang']) : selectSpecificColumn("`type_name`", "`types`", "WHERE `type_id` = $typeid")[0]['type_name']);
  $tableID = "allPiecesOfType";                                   // table id
  
} elseif ($query == 'showConnectionTypes' && $action == 'showPiecesConn') {
  
} else {
  $condition = '';
  $tableID = "";
  $subTitle = "";
}



// prepare statment
$stmt = $con->prepare($q);
$stmt->execute(); // execute q2
$rows = $stmt->fetchAll(); // fetch data

// create an object of Database
$db_obj = new Database();

?>
<!-- start edit profile page -->
<div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
  <!-- start header -->
  <header class="header mb-3">
    <!-- check subtitle -->
    <?php if (!empty($subTitle)) { ?>
      <!-- show sub title -->
      <p class=" text-success text-capitalize" ><?php echo $subTitle ?></p>
    <?php } ?>

    
  </header>
  
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
    <table class="table table-bordered  display compact table-style" id="<?php echo $tableID ?>" style="width:100%">
      <thead class="primary text-capitalize">
        <tr>
          <th style="max-width: 40px">#</th>
          <th style="min-width: 150px" class="text-uppercase"><?php echo language('IP', @$_SESSION['systemLang']) ?></th>
          <th style="min-width: 150px" class="text-uppercase"><?php echo language('MAC ADD', @$_SESSION['systemLang']) ?></th>
          <th style="min-width: 250px"><?php echo language('CLIENT NAME', @$_SESSION['systemLang']) ?></th>
          <th style="min-width: 200px"><?php echo language('USERNAME', @$_SESSION['systemLang']) ?></th>
          <th style="min-width: 150px"><?php echo language('THE DIRECTION', @$_SESSION['systemLang']) ?></th>
          <th style="min-width: 100px"><?php echo language('THE SOURCE', @$_SESSION['systemLang']) ?></th>
          <th style="min-width: 100px"><?php echo language('DEVICE TYPE', @$_SESSION['systemLang']) ?></th>
          <th style="min-width: 100px"><?php echo language('CONNECTION TYPE', @$_SESSION['systemLang']) ?></th>
          <th style="min-width: 100px"><?php echo language('THE TYPE', @$_SESSION['systemLang']) ?></th>
          <th style="min-width: 100px"><?php echo language('CONNECTION', @$_SESSION['systemLang']) ?></th>
          <th style="min-width: 100px"><?php echo language('ADDED DATE', @$_SESSION['systemLang']) ?></th>
          <th style="min-width: 75px"><?php echo language('CONTROL', @$_SESSION['systemLang']) ?></th>
        </tr>
      </thead>
      <tbody id="piecesTbl">
        <?php $index = 0; ?>
        <?php foreach ($rows as $row) { ?>
          <?php $name = $row['is_client'] ? 'client' : 'piece' ?>
          <tr>
            <!-- index -->
            <td ><?php echo ++$index; ?></td>
            <!-- piece ip -->
            <td class="text-capitalize <?php echo $row['piece_ip'] == '0.0.0.0' ? 'text-danger ' : '' ?> " data-ip="<?php echo convertIP($row['piece_ip']) ?>"><?php echo $row['piece_ip'] == '0.0.0.0' ?  language("NO DATA ENTERED", @$_SESSION['systemLang']) :"<a href='http://" . $row['piece_ip'] . "' target='_blank'>" . $row['piece_ip'] . '</a>'; ?></td>
            <!-- piece mac address -->
            <td class="text-capitalize <?php echo !empty($row['mac_add']) ? "" : "text-danger " ?>"><?php echo !empty($row['mac_add']) ? $row['mac_add'] : language("NO DATA ENTERED", @$_SESSION['systemLang']) ?></td>
            <!-- piece name -->
            <td>
              <a class="<?php if ($_SESSION['pcs_update'] == 0) {echo 'd-none';} ?>" href="?name=<?php echo $name ?>&do=edit-piece&piece-id=<?php echo $row['piece_id']; ?>" target="">
                <?php echo trim($row['piece_name'], ' ') ?>
                <?php if ($row['direction_id'] == 0) { ?>
                  <i class="bi bi-exclamation-triangle-fill text-danger" title="<?php echo language("DIRECTION NO DATA ENTERED", @$_SESSION['systemLang']) ?>"></i>
                <?php } ?>
              </a>
              <?php if ($row['added_date'] == date('Y-m-d')) { ?>
                <span class="badge bg-danger p-1 <?php echo @$_SESSION['systemLang'] == 'ar' ? 'me-1' : 'ms-1' ?>"><?php echo language('NEW', @$_SESSION['systemLang']) ?></span>
              <?php } ?>
            </td>
            <!-- piece username -->
            <td class="text-capitalize">
              <a href="?do=edit-piece&piece-id=<?php echo $row['piece_id']; ?>">
                <?php echo $row['username']; ?>
              </a>
            </td>
            <!-- piece direction -->
            <td class="text-capitalize" >
              <?php if ($row['direction_id'] != 0) { ?>
                <a href="<?php echo $nav_up_level ?>directions/index.php?do=showDir&dirId=<?php echo $row['direction_id']; ?>">
                  <?php echo $db_obj->select_specific_column("`direction_name`", "`direction`", "WHERE `direction_id` = ".$row['direction_id'])[0]['direction_name']; ?>
                </a>
              <?php } else { ?>
                <span class="text-danger"><?php echo language("NO DATA ENTERED", @$_SESSION['systemLang']) ?></span>
              <?php } ?>
            </td>
            <!-- piece source -->
            <td data-ip="<?php echo convertIP($sourceip) ;?>"> 
              <?php $sourceip = $row['source_id'] == 0 ? $row['piece_ip'] : $db_obj->select_specific_column("`piece_ip`", "`pieces`", "WHERE `piece_id` = " . $row['source_id'])[0]['piece_ip']; ?>
              <?php echo '<a href="http://' . $sourceip . '" target="">' . $sourceip . '</a>'; ?>
            </td>
            <!-- device type -->
            <td class="text-capitalize">
              <?php if (!empty($row['device_type'])) { ?>
                <?php echo $row['device_type'] ?>
              <?php } else { ?>
                <span class="text-danger"><?php echo language("NO DATA ENTERED", @$_SESSION['systemLang']) ?></span>
              <?php } ?>
            </td>
            <!-- connection type -->
            <td class="text-uppercase" data-value="<?php echo $row['conn_type'] ?>">
              <?php echo $row['conn_type'] == 0 ? 'none' : $db_obj->select_specific_column("`conn_name`", "`conn_types`", "WHERE `id` = ".$row['conn_type'])[0]['conn_name']; ?>
            </td>
            <!-- type -->
            <td class="text-capitalize">
              <?php if ($row['type_id'] != 0) { ?>
                <?php echo $db_obj->select_specific_column("`type_name`", "`types`", "WHERE `type_id` = ". $row['type_id'])[0]['type_name']; ?>
              <?php } elseif (($row['is_client'] == 1)) { ?>
                <span><?php echo language("CLIENT", @$_SESSION['systemLang']) ?></span>
              <?php } else { ?>
                <span class="text-danger"><?php echo language("NO DATA ENTERED", @$_SESSION['systemLang']) ?></span>
              <?php } ?>
            </td>
            <!-- connection -->
            <td><?php echo $row['direct'] == 0 ? language('NOT DIRECT', @$_SESSION['systemLang']) : language('DIRECT', @$_SESSION['systemLang']); ?></td>
            <!-- added date -->
            <td><?php echo $row['added_date'] == '0000-00-00' ? language("NO DATA ENTERED", @$_SESSION['systemLang']) : $row['added_date'] ?></td>
            <!-- control -->
            <td>
              <a class="btn btn-success text-capitalize fs-12 <?php if ($_SESSION['pcs_update'] == 0) {echo 'd-none';} ?>" href="?do=edit-piece&piece-id=<?php echo $row['piece_id']; ?>" target=""><i class="bi bi-pencil-square"></i><!-- <?php echo language('EDIT', @$_SESSION['systemLang']) ?> --></a>
              <?php if ($row['is_client'] == 0) { ?>
                <a class="btn btn-outline-primary text-capitalize fs-12 <?php if ($_SESSION['pcs_show'] == 0) {echo 'd-none';} ?>" href="?name=<?php echo $name ?>&do=show-piece&dir-id=<?php echo $row['direction_id'] ?>&srcId=<?php echo $row['piece_id'] ?>" ><i class="bi bi-eye"></i><!-- <?php echo language('SHOW', @$_SESSION['systemLang']).' '.language('PIECES', @$_SESSION['systemLang']) ?> --></a>
              <?php } ?>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>