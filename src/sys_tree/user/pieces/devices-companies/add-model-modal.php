<!-- Modal -->
<div class="modal fade" id="addNewDeviceModel" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-company-dialog" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="m-auto modal-title h5 " id="staticBackdropLabel"><?php echo language("ADD NEW MODEL", @$_SESSION['systemLang']) ?></h5>
      </div>
      <div class="modal-body">
        <form action="?do=devices-companies&action=insert-model" method="POST" id="addDeviceModelForm" onchange="form_validation(this)">
          <input type="hidden" name="device-id" id="device-id" value="<?php echo $device_id ?>">
          <!-- button to add a model field -->
          <button type="button" class="btn btn-outline-success me-auto fs-12 py-1" onclick="add_model(this)" data-model-num="0">
            <i class="bi bi-plus"></i>
            <?php echo language("ADD MODEL", @$_SESSION['systemLang']) ?>
          </button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary py-1 px-5 fs-12" form="addDeviceModelForm" onclick="form_validation(this.form, 'submit')"><?php echo language("ADD", @$_SESSION['systemLang']) ?></button>
        <button type="button" class="btn btn-outline-secondary py-1 px-3 fs-12" data-bs-dismiss="modal"><?php echo language("CLOSE", @$_SESSION['systemLang']) ?></button>
      </div>
    </div>
  </div>
</div>