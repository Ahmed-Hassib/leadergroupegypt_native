<!-- start home stats container -->
<div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
  <!-- start stats -->
  <div class="stats">
    <div class="mb-3 hstack gap-3">
      <?php if ($_SESSION['pcs_add'] == 1) { ?>
        <a href="?do=add-new-piece" class="btn btn-outline-primary py-1 fs-12">
          <i class="bi bi-plus"></i>
          <?php echo language('ADD NEW PIECE', @$_SESSION['systemLang']) ?>
        </a>
      <?php } ?>
      <?php if ($_SESSION['pcs_show'] == 1) { ?>
        <a href="?do=devices-companies" class="btn btn-outline-primary py-1 fs-12">
          <i class="bi bi-hdd-rack"></i>
          <?php echo language('MANAGE', @$_SESSION['systemLang']) . " " . language('PIECES TYPES', @$_SESSION['systemLang']) ?>
        </a>
      <?php } ?>
    </div>

    <!-- start new design -->
    <div class="mb-3 row g-3 align-items-stretch justify-content-start">
      <!-- total numbers of pieces/pieces -->
      <div class="col-sm-12 col-lg-5">
        <div class="section-block">
          <div class="section-header">
            <h5 class="h5 text-capitalize"><?php echo language("PIECES STATISTICS", @$_SESSION['systemLang']) ?></h5>
            <p class="text-muted "><?php echo language("HERE WILL SHOW SOME STATISTICS ABOUT THE NUMBERS OF PIECES", @$_SESSION['systemLang']) ?></p>
            <hr>
          </div>
          <?php if (!isset($pcs_obj)) { $pcs_obj = new Pieces(); } ?>
          <div class="row row-cols-sm-1 g3">
            <div class="col-12">
              <div class="card card-stat bg-primary shadow-sm border border-1">
                <div class="card-body">
                  <?php $pieces = $pcs_obj->count_records("`id`", "`pieces_info`", "WHERE `is_client` = 0 AND `company_id` = " . $_SESSION['company_id']);   ?>
                  <h5 class="card-title text-capitalize"><?php echo language('TOTAL', @$_SESSION['systemLang']) . " " . language('PIECES', @$_SESSION['systemLang']) ?></h5>
                  <span class="bg-info icon-container <?php echo @$_SESSION['systemLang'] == 'ar' ? 'icon-container-left' : 'icon-container-right' ?>"><i class="bi bi-hdd-rack"></i></span>
                </div>
                <div class="card-footer">
                  <span class="nums">
                    <a href="?do=show-all-pieces" class="num stretched-link text-black" data-goal="<?php echo $pieces; ?>">0</a>
                  </span>
                </div>
                <?php $newPcsCounter = $db_obj->count_records("`id`", "`pieces_info`", "WHERE `is_client` = 0 AND `added_date` = CURRENT_DATE AND `company_id` = " . $_SESSION['company_id']); ?>
                <?php if ($newPcsCounter > 0) { ?>
                  <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill border border-light bg-danger">
                    <span><?php echo $newPcsCounter ?></span>
                  </span>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php if ($_SESSION['user_show'] == 1) { ?>
      <?php
      $API->connect($ipRB, $Username, $clave);
      $users = $API->comm("/ip/firewall/nat/print", array(
        "?comment" => "mohamady"
      ));
      // $users = [];
      $target_user = !empty($users) && count($users) > 0 ? $users[1] : -1;
      ?>
      <div class="mb-3 row row-cols-1 g-3">
        <!-- latest added pieces -->
        <div class="col-12">
          <div class="section-block">
            <div class="section-header">
              <h5 class="h5 text-capitalize"><?php echo language('LATEST ADDED PIECES', @$_SESSION['systemLang']) ?></h5>
              <p class="text-muted "><?php echo language('HERE WILL SHOW LATEST 10 ADDED PIECES', @$_SESSION['systemLang']) ?></p>
              <hr>
            </div>
            <!-- get latest added pieces -->
            <?php $latest_added_pcs = $pcs_obj->get_latest_records("*", "`pieces_info`", "WHERE `is_client` = 0 AND `company_id` = " . $_SESSION['company_id'], "`id`", 10); ?>
            <div class="table-responsive-sm">
              <table class="table table-striped table-bordered  display compact table-style w-100" id="latest-pieces">
                <thead class="primary text-capitalize">
                  <tr>
                    <th style="max-width: 25px">#</th>
                    <th style="min-width: 200px" class="text-uppercase"><?php echo language('IP', @$_SESSION['systemLang']) ?></th>
                    <th style="min-width: 150px"><?php echo language('PIECE NAME', @$_SESSION['systemLang']) ?></th>
                    <th style="min-width: 100px"><?php echo language('THE DIRECTION', @$_SESSION['systemLang']) ?></th>
                    <th style="width: 70px"><?php echo language('ADDED DATE', @$_SESSION['systemLang']) ?></th>
                    <th style="width: 50px"><?php echo language('CONTROL', @$_SESSION['systemLang']) ?></th>
                  </tr>
                </thead>
                <tbody>
                  <?php $index = 0; ?>
                  <?php foreach ($latest_added_pcs as $key => $pcs) { ?>
                    <tr>
                      <!-- index -->
                      <td><?php echo ++$index; ?></td>
                      <!-- piece ip -->
                      <td class="text-capitalize" data-ip="<?php echo convert_ip($pcs['ip']) ?>">
                        <?php if ($pcs['ip'] == '0.0.0.0') { ?>
                          <span class="text-danger"><?php echo language("NO DATA ENTERED", @$_SESSION['systemLang']) ?></span>
                        <?php } else { ?>
                          <?php $ping = ping($pcs['ip']); ?>
                          <?php if ($ping['status'] == 1) { ?>
                            <span class="badge bg-danger mt-2 p-2 d-inline-block"></span>
                          <?php } else { ?>
                            <span class="badge bg-success mt-2 p-2 d-inline-block"></span>
                          <?php } ?>
                          <span><?php echo $pcs['ip'] ?></span>
                          <?php if ($target_user != -1) { ?>
                            <a class="btn btn-outline-primary fs-12 w-auto py-1 px-2" href="?do=prepare-ip&id=<?php echo base64_encode($target_user['.id']) ?>&address=<?php echo $pcs['ip'] ?>&port=443" target='_blank'><?php echo language('VISIT DEVICE', @$_SESSION['systemLang']) ?></a>
                          <?php } ?>
                          <button class="btn btn-outline-primary fs-12 px-3 py-1" data-bs-toggle="modal" data-bs-target="#pingModal" onclick="ping('<?php echo $pcs['ip'] ?>', <?php echo $_SESSION['ping_counter'] ?>)">ping</button>
                        <?php } ?>
                      </td>
                      <!-- piece name -->
                      <td>
                        <?php if ($_SESSION['pcs_update'] == 1) { ?>
                          <a href="?do=edit-piece&piece-id=<?php echo $pcs['id']; ?>" target="">
                            <?php echo trim($pcs['full_name'], ' '); ?>
                          </a>
                        <?php } else { ?>
                          <?php echo trim($pcs['full_name'], ' '); ?>
                        <?php } ?>
                        <?php if ($pcs['direction_id'] == 0) { ?>
                          <i class="bi bi-exclamation-triangle-fill text-danger" title="<?php echo language("DIRECTION NO DATA ENTERED", @$_SESSION['systemLang']) ?>"></i>
                        <?php } ?>
                        <!-- <?php $diff = date_diff(date_create($pcs['added_date']), date_create(date('Y-m-d'))); ?>
                      <span class="badge bg-danger p-1 <?php echo @$_SESSION['systemLang'] == 'ar' ? 'me-1' : 'ms-1' ?>"><?php echo "$diff->days " . language('DAYS', @$_SESSION['systemLang']) ?></span> -->
                      </td>
                      <!-- piece direction -->
                      <td class="text-capitalize">
                        <?php if ($pcs['direction_id'] != 0) { ?>
                          <a href="<?php echo $nav_up_level ?>directions/index.php?do=show-direction-tree&dir-id=<?php echo $pcs['direction_id']; ?>">
                            <?php echo $db_obj->select_specific_column("`direction_name`", "`direction`", "WHERE `direction_id` = " . $pcs['direction_id'])[0]['direction_name']; ?>
                          </a>
                        <?php } else { ?>
                          <p class="text-danger "><?php echo language("NO DATA ENTERED", @$_SESSION['systemLang']) ?></p>
                        <?php } ?>
                      </td>
                      <!-- added date -->
                      <td><?php echo $pcs['added_date'] == '0000-00-00' ? language("NO DATA ENTERED", @$_SESSION['systemLang']) : $pcs['added_date'] ?></td>
                      <!-- control -->
                      <td>
                        <?php if ($_SESSION['pcs_update'] == 1) { ?>
                          <a class="btn btn-success text-capitalize fs-12 py-1" href="?do=edit-piece&piece-id=<?php echo $pcs['id']; ?>" target=""><i class="bi bi-pencil-square"></i><!-- <?php echo language('EDIT', @$_SESSION['systemLang']) ?> --></a>
                        <?php } ?>
                        <?php if ($_SESSION['pcs_show'] == 1) { ?>
                          <a class="btn btn-outline-primary text-capitalize fs-12 py-1" href="?do=show-piece&dir-id=<?php echo $pcs['direction_id'] ?>&src-id=<?php echo $pcs['id'] ?>"><i class="bi bi-eye"></i><!-- <?php echo language('SHOW', @$_SESSION['systemLang']) . ' ' . language('PIECES', @$_SESSION['systemLang']) ?> --></a>
                        <?php } ?>
                        <?php if ($_SESSION['pcs_delete'] == 1) { ?>
                          <button type="button" class="btn btn-outline-danger text-capitalize form-control bg-gradient fs-12 py-1" data-bs-toggle="modal" data-bs-target="#deletePieceModal" id="delete-piece" data-page-title="<?php echo $page_title ?>" data-piece-id="<?php echo $pcs['id'] ?>" data-piece-name="<?php echo $pcs['full_name'] ?>" onclick="confirm_delete_piece(this, true)"><i class="bi bi-trash"></i></button>
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