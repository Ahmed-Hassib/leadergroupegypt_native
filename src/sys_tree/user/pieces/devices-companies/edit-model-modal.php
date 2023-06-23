<!-- Modal -->
<div class="modal fade" id="editDeviceModel" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-model-dialog" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="m-auto modal-title h5 " id="staticBackdropLabel"><?php echo language("EDIT MODEL INFO", @$_SESSION['systemLang']) ?></h5>
      </div>
      <div class="modal-body">
        <form action="?do=devices-companies&action=update-model" method="POST" id="edit-model" onchange="form_validation(this)">
          <input type="hidden" name="model-id" id="model-id">
          <!-- start model name -->
          <div class="mb-sm-2 mb-md-3 row">
            <label for="old-model-name" class="col-sm-12 col-form-label text-capitalize"><?php echo language('OLD MODEL NAME', @$_SESSION['systemLang']) ?></label>
            <div class="col-sm-12 position-relative">
              <input type="text" class="form-control" id="old-model-name" name="old-model-name" autocomplete="off" required readonly />
            </div>
          </div>
          <!-- end model name -->
          <!-- start model name -->
          <div class="mb-sm-2 mb-md-3 row">
            <label for="new-model-name" class="col-sm-12 col-form-label text-capitalize"><?php echo language('NEW MODEL NAME', @$_SESSION['systemLang']) ?></label>
            <div class="col-sm-12 position-relative">
              <input type="text" class="form-control" id="new-model-name" name="new-model-name" autocomplete="off" required />
            </div>
          </div>
          <!-- end model name -->
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary py-1 px-5 fs-12" form="edit-model" onclick="form_validation(this.form, 'submit')"><?php echo language("SAVE CHANGES", @$_SESSION['systemLang']) ?></button>
        <button type="button" class="btn btn-outline-secondary py-1 px-3 fs-12" data-bs-dismiss="modal"><?php echo language("CLOSE", @$_SESSION['systemLang']) ?></button>
      </div>
    </div>
  </div>
</div>