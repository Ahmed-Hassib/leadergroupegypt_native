<!-- modal to show -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="width: 500px">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-capitalize " id="exampleModalLabel"><?php echo language('CONFIRM', @$_SESSION['systemLang'])." ".language('DELETE', @$_SESSION['systemLang'])." ".language('EMPLOYEE', @$_SESSION['systemLang']) ?></h5>
                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
            </div>
            <div class="modal-body">
                <h4 class="h4 text-danger " <?php echo @$_SESSION['systemLang'] == "ar" ? "dir=rtl" : ""; ?>><?php echo language('ARE YOU SURE TO DELETE', @$_SESSION['systemLang'])." '" ?> <span id="deleted-username"></span> <?php echo "' ".( @$_SESSION['systemLang'] == "ar" ? "؟" : "?" )?> </h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary fs-12" data-bs-dismiss="modal"><?php echo language('CLOSE', @$_SESSION['systemLang']) ?></button>
                <a id="delete-user" class="btn btn-danger text-capitalize fs-12 <?php if ($_SESSION['user_delete'] == 0) {echo 'disabled';} ?>" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'ltr' : 'rtl' ?>"><i class="bi bi-trash"></i>&nbsp;<?php echo language('DELETE', @$_SESSION['systemLang']) ?></a>
            </div>
        </div>
    </div>
</div>