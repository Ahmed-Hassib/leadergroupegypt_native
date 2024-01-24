<?php
// check date
$date = isset($_GET['date']) && !empty($_GET['date']) ? trim($_GET['date'], " ") : null;
// check period start
$period_start = isset($_GET['period-start']) && !empty($_GET['period-start']) ? trim($_GET['period-start'], " ") : null;
// check period end
$period_end = isset($_GET['period-end']) && !empty($_GET['period-end']) ? trim($_GET['period-end'], " ") : Date('Y-m-d');
// create an object of TemporaryDeletes class
$temp_deletes_obj = new PiecesDeletes();
// craete an object of Pieces class
$pcs_obj = new Pieces();
?>
<div class="container" dir="<?php echo $page_dir ?>">
  <div class="mb-3 row g-3">
    <div class="col-sm-12 col-lg-4">
      <div class="section-block">
        <header class="section-header">
          <h5 class="h5 text-capitalize">
            <?php echo lang('SELECT DAY'); ?>
          </h5>
          <hr>
        </header>
        <form action="" method="get" name="malfunction-year-form">
          <input type="hidden" name="do" value="pieces">
          <div class="row g-3 align-items-baseline">
            <div class="col-7">
              <div class="form-floating">
                <input type="date" class="form-control" name="date" id="date" min="2022-01-01" max="<?php echo Date('Y-m-d') ?>" value="<?php echo $date ?>" required>
                <label for="date">
                  <?php echo lang('THE DATE') ?>
                </label>
              </div>
            </div>
            <div class="col-5">
              <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-check-all"></i>
                <?php echo lang('APPLY') ?>
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <div class="col-sm-12 col-lg-8">
      <div class="section-block">
        <header class="section-header">
          <h5 class="h5 text-capitalize">
            <?php echo lang('SELECT PERIOD'); ?>
          </h5>
          <hr>
        </header>
        <form action="" method="get" name="malfunction-year-form">
          <input type="hidden" name="do" value="pieces">
          <div class="row g-3 align-items-baseline">
            <div class="col-sm-6 col-md-4">
              <div class="form-floating">
                <input type="date" class="form-control" name="period-start" id="period-start" min="2022-01-01" max="<?php echo Date('Y-m-d') ?>" value="<?php echo $period_start ?>" required>
                <label for="date">
                  <?php echo lang('PERIOD START') ?>
                </label>
              </div>
            </div>
            <div class="col-sm-6 col-md-4">
              <div class="form-floating">
                <input type="date" class="form-control" name="period-end" id="period-end" min="2022-01-01" max="<?php echo Date('Y-m-d') ?>" value="<?php echo $period_end ?>" required>
                <label for="date">
                  <?php echo lang('PERIOD END') ?>
                </label>
              </div>
            </div>
            <div class="col-sm-12 col-md-4">
              <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-check-all"></i>
                <?php echo lang('APPLY') ?>
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <?php if ($date != null || ($period_start != null && $period_end != null)) { ?>
    <div class="row g-3">
      <div class="col-sm-12">
        <div class="section-block">
          <header class="section-header">
            <h5 class="h5 text-capitalize">
              <?php
              if ($date != null) {
                $title = lang('YOU ARE SHOWING DATA FOR A DAY') . " {$date}";
                // get all deleted pieces of specific date
                $deleted_pieces = $temp_deletes_obj->get_all_deleted_pieces($date);
              } elseif ($period_start != null && $period_end != null) {
                $title = lang('YOU ARE SHOWING DATA FOR A PERIOD') . "  " . lang('FROM') . " {$period_start} " . lang('TO') . " {$period_end}";
                // get all deleted pieces of specific date
                $deleted_pieces = $temp_deletes_obj->get_all_deleted_pieces($period_start, $period_end);
              } else {
                $title = lang('NOT ASSIGNED');
              }
              // display title
              echo $title;
              ?>
            </h5>
            <hr>
          </header>
          <!-- start table container -->
          <div class="table-responsive-sm">
            <!-- strst pieces table -->
            <table class="table table-bordered table-striped display display-big-data compact table-style" style="width:100%">
              <thead class="primary text-capitalize">
                <tr>
                  <!-- <th></th> -->
                  <th>#</th>
                  <th class="big-data">
                    <?php echo lang('PCS NAME', 'pieces') ?>
                  </th>
                  <th class="big-data">
                    <?php echo lang('ADDRESS') ?>
                  </th>
                  <th>
                    <?php echo lang('PHONE') ?>
                  </th>
                  <th>
                    <?php echo lang('THE DIRECTION', 'directions') ?>
                  </th>
                  <th>
                    <?php echo lang('MAC') ?>
                  </th>
                  <th class="date-data">
                    <?php echo lang('DELETED DATE') ?>
                  </th>
                  <th>
                    <?php echo lang('CONTROL') ?>
                  </th>
                </tr>
              </thead>
              <tbody id="piecesTbl">
                <?php if ($deleted_pieces != null) { ?>
                  <?php foreach ($deleted_pieces as $index => $piece) { ?>
                    <tr>
                      <!-- <td class="dt-control" onclick="show_hide_extra_data(this, <?php echo $index ?>)"></td> -->
                      <!-- index -->
                      <td>
                        <?php echo ++$index; ?>
                      </td>
                      <!-- client name -->
                      <td>
                        <?php echo trim($piece['full_name'], ' ') ?>
                      </td>
                      <!-- client address -->
                      <td>
                        <?php echo trim($piece['address'], ' '); ?>
                      </td>
                      <!-- client phone -->
                      <td>
                        <?php echo trim($piece['phone'], ' '); ?>
                      </td>
                      <!-- client direction -->
                      <td class="text-capitalize">
                        <?php
                        if (!empty($db_obj->select_specific_column("`direction_name`", "`direction`", "WHERE `direction_id` = " . $piece['direction_id']))) {
                          $dir_name = $db_obj->select_specific_column("`direction_name`", "`direction`", "WHERE `direction_id` = " . $piece['direction_id'])[0]['direction_name'];
                        } else {
                          $dir_name = null;
                        }
                        ?>
                        <?php if ($piece['direction_id'] != 0 && $_SESSION['sys']['dir_update'] == 1 && $dir_name != null) { ?>
                          <a target="_blank" href="<?php echo $nav_up_level ?>directions/index.php?do=show-direction-tree&dir-id=<?php echo base64_encode($piece['direction_id']); ?>">
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
                      <!-- mac address -->
                      <td>
                        <?php
                        // check result
                        if (empty($piece['mac_add'])) {
                          $mac_addr = lang('NOT ASSIGNED');
                          $mac_class = 'text-danger fs-12 fw-bold';
                        } else {
                          $mac_addr = $piece['mac_add'];
                          $mac_class = '';
                        }
                        ?>
                        <span class="<?php echo isset($mac_class) ? $mac_class : '' ?>">
                          <?php echo $mac_addr ?>
                        </span>
                      </td>
                      <!-- deleted date -->
                      <td>
                        <?php
                        // check result
                        if ($piece['deleted_date'] == '0000-00-00') {
                          $date = lang('NOT ASSIGNED');
                          $date_class = 'text-danger fs-12 fw-bold';
                        } else {
                          $date = $piece['deleted_date'];
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
                          <a class="btn btn-success text-capitalize fs-12 " href="?do=pieces&action=restore&id=<?php echo base64_encode($piece['id']); ?>">
                            <i class="bi bi-arrow-clockwise"></i>
                            <?php echo lang('RESTORE') ?>
                          </a>
                        <?php } ?>
                        <?php if ($_SESSION['sys']['pcs_delete'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) { ?>
                          <button type="button" class="btn btn-outline-danger text-capitalize form-control bg-gradient fs-12" data-bs-toggle="modal" data-bs-target="#deletePieceModal" id="delete-piece-<?php echo ($index + 1) ?>" data-piece-id="<?php echo base64_encode($piece['id']) ?>" data-piece-name="<?php echo $piece['full_name'] ?>" onclick="confirm_delete_piece(this, true)"><i class="bi bi-trash"></i>
                            <?php echo lang('PERMANENT DELETE') ?>
                          </button>
                        <?php } ?>
                      </td>
                    </tr>
                  <?php } ?>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  <?php } ?>

</div>


<?php if ($_SESSION['sys']['pcs_delete'] == 1 && isset($deleted_pieces) && $deleted_pieces != null) { ?>
  <?php include_once "delete-modal.php"; ?>

  <script>
    let deleted_piece_name_in_modal = document.querySelector('#deleted-piece-name');
    let deleted_piece_url_in_modal = document.querySelector('#deleted-piece-url');

    function confirm_delete_piece(btn, will_back = null) {
      // get piece info
      let piece_id = btn.dataset.pieceId;
      let piece_name = btn.dataset.pieceName;
      // prepare url
      let url = `../pieces/index.php?do=permanent-delete-piece&piece-id=${piece_id}&deleted=true&back=true`;
      // put it into the modal
      deleted_piece_name_in_modal.textContent = `'${piece_name}'`;
      deleted_piece_url_in_modal.href = url;
    }
  </script>
<?php } ?>