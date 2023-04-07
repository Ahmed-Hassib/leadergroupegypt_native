<?php
// check if Get request dir-id is numeric and get the integer value
$dir_id = isset($_GET['dir-id']) && is_numeric($_GET['dir-id']) ? intval($_GET['dir-id']) : -1;
// check if Get request src-id is numeric and get the integer value
$src_id = isset($_GET['src-id']) && is_numeric($_GET['src-id']) ? intval($_GET['src-id']) : -1;
// check the direction and source id
if ($dir_id != -1 && $src_id != -1) {
  // create an object of Pieces class
  $pcs_obj = new Pieces();
  // get name of current devices
  $current_piece_name = $pcs_obj->select_specific_column("`full_name`", "`pieces_info`", "WHERE `id` = $src_id")[0]['full_name'];
  // condition
  $condition = "WHERE `company_id` = ".$_SESSION['company_id'] ." AND `direction_id` = $dir_id AND `source_id` = $src_id";    // query condition
  // get all pieces
  $pieces_info = $pcs_obj->get_spec_pieces($condition);
  
  // counter
  $counter = $pieces_info[0];
  // data 
  $pieces_data = $pieces_info[1];
?>
  <!-- start edit profile page -->
  <div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
    <!-- start header -->
    <header class="header mb-3">
      <div class="hstack gap-2">
        <!-- edit current piece -->
        <div>
          <!-- Button trigger modal -->
          <a class="btn btn-outline-success fs-12 py-1" href="?name=pieces&do=edit-piece&piece-id=<?php echo $src_id; ?>">
            <i class="bi bi-pencil d-sm-block d-md-none"></i>
            <span class="d-none d-md-block"><?php echo language("EDIT CURRENT PIECE", @$_SESSION['systemLang']) ?></span>
          </a>
        </div>
        <!-- edit current piece -->
        <?php $src_ip = $db_obj->select_specific_column("`ip`", "`pieces_info`", "WHERE `id` = $src_id")[0]['ip'] ?>
        <?php if ($src_ip !== '0.0.0.0') { ?>
          <div>
            <!-- Button trigger modal -->
            <a class="btn btn-outline-primary fs-12 py-1" href="http://<?php echo $src_ip; ?>" target="_blank">
              <i class="bi bi-box-arrow-in-up-right d-sm-block d-md-none"></i>
              <span class="d-none d-md-block"><?php echo language("VISIT PIECE", @$_SESSION['systemLang']) ?></span>
            </a>
          </div>
        <?php } ?>
      </div>
      
      <h4 class="h4"><?php echo $current_piece_name ?></h4>
    </header>
    <?php if ($counter > 0) { ?>
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
        <table class="table table-bordered  display compact table-style" style="width:100%">
          <thead class="primary text-capitalize">
            <tr>
              <th style="max-width: 40px">#</th>
              <th style="min-width: 150px" class="text-uppercase"><?php echo language('IP', @$_SESSION['systemLang']) ?></th>
              <th style="min-width: 150px" class="text-uppercase"><?php echo language('MAC ADD', @$_SESSION['systemLang']) ?></th>
              <th style="min-width: 250px"><?php echo language('PIECE NAME', @$_SESSION['systemLang']) ?></th>
              <th style="min-width: 200px"><?php echo language('USERNAME', @$_SESSION['systemLang']) ?></th>
              <th style="min-width: 150px"><?php echo language('THE DIRECTION', @$_SESSION['systemLang']) ?></th>
              <th style="min-width: 100px"><?php echo language('THE SOURCE', @$_SESSION['systemLang']) ?></th>
              <th style="min-width: 100px"><?php echo language('THE TYPE', @$_SESSION['systemLang']) ?></th>
              <th style="min-width: 100px"><?php echo language('DEVICE TYPE', @$_SESSION['systemLang']) ?></th>
              <th style="min-width: 100px"><?php echo language('DEVICE MODEL', @$_SESSION['systemLang']) ?></th>
              <th style="min-width: 100px"><?php echo language('CONNECTION TYPE', @$_SESSION['systemLang']) ?></th>
              <th style="min-width: 100px"><?php echo language('ADDED DATE', @$_SESSION['systemLang']) ?></th>
              <th style="min-width: 75px"><?php echo language('CONTROL', @$_SESSION['systemLang']) ?></th>
            </tr>
          </thead>
          <tbody id="piecesTbl">
            <?php foreach ($pieces_data as $index => $piece) { ?>
              <?php $name = $piece['is_client'] ? 'clients' : 'pieces' ?>
              <tr>
                <!-- index -->
                <td ><?php echo ++$index; ?></td>

                <!-- piece ip -->
                <td class="text-capitalize <?php echo $piece['ip'] == '0.0.0.0' ? 'text-danger ' : '' ?> " data-ip="<?php echo convertIP($piece['ip']) ?>"><?php echo $piece['ip'] == '0.0.0.0' ?  language("NO DATA ENTERED", @$_SESSION['systemLang']) :"<a href='http://" . $piece['ip'] . "' target='_blank'>" . $piece['ip'] . '</a>'; ?></td>

                <!-- piece mac address -->
                <td class="text-capitalize <?php echo !empty($piece['mac_add']) ? "" : "text-danger " ?>"><?php echo !empty($piece['mac_add']) ? $piece['mac_add'] : language("NO DATA ENTERED", @$_SESSION['systemLang']) ?></td>
                
                <!-- piece name -->
                <td>
                  <a class="<?php if ($_SESSION['pcs_update'] == 0) {echo 'd-none';} ?>" href="?name=<?php echo $name ?>&do=edit-piece&piece-id=<?php echo $piece['id']; ?>" target="">
                    <?php echo trim($piece['full_name'], ' ') ?>
                    <?php if ($piece['direction_id'] == 0) { ?>
                        <i class="bi bi-exclamation-triangle-fill text-danger" title="<?php echo language("DIRECTION NO DATA ENTERED", @$_SESSION['systemLang']) ?>"></i>
                    <?php } ?>
                  </a>
                  <?php if ($piece['added_date'] == date('Y-m-d')) { ?>
                    <span class="badge bg-danger p-1 <?php echo @$_SESSION['systemLang'] == 'ar' ? 'me-1' : 'ms-1' ?>"><?php echo language('NEW', @$_SESSION['systemLang']) ?></span>
                  <?php } ?>
                </td>

                <!-- piece username -->
                <td class="text-capitalize">
                  <a href="?name=<?php echo $name ?>&do=edit-piece&piece-id=<?php echo $piece['id']; ?>">
                    <?php echo $piece['username']; ?>
                  </a>
                </td>

                <!-- piece direction -->
                <td class="text-capitalize" >
                  <?php if ($piece['direction_id'] != 0) { ?>
                    <a href="<?php echo $nav_up_level ?>directions/index.php?do=show-direction-tree&dir-id=<?php echo $piece['direction_id']; ?>">
                        <?php echo $db_obj->select_specific_column("`direction_name`", "`direction`", "WHERE `direction_id` = ".$piece['direction_id'])[0]['direction_name']; ?>
                    </a>
                  <?php } else { ?>
                    <span class="text-danger"><?php echo language("NO DATA ENTERED", @$_SESSION['systemLang']) ?></span>
                  <?php } ?>
                </td>

                <!-- piece source -->
                <?php $sourceip = $piece['source_id'] == 0 ? $piece['ip'] : $db_obj->select_specific_column("`ip`", "`pieces_info`", "WHERE `id` = " . $piece['source_id'])[0]['ip']; ?>
                <td data-ip="<?php echo convertIP($sourceip) ;?>"> 
                  <?php echo '<a href="http://' . $sourceip . '" target="">' . $sourceip . '</a>'; ?>
                </td>

                <!-- type -->
                <td class="text-capitalize">
                  <?php 
                  if ($piece['is_client'] == 1) { 
                    $type = language("CLIENT", @$_SESSION['systemLang']);
                    $type_class = "";

                  } elseif ($piece['is_client'] == 0) {
                    
                    if ($piece['device_type'] == 1) {
                      $type = language('TRANSMITTER', @$_SESSION['systemLang']);
                      $type_class = "";
                    
                    } elseif ($piece['device_type'] == 2) {
                      $type = language('RECEIVER', @$_SESSION['systemLang']);
                      $type_class = "";
                    
                    } else {
                      $type = language('NO DATA ENTERED', @$_SESSION['systemLang']);
                      $type_class = "text-danger";
                    }

                  } else {
                    $type = language('NO DATA ENTERED', @$_SESSION['systemLang']);
                    $type_class = "text-danger";
                  }
                  ?>

                  <!-- display type -->
                  <span class="<?php echo isset($type_class) ? $type_class : '' ?>"><?php echo $type ?></span>
                </td>

                <!-- device type -->
                <td class="text-capitalize">
                  <?php 
                  if ($piece['device_id'] <= 0) {
                    $device_type = language('NO DATA ENTERED', @$_SESSION['systemLang']);
                    $device_class = 'text-danger';
                  } else {
                    $device_type = $db_obj->select_specific_column("`device_name`", "`devices_info`", "WHERE `device_id` = " . $piece['device_id'])[0]['device_name'];
                    $device_class = '';
                  }
                  ?>

                  <span class="<?php echo isset($device_class) ? $device_class : '' ?>"><?php echo $device_type ?></span>
                </td>
                <!-- device model -->
                <td>
                  <?php 
                  if ($piece['device_model'] <= 0) {
                    $model_name = language('NO DATA ENTERED', @$_SESSION['systemLang']);
                    $model_class = 'text-danger';
                  } else {
                    $model_name = $db_obj->select_specific_column("`model_name`", "`devices_model`", "WHERE `model_id` = " . $piece['device_model'])[0]['model_name'];
                    $model_class = '';
                  }
                  ?>

                  <span class="<?php echo isset($model_class) ? $model_class : '' ?>"><?php echo $model_name ?></span>
                </td>

                <!-- connection type -->
                <td class="text-uppercase" data-value="<?php echo $piece['connection_type'] ?>">
                  <?php echo $piece['connection_type'] == 0 ? 'none' : $db_obj->select_specific_column("`connection_name`", "`connection_types`", "WHERE `id` = ".$piece['connection_type'])[0]['connection_name']; ?>
                </td>

                <!-- added date -->
                <td><?php echo $piece['added_date'] == '0000-00-00' ? language("NO DATA ENTERED", @$_SESSION['systemLang']) : $piece['added_date'] ?></td>

                <!-- control -->
                <td>
                  <a class="btn btn-success text-capitalize fs-12 <?php if ($_SESSION['pcs_update'] == 0) {echo 'd-none';} ?>" href="?name=<?php echo $name ?>&do=edit-piece&piece-id=<?php echo $piece['id']; ?>" target=""><i class="bi bi-pencil-square"></i><!-- <?php echo language('EDIT', @$_SESSION['systemLang']) ?> --></a>
                  <?php if ($piece['is_client'] == 0) { ?>
                      <a class="btn btn-outline-primary text-capitalize fs-12 <?php if ($_SESSION['pcs_show'] == 0) {echo 'd-none';} ?>" href="?name=<?php echo $name ?>&do=show-piece&dir-id=<?php echo $piece['direction_id'] ?>&src-id=<?php echo $piece['id'] ?>" ><i class="bi bi-eye"></i></a>
                  <?php } ?>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    <?php } else {
      // include data error
      include_once $globmod . 'no-data-founded-no-redirect.php';
    } ?>
  </div>
<?php
} else {
  // include data error
  include_once $globmod . 'data-error.php';
}
?>