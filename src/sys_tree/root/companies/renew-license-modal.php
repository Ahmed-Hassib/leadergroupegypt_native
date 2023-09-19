<!-- Modal -->
<div class="modal fade" id="renew_license" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-type-dialog" dir="<?php echo $page_dir ?>">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="m-auto modal-title h5 " id="staticBackdropLabel"><?php echo lang("RENEW LICENSE", @$_SESSION['sys']['lang']) ?></h5>
            </div>
            <div class="modal-body">
                <form action="?do=renew-license" method="POST" id="renewLicenseForm">
                    <!-- type id -->
                    <input type="hidden" name="company-id" id="company-id">
                    <!-- start company name field -->
                    <div class="mb-sm-2 mb-md-3 row">
                        <label for="company-name" class="col-sm-12 col-md-5 col-form-label text-capitalize" ><?php echo lang('COMPANY NAME', @$_SESSION['sys']['lang']) ?></label>
                        <div class="col-sm-12 col-md-7">
                            <input type="text" class="form-control" name="company-name" id="company-name" placeholder="<?php echo lang('COMPANY NAME', @$_SESSION['sys']['lang']) ?>" required readonly>
                        </div>
                    </div>
                    <!-- end company name field -->
                    <!-- strat license field -->
                    <div class="mb-4 row">
                        <label for="license-type" class="col-sm-12 col-md-5 col-form-label text-capitalize"><?php echo lang('CHOOSE LICENSE', @$_SESSION['sys']['lang']) ?></label>
                        <div class="col-sm-12 col-md-7">
                            <select name="license-type" id="license-type" class="form-select" required>
                                <option value="default"  disabled selected><?php echo lang('CHOOSE LICENSE', @$_SESSION['sys']['lang']) ?></option>
                                <option value="1"><?php echo lang('MONTHLY', @$_SESSION['sys']['lang']); ?></option>
                                <option value="2"><?php echo lang('3 MONTHS', @$_SESSION['sys']['lang']); ?></option>
                                <option value="3"><?php echo lang('6 MONTHS', @$_SESSION['sys']['lang']); ?></option>
                                <option value="4"><?php echo lang('YEARLY', @$_SESSION['sys']['lang']); ?></option>
                            </select>
                        </div>
                    </div>
                    <!-- end backup field -->
                    <!-- start root password field -->
                    <div class="mb-sm-2 mb-md-3 row">
                        <label class="col-sm-12 col-md-5 col-form-label text-capitalize" for="root-password"><?php echo lang('PASSWORD', @$_SESSION['sys']['lang']) ?></label>
                        <div class="col-sm-12 col-md-7">
                            <input type="password" class="form-control" id="root-password" name="root-password" placeholder="<?php echo lang('PASSWORD', @$_SESSION['sys']['lang']) ?>" required>
                            <i class="bi bi-eye-slash show-pass text-dark show-pass <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'show-pass-left' : 'show-pass-right' ?>" id="show-pass" onclick="show_pass(this)"></i>
                        </div>
                    </div>
                    <!-- end root password field -->
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary py-1 px-5 fs-12" form="renewLicenseForm" onclick="form_validation(this.form, 'submit')"><?php echo lang("SAVE CHANGES", @$_SESSION['sys']['lang']) ?></button>
                <button type="button" class="btn btn-outline-secondary py-1 px-3 fs-12" data-bs-dismiss="modal"><?php echo lang("CLOSE", @$_SESSION['sys']['lang']) ?></button>
            </div>
        </div>
    </div>
</div>