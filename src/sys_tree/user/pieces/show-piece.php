<?php
// check if Get request dir-id is numeric and get the integer value
$dir_id = isset($_GET['dir-id']) && !empty($_GET['dir-id']) ? base64_decode($_GET['dir-id']) : -1;
// check if Get request src-id is numeric and get the integer value
$src_id = isset($_GET['src-id']) && !empty($_GET['src-id']) ? base64_decode($_GET['src-id']) : -1;
// check the direction and source id
if ($dir_id != -1 && $src_id != -1) {
  // create an object of Pieces class
  $pcs_obj = !isset($pcs_obj) ? new Pieces() : $pcs_obj;
  // get name of current devices
  $current_piece_name = $pcs_obj->select_specific_column("`full_name`", "`pieces_info`", "WHERE `id` = $src_id")[0]['full_name'];
  // condition
  $condition = "WHERE `company_id` = " . base64_decode($_SESSION['sys']['company_id']) . " AND `direction_id` = $dir_id AND `source_id` = $src_id"; // query condition
  // get all pieces
  $pieces_info = $pcs_obj->get_spec_pieces($condition);

  // counter
  $counter = $pieces_info[0];

  // $API->connect($ipRB, $Username, $clave);
  // $users =  $API->comm("/ip/firewall/nat/print", array(
  //   "?comment" => "mohamady"
  // ));
  $users = [];
  $target_user = !empty($users) && count($users) > 0 ? $users[1] : -1;

  // flag for include js code
  $is_big_data_ping = true;
  ?>
  <!-- start edit profile page -->
  <div class="container" dir="<?php echo $page_dir ?>">
    <!-- start header -->
    <header class="header mb-3">
      <div class="hstack gap-2">
        <?php if ($_SESSION['sys']['pcs_update'] == 1) { ?>
          <!-- edit current piece -->
          <div>
            <!-- Button trigger modal -->
            <a class="btn btn-outline-success fs-12 py-1"
              href="?do=edit-piece&piece-id=<?php echo base64_encode($src_id); ?>">
              <i class="bi bi-pencil d-sm-block d-md-none"></i>
              <span class="d-none d-md-block">
                <?php echo lang("EDIT CURR PCS", $lang_file) ?>
              </span>
            </a>
          </div>
          <!-- edit current piece -->
        <?php } ?>
        <?php $src_ip = $db_obj->select_specific_column("`ip`", "`pieces_info`", "WHERE `id` = $src_id")[0]['ip'] ?>
        <?php $src_port = $db_obj->select_specific_column("`port`", "`pieces_info`", "WHERE `id` = $src_id")[0]['port'] ?>
        <?php if ($src_ip !== '0.0.0.0' && $target_user != -1) { ?>
          <div>
            <!-- Button trigger modal -->
            <a class="btn btn-outline-primary fs-12 py-1"
              href="?do=prepare-ip&id=<?php echo base64_encode($target_user['.id']) ?>&address=<?php echo $src_ip ?>&port=<?php echo $src_port != 0 ? $src_port : '443' ?>"
              target="_blank">
              <i class="bi bi-box-arrow-in-up-right d-sm-block d-md-none"></i>
              <?php echo lang('VISIT DEVICE', $lang_file) ?>
            </a>
          </div>
        <?php } ?>
      </div>

      <h4 class="h4">
        <?php echo $current_piece_name ?>
      </h4>
    </header>
    <?php if ($counter > 0) { ?>
      <?php
      // get data
      $all_data = prepare_pcs_datatables($pieces_info[1], $lang_file);
      // json data
      $all_data_json = json_encode($all_data);
      ?>
      <!-- start table container -->
      <div class="table-responsive-sm">
        <!-- strst pieces table -->
        <table class="table table-bordered display compact table-style" style="width:100%">
          <thead class="primary text-capitalize">
            <tr>
              <th></th>
              <th>#</th>
              <th>
                <?php echo lang('PCS NAME', $lang_file) ?>
              </th>
              <th>
                <?php echo lang('PROP ADDR', $lang_file) ?>
              </th>
              <th>
                <?php echo lang('AGENT PHONE', $lang_file) ?>
              </th>
              <th>
                <?php echo lang('CONTROL') ?>
              </th>
            </tr>
          </thead>
          <tbody id="piecesTbl">
            <?php foreach ($all_data as $index => $piece) { ?>
              <?php $name = $piece['is_client'] ? 'clients' : 'pieces' ?>
              <tr>
                <td class="dt-control" onclick="show_hide_extra_data(this, <?php echo $index ?>)"></td>
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
                    <i class="bi bi-exclamation-triangle-fill text-danger fw-bold" title="<?php echo lang("NO DATA") ?>"></i>
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
                      <?php echo lang('NO DATA') ?>
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
                      <?php echo lang('NO DATA') ?>
                    </span>
                  <?php } ?>
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


<script>
  var pcs_data_tables = <?php echo $all_data_json ?>;
</script>