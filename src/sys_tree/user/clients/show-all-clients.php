<?php

// create an object of Pieces class
$pcs_obj = !isset($pcs_obj) ? new Pieces() : $pcs_obj;
// get all clients
$all_clients_data = $pcs_obj->get_all_pieces(base64_decode($_SESSION['sys']['company_id']), 1);
// get counter flag
$counter = $all_clients_data[0];
// check counter
if ($counter > 0) {
  // get data
  $all_data = prepare_pcs_datatables($all_clients_data[1], $lang_file);
  // json data
  $all_data_json = json_encode($all_data);

  // flag for include js code
  $is_big_data_ping = true;
?>
  <!-- start edit profile page -->
  <div class="container" dir="<?php echo $page_dir ?>">
    <!-- start header -->
    <header class="header mb-3">
      <h4 class="h4">
        <?php echo lang('ALL CLTS', $lang_file) ?>
      </h4>
    </header>
    <div class="mb-3 hstack gap-3">
      <?php if ($_SESSION['sys']['clients_add'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) { ?>
        <a href="?do=add-new-client" class="btn btn-outline-primary py-1 fs-12">
          <i class="bi bi-plus"></i>
          <?php echo lang('ADD NEW', $lang_file) ?>
        </a>
      <?php } ?>
      <button class="btn btn-primary fs-12 py-1" onclick="show_display_side_btns(this)">
        <i class="bi bi-eye-slash"></i>
        <?php echo lang('SHOW/HIDE SCROLL BUTTONS') ?>
      </button>
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
          <button type="button" role="button" class="scroll-button scroll-next <?php echo $_SESSION['system_lang'] == 'ar' ? 'scroll-next-left' : 'scroll-next-right' ?>">
            <i class="carousel-control-next-icon"></i>
          </button>
        </div>
      <?php } ?>
      <!-- strst clients table -->
      <table class="table table-bordered table-striped display display-big-data compact table-style" style="width:100%">
        <thead class="primary text-capitalize">
          <tr>
            <!-- <th></th> -->
            <th>#</th>
            <th class="big-data">
              <?php echo lang('CLT NAME', $lang_file) ?>
            </th>
            <th class="big-data">
              <?php echo lang('ADDR', $lang_file) ?>
            </th>
            <th>
              <?php echo lang('PHONE', $lang_file) ?>
            </th>
            <th>
              <?php echo lang('TYPE', 'pieces') ?>
            </th>
            <th>
              <?php echo lang('COORDINATES', 'pieces') ?>
            </th>
            <th class="big-data">
              <?php echo lang('NOTE') ?>
            </th>
            <th>
              <?php echo lang('VISIT TIME', 'pieces') ?>
            </th>
            <th>
              <?php echo lang('DIRECTION', 'directions') ?>
            </th>
            <th class="big-data">
              <?php echo lang('THE SRC', 'pieces') ?>
            </th class="big-data">
            <th>
              <?php echo lang('ALT SRC', 'pieces') ?>
            </th>
            <th>
              <?php echo lang('DEV TYPE', 'pieces') ?>
            </th>
            <th>
              <?php echo lang('DEV MODEL', 'pieces') ?>
            </th>
            <th>
              <?php echo lang('CONN TYPE', 'pieces') ?>
            </th>
            <th class="big-data">
              <?php echo lang('IP') ?>
            </th>
            <th>
              <?php echo lang('PORT') ?>
            </th>
            <th>
              <?php echo lang('MAC') ?>
            </th>
            <th>
              <?php echo lang('USERNAME') ?>
            </th>
            <th>
              <?php echo lang('SSID', 'pieces') ?>
            </th>
            <th>
              <?php echo lang('FREQ', 'pieces') ?>
            </th>
            <th>
              <?php echo lang('WAVE', 'pieces') ?>
            </th>
            <th class="date-data">
              <?php echo lang('ADDED DATE') ?>
            </th>
            <th>
              <?php echo lang('CONTROL') ?>
            </th>
          </tr>
        </thead>
        <tbody id="clientsTbl">
          <?php foreach ($all_data as $index => $client) { ?>
            <tr>
              <!-- <td class="dt-control" onclick="show_hide_extra_data(this, <?php echo $index ?>)"></td> -->
              <!-- index -->
              <td>
                <?php echo ++$index; ?>
              </td>
              <!-- client name -->
              <td>
                <?php if ($_SESSION['sys']['pcs_show'] == 1) { ?>
                  <a href="?do=edit-client&client-id=<?php echo base64_encode($client['id']); ?>" target="">
                    <?php echo trim($client['full_name'], ' ') ?>
                  </a>
                <?php } else { ?>
                  <span>
                    <?php echo trim($client['full_name'], ' ') ?>
                  </span>
                <?php } ?>
                <?php if ($client['direction_id'] == 0) { ?>
                  <i class="bi bi-exclamation-triangle-fill text-danger fw-bold" title="<?php echo lang("NOT ASSIGNED") ?>"></i>
                <?php } ?>
                <?php if ($client['added_date'] == date('Y-m-d')) { ?>
                  <span class="badge bg-danger p-1 <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'me-1' : 'ms-1' ?>">
                    <?php echo lang('NEW') ?>
                  </span>
                <?php } ?>
              </td>
              <!-- client address -->
              <td>
                <?php
                // get piece address
                $addr = $pcs_obj->select_specific_column("`address`", "`pieces_addr`", "WHERE `id` = " . $client['id']);
                // check result
                if (count($addr) > 0) {
                  echo trim($addr[0]['address']);
                } else { ?>
                  <span class="text-danger fs-12 fw-bold">
                    <?php echo lang('NOT ASSIGNED') ?>
                  </span>
                <?php } ?>
              </td>
              <!-- client phone -->
              <td>
                <?php
                // get piece phone
                $phones = $pcs_obj->select_specific_column("`phone`", "`pieces_phones`", "WHERE `id` = " . $client['id']);
                // check result
                if (count($phones) > 0) {
                  echo trim($phones[0]['phone']);
                } else { ?>
                  <span class="text-danger fs-12 fw-bold">
                    <?php echo lang('NOT ASSIGNED') ?>
                  </span>
                <?php } ?>
              </td>
              <!-- pice type -->
              <td class="text-capitalize">
                <?php
                if ($client['is_client'] == 1) {
                  $type = lang("CLT", 'clients');
                  $type_class = "";
                } elseif ($client['is_client'] == 0) {
                  if ($client['device_type'] == 1) {
                    $type = lang('TRANSMITTER', 'pieces');
                    $type_class = "";
                  } elseif ($client['device_type'] == 2) {
                    $type = lang('RECEIVER', 'pieces');
                    $type_class = "";
                  } else {
                    $type = lang('NOT ASSIGNED');
                    $type_class = "text-danger fs-12 fw-bold";
                  }
                } else {
                  $type = lang('NOT ASSIGNED');
                  $type_class = "text-danger fs-12 fw-bold";
                }
                ?>
                <!-- display type -->
                <span class="<?php echo isset($type_class) ? $type_class : '' ?>">
                  <?php echo $type ?>
                </span>
              </td>
              <!-- internet source -->
              <td>
                <?php
                // get internet source
                $coordinates = $pcs_obj->select_specific_column("`coordinates`", "`pieces_Coordinates`", "WHERE `id` = " . $client['id']);
                // check result
                if (!empty($coordinates)) {
                  echo $coordinates[0]['coordinates'];
                } else { ?>
                  <span class="text-danger fs-12 fw-bold">
                    <?php echo lang('NOT ASSIGNED') ?>
                  </span>
                <?php } ?>
              </td>
              <!-- notes -->
              <td>
                <?php echo $client['notes'] ?>
              </td>
              <!-- visit time -->
              <td>
                <?php if ($client['visit_time'] == 1) {
                  echo lang('ANY TIME', 'pieces');
                } elseif ($client['visit_time'] == 2) {
                  echo lang('ADV CONN', 'pieces');
                } else { ?>
                  <span class="text-danger fs-12 fw-bold">
                    <?php echo lang('NOT ASSIGNED') ?>
                  </span>
                <?php } ?>
              </td>
              <!-- client direction -->
              <td class="text-capitalize">
                <?php $dir_name = $db_obj->select_specific_column("`direction_name`", "`direction`", "WHERE `direction_id` = " . $client['direction_id'])[0]['direction_name']; ?>
                <?php if ($client['direction_id'] != 0 && $_SESSION['sys']['dir_update'] == 1) { ?>
                  <a href="<?php echo $nav_up_level ?>directions/index.php?do=show-direction-tree&dir-id=<?php echo base64_encode($client['direction_id']); ?>">
                    <?php echo $dir_name ?>
                  </a>
                <?php } elseif ($_SESSION['sys']['dir_update'] == 0) { ?>
                  <span>
                    <?php echo $dir_name ?>
                  </span>
                <?php } else { ?>
                  <span class="text-danger fs-12 fw-bold">
                    <?php echo lang("NOT ASSIGNED") ?>
                  </span>
                <?php } ?>
              </td>
              <!-- client source -->
              <td class="text-capitalize" data-ip="<?php echo convert_ip($source_ip) ?>">
                <?php
                // get source info
                $source_info = $db_obj->select_specific_column("`full_name`, `ip`, `port`", "`pieces_info`", "WHERE `id` = " . $client['source_id']);
                // check info
                if (!empty($source_info)) {
                  $source_name = trim($source_info[0]['full_name'], ' \t\n\v');
                  $source_ip = trim($source_info[0]['ip'], ' \t\n\v');
                  $source_port = trim($source_info[0]['port'], ' \t\n\v');
                } elseif ($client['source_id'] == 0) {
                  $source_name = trim($client['full_name'], ' \t\n\v');
                  $source_ip = trim($client['ip'], ' \t\n\v');
                  $source_port = trim($client['port'], ' \t\n\v');
                }
                ?>
                <?php if ($source_ip == '0.0.0.0') { ?>
                  <span class="text-danger fs-12 fw-bold">
                    <?php echo lang("NOT ASSIGNED") ?>
                  </span>
                <?php } else { ?>
                  <span class="device-status">
                    <span class="ping-preloader ping-preloader-table position-relative">
                      <span class="ping-spinner ping-spinner-table spinner-grow spinner-border"></span>
                    </span>
                    <span class="ping-status"></span>
                    <span class="pcs-ip" data-pcs-ip="<?php echo $source_ip ?>">
                      <?php echo $source_name ?>
                    </span><br>
                    <a href="<?php echo $source_ip ?>" target="_blank">
                      <?php echo $source_ip ?>
                    </a>
                  </span><br>
                  <?php if ($_SESSION['sys']['mikrotik']['status'] && isset($source_ip) && $source_ip != '0.0.0.0' && 0) { ?>
                    <a class="mx-1 btn btn-outline-primary fs-12 px-3 py-0" href="<?php echo $nav_up_level ?>pieces/index.php?do=mikrotik&ip=<?php echo $source_ip ?>&port=<?php echo $source_port == '80' ? '80' : '443' ?>" target='_blank'>
                      <?php echo lang('VISIT DEVICE', $lang_file) ?>
                    </a>
                  <?php } ?>
                  <button class="btn btn-outline-primary fs-12 px-3 py-0" data-bs-toggle="modal" data-bs-target="#pingModal" onclick="ping('<?php echo $source_ip ?>', <?php echo $_SESSION['sys']['ping_counter'] ?>)">ping</button>
                <?php } ?>
              </td>
              <!-- client alt source -->
              <td class="text-capitalize" data-ip="<?php echo convert_ip($source_ip) ?>">
                <?php
                // get source info
                $alt_source_info = $db_obj->select_specific_column("`full_name`, `ip`, `port`", "`pieces_info`", "WHERE `id` = " . $client['source_id']);
                // default info is null
                $alt_source_name = null;
                $alt_source_ip = null;
                $alt_source_port = null;
                // check info
                if (!empty($alt_source_info)) {
                  $alt_source_name = trim($alt_source_info[0]['full_name'], ' \t\n\v');
                  $source_ip = trim($alt_source_info[0]['ip'], ' \t\n\v');
                  $alt_source_port = trim($alt_source_info[0]['port'], ' \t\n\v');
                } elseif ($client['source_id'] == 0) {
                  $alt_source_name = trim($client['full_name'], ' \t\n\v');
                  $alt_source_ip = trim($client['ip'], ' \t\n\v');
                  $alt_source_port = trim($client['port'], ' \t\n\v');
                }
                ?>
                <?php if ($alt_source_ip == null) { ?>
                  <span class="text-danger fs-12 fw-bold">
                    <?php echo lang("NOT ASSIGNED") ?>
                  </span>
                <?php } else { ?>
                  <span class="device-status">
                    <span class="ping-preloader ping-preloader-table position-relative">
                      <span class="ping-spinner ping-spinner-table spinner-grow spinner-border"></span>
                    </span>
                    <span class="ping-status"></span>
                    <span class="pcs-ip" data-pcs-ip="<?php echo $alt_source_ip ?>">
                      <?php echo $alt_source_name ?>
                    </span><br>
                    <a href="<?php echo $alt_source_ip ?>" target="_blank">
                      <?php echo $alt_source_ip ?>
                    </a>
                  </span><br>
                  <?php if ($_SESSION['sys']['mikrotik']['status'] && isset($alt_source_ip) && $alt_source_ip != '0.0.0.0' && 0) { ?>
                    <a class="mx-1 btn btn-outline-primary fs-12 px-3 py-0" href="<?php echo $nav_up_level ?>pieces/index.php?do=mikrotik&ip=<?php echo $alt_source_ip ?>&port=<?php echo $source_port == '80' ? '80' : '443' ?>" target='_blank'>
                      <?php echo lang('VISIT DEVICE', $lang_file) ?>
                    </a>
                  <?php } ?>
                  <button class="btn btn-outline-primary fs-12 px-3 py-0" data-bs-toggle="modal" data-bs-target="#pingModal" onclick="ping('<?php echo $alt_source_ip ?>', <?php echo $_SESSION['sys']['ping_counter'] ?>)">ping</button>
                <?php } ?>
              </td>
              <!-- device type -->
              <td class="text-capitalize">
                <?php
                if ($client['device_id'] <= 0) {
                  $device_type = lang('NOT ASSIGNED');
                  $device_class = 'text-danger fs-12 fw-bold';
                } else {
                  $device_type = $db_obj->select_specific_column("`device_name`", "`devices_info`", "WHERE `device_id` = " . $client['device_id'])[0]['device_name'];
                  $device_class = '';
                }
                ?>
                <span class="<?php echo isset($device_class) ? $device_class : '' ?>">
                  <?php echo $device_type ?>
                </span>
              </td>
              <!-- device model -->
              <td>
                <?php
                if ($client['device_model'] <= 0) {
                  $model_name = lang('NOT ASSIGNED');
                  $model_class = 'text-danger fs-12 fw-bold';
                } else {
                  $model_name = $db_obj->select_specific_column("`model_name`", "`devices_model`", "WHERE `model_id` = " . $client['device_model'])[0]['model_name'];
                  $model_class = '';
                }
                ?>
                <span class="<?php echo isset($model_class) ? $model_class : '' ?>">
                  <?php echo $model_name ?>
                </span>
              </td>
              <!-- connection type -->
              <td class="text-uppercase" data-value="<?php echo $client['connection_type'] ?>">
                <?php
                if ($client['connection_type'] <= 0) {
                  $conn_name = lang('NOT ASSIGNED');
                  $conn_class = 'text-danger fs-12 fw-bold';
                } else {
                  $conn_name = $db_obj->select_specific_column("`connection_name`", "`connection_types`", "WHERE `id` = " . $client['connection_type'])[0]['connection_name'];
                  $conn_class = '';
                }
                ?>
                <span class="<?php echo isset($conn_class) ? $conn_class : '' ?>">
                  <?php echo $conn_name ?>
                </span>
              </td>
              <!-- client ip -->
              <td>
                <?php
                if (trim($client['ip'], ' \t\n\v') == null || empty(trim($client['ip'], ' \t\n\v')) || trim($client['ip'], ' \t\n\v') == '0.0.0.0') { ?>
                  <span class="text-danger fs-12 fw-bold">
                    <?php echo lang('NOT ASSIGNED') ?>
                  </span>
                <?php } else { ?>
                  <span class="device-status">
                    <span class="ping-preloader ping-preloader-table position-relative">
                      <span class="ping-spinner ping-spinner-table spinner-grow spinner-border"></span>
                    </span>
                    <span class="ping-status"></span>
                    <span class="pcs-ip" data-pcs-ip="<?php echo trim($client['ip'], ' \t\n\v') ?>">
                      <a href="<?php echo trim($client['ip'], ' \t\n\v') ?>" target="_blank">
                        <?php echo trim($client['ip'], ' \t\n\v') ?>
                      </a>
                    </span>
                  </span><br>
                  <?php if ($_SESSION['sys']['mikrotik']['status'] && isset($client['ip']) && $client['ip'] != '0.0.0.0' && 0) { ?>
                    <a class="mx-1 btn btn-outline-primary fs-12 px-3 py-0" href="<?php echo $nav_up_level ?>pieces/index.php?do=mikrotik&ip=<?php echo $client['ip'] ?>&port=<?php echo $source_port == '80' ? '80' : '443' ?>" target='_blank'>
                      <?php echo lang('VISIT DEVICE', $lang_file) ?>
                    </a>
                  <?php } ?>
                  <button class="btn btn-outline-primary fs-12 px-3 py-0" data-bs-toggle="modal" data-bs-target="#pingModal" onclick="ping('<?php echo trim($client['ip'], ' \t\n\v') ?>', <?php echo $_SESSION['sys']['ping_counter'] ?>)">ping</button>
                <?php } ?>
              </td>
              <!-- client port -->
              <td>
                <?php
                if ($client['port'] <= 0) {
                  $port_name = lang('NOT ASSIGNED');
                  $port_class = 'text-danger fs-12 fw-bold';
                } else {
                  $port_name = $client['port'];
                  $port_class = '';
                }
                ?>
                <span class="<?php echo isset($port_class) ? $port_class : '' ?>">
                  <?php echo $port_name ?>
                </span>
              </td>
              <!-- mac address -->
              <td>
                <?php
                // get mac address
                $mac_addr_info = $db_obj->select_specific_column("`mac_add`", "`pieces_mac_addr`", "WHERE `id` = " . $client['id']);
                // check result
                if (count($mac_addr_info) <= 0 || $mac_addr_info == null) {
                  $mac_addr = lang('NOT ASSIGNED');
                  $mac_class = 'text-danger fs-12 fw-bold';
                } else {
                  $mac_addr = $mac_addr_info[0]['mac_add'];
                  $mac_class = '';
                }
                ?>
                <span class="<?php echo isset($mac_class) ? $mac_class : '' ?>">
                  <?php echo $mac_addr ?>
                </span>
              </td>
              <!-- client username -->
              <td>
                <?php
                if ($client['username'] == null || strlen($client['username']) <= 0) {
                  $username_name = lang('NOT ASSIGNED');
                  $username_class = 'text-danger fs-12 fw-bold';
                } else {
                  $username_name = $client['username'];
                  $username_class = '';
                }
                ?>
                <span class="<?php echo isset($username_class) ? $username_class : '' ?>">
                  <?php echo $username_name ?>
                </span>
              </td>
              <!-- ssid -->
              <td>
                <?php
                // get ssid
                $ssid_info = $db_obj->select_specific_column("`ssid`", "`pieces_ssid`", "WHERE `id` = " . $client['id']);
                // check result
                if (count($ssid_info) <= 0 || $ssid_info == null) {
                  $ssid = lang('NOT ASSIGNED');
                  $ssid_class = 'text-danger fs-12 fw-bold';
                } else {
                  $ssid = $ssid_info[0]['ssid'];
                  $ssid_class = '';
                }
                ?>
                <span class="<?php echo isset($ssid_class) ? $ssid_class : '' ?>">
                  <?php echo $ssid ?>
                </span>
              </td>
              <!-- frequency -->
              <td>
                <?php
                // get frequency
                $frequency_info = $db_obj->select_specific_column("`frequency`", "`pieces_frequency`", "WHERE `id` = " . $client['id']);
                // check result
                if (count($frequency_info) <= 0 || $frequency_info == null) {
                  $frequency = lang('NOT ASSIGNED');
                  $frequency_class = 'text-danger fs-12 fw-bold';
                } else {
                  $frequency = $frequency_info[0]['frequency'];
                  $frequency_class = '';
                }
                ?>
                <span class="<?php echo isset($frequency_class) ? $frequency_class : '' ?>">
                  <?php echo $frequency ?>
                </span>
              </td>
              <!-- wave -->
              <td>
                <?php
                // get wave
                $wave_info = $db_obj->select_specific_column("`wave`", "`pieces_wave`", "WHERE `id` = " . $client['id']);
                // check result
                if (count($wave_info) <= 0 || $wave_info == null) {
                  $wave = lang('NOT ASSIGNED');
                  $wave_class = 'text-danger fs-12 fw-bold';
                } else {
                  $wave = $wave_info[0]['wave'];
                  $wave_class = '';
                }
                ?>
                <span class="<?php echo isset($wave_class) ? $wave_class : '' ?>">
                  <?php echo $wave ?>
                </span>
              </td>
              <!-- added date -->
              <td>
                <?php
                // check result
                if ($client['added_date'] == '0000-00-00') {
                  $date = lang('NOT ASSIGNED');
                  $date_class = 'text-danger fs-12 fw-bold';
                } else {
                  $date = $client['added_date'];
                  $date_class = '';
                }
                ?>
                <span class="<?php echo isset($date_class) ? $date_class : '' ?>">
                  <?php echo $date ?>
                </span>
              </td>
              <!-- control -->
              <td>
                <?php if ($_SESSION['sys']['pcs_show'] == 1) { ?>
                  <a class="btn btn-success text-capitalize fs-12 " href="?do=edit-client&client-id=<?php echo base64_encode($client['id']); ?>" target="_blank">
                    <i class="bi bi-pencil-square"></i>
                    <?php echo lang('EDIT') ?>
                  </a>
                <?php } ?>
                <?php if ($client['is_client'] == 0 && $_SESSION['sys']['pcs_show'] == 1) { ?>
                  <a class="btn btn-outline-primary text-capitalize fs-12" href="?do=show-piece&dir-id=<?php echo base64_encode($client['direction_id']) ?>&src-id=<?php echo base64_encode($client['id']) ?>"><i class="bi bi-eye"></i>
                    <?php echo lang('SHOW DETAILS') ?>
                  </a>
                <?php } ?>
                <?php if ($_SESSION['sys']['pcs_delete'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) { ?>
                  <button type="button" class="btn btn-outline-danger text-capitalize form-control bg-gradient fs-12" data-bs-toggle="modal" data-bs-target="#deleteClientModal" id="delete-client-<?php echo ($index + 1) ?>" data-client-id="<?php echo base64_encode($client['id']) ?>" data-client-name="<?php echo $client['full_name'] ?>" onclick="confirm_delete_client(this, true)"><i class="bi bi-trash"></i>
                    <?php echo lang('DELETE') ?>
                  </button>
                <?php } ?>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
  <?php if ($_SESSION['sys']['clients_delete'] == 1) {
    include_once "delete-client-modal.php";
  } ?>
<?php } else {
  // include no data founded module
  include_once $globmod . 'no-data-founded-no-redirect.php';
} ?>


<script>
  var pcs_data_tables = <?php echo $all_data_json ?>;
</script>