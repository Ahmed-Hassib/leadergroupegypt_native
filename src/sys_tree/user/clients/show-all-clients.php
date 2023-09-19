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

  // $API->connect($ipRB, $Username, $clave);
  // $users =  $API->comm("/ip/firewall/nat/print", array(
  //   "?comment" => "mohamady"
  // ));
  $users = [];
  $target_user = !empty($users) && count($users) > 0 ? $users[1] : -1;

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
      <?php if ($_SESSION['sys']['clients_add'] == 1) { ?>
        <a href="?do=add-new-client" class="btn btn-outline-primary py-1 fs-12">
          <i class="bi bi-plus"></i>
          <?php echo lang('ADD NEW', $lang_file) ?>
        </a>
      <?php } ?>
    </div>
    <!-- start table container -->
    <div class="table-responsive-sm">
      <!-- strst pieces table -->
      <table class="table table-bordered display compact table-style" style="width:100%">
        <thead class="primary text-capitalize">
          <tr>
            <th></th>
            <th>#</th>
            <th>
              <?php echo lang('CLT NAME', $lang_file) ?>
            </th>
            <th>
              <?php echo lang('ADDR', $lang_file) ?>
            </th>
            <th>
              <?php echo lang('PHONE', $lang_file) ?>
            </th>
            <th>
              <?php echo lang('CONTROL') ?>
            </th>
          </tr>
        </thead>
        <tbody id="piecesTbl">
          <?php foreach ($all_data as $index => $client) { ?>
            <tr>
              <td class="dt-control" onclick="show_hide_extra_data(this, <?php echo $index ?>)"></td>
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
                  <i class="bi bi-exclamation-triangle-fill text-danger fw-bold" title="<?php echo lang("NO DATA") ?>"></i>
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
                // get client address
                $addr = $pcs_obj->select_specific_column("`address`", "`pieces_addr`", "WHERE `id` = " . $client['id']);
                // check result
                if (count($addr) > 0) {
                  echo trim($addr[0]['address']);
                } else { ?>
                  <span class="text-danger fs-12 fw-bold">
                    <?php echo lang('NO DATA') ?>
                  </span>
                <?php } ?>
              </td>
              <!-- client phone -->
              <td>
                <?php
                // get client phone
                $phones = $pcs_obj->select_specific_column("`phone`", "`pieces_phones`", "WHERE `id` = " . $client['id']);
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
                    href="?do=edit-client&client-id=<?php echo base64_encode($client['id']); ?>" target="_blank">
                    <i class="bi bi-pencil-square"></i>
                    <!-- <?php echo lang('EDIT') ?> -->
                  </a>
                <?php } ?>
                <?php if ($_SESSION['sys']['pcs_delete'] == 1) { ?>
                  <button type="button" class="btn btn-outline-danger text-capitalize form-control bg-gradient fs-12"
                    data-bs-toggle="modal" data-bs-target="#deleteClientModal" id="delete-client-<?php echo ($index + 1) ?>"
                    data-client-id="<?php echo base64_encode($client['id']) ?>"
                    data-client-name="<?php echo $client['full_name'] ?>" onclick="confirm_delete_client(this, true)"><i
                      class="bi bi-trash"></i></button>
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