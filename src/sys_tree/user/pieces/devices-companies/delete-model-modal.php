<!-- Modal -->
<div class="modal fade" id="deleteDeviceModel" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-model-dialog" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="m-auto modal-title h5 " id="staticBackdropLabel"><?php echo language("DELETE MODEL INFO", @$_SESSION['systemLang']) ?></h5>
      </div>
      <div class="modal-body">
        <form action="?do=devices-companies&action=delete-model" method="POST" id="delete-model">
          <input type="hidden" name="deleted-model-id" id="deleted-model-id">
          <!-- start model name -->
          <div class="mb-sm-2 mb-md-3 row">
            <h4 class="h4"><?php echo language('ARE YOU SURE TO DELETE') ?>&nbsp;`<span class="text-danger" id="deleted-model-name"></span>`&nbsp;<?php echo @$_SESSION['systemLang'] == 'ar' ? '؟' : '?' ?></h4>
          </div>
          <!-- end model name -->
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger py-1 px-5 fs-12" form="delete-model" onclick="form_validation(this.form, 'submit')"><?php echo language("DELETE", @$_SESSION['systemLang']) ?></button>
        <button type="button" class="btn btn-outline-secondary py-1 px-3 fs-12" data-bs-dismiss="modal"><?php echo language("CLOSE", @$_SESSION['systemLang']) ?></button>
      </div>
    </div>
  </div>
</div>