<?php
if (!isset($pcs_obj)) {
  // create an object of Pieces class
  $pcs_obj = new Pieces();
}
// get direction id
$type = isset($_GET['type']) ? $_GET['type'] : -1;
// get type
$dir_id = isset($_GET['dir-id']) && !empty($_GET['dir-id']) ? intval($_GET['dir-id']) : -1;
// condition
$condition = "WHERE `pieces_info`.`is_client` = $type AND `pieces_info`.`direction_id` = $dir_id";
// get all pieces
$all_pieces_data = $pcs_obj->get_spec_pieces($condition);
// get counter flag
$counter = $all_pieces_data[0];
// get direction name
$dir_name = $pcs_obj->select_specific_column("`direction_name`", "`direction`", "WHERE `direction_id` = " . $dir_id)[0]['direction_name'];

if ($_GET['type'] == -1) {
  $main_title = "SHOW DIRECTION UNKNOWN";
} else {
  $main_title = "SHOW DIRECTION PIECES";
}
?>
<!-- start edit profile page -->
<div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
  <!-- start header -->
  <header class="header mb-3">
    <h4 class="h4"><?php echo language($main_title, @$_SESSION['systemLang']) ?></h4>
    <h5 class="h5"><?php echo $dir_name ?></h5>
  </header>

  <div class="mb-3 hstack gap-3">
    <?php if ($_SESSION['pcs_add'] == 1) { ?>
    <div>
      <a href="?do=add-new-piece" class="btn btn-outline-primary py-1 fs-12">
        <i class="bi bi-plus"></i>
        <?php echo language('ADD NEW PIECE', @$_SESSION['systemLang']) ?>
      </a>
    </div>
    <?php } ?>
  </div>
</div>
<?php
// check counter
if ($counter == true) {
  // get data
  $all_data = $all_pieces_data[1];

  // $API->connect($ipRB, $Username, $clave);
  // $users =  $API->comm("/ip/firewall/nat/print", array(
  //   "?comment" => "mohamady"
  // ));
  $users = [];
  $target_user = !empty($users) && count($users) > 0 ? $users[1] : -1;

  // flag for include js code
  $is_big_data_ping = true;
?>
<div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
  <!-- start table container -->
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
  <!-- strst users table -->
  <table class="table table-bordered  display compact table-style" style="width:100%">
    <thead class="primary text-capitalize">
      <tr>
        <th style="max-width: 40px">#</th>
        <th style="min-width: 300px" class="text-uppercase"><?php echo language('IP', @$_SESSION['systemLang']) ?></th>
        <th style="min-width: 150px" class="text-uppercase"><?php echo language('MAC ADD', @$_SESSION['systemLang']) ?>
        </th>
        <th style="min-width: 200px"><?php echo language('PIECE NAME', @$_SESSION['systemLang']) ?></th>
        <th style="min-width: 150px"><?php echo language('USERNAME', @$_SESSION['systemLang']) ?></th>
        <th style="min-width: 100px"><?php echo language('THE DIRECTION', @$_SESSION['systemLang']) ?></th>
        <th style="min-width: 300px"><?php echo language('THE SOURCE', @$_SESSION['systemLang']) ?></th>
        <th style="min-width: 100px"><?php echo language('THE TYPE', @$_SESSION['systemLang']) ?></th>
        <th style="min-width: 100px"><?php echo language('DEVICE TYPE', @$_SESSION['systemLang']) ?></th>
        <th style="min-width: 100px"><?php echo language('DEVICE MODEL', @$_SESSION['systemLang']) ?></th>
        <th style="min-width: 100px"><?php echo language('CONNECTION TYPE', @$_SESSION['systemLang']) ?></th>
        <th style="min-width: 100px"><?php echo language('ADDED DATE', @$_SESSION['systemLang']) ?></th>
        <th style="min-width: 100px"><?php echo language('CONTROL', @$_SESSION['systemLang']) ?></th>
      </tr>
    </thead>
    <tbody id="piecesTbl">
      <?php foreach ($all_data as $index => $piece) { ?>
      <?php
          // check type of child
          if ($piece['is_client'] == 1) {
            $url = $nav_up_level . "clients/index.php?do=edit-client&client-id=" . $piece['id'];
          } else {
            $url = "?do=edit-piece&piece-id=" . $piece['id'];
          }
          ?>
      <tr>
        <!-- index -->
        <td><?php echo ++$index; ?></td>

        <!-- piece ip -->
        <td class="text-capitalize" data-ip="<?php echo convert_ip($piece['ip']) ?>">
          <?php if ($piece['ip'] == '0.0.0.0') { ?>
          <span class="text-danger"><?php echo language("NO DATA ENTERED", @$_SESSION['systemLang']) ?></span>
          <?php } else { ?>
          <span class="device-status">
            <span class="ping-preloader ping-preloader-table position-relative">
              <span class="ping-spinner ping-spinner-table spinner-grow spinner-border"></span>
            </span>
            <span class="ping-status"></span>
            <span class="pcs-ip" data-pcs-ip="<?php echo $piece['ip'] ?>"><?php echo $piece['ip'] ?></span>
          </span>
          <?php if ($target_user != -1) { ?>
          <a class="btn btn-outline-primary fs-12 w-auto py-1 px-2"
            href="?do=prepare-ip&id=<?php echo base64_encode($target_user['.id']) ?>&address=<?php echo $piece['ip'] ?>&port=<?php echo $piece['port'] != 0 ? $piece['port'] : '443' ?>"
            target='_blank'><?php echo language('VISIT DEVICE', @$_SESSION['systemLang']) ?></a>
          <?php } ?>
          <button class="btn btn-outline-primary fs-12 px-3 py-1" data-bs-toggle="modal" data-bs-target="#pingModal"
            onclick="ping('<?php echo $piece['ip'] ?>', <?php echo $_SESSION['ping_counter'] ?>)">ping</button>
          <?php } ?>
        </td>

        <!-- piece mac address -->
        <td class="text-capitalize <?php echo !empty($piece['mac_add']) ? "" : "text-danger " ?>">
          <?php echo !empty($piece['mac_add']) ? $piece['mac_add'] : language("NO DATA ENTERED", @$_SESSION['systemLang']) ?>
        </td>

        <!-- piece name -->
        <td>
          <?php if ($_SESSION['pcs_show'] == 1) { ?>
          <a href="<?php echo $url ?>" target="">
            <?php echo trim($piece['full_name'], ' ') ?>
          </a>
          <?php } else { ?>
          <span><?php echo trim($piece['full_name'], ' ') ?></span>
          <?php } ?>
          <?php if ($piece['direction_id'] == 0) { ?>
          <i class="bi bi-exclamation-triangle-fill text-danger"
            title="<?php echo language("DIRECTION NO DATA ENTERED", @$_SESSION['systemLang']) ?>"></i>
          <?php } ?>
          <?php if ($piece['added_date'] == date('Y-m-d')) { ?>
          <span
            class="badge bg-danger p-1 <?php echo @$_SESSION['systemLang'] == 'ar' ? 'me-1' : 'ms-1' ?>"><?php echo language('NEW', @$_SESSION['systemLang']) ?></span>
          <?php } ?>
        </td>

        <!-- piece username -->
        <td class="text-capitalize">
          <?php if ($_SESSION['pcs_show'] == 1) { ?>
          <a href="<?php echo $url ?>">
            <?php echo $piece['username']; ?>
          </a>
          <?php } else { ?>
          <span><?php echo $piece['username']; ?></span>
          <?php } ?>
        </td>

        <!-- piece direction -->
        <td class="text-capitalize">
          <?php $dir_name = $db_obj->select_specific_column("`direction_name`", "`direction`", "WHERE `direction_id` = " . $piece['direction_id'])[0]['direction_name']; ?>
          <?php if ($piece['direction_id'] != 0 && $_SESSION['dir_update'] == 1) { ?>
          <a
            href="<?php echo $nav_up_level ?>directions/index.php?do=show-direction-tree&dir-id=<?php echo $piece['direction_id']; ?>">
            <?php echo $dir_name ?>
          </a>
          <?php } elseif ($_SESSION['dir_update'] == 0) { ?>
          <span><?php echo $dir_name ?></span>
          <?php } else { ?>
          <span class="text-danger"><?php echo language("NO DATA ENTERED", @$_SESSION['systemLang']) ?></span>
          <?php } ?>
        </td>

        <!-- piece source -->
        <?php $source_ip = $piece['source_id'] == 0 ? $piece['ip'] : $db_obj->select_specific_column("`ip`", "`pieces_info`", "WHERE `id` = " . $piece['source_id'])[0]['ip']; ?>
        <?php $source_port = $piece['source_id'] == 0 ? $piece['ip'] : $db_obj->select_specific_column("`port`", "`pieces_info`", "WHERE `id` = " . $piece['source_id'])[0]['port']; ?>
        <td class="text-capitalize" data-ip="<?php echo convert_ip($source_ip) ?>">
          <?php if ($source_ip == '0.0.0.0') { ?>
          <span class="text-danger"><?php echo language("NO DATA ENTERED", @$_SESSION['systemLang']) ?></span>
          <?php } else { ?>
          <span class="device-status">
            <span class="ping-preloader ping-preloader-table position-relative">
              <span class="ping-spinner ping-spinner-table spinner-grow spinner-border"></span>
            </span>
            <span class="ping-status"></span>
            <span class="pcs-ip" data-pcs-ip="<?php echo $source_ip ?>"><?php echo $source_ip ?></span>
          </span>
          <?php if ($target_user != -1) { ?>
          <a class="btn btn-outline-primary fs-12 w-auto py-1 px-2"
            href="?do=prepare-ip&id=<?php echo base64_encode($target_user['.id']) ?>&address=<?php echo $source_ip ?>&port=<?php echo $source_port != 0 ? $source_port : '443' ?>"
            target='_blank'><?php echo language('VISIT DEVICE', @$_SESSION['systemLang']) ?></a>
          <?php } ?>
          <button class="btn btn-outline-primary fs-12 px-3 py-1" data-bs-toggle="modal" data-bs-target="#pingModal"
            onclick="ping('<?php echo $source_ip ?>', <?php echo $_SESSION['ping_counter'] ?>)">ping</button>
          <?php } ?>
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
          <?php echo $piece['connection_type'] == 0 ? 'none' : $db_obj->select_specific_column("`connection_name`", "`connection_types`", "WHERE `id` = " . $piece['connection_type'])[0]['connection_name']; ?>
        </td>

        <!-- added date -->
        <td>
          <?php echo $piece['added_date'] == '0000-00-00' ? language("NO DATA ENTERED", @$_SESSION['systemLang']) : $piece['added_date'] ?>
        </td>

        <!-- control -->
        <td>
          <?php if ($_SESSION['pcs_show'] == 1) { ?>
          <a class="btn btn-success text-capitalize fs-12 " href="<?php echo $url ?>" target=""><i
              class="bi bi-pencil-square"></i><!-- <?php echo language('EDIT', @$_SESSION['systemLang']) ?> --></a>
          <?php } ?>
          <?php if ($piece['is_client'] == 0 && $_SESSION['pcs_show'] == 1) { ?>
          <a class="btn btn-outline-primary text-capitalize fs-12"
            href="?do=show-piece&dir-id=<?php echo $piece['direction_id'] ?>&src-id=<?php echo $piece['id'] ?>"><i
              class="bi bi-eye"></i></a>
          <?php } ?>
          <?php if ($_SESSION['pcs_delete'] == 1) { ?>
          <button type="button" class="btn btn-outline-danger text-capitalize form-control bg-gradient fs-12"
            data-bs-toggle="modal" data-bs-target="#deletePieceModal" id="delete-piece"
            data-page-title="<?php echo $name ?>" data-piece-id="<?php echo $piece['id'] ?>"
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