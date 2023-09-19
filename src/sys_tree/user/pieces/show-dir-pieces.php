<?php
// create an object of Pieces class
$pcs_obj = !isset($pcs_obj) ? new Pieces() : $pcs_obj;

// get direction id
$type = isset($_GET['type']) ? $_GET['type'] : -1;
// get type
$dir_id = isset($_GET['dir-id']) && !empty($_GET['dir-id']) ? base64_decode($_GET['dir-id']) : -1;
// condition
$condition = "WHERE `pieces_info`.`is_client` = $type AND `pieces_info`.`direction_id` = $dir_id";
// get all pieces
$all_pieces_data = $pcs_obj->get_spec_pieces($condition);
// get counter flag
$counter = $all_pieces_data[0];
// get direction name
$dir_name = $pcs_obj->select_specific_column("`direction_name`", "`direction`", "WHERE `direction_id` = " . $dir_id)[0]['direction_name'];

if ($_GET['type'] == -1) {
  $main_title = "SHOW DIR UNK";
} else {
  $main_title = "SHOW DIR PCS";
}
?>
<!-- start edit profile page -->
<div class="container" dir="<?php echo $page_dir ?>">
  <!-- start header -->
  <header class="header mb-3">
    <h4 class="h4">
      <?php echo lang($main_title, 'directions') ?>
    </h4>
    <h5 class="h5">
      <?php echo $dir_name ?>
    </h5>
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
</div>
<?php
// check counter
if ($counter == true) {
  // get data
  $all_data = prepare_pcs_datatables($all_pieces_data[1], $lang_file);
  // json data
  $all_data_json = json_encode($all_data);

  // $API->connect($ipRB, $Username, $clave);
  // $users =  $API->comm("/ip/firewall/nat/print", array(
  //   "?comment" => "mohamady"
  // ));
  $users = [];
  $target_user = !empty($users) && count($users) > 0 ? $users[1] : -1;

  // flag for include js code
  $is_big_data_ping = true;
  ?>
  <div class="container" dir="<?php echo $page_dir ?>">
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
  </div>
<?php } else {
  // include no data founded module
  include_once $globmod . 'no-data-founded-no-redirect.php';
} ?>


<script>
  var pcs_data_tables = <?php echo $all_data_json ?>;
</script>