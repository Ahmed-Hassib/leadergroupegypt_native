<!-- Modal -->
<div class="modal fade" id="addNewDevice" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-company-dialog" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="m-auto modal-title h5 " id="staticBackdropLabel"><?php echo language("ADD NEW DEVICE", @$_SESSION['systemLang']) ?></h5>
      </div>
      <div class="modal-body">
        <form action="?name=pieces&do=devices-companies&action=insert-device" method="POST" id="addDevice" onchange="form_validation(this)">
          <?php if (isset($dev_company_name)) { ?>
            <input type="hidden" name="company-id" id="company-id" value="<?php echo $dev_company_id ?>">
          <?php } ?>
          <!-- start company name -->
          <div class="mb-sm-2 mb-md-3 row">
            <label for="<?php echo isset($dev_company_name) ? 'company-name' : 'company-id' ?>" class="col-sm-12 col-form-label text-capitalize"><?php echo language('COMPANY NAME', @$_SESSION['systemLang']) ?></label>
            <div class="col-sm-12 position-relative">
              <?php if (isset($dev_company_name)) { ?>
                <input type="text" class="form-control" id="company-name" name="company-name" value="<?php echo $dev_company_name ?>" autocomplete="off" required  readonly/>
              <?php } else { ?>
                <select class="form-select" name="company-id" id="company-id" required>
                  <?php if (count($manufacture_companies) > 0 && $manufacture_companies != null) {?>
                    <option value="default" disabled selected><?php echo language('SELECT MANUFACTURE COMPANY') ?></option>
                    <?php foreach ($manufacture_companies as $company) { ?>
                      <option value="<?php echo $company['man_company_id'] ?>"><?php echo $company['man_company_name'] ?></option>
                    <?php } ?>
                  <?php } else { ?>
                    <option value="default" disabled selected><?php echo language('NOT AVAILABLE NOW', @$_SESSION['systemLang']) ?></option>
                  <?php } ?>
                </select>
              <?php } ?>
              <?php if (count($manufacture_companies) == 0 && $manufacture_companies == null) {?>
                <div id="man-company-help" class="form-text text-danger"><?php echo language('THERE IS NO COMPANIES TO SELECT PLEASE ADD SOME COMPANIES', @$_SESSION['systemLang']) ?></div>
              <?php } ?>
            </div>
          </div>
          <!-- end company name -->
          <!-- start device name -->
          <div class="mb-sm-2 mb-md-3 row">
            <label for="device-name" class="col-sm-12 col-form-label text-capitalize"><?php echo language('PIECE NAME', @$_SESSION['systemLang']) ?></label>
            <div class="col-sm-12 position-relative">
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