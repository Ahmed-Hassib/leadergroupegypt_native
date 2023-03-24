<!-- Modal -->
<div class="modal fade" id="delete_company" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-type-dialog" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="m-auto modal-title h5 " id="staticBackdropLabel"><?php echo language("DELETE COMPANY", @$_SESSION['systemLang']) ?></h5>
            </div>
            <div class="modal-body">
                <form action="" method="POST" id="">
                    <!-- type id -->
                    <input type="hidden" name="deleted-company-id" id="deleted-company-id">
                    <!-- start company name field -->
                    <div class="mb-sm-2 mb-md-3 row">
                      <?php echo language('ARE YOU SURE FOR DELETTION OPERATION ?') ?>
                    </div>
                    <!-- end root password field -->
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary py-1 px-5 fs-12" form="renewLicenseForm" onclick="form_validation(this.form, 'submit')"><?php echo language("SAVE CHANGES", @$_SESSION['systemLang']) ?></button>
                <button type="button" class="btn btn-outline-secondary py-1 px-3 fs-12" data-bs-dismiss="modal"><?php echo language("CLOSE", @$_SESSION['systemLang']) ?></button>
            </div>
        </div>
    </div>
</div>