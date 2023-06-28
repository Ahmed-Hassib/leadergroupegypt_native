<!-- modal to show -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="width: 500px"  dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-capitalize " id="exampleModalLabel"><?php echo language('CONFIRM', @$_SESSION['systemLang'])." ".language('DELETE', @$_SESSION['systemLang'])." ".language('EMPLOYEE', @$_SESSION['systemLang']) ?></h5>
      </div>
      <div class="modal-body">
        <h4 class="h4" <?php echo @$_SESSION['systemLang'] == "ar" ? "dir=rtl" : ""; ?>><?php echo language('ARE YOU SURE TO DELETE', @$_SESSION['systemLang'])." '" ?> <span id="deleted-username" class="text-danger"></span> <?php echo "' ".( @$_SESSION['systemLang'] == "ar" ? "؟" : "?" )?> </h4>
      </div>
      <div class="modal-footer">
        <?php if ($_SESSION['user_delete'] == 1) { ?>
          <a id="delete-user" class="btn btn-danger text-capitalize py-1 fs-12" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>"><i class="bi bi-trash"></i>&nbsp;<?php echo language('DELETE', @$_SESSION['systemLang']) ?></a>
        <?php } ?>
        <button type="button" class="btn btn-outline-secondary py-1 fs-12" data-bs-dismiss="modal"><?php echo language('CLOSE', @$_SESSION['systemLang']) ?></button>
      </div>
    </div>
  </div>
</div>