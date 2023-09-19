<!-- Modal -->
<div class="modal fade" id="deleteDeviceModal" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-device-dialog" dir="<?php echo $page_dir ?>">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="m-auto modal-title h5 " id="staticBackdropLabel"><?php echo lang("DELETE DEVICE INFO", $lang_file) ?></h5>
      </div>
      <div class="modal-body">
        <form action="?do=devices-companies&action=delete-device" method="POST" id="delete-device">
          <input type="hidden" name="deleted-device-id" id="deleted-device-id">
          <!-- start device name -->
          <div class="mb-3">
            <h4 class="h4"><?php echo lang('CONFIRM DELETE') ?>&nbsp;`<span class="text-danger" id="deleted-device-name"></span>`&nbsp;<?php echo @$_SESSION['sys']['lang'] == 'ar' ? '؟' : '?' ?></h4>
          </div>
          <!-- end device name -->
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger py-1 px-5 fs-12" form="delete-device" onclick="form_validation(this.form, 'submit')"><?php echo lang("DELETE") ?></button>
        <button type="button" class="btn btn-outline-secondary py-1 px-3 fs-12" data-bs-dismiss="modal"><?php echo lang("CLOSE") ?></button>
      </div>
    </div>
  </div>
</div>