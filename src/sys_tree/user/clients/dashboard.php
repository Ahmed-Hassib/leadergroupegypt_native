<?php
// // change ir in api
// $users = $API->comm("/ip/firewall/nat/add", array(
//   "action" => "dst-nat",
//   "chain" => "dstnat",
//   "comment" => "hassib",
//   "dst-port" => "5003",
//   "in-interface" => "MANAGEMENT-SYSTEM",
//   "protocol" => "tcp",
//   "to-addressed" => "192.168.60.17",
//   "to-ports" => "80"
// ));
?>
<!-- start home stats container -->
<div class="container" dir="<?php echo $page_dir ?>">
  <!-- start stats -->
  <div class="stats">
    <div class="mb-3 hstack gap-3">
      <?php if ($_SESSION['sys']['clients_add'] == 1) { ?>
        <a href="?do=add-new-client" class="btn btn-outline-primary py-1 fs-12">
          <i class="bi bi-person-plus"></i>
          <?php echo lang('ADD NEW', $lang_file) ?>
        </a>
      <?php } ?>
    </div>

    <!-- start new design -->
    <div class="mb-3 row g-3 align-items-stretch justify-content-start">
      <!-- total numbers of clients -->
      <div class="col-sm-12 col-lg-5">
        <div class="section-block">
          <div class="section-header">
            <h5 class="h5 text-capitalize">
              <?php echo lang("CLT STATISTICS", $lang_file) ?>
            </h5>
            <p class="text-muted ">
              <?php echo lang("CLT NOTE", $lang_file) ?>
            </p>
            <hr>
          </div>
          <?php $pcs_obj = !isset($pcs_obj) ? new Pieces() : $pcs_obj; ?>
          <div class="row row-cols-sm-1 gx-3 gy-5">
            <div class="col-12">
              <div class="card card-stat bg-primary shadow-sm border border-1">
                <div class="card-body">
                  <?php $clients = $pcs_obj->count_records('`id`', '`pieces_info`', 'WHERE `is_client` = 1 AND `company_id` = ' . base64_decode($_SESSION['sys']['company_id'])); ?>
                  <h5 class="card-title text-capitalize">
                    <?php echo lang('CLIENTS') ?>
                  </h5>
                  <span
                    class="bg-info icon-container <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'icon-container-left' : 'icon-container-right' ?>"><i
                      class="bi bi-people"></i></span>
                </div>
                <div class="card-footer">
                  <span class="nums">
                    <a href="?do=show-all-clients" class="num stretched-link text-black"
                      data-goal="<?php echo $clients; ?>">0</a>
                  </span>
                </div>
                <?php $newPcsCounter = $db_obj->count_records("`id`", "`pieces_info`", "WHERE `is_client` = 1 AND `added_date` = CURRENT_DATE AND `company_id` = " . base64_decode($_SESSION['sys']['company_id'])); ?>
                <?php if ($newPcsCounter > 0) { ?>
                  <span
                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill border border-light bg-danger">
                    <span>
                      <?php echo $newPcsCounter . ' ' . lang('NEW') ?>
                    </span>
                  </span>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php if ($_SESSION['sys']['clients_show'] == 1) { ?>
      <?php
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
      ?>
      <!-- latest added clients -->
      <div class="mb-3 row row-cols-1 g-3">
        <div class="col-12">
          <div class="section-block">
            <div class="section-header">
              <h5 class="h5 text-capitalize">
                <?php echo lang('LATEST', $lang_file) ?>
              </h5>
              <p class="text-muted ">
                <?php echo lang('LATEST NOTE', $lang_file) ?>
              </p>
              <hr>
            </div>
            <!-- get latest added clients -->
            <?php $latest_added_clients = $pcs_obj->get_latest_records("*", "`pieces_info`", "WHERE `is_client` = 1 AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']), "`id`", 10); ?>
            <?php
              if (count($latest_added_clients) > 0) {
                // get data
                $all_data = prepare_pcs_datatables($latest_added_clients, $lang_file);
                // json data
                $all_data_json = json_encode($all_data);
              } else {
                $all_data = [];
              }
              ?>
            <div class="table-responsive-sm">
              <!-- strst pieces table -->
              <table class="table table-bordered table-striped pcs-data display compact table-style" style="width:100%">
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
                          <i class="bi bi-exclamation-triangle-fill text-danger fw-bold"
                            title="<?php echo lang("NOT ASSIGNED") ?>"></i>
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
                            <?php echo lang('NOT ASSIGNED') ?>
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
                            <?php echo lang('NOT ASSIGNED') ?>
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
                            data-bs-toggle="modal" data-bs-target="#deleteClientModal"
                            id="delete-client-<?php echo ($index + 1) ?>"
                            data-client-id="<?php echo base64_encode($client['id']) ?>"
                            data-client-name="<?php echo $client['full_name'] ?>"
                            onclick="confirm_delete_client(this, true)"><i class="bi bi-trash"></i></button>
                        <?php } ?>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>
  <!-- end stats -->
</div>
<!-- end home stats container -->

<?php if (count($latest_added_clients) > 0) { ?>
  <script>
    var pcs_data_tables = <?php echo $all_data_json ?>;
  </script>
<?php } ?>