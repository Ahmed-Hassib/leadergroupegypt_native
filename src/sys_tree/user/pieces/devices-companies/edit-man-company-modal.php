<!-- Modal -->
<div class="modal fade" id="editDevCompanyModal" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-company-dialog" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="m-auto modal-title h5 " id="staticBackdropLabel"><?php echo language("EDIT COMPANY INFO", @$_SESSION['systemLang']) ?></h5>
      </div>
      <div class="modal-body">
        <form action="?do=devices-companies&action=update-man-company" method="POST" id="edit-man-company" onchange="form_validation(this)">
          <input type="hidden" name="company-id" id="company-id">
          <!-- start company name -->
          <div class="mb-sm-2 mb-md-3 row">
            <label for="old-company-name" class="col-sm-12 col-form-label text-capitalize"><?php echo language('OLD COMPANY NAME', @$_SESSION['systemLang']) ?></label>
            <div class="col-sm-12 position-relative">
              <input type="text" class="form-control" id="old-company-name" name="old-company-name" autocomplete="off" required readonly />
            </div>
          </div>
          <!-- end company name -->
          <!-- start company name -->
          <div class="mb-sm-2 mb-md-3 row">
            <label for="new-company-name" class="col-sm-12 col-form-label text-capitalize"><?php echo language('NEW COMPANY NAME', @$_SESSION['systemLang']) ?></label>
            <div class="col-sm-12 position-relative">
              <input type="text" class="form-control" id="new-company-name" name="new-company-name" autocomplete="off" required />
            </div>
          </div>
          <!-- end company name -->
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary py-1 px-5 fs-12" form="edit-man-company" onclick="form_validation(this.form, 'submit')"><?php echo language("SAVE CHANGES", @$_SESSION['systemLang']) ?></button>
        <button type="button" class="btn btn-outline-secondary py-1 px-3 fs-12" data-bs-dismiss="modal"><?php echo language("CLOSE", @$_SESSION['systemLang']) ?></button>
      </div>
    </div>
  </div>
</div>