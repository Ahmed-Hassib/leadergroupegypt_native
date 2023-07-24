<!-- start home stats container -->
<div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
  <!-- start stats -->
  <div class="stats">
    <div class="mb-3 hstack gap-3">
      <?php if ($_SESSION['clients_add'] == 1) { ?>
        <a href="?do=add-new-client" class="btn btn-outline-primary py-1 fs-12">
          <i class="bi bi-person-plus"></i>
          <?php echo language('ADD NEW CLIENT', @$_SESSION['systemLang']) ?>
        </a>
      <?php } ?>
    </div>

    <!-- start new design -->
    <div class="mb-3 row g-3 align-items-stretch justify-content-start">
      <!-- total numbers of clients -->
      <div class="col-sm-12 col-lg-5">
        <div class="section-block">
          <div class="section-header">
            <h5 class="h5 text-capitalize"><?php echo language("CLIENTS STATISTICS", @$_SESSION['systemLang']) ?></h5>
            <p class="text-muted "><?php echo language("HERE WILL SHOW SOME STATISTICS ABOUT THE NUMBERS OF CLIENTS", @$_SESSION['systemLang']) ?></p>
            <hr>
          </div>
          <?php if (!isset($pcs_obj)) {
            $pcs_obj = new Pieces();
          } ?>
          <div class="row row-cols-sm-1 gx-3 gy-5">
            <div class="col-12">
              <div class="card card-stat bg-primary shadow-sm border border-1">
                <div class="card-body">
                  <?php $clients = $pcs_obj->count_records('`id`', '`pieces_info`', 'WHERE `is_client` = 1 AND `company_id` = ' . $_SESSION['company_id']); ?>
                  <h5 class="card-title text-capitalize"><?php echo language('TOTAL', @$_SESSION['systemLang']) . " " . language('CLIENTS', @$_SESSION['systemLang']) ?></h5>
                  <span class="bg-info icon-container <?php echo @$_SESSION['systemLang'] == 'ar' ? 'icon-container-left' : 'icon-container-right' ?>"><i class="bi bi-people"></i></span>
                </div>
                <div class="card-footer">
                  <span class="nums">
                    <a href="?do=show-all-clients" class="num stretched-link text-black" data-goal="<?php echo $clients; ?>">0</a>
                  </span>
                </div>
                <?php $newPcsCounter = $db_obj->count_records("`id`", "`pieces_info`", "WHERE `is_client` = 1 AND `added_date` = CURRENT_DATE AND `company_id` = " . $_SESSION['company_id']); ?>
                <?php if ($newPcsCounter > 0) { ?>
                  <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill border border-light bg-danger">
                    <span><?php echo $newPcsCounter . ' ' . language('NEW', @$_SESSION['systemLang']) ?></span>
                  </span>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php if ($_SESSION['clients_show'] == 1) { ?>
      <?php
      $API->connect($ipRB, $Username, $clave);
      $users =  $API->comm("/ip/firewall/nat/print", array(
        "?comment" => "mohamady"
      ));
      $target_user = !empty($users) && count($users) > 0 ? $users[1] : -1;
      ?>
      <!-- latest added clients -->
      <div class="mb-3 row row-cols-1 g-3">
        <div class="col-12">
          <div class="section-block">
            <div class="section-header">
              <h5 class="h5 text-capitalize"><?php echo language('LATEST ADDED CLIENTS', @$_SESSION['systemLang']) ?></h5>
              <p class="text-muted "><?php echo language('HERE WILL SHOW LATEST 10 ADDED CLIENTS', @$_SESSION['systemLang']) ?></p>
              <hr>
            </div>
            <!-- get latest added clients -->
            <?php $latest_added_clients = $pcs_obj->get_latest_records("*", "`pieces_info`", "WHERE `is_client` = 1 AND `company_id` = " . $_SESSION['company_id'], "`id`", 10); ?>
            <div class="table-responsive-sm">
              <table class="table table-striped table-bordered  display compact w-100">
                <thead class="primary text-capitalize">
                  <tr>
                    <th style="max-width: 25px">#</th>
                    <th style="min-width: 100px" class="text-uppercase"><?php echo language('IP', @$_SESSION['systemLang']) ?></th>
                    <th style="min-width: 150px"><?php echo language('CLIENT NAME', @$_SESSION['systemLang']) ?></th>
                    <th style="min-width: 100px"><?php echo language('THE DIRECTION', @$_SESSION['systemLang']) ?></th>
                    <th style="min-width: 100px"><?php echo language('ADDED DATE', @$_SESSION['systemLang']) ?></th>
                    <th style="min-width: 25px"><?php echo language('CONTROL', @$_SESSION['systemLang']) ?></th>
                  </tr>
                </thead>
                <tbody>
                  <?php $index = 0; ?>
                  <?php foreach ($latest_added_clients as $key => $client) { ?>
                    <tr>
                      <!-- index -->
                      <td><?php echo ++$index; ?></td>
                      <!-- client ip -->
                      <td class="text-capitalize" data-ip="<?php echo convertIP($client['ip']) ?>">
                        <?php if ($client['ip'] == '0.0.0.0') { ?>
                          <span class="text-danger"><?php echo language("NO DATA ENTERED", @$_SESSION['systemLang']) ?></span>
                        <?php } else { ?>
                          <span><?php echo $client['ip'] ?></span>
                          <?php if ($target_user != -1) { ?>
                            <a class="btn btn-outline-primary fs-12 w-auto py-1 px-2" href="?do=prepare-ip&id=<?php echo base64_encode($target_user['.id']) ?>&address=<?php echo $client['ip'] ?>&port=443" target='_blank'><?php echo language('VISIT DEVICE', @$_SESSION['systemLang']) ?></a>
                          <?php } ?>
                        <?php } ?>
                      </td> <!-- client name -->
                      <td>
                        <?php if ($_SESSION['clients_update'] == 1) { ?>
                          <a href="?do=edit-client&client-id=<?php echo $client['id']; ?>" target="">
                            <?php echo trim($client['full_name'], ' '); ?>
                            <?php if ($client['direction_id'] == 0) { ?>
                              <i class="bi bi-exclamation-triangle-fill text-danger" title="<?php echo language("DIRECTION NO DATA ENTERED", @$_SESSION['systemLang']) ?>"></i>
                            <?php } ?>
                          </a>
                        <?php } else { ?>
                          <span><?php echo trim($client['full_name'], ' '); ?></span>
                        <?php } ?>
                      </td>
                      <!-- client direction -->
                      <td class="text-capitalize">
                        <?php if ($client['direction_id'] != 0) { ?>
                          <a href="<?php echo $nav_up_level ?>directions/index.php?do=show-direction-tree&dir-id=<?php echo $client['direction_id']; ?>">
                            <?php echo $db_obj->select_specific_column("`direction_name`", "`direction`", "WHERE `direction_id` = " . $client['direction_id'])[0]['direction_name']; ?>
                          </a>
                        <?php } else { ?>
                          <p class="text-danger "><?php echo language("NO DATA ENTERED", @$_SESSION['systemLang']) ?></p>
                        <?php } ?>
                      </td>
                      <!-- added date -->
                      <td><?php echo $client['added_date'] == '0000-00-00' ? language("NO DATA ENTERED", @$_SESSION['systemLang']) : $client['added_date'] ?></td>
                      <!-- control -->
                      <td>
                        <?php if ($_SESSION['clients_update'] == 1) { ?>
                          <a class="btn btn-success text-capitalize fs-12 py-1" href="?do=edit-client&client-id=<?php echo $client['id']; ?>" target=""><i class="bi bi-pencil-square"></i><!-- <?php echo language('EDIT', @$_SESSION['systemLang']) ?> --></a>
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
        </div>
      </div>
    <?php } ?>
  </div>
  <!-- end stats -->
</div>
<!-- end home stats container -->