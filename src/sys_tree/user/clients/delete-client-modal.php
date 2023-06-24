<!-- Modal -->
<div class="modal fade" id="deleteClientModal" tabindex="-1" aria-labelledby="deleteClientModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="width: 500px" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-capitalize " id="exampleModalLabel"><?php echo language('CONFIRM', @$_SESSION['systemLang'])." ".language('DELETE', @$_SESSION['systemLang'])." ".language('CLIENT', @$_SESSION['systemLang']) ?></h5>
      </div>
      <div class="modal-body">
        <h5 class="h5"><?php echo language('ARE YOU SURE TO DELETE', @$_SESSION['systemLang']) ?>&nbsp;<span class="text-danger" id="deleted-client-name"></span>&nbsp;<?php echo @$_SESSION['systemLang'] == "ar" ? "؟" : "?" ?></h5>
      </div>
      <div class="modal-footer">
        <?php if ($_SESSION['clients_delete'] == 1) { ?>
          <a id="deleted-client-url" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'ltr' : 'rtl' ?>" class="btn btn-danger text-capitalize fs-12 py-1"><i class="bi bi-trash"></i>&nbsp;<?php echo language('DELETE', @$_SESSION['systemLang']) ?></a>
        <?php } ?>
        <button type="button" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'ltr' : 'rtl' ?>" class="btn btn-outline-secondary fs-12 py-1" data-bs-dismiss="modal"><?php echo language('CLOSE', @$_SESSION['systemLang']) ?></button>
      </div>
    </div>
  </div>
</div>