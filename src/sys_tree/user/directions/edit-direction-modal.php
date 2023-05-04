<!-- Modal -->
<div class="modal fade" id="editDirectionModal" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
  <div class="modal-dialog modal-dialog-centered modal-type-dialog" >
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="m-auto modal-title h5 " id="staticBackdropLabel"><?php echo language("EDIT DIRECTION", @$_SESSION['systemLang']) ?></h5>
      </div>
      <div class="modal-body">
        <form action="?do=update-direction-info" method="POST" id="editDirection" onchange="form_validation(this)">
          <!-- type id -->
          <input type="hidden" name="updated-dir-id" id="updated-dir-id">
          <!-- start old direction name -->
          <div class="mb-sm-2 mb-md-3 row">
            <label for="updated-dir-name" class="col-sm-12 col-form-label text-capitalize"><?php echo language('THE DIRECTION', @$_SESSION['systemLang']) ?></label>
            <div class="col-sm-12 position-relative">
              <?php
                // create an object of Direction class
                $dir_obj = new Direction();
                // get all directions 
                $directions = $dir_obj->get_all_directions($_SESSION['company_id']);
                $directions_info = $directions[1]; 
              ?>
              <select class="form-select" id="updated-dir-name" name="updated-dir-name"  required>
                <option value="default" disabled selected><?php echo language('SELECT', @$_SESSION['systemLang'])." ".language('THE DIRECTION', @$_SESSION['systemLang']) ?></option>
                <!-- loop on pieces types -->
                <?php foreach ($directions_info as $dir) { ?>
                  <option value="<?php echo $dir['direction_id'] ?>"><?php echo $dir['direction_name'] ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <!-- end old direction name -->
          <!-- start direction name field -->
          <div class="mb-sm-2 mb-md-3 row">
              <label for="new-direction-name" class="col-sm-12 col-form-label text-capitalize" ><?php echo language('DIRECTION NAME', @$_SESSION['systemLang']) ?></label>
              <div class="col-sm-12 position-relative">
                <input type="text" class="form-control" name="new-direction-name" id="new-direction-name" placeholder="<?php echo language('DIRECTION NAME', @$_SESSION['systemLang']) ?>" onblur="direction_validation(this)" onblur="direction_validation(this)" required>
                <div id="passHelp" class="form-text"><?php echo language('MAKE SURE YOU ENTER THE FULL NAME OF THE DIRECTION', @$_SESSION['systemLang']) ?></div>
              </div>
          </div>
          <!-- end direction name field -->
        </form>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-primary py-1 fs-12" form="editDirection" onclick="form_validation(this.form, 'submit')"><?php echo language("SAVE CHANGES", @$_SESSION['systemLang']) ?></button>
          <button type="button" class="btn btn-outline-secondary py-1 px-3 fs-12" data-bs-dismiss="modal"><?php echo language("CLOSE", @$_SESSION['systemLang']) ?></button>
      </div>
    </div>
  </div>
</div>