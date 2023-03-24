<!-- Modal -->
<div class="modal fade" id="addNewDevice" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-company-dialog" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="m-auto modal-title h5 " id="staticBackdropLabel"><?php echo language("ADD NEW DEVICE", @$_SESSION['systemLang']) ?></h5>
      </div>
      <div class="modal-body">
        <form action="?name=pieces&do=devices-companies&action=insert-device" method="POST" id="addDevice" onchange="form_validation(this)">
          <input type="hidden" name="company-id" id="company-id" value="<?php echo $dev_company_id ?>">
          <!-- start company name -->
          <div class="mb-sm-2 mb-md-3 row">
            <label for="company-name" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('COMPANY NAME', @$_SESSION['systemLang']) ?></label>
            <div class="col-sm-12 col-md-8">
              <input type="text" class="form-control" id="company-name" name="company-name" value="<?php echo $dev_company_name ?>" autocomplete="off" required  readonly/>
            </div>
          </div>
          <!-- end company name -->
          <!-- start device name -->
          <div class="mb-sm-2 mb-md-3 row">
            <label for="device-name" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('PIECE NAME', @$_SESSION['systemLang']) ?></label>
            <div class="col-sm-12 col-md-8">
              <input type="text" class="form-control" id="device-name"  name="device-name" autocomplete="off" required />
            </div>
          </div>
          <!-- end device name -->

          <button type="button" class="btn btn-outline-success me-auto fs-12 py-1" onclick="add_model(this)" data-model-num="0">
            <i class="bi bi-plus"></i>
            <?php echo language("ADD MODEL", @$_SESSION['systemLang']) ?>
          </button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary py-1 px-5 fs-12" form="addDevice" onclick="form_validation(this.form, 'submit')"><?php echo language("ADD", @$_SESSION['systemLang']) ?></button>
        <button type="button" class="btn btn-outline-secondary py-1 px-3 fs-12" data-bs-dismiss="modal"><?php echo language("CLOSE", @$_SESSION['systemLang']) ?></button>
      </div>
    </div>
  </div>
</div>