<?php

// create an object of Pieces class
$pcs_obj = new Pieces();
// get all clients
$all_clients_data = $pcs_obj->get_all_pieces($_SESSION['company_id'], 1);
// get counter flag
$counter = $all_clients_data[0];
// check counter
if ($counter > 0) {
  // get data
  $all_data = $all_clients_data[1];

  $API->connect($ipRB, $Username, $clave);
  $users =  $API->comm("/ip/firewall/nat/print", array(
    "?comment" => "mohamady"
  ));
  $target_user = !empty($users) && count($users) > 0 ? $users[1] : -1;

?>
  <!-- start edit profile page -->
  <div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
    <!-- start header -->
    <header class="header mb-3">
      <h4 class="h4"><?php echo language('SHOW ALL CLIENTS', @$_SESSION['systemLang']) ?></h4>
    </header>
    <div class="mb-3 hstack gap-3">
      <?php if ($_SESSION['clients_add'] == 1) { ?>
        <a href="?do=add-new-client" class="btn btn-outline-primary py-1 fs-12">
          <i class="bi bi-plus"></i>
          <?php echo language('ADD NEW CLIENT', @$_SESSION['systemLang']) ?>
        </a>
      <?php } ?>
    </div>
    <!-- start table container -->
    <div class="table-responsive-sm">
      <?php if (count($all_data) > 10) { ?>
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
      <?php } ?> <!-- strst users table -->
      <table class="table table-bordered  display compact table-style" style="width:100%">
        <thead class="primary text-capitalize">
          <tr>
            <th style="max-width: 40px">#</th>
            <th style="min-width: 250px" class="text-uppercase"><?php echo language('IP', @$_SESSION['systemLang']) ?></th>
            <th style="min-width: 150px" class="text-uppercase"><?php echo language('MAC ADD', @$_SESSION['systemLang']) ?></th>
            <th style="min-width: 200px"><?php echo language('CLIENT NAME', @$_SESSION['systemLang']) ?></th>
            <th style="min-width: 200px"><?php echo language('USERNAME', @$_SESSION['systemLang']) ?></th>
            <th style="min-width: 150px"><?php echo language('THE DIRECTION', @$_SESSION['systemLang']) ?></th>
            <th style="min-width: 200px"><?php echo language('THE SOURCE', @$_SESSION['systemLang']) ?></th>
            <th style="min-width: 100px"><?php echo language('THE TYPE', @$_SESSION['systemLang']) ?></th>
            <th style="min-width: 100px"><?php echo language('DEVICE TYPE', @$_SESSION['systemLang']) ?></th>
            <th style="min-width: 100px"><?php echo language('DEVICE MODEL', @$_SESSION['systemLang']) ?></th>
            <th style="min-width: 100px"><?php echo language('CONNECTION TYPE', @$_SESSION['systemLang']) ?></th>
            <th style="min-width: 100px"><?php echo language('ADDED DATE', @$_SESSION['systemLang']) ?></th>
            <th style="min-width: 10px"><?php echo language('CONTROL', @$_SESSION['systemLang']) ?></th>
          </tr>
        </thead>
        <tbody id="piecesTbl">
          <?php foreach ($all_data as $index => $client) { ?>
            <tr>
              <!-- index -->
              <td><?php echo ++$index; ?></td>

              <!-- client ip -->
              <td class="text-capitalize" data-ip="<?php echo convert_ip($client['ip']) ?>">
                <?php if ($client['ip'] == '0.0.0.0') { ?>
                  <span class="text-danger"><?php echo language("NO DATA ENTERED", @$_SESSION['systemLang']) ?></span>
                <?php } else { ?>
                  <span><?php echo $client['ip'] ?></span>
                  <?php if ($target_user != -1) { ?>
                    <a class="btn btn-outline-primary fs-12 w-auto py-1 px-2" href="?do=prepare-ip&id=<?php echo base64_encode($target_user['.id']) ?>&address=<?php echo $client['ip'] ?>&port=443" target='_blank'><?php echo language('VISIT DEVICE', @$_SESSION['systemLang']) ?></a>
                  <?php } ?>
                <?php } ?>
              </td>

              <!-- client mac address -->
              <td class="text-capitalize <?php echo !empty($client['mac_add']) ? "" : "text-danger " ?>"><?php echo !empty($client['mac_add']) ? $client['mac_add'] : language("NO DATA ENTERED", @$_SESSION['systemLang']) ?></td>

              <!-- client name -->
              <td>
                <?php if ($_SESSION['clients_show'] == 1) { ?>
                  <a href="?do=edit-client&client-id=<?php echo $client['id']; ?>" target="">
                    <?php echo trim($client['full_name'], ' ') ?>
                  </a>
                <?php } else { ?>
                  <span><?php echo trim($client['full_name'], ' ') ?></span>
                <?php } ?>
                <?php if ($client['direction_id'] == 0) { ?>
                  <i class="bi bi-exclamation-triangle-fill text-danger" title="<?php echo language("DIRECTION NO DATA ENTERED", @$_SESSION['systemLang']) ?>"></i>
                <?php } ?>
                <?php if ($client['added_date'] == get_date_now()) { ?>
                  <span class="badge bg-danger p-1 <?php echo @$_SESSION['systemLang'] == 'ar' ? 'me-1' : 'ms-1' ?>"><?php echo language('NEW', @$_SESSION['systemLang']) ?></span>
                <?php } ?>
              </td>

              <!-- client username -->
              <td class="text-capitalize">
                <?php if ($_SESSION['clients_show'] == 1) { ?>
                  <a href="?do=edit-client&client-id=<?php echo $client['id']; ?>">
                    <?php echo $client['username']; ?>
                  </a>
                <?php } else { ?>
                  <span><?php echo $client['username']; ?></span>
                <?php } ?>
              </td>

              <!-- client direction -->
              <td class="text-capitalize">
                <?php $dir_name = $db_obj->select_specific_column("`direction_name`", "`direction`", "WHERE `direction_id` = " . $client['direction_id'])[0]['direction_name']; ?>
                <?php if ($client['direction_id'] != 0 && $_SESSION['dir_show'] == 1) { ?>
                  <a href="<?php echo $nav_up_level ?>directions/index.php?do=show-direction-tree&dir-id=<?php echo $client['direction_id']; ?>">
                    <?php echo $dir_name ?>
                  </a>
                <?php } elseif ($_SESSION['dir_show'] == 0) { ?>
                  <span><?php echo $dir_name ?></span>
                <?php } else { ?>
                  <span class="text-danger"><?php echo language("NO DATA ENTERED", @$_SESSION['systemLang']) ?></span>
                <?php } ?>
              </td>

              <!-- client source -->
              <?php $sourceip = $client['source_id'] == 0 ? $client['ip'] : @$db_obj->select_specific_column("`ip`", "`pieces_info`", "WHERE `id` = " . $client['source_id'])[0]['ip']; ?>
              <td class="text-capitalize" data-ip="<?php echo convert_ip($sourceip) ?>">
                <?php if ($sourceip == '0.0.0.0') { ?>
                  <span class="text-danger"><?php echo language("NO DATA ENTERED", @$_SESSION['systemLang']) ?></span>
                <?php } else { ?>
                  <span><?php echo $sourceip ?></span>
                  <?php if ($target_user != -1) { ?>
                    <a class="btn btn-outline-primary fs-12 w-auto py-1 px-2" href="?do=prepare-ip&id=<?php echo base64_encode($target_user['.id']) ?>&address=<?php echo $sourceip ?>&port=443" target='_blank'><?php echo language('VISIT DEVICE', @$_SESSION['systemLang']) ?></a>
                  <?php } ?>
                <?php } ?>
              </td>

              <!-- type -->
              <td class="text-capitalize">
                <?php
                if ($client['is_client'] == 1) {
                  $type = language("CLIENT", @$_SESSION['systemLang']);
                  $type_class = "";
                } elseif ($client['is_client'] == 0) {

                  if ($client['device_type'] == 1) {
                    $type = language('TRANSMITTER', @$_SESSION['systemLang']);
                    $type_class = "";
                  } elseif ($client['device_type'] == 2) {
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
                if ($client['device_id'] <= 0) {
                  $device_type = language('NO DATA ENTERED', @$_SESSION['systemLang']);
                  $device_class = 'text-danger';
                } else {
                  $device_type = $db_obj->select_specific_column("`device_name`", "`devices_info`", "WHERE `device_id` = " . $client['device_id'])[0]['device_name'];
                  $device_class = '';
                }
                ?>

                <span class="<?php echo isset($device_class) ? $device_class : '' ?>"><?php echo $device_type ?></span>
              </td>
              <!-- device model -->
              <td>
                <?php
                if ($client['device_model'] <= 0) {
                  $model_name = language('NO DATA ENTERED', @$_SESSION['systemLang']);
                  $model_class = 'text-danger';
                } else {
                  $model_name = $db_obj->select_specific_column("`model_name`", "`devices_model`", "WHERE `model_id` = " . $client['device_model'])[0]['model_name'];
                  $model_class = '';
                }
                ?>

                <span class="<?php echo isset($model_class) ? $model_class : '' ?>"><?php echo $model_name ?></span>
              </td>

              <!-- connection type -->
              <td class="text-uppercase" data-value="<?php echo $client['connection_type'] ?>">
                <?php $connection_type = $client['connection_type'] == 0 || $client['connection_type'] == -1 ? language('NO DATA ENTERED', @$_SESSION['systemLang']) : $db_obj->select_specific_column("`connection_name`", "`connection_types`", "WHERE `id` = " . $client['connection_type'] . " AND `company_id` = " . $_SESSION['company_id'])[0]['connection_name']; ?>
                <?php echo $connection_type; ?>
              </td>

              <!-- added date -->
              <td><?php echo $client['added_date'] == '0000-00-00' ? language("NO DATA ENTERED", @$_SESSION['systemLang']) : $client['added_date'] ?></td>

              <!-- control -->
              <td>
                <?php if ($_SESSION['clients_show'] == 1) { ?>
                  <a class="btn btn-success text-capitalize fs-12" href="?do=edit-client&client-id=<?php echo $client['id']; ?>" target=""><i class="bi bi-pencil-square"></i><!-- <?php echo language('EDIT', @$_SESSION['systemLang']) ?> --></a>
                <?php } ?>

                <?php if ($_SESSION['clients_delete'] == 1) { ?>
                  <button type="button" class="btn btn-outline-danger text-capitalize form-control bg-gradient fs-12" data-bs-toggle="modal" data-bs-target="#deleteClientModal" id="delete-client" data-client-id="<?php echo $client['id'] ?>" data-client-name="<?php echo $client['full_name'] ?>" onclick="confirm_delete_client(this, true)"><i class="bi bi-trash"></i></button>
                <?php } ?>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
  <?php if ($_SESSION['clients_delete'] == 1) {
    include "delete-client-modal.php";
  } ?>
<?php } else {
  // include no data founded module
  include_once $globmod . 'no-data-founded-noredirect.php';
} ?>