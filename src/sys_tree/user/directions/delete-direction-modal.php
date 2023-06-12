<!-- Modal -->
<div class="modal fade" id="deleteDirectionModal" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
  <div class="modal-dialog modal-dialog-centered modal-type-dialog" >
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="m-auto modal-title h5 " id="staticBackdropLabel"><?php echo language("DELETE DIRECTION", @$_SESSION['systemLang']) ?></h5>
      </div>
      <div class="modal-body">
        <form action="?do=delete-direction" method="POST" id="deleteDirection">
          <!-- type id -->
          <input type="hidden" name="deleted-dir-id" id="deleted-dir-id">
          <!-- start old direction name -->
          <div class="mb-sm-2 mb-md-3 row">
            <label for="deleted-dir-name" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('THE DIRECTION', @$_SESSION['systemLang']) ?></label>
            <div class="col-sm-12 col-md-8">
              <?php
              if (!isset($dir_obj)) {
                // create an object of Direction class
                $dir_obj = new Direction();
              }
              // get all directions
              $dirs = $dir_obj->get_all_directions($_SESSION['company_id']);
              // data counter
              $dirs_counter = $dirs[0];
              // data rows
              $dires_data = $dirs[1]; 
              ?>
              <select class="form-select" id="deleted-dir-name" name="deleted-dir-name" onchange="document.getElementById('deleted-dir-id').value = this.value;" required>
                <option value="default" disabled selected><?php echo language('SELECT', @$_SESSION['systemLang'])." ".language('THE DIRECTION', @$_SESSION['systemLang']) ?></option>
                <!-- loop on pieces types -->
                <?php foreach ($dires_data as $dir) {
                  // clients condition
                  $clients_conditions   = "WHERE `direction_id` = '" . $dir['direction_id'] . "' AND `is_client` = 1 AND `company_id` = " . $_SESSION['company_id'];
                  // pieces condition
                  $pieces_conditions     = "WHERE `direction_id` = '" . $dir['direction_id'] . "' AND `is_client` = 0 AND `company_id` = " . $_SESSION['company_id'];
                  // count pieces
                  $pieces = $dir_obj->count_records("`id`", "pieces_info", $pieces_conditions);
                  // count clients
                  $clients = $dir_obj->count_records("`id`", "pieces_info", $clients_conditions);
                ?>
                  <?php if ($pieces == 0 && $clients == 0) { ?>
                    <option value="<?php echo $dir['direction_id'] ?>"><?php echo $dir['direction_name'] ?></option>
                  <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>
          <!-- end old direction name -->
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger py-1 fs-12" form="deleteDirection" onclick="form_validation(this.form, 'submit')"><i class="bi bi-trash"></i>&nbsp;<?php echo language("DELETE", @$_SESSION['systemLang']) ?></button>
        <button type="button" class="btn btn-outline-secondary py-1 px-3 fs-12" data-bs-dismiss="modal"><?php echo language("CLOSE", @$_SESSION['systemLang']) ?></button>
      </div>
    </div>
  </div>
</div>