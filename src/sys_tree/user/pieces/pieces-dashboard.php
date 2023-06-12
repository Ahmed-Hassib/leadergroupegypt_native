<!-- start home stats container -->
<div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
  <!-- start stats -->
  <div class="stats">
    <div class="mb-3 hstack gap-3">
      <div class="<?php if ($_SESSION['pcs_add'] == 0) {echo 'd-none';} ?>">
        <a href="?name=pieces&do=add-new-piece" class="btn btn-outline-primary py-1 fs-12">
          <i class="bi bi-plus"></i>
          <?php echo language('ADD NEW PIECE', @$_SESSION['systemLang']) ?>
        </a>
      </div>
      <div class="<?php if ($_SESSION['pcs_show'] == 0) {echo 'd-none';} ?>">
        <a href="?name=pieces&do=devices-companies" class="btn btn-outline-primary py-1 fs-12">
          <i class="bi bi-hdd-rack"></i>
          <?php echo language('MANAGE', @$_SESSION['systemLang'])." ".language('PIECES TYPES', @$_SESSION['systemLang']) ?>
        </a>
      </div>
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
          <?php
          if (!isset($pcs_obj)) {
            // create an object of Pieces class
            $pcs_obj = new Pieces();
          }
          ?>
          <div class="row row-cols-sm-1 g3">
            <div class="col-12">
              <div class="card card-stat bg-primary shadow-sm border border-1">
                <div class="card-body">
                  <?php $pieces = $pcs_obj->count_records("`id`", "`pieces_info`", "WHERE `is_client` = 0 AND `company_id` = ".$_SESSION['company_id']);   ?>
                  <h5 class="card-title text-capitalize"><?php echo language('TOTAL', @$_SESSION['systemLang'])." ".language('PIECES', @$_SESSION['systemLang']) ?></h5>
                  <span class="bg-info icon-container <?php echo @$_SESSION['systemLang'] == 'ar' ? 'icon-container-left' : 'icon-container-right' ?>"><i class="bi bi-hdd-rack"></i></span>
                </div>
                <div class="card-footer">
                  <span class="nums">
                    <a href="?name=pieces&do=show-all-pieces" class="num stretched-link text-black" data-goal="<?php echo $pieces; ?>">0</a>
                  </span>
                </div>
                <?php $newPcsCounter = $db_obj->count_records("`id`", "`pieces_info`", "WHERE `is_client` = 0 AND `added_date` = CURRENT_DATE AND `company_id` = ".$_SESSION['company_id']); ?>
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
    
    <div class="mb-3 row row-cols-1 g-3">
      <!-- latest added pieces -->
      <div class="col-12 <?php if ($_SESSION['user_show'] == 0) {echo 'd-none';} ?>">
        <div class="section-block">
          <div class="section-header">
            <h5 class="h5 text-capitalize"><?php echo language('LATEST ADDED PIECES', @$_SESSION['systemLang']) ?></h5>
            <p class="text-muted "><?php echo language('HERE WILL SHOW LATEST 10 ADDED PIECES', @$_SESSION['systemLang']) ?></p>
          <hr>
        </div>
        <!-- get latest added pieces -->
        <?php $latest_added_pcs = $pcs_obj->get_latest_records("*", "`pieces_info`", "WHERE `is_client` = 0 AND `company_id` = ".$_SESSION['company_id'], "`id`", 10); ?>
          <div class="table-responsive-sm">
            <table class="table table-striped table-bordered  display compact table-style w-100" id="latest-pieces">
              <thead class="primary text-capitalize">
                <tr>
                  <th style="max-width: 25px">#</th>
                  <th style="min-width: 100px" class="text-uppercase"><?php echo language('IP', @$_SESSION['systemLang']) ?></th>
                  <th style="min-width: 150px"><?php echo language('PIECE NAME', @$_SESSION['systemLang']) ?></th>
                  <th style="min-width: 100px"><?php echo language('THE DIRECTION', @$_SESSION['systemLang']) ?></th>
                  <th style="min-width: 100px"><?php echo language('ADDED DATE', @$_SESSION['systemLang']) ?></th>
                  <th style="min-width: 25px"><?php echo language('CONTROL', @$_SESSION['systemLang']) ?></th>
                </tr>
              </thead>
              <tbody>
                <?php $index = 0; ?>
                <?php foreach ($latest_added_pcs as $key => $pcs) { ?>
                  <tr>
                    <!-- index -->
                    <td ><?php echo ++$index; ?></td>
                    <!-- piece ip -->
                    <td class="text-capitalize <?php echo $pcs['ip'] == '0.0.0.0' ? 'text-danger' : '' ?>" data-ip="<?php echo convertIP($pcs['ip']) ?>"><?php echo $pcs['ip'] == '0.0.0.0' ?  language("NO DATA ENTERED", @$_SESSION['systemLang']) :"<a href='http://" . $pcs['ip'] . "' target='_blank'>" . $pcs['ip'] . '</a>'; ?></td>
                    <!-- piece name -->
                    <td>
                      <a class="<?php if ($_SESSION['pcs_update'] == 0) {echo 'd-none';} ?>" href="?name=pieces&do=edit-piece&piece-id=<?php echo $pcs['id']; ?>" target="">
                        <?php echo trim($pcs['full_name'], ' '); ?>
                        <?php if ($pcs['direction_id'] == 0) { ?>
                          <i class="bi bi-exclamation-triangle-fill text-danger" title="<?php echo language("DIRECTION NO DATA ENTERED", @$_SESSION['systemLang']) ?>"></i>
                        <?php } ?>
                      </a>
                      <!-- <?php $diff = date_diff(date_create($pcs['added_date']), date_create(date('Y-m-d'))); ?>
                      <span class="badge bg-danger p-1 <?php echo @$_SESSION['systemLang'] == 'ar' ? 'me-1' : 'ms-1' ?>"><?php echo "$diff->days " . language('DAYS', @$_SESSION['systemLang']) ?></span> -->
                    </td>
                    <!-- piece direction -->
                    <td class="text-capitalize" >
                      <?php if ($pcs['direction_id'] != 0) { ?>
                        <a href="<?php echo $nav_up_level ?>directions/index.php?do=show-direction-tree&dir-id=<?php echo $pcs['direction_id']; ?>">
                          <?php echo $db_obj->select_specific_column("`direction_name`", "`direction`", "WHERE `direction_id` = ".$pcs['direction_id'])[0]['direction_name']; ?>
                        </a>
                      <?php } else { ?>
                        <p class="text-danger "><?php echo language("NO DATA ENTERED", @$_SESSION['systemLang']) ?></p>
                      <?php } ?>
                    </td>
                    <!-- added date -->
                    <td><?php echo $pcs['added_date'] == '0000-00-00' ? language("NO DATA ENTERED", @$_SESSION['systemLang']) : $pcs['added_date'] ?></td>
                    <!-- control -->
                    <td>
                      <a class="btn btn-success text-capitalize fs-12 <?php if ($_SESSION['pcs_update'] == 0) {echo 'd-none';} ?>" href="?name=pieces&do=edit-piece&piece-id=<?php echo $pcs['id']; ?>" target=""><i class="bi bi-pencil-square"></i><!-- <?php echo language('EDIT', @$_SESSION['systemLang']) ?> --></a>
                      <a class="btn btn-outline-primary text-capitalize fs-12 <?php if ($_SESSION['pcs_show'] == 0) {echo 'd-none';} ?>" href="?name=pieces&do=show-piece&dir-id=<?php echo $pcs['direction_id'] ?>&src-id=<?php echo $pcs['id'] ?>" ><i class="bi bi-eye"></i><!-- <?php echo language('SHOW', @$_SESSION['systemLang']).' '.language('PIECES', @$_SESSION['systemLang']) ?> --></a>
                      <?php if ($_SESSION['pcs_delete'] == 1) { ?>
                        <button type="button" class="btn btn-outline-danger text-capitalize form-control bg-gradient fs-12" data-bs-toggle="modal" data-bs-target="#deletePieceModal" id="delete-piece" data-page-title="<?php echo $page_title ?>" data-piece-id="<?php echo $pcs['id'] ?>" data-piece-name="<?php echo $pcs['full_name'] ?>" onclick="confirm_delete_piece(this)"><i class="bi bi-trash"></i></button>
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
  </div>    
  <!-- end stats -->
</div>
<!-- end home stats container -->