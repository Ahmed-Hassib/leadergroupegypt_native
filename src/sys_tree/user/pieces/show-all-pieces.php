<?php
// create an object of Pieces class
$pcs_obj = !isset($pcs_obj) ? new Pieces() : $pcs_obj;
// get all pieces
$all_pieces_data = $pcs_obj->get_all_pieces(base64_decode($_SESSION['sys']['company_id']), 0);
// get counter flag
$counter = $all_pieces_data[0];
// check counter
if ($counter > 0) {
  // get data
  $all_data = prepare_pcs_datatables($all_pieces_data[1], $lang_file);

  // json data
  $all_data_json = json_encode($all_data);
  // // check if api obj was created && connection to mikrotik
  // if (isset($api_obj) && $api_obj->connect($mikrotik_ip, $mikrotik_username, $mikrotik_password)) {
  //   // get users
  //   $users = $api_obj->comm("/ip/firewall/nat/print", array(
  //     "?comment" => "mohamady",
  //     "?disabled" => "false"
  //   )
  //   );


  //   echo "<pre dir='ltr'>";
  //   echo lang('MIKROTIK SUCCESS') . "<br>";
  //   print_r($users);
  //   echo "</pre>";
  // } else {
  //   $users = [];
  // }

  $users = [];
  $target_user = !empty($users) && count($users) > 0 ? $users[1] : -1;
  // flag for include js code
  $is_big_data_ping = true;
  ?>
  <!-- start edit profile page -->
  <div class="container" dir="<?php echo $page_dir ?>">
    <!-- start header -->
    <header class="header mb-3">
      <h4 class="h4">
        <?php echo lang('ALL PCS', $lang_file) ?>
      </h4>
    </header>

    <div class="mb-3 hstack gap-3">
      <?php if ($_SESSION['sys']['pcs_add'] == 1) { ?>
        <div>
          <a href="?do=add-new-piece" class="btn btn-outline-primary py-1 fs-12">
            <i class="bi bi-plus"></i>
            <?php echo lang('ADD NEW', $lang_file) ?>
          </a>
        </div>
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
          <button type="button" role="button"
            class="scroll-button scroll-next <?php echo $_SESSION['systemLang'] == 'ar' ? 'scroll-next-left' : 'scroll-next-right' ?>">
            <i class="carousel-control-next-icon"></i>
          </button>
        </div>
      <?php } ?>
      <!-- strst pieces table -->
      <table class="table table-bordered display compact table-style" style="width:100%">
        <thead class="primary text-capitalize">
          <tr>
            <!-- <th></th> -->
            <th>#</th>
            <th class="big-data">
              <?php echo lang('PCS NAME', $lang_file) ?>
            </th>
            <th class="big-data">
              <?php echo lang('PROP ADDR', $lang_file) ?>
            </th>
            <th>
              <?php echo lang('AGENT PHONE', $lang_file) ?>
            </th>
            <th>
              <?php echo lang('TYPE', $lang_file) ?>
            </th>
            <th>
              <?php echo lang('INT SRC', $lang_file) ?>
            </th>
            <th class="big-data">
              <?php echo lang('NOTE') ?>
            </th>
            <th>
              <?php echo lang('VISIT TIME', $lang_file) ?>
            </th>
            <th>
              <?php echo lang('DIRECTION', 'directions') ?>
            </th>
            <th class="big-data">
              <?php echo lang('THE SRC', $lang_file) ?>
            </th>
            <th class="big-data">
              <?php echo lang('ALT SRC', $lang_file) ?>
            </th>
            <th>
              <?php echo lang('DEV TYPE', $lang_file) ?>
            </th>
            <th>
              <?php echo lang('DEV MODEL', $lang_file) ?>
            </th>
            <th>
              <?php echo lang('CONN TYPE', $lang_file) ?>
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
              <?php echo lang('SSID', $lang_file) ?>
            </th>
            <th>
              <?php echo lang('FREQ', $lang_file) ?>
            </th>
            <th>
              <?php echo lang('WAVE', $lang_file) ?>
            </th>
            <th class="date-data">
              <?php echo lang('ADDED DATE') ?>
            </th>
            <th>
              <?php echo lang('CONTROL') ?>
            </th>
          </tr>
        </thead>
        <tbody id="piecesTbl">
          <?php foreach ($all_data as $index => $piece) { ?>
            <tr>
              <!-- <td class="dt-control" onclick="show_hide_extra_data(this, <?php echo $index ?>)"></td> -->
              <!-- index -->
              <td>
                <?php echo ++$index; ?>
              </td>
              <!-- piece name -->
              <td>
                <?php if ($_SESSION['sys']['pcs_show'] == 1) { ?>
                  <a href="?do=edit-piece&piece-id=<?php echo base64_encode($piece['id']); ?>" target="">
                    <?php echo trim($piece['full_name'], ' ') ?>
                  </a>
                <?php } else { ?>
                  <span>
                    <?php echo trim($piece['full_name'], ' ') ?>
                  </span>
                <?php } ?>
                <?php if ($piece['direction_id'] == 0) { ?>
                  <i class="bi bi-exclamation-triangle-fill text-danger fw-bold"
                    title="<?php echo lang("NOT ASSIGNED") ?>"></i>
                <?php } ?>
                <?php if ($piece['added_date'] == date('Y-m-d')) { ?>
                  <span class="badge bg-danger p-1 <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'me-1' : 'ms-1' ?>">
                    <?php echo lang('NEW') ?>
                  </span>
                <?php } ?>
              </td>
              <!-- piece address -->
              <td>
                <?php
                // get piece address
                $addr = $pcs_obj->select_specific_column("`address`", "`pieces_addr`", "WHERE `id` = " . $piece['id']);
                // check result
                if (count($addr) > 0) {
                  echo trim($addr[0]['address']);
                } else { ?>
                  <span class="text-danger fs-12 fw-bold">
                    <?php echo lang('NOT ASSIGNED') ?>
                  </span>
                <?php } ?>
              </td>
              <!-- piece phone -->
              <td>
                <?php
                // get piece phone
                $phones = $pcs_obj->select_specific_column("`phone`", "`pieces_phones`", "WHERE `id` = " . $piece['id']);
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
                if ($piece['is_client'] == 1) {
                  $type = lang("CLT", 'clients');
                  $type_class = "";
                } elseif ($piece['is_client'] == 0) {
                  if ($piece['device_type'] == 1) {
                    $type = lang('TRANSMITTER', $lang_file);
                    $type_class = "";
                  } elseif ($piece['device_type'] == 2) {
                    $type = lang('RECEIVER', $lang_file);
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
                $internet_source = $pcs_obj->select_specific_column("`internet_source`", "`pieces_internet_source`", "WHERE `id` = " . $piece['id']);
                // check result
                if (!empty($internet_source)) {
                  echo $internet_source[0]['internet_source'];
                } else { ?>
                  <span class="text-danger fs-12 fw-bold">
                    <?php echo lang('NOT ASSIGNED') ?>
                  </span>
                <?php } ?>
              </td>
              <!-- notes -->
              <td>
                <?php echo $piece['notes'] ?>
              </td>
              <!-- visit time -->
              <td>
                <?php if ($piece['visit_time'] == 1) {
                  echo lang('ANY TIME', $lang_file);
                } elseif ($piece['visit_time'] == 2) {
                  echo lang('ADV CONN', $lang_file);
                } else { ?>
                  <span class="text-danger fs-12 fw-bold">
                    <?php echo lang('NOT ASSIGNED') ?>
                  </span>
                <?php } ?>
              </td>
              <!-- piece direction -->
              <td class="text-capitalize">
                <?php $dir_name = $db_obj->select_specific_column("`direction_name`", "`direction`", "WHERE `direction_id` = " . $piece['direction_id'])[0]['direction_name']; ?>
                <?php if ($piece['direction_id'] != 0 && $_SESSION['sys']['dir_update'] == 1) { ?>
                  <a
                    href="<?php echo $nav_up_level ?>directions/index.php?do=show-direction-tree&dir-id=<?php echo base64_encode($piece['direction_id']); ?>">
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
              <!-- piece source -->
              <td class="text-capitalize" data-ip="<?php echo convert_ip($source_ip) ?>">
                <?php
                // get source info
                $source_info = $db_obj->select_specific_column("`full_name`, `ip`, `port`", "`pieces_info`", "WHERE `id` = " . $piece['source_id']);
                // check info
                if (!empty($source_info)) {
                  $source_name = $source_info[0]['full_name'];
                  $source_ip = $source_info[0]['ip'];
                  $source_port = $source_info[0]['port'];
                } elseif ($piece['source_id'] == 0) {
                  $source_name = $piece['full_name'];
                  $source_ip = $piece['ip'];
                  $source_port = $piece['port'];
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
                      <?php echo $source_name . " <br> " . $source_ip ?>
                    </span>
                  </span>
                  <?php if ($target_user != -1) { ?>
                    <a class="btn btn-outline-primary fs-12 w-auto py-1 px-2"
                      href="?do=prepare-ip&id=<?php echo base64_encode($target_user['.id']) ?>&address=<?php echo $source_ip ?>&port=<?php echo $source_port != 0 ? $source_port : '443' ?>"
                      target='_blank'>
                      <?php echo lang('VISIT DEVICE', $lang_file) ?>
                    </a>
                  <?php } ?>
                  <button class="btn btn-outline-primary fs-12 px-3 py-0" data-bs-toggle="modal" data-bs-target="#pingModal"
                    onclick="ping('<?php echo $source_ip ?>', <?php echo $_SESSION['ping_counter'] ?>)">ping</button>
                <?php } ?>
              </td>
              <!-- piece alt source -->
              <td class="text-capitalize" data-ip="<?php echo convert_ip($source_ip) ?>">
                <?php
                // get source info
                $alt_source_info = $db_obj->select_specific_column("`full_name`, `ip`, `port`", "`pieces_info`", "WHERE `id` = " . $piece['source_id']);
                // default info is null
                $alt_source_name = null;
                $alt_source_ip = null;
                $alt_source_port = null;
                // check info
                if (!empty($alt_source_info)) {
                  $alt_source_name = $alt_source_info[0]['full_name'];
                  $source_ip = $alt_source_info[0]['ip'];
                  $alt_source_port = $alt_source_info[0]['port'];
                } elseif ($piece['source_id'] == 0) {
                  $alt_source_name = $piece['full_name'];
                  $alt_source_ip = $piece['ip'];
                  $alt_source_port = $piece['port'];
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
                      <?php echo $alt_source_name . " <br> " . $alt_source_ip ?>
                    </span>
                  </span>
                  <?php if ($target_user != -1) { ?>
                    <a class="btn btn-outline-primary fs-12 w-auto py-1 px-2"
                      href="?do=prepare-ip&id=<?php echo base64_encode($target_user['.id']) ?>&address=<?php echo $alt_source_ip ?>&port=<?php echo $alt_source_port != 0 ? $alt_source_port : '443' ?>"
                      target='_blank'>
                      <?php echo lang('VISIT DEVICE', $lang_file) ?>
                    </a>
                  <?php } ?>
                  <button class="btn btn-outline-primary fs-12 px-3 py-0" data-bs-toggle="modal" data-bs-target="#pingModal"
                    onclick="ping('<?php echo $alt_source_ip ?>', <?php echo $_SESSION['ping_counter'] ?>)">ping</button>
                <?php } ?>
              </td>
              <!-- device type -->
              <td class="text-capitalize">
                <?php
                if ($piece['device_id'] <= 0) {
                  $device_type = lang('NOT ASSIGNED');
                  $device_class = 'text-danger fs-12 fw-bold';
                } else {
                  $device_type = $db_obj->select_specific_column("`device_name`", "`devices_info`", "WHERE `device_id` = " . $piece['device_id'])[0]['device_name'];
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
                if ($piece['device_model'] <= 0) {
                  $model_name = lang('NOT ASSIGNED');
                  $model_class = 'text-danger fs-12 fw-bold';
                } else {
                  $model_name = $db_obj->select_specific_column("`model_name`", "`devices_model`", "WHERE `model_id` = " . $piece['device_model'])[0]['model_name'];
                  $model_class = '';
                }
                ?>
                <span class="<?php echo isset($model_class) ? $model_class : '' ?>">
                  <?php echo $model_name ?>
                </span>
              </td>
              <!-- connection type -->
              <td class="text-uppercase" data-value="<?php echo $piece['connection_type'] ?>">
                <?php
                if ($piece['connection_type'] <= 0) {
                  $conn_name = lang('NOT ASSIGNED');
                  $conn_class = 'text-danger fs-12 fw-bold';
                } else {
                  $conn_name = $db_obj->select_specific_column("`connection_name`", "`connection_types`", "WHERE `id` = " . $piece['connection_type'])[0]['connection_name'];
                  $conn_class = '';
                }
                ?>
                <span class="<?php echo isset($conn_class) ? $conn_class : '' ?>">
                  <?php echo $conn_name ?>
                </span>
              </td>
              <!-- piece ip -->
              <td>
                <?php
                if ($piece['ip'] == null || empty($piece['ip']) || $piece['ip'] == '0.0.0.0') { ?>
                  <span class="text-danger fs-12 fw-bold">
                    <?php echo lang('NOT ASSIGNED') ?>
                  </span>
                <?php } else { ?>
                  <span class="device-status">
                    <span class="ping-preloader ping-preloader-table position-relative">
                      <span class="ping-spinner ping-spinner-table spinner-grow spinner-border"></span>
                    </span>
                    <span class="ping-status"></span>
                    <span class="pcs-ip" data-pcs-ip="<?php echo $piece['ip'] ?>">
                      <?php echo $piece['ip'] ?>
                    </span>
                  </span>
                  <?php if ($target_user != -1) { ?>
                    <a class="btn btn-outline-primary fs-12 w-auto py-1 px-2"
                      href="?do=prepare-ip&id=<?php echo base64_encode($target_user['.id']) ?>&address=<?php echo $piece['ip'] ?>&port=<?php echo $alt_source_port != 0 ? $alt_source_port : '443' ?>"
                      target='_blank'>
                      <?php echo lang('VISIT DEVICE', $lang_file) ?>
                    </a>
                  <?php } ?>
                  <button class="btn btn-outline-primary fs-12 px-3 py-0" data-bs-toggle="modal" data-bs-target="#pingModal"
                    onclick="ping('<?php echo $piece['ip'] ?>', <?php echo $_SESSION['ping_counter'] ?>)">ping</button>
                <?php } ?>
              </td>
              <!-- piece port -->
              <td>
                <?php
                if ($piece['port'] <= 0) {
                  $port_name = lang('NOT ASSIGNED');
                  $port_class = 'text-danger fs-12 fw-bold';
                } else {
                  $port_name = $piece['port'];
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
                $mac_addr_info = $db_obj->select_specific_column("`mac_add`", "`pieces_mac_addr`", "WHERE `id` = " . $piece['id']);
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
              <!-- piece username -->
              <td>
                <?php
                if ($piece['username'] == null || strlen($piece['username']) <= 0) {
                  $username_name = lang('NOT ASSIGNED');
                  $username_class = 'text-danger fs-12 fw-bold';
                } else {
                  $username_name = $piece['username'];
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
                $ssid_info = $db_obj->select_specific_column("`ssid`", "`pieces_ssid`", "WHERE `id` = " . $piece['id']);
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
                $frequency_info = $db_obj->select_specific_column("`frequency`", "`pieces_frequency`", "WHERE `id` = " . $piece['id']);
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
                $wave_info = $db_obj->select_specific_column("`wave`", "`pieces_wave`", "WHERE `id` = " . $piece['id']);
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
                if ($piece['added_date'] == '0000-00-00') {
                  $date = lang('NOT ASSIGNED');
                  $date_class = 'text-danger fs-12 fw-bold';
                } else {
                  $date = $piece['added_date'];
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
                  <a class="btn btn-success text-capitalize fs-12 "
                    href="?do=edit-piece&piece-id=<?php echo base64_encode($piece['id']); ?>" target="_blank">
                    <i class="bi bi-pencil-square"></i>
                    <!-- <?php echo lang('EDIT') ?> -->
                  </a>
                <?php } ?>
                <?php if ($piece['is_client'] == 0 && $_SESSION['sys']['pcs_show'] == 1) { ?>
                  <a class="btn btn-outline-primary text-capitalize fs-12"
                    href="?do=show-piece&dir-id=<?php echo base64_encode($piece['direction_id']) ?>&src-id=<?php echo base64_encode($piece['id']) ?>"><i
                      class="bi bi-eye"></i></a>
                <?php } ?>
                <?php if ($_SESSION['sys']['pcs_delete'] == 1) { ?>
                  <button type="button" class="btn btn-outline-danger text-capitalize form-control bg-gradient fs-12"
                    data-bs-toggle="modal" data-bs-target="#deletePieceModal" id="delete-piece-<?php echo ($index + 1) ?>"
                    data-piece-id="<?php echo base64_encode($piece['id']) ?>"
                    data-piece-name="<?php echo $piece['full_name'] ?>" onclick="confirm_delete_piece(this, true)"><i
                      class="bi bi-trash"></i></button>
                <?php } ?>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
<?php } else {
  // include no data founded module
  include_once $globmod . 'no-data-founded-no-redirect.php';
} ?>

<script>
  var pcs_data_tables = <?php echo $all_data_json ?>;
</script>