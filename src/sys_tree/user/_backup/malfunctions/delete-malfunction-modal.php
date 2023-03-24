<!-- Modal -->
<div class="modal fade" id="deleteMalModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-capitalize " id="exampleModalLabel"><?php echo language('CONFIRM', @$_SESSION['systemLang'])." ".language('DELETE', @$_SESSION['systemLang'])." ".language('THE MALFUNCTION', @$_SESSION['systemLang']) ?></h5>
            </div>
            <div class="modal-body">
                <h2 class="h2" <?php echo @$_SESSION['systemLang'] == "ar" ? "dir=rtl" : ""; ?>><?php echo language('ARE YOU SURE TO DELETE', @$_SESSION['systemLang'])." ".language('THE MALFUNCTION', @$_SESSION['systemLang'])." ".( @$_SESSION['systemLang'] == "ar" ? "؟" : "?" )?> </h2>
                <p id="test"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary fs-12" data-bs-dismiss="modal">Close</button>
                <a class="btn btn-danger text-capitalize fs-12 <?php if ($_SESSION['mal_delete'] == 0) {echo 'disabled';} ?>" id="confirm-delete-malfunction"><i class="bi bi-trash"></i>&nbsp;<?php echo language('DELETE', @$_SESSION['systemLang']) ?></a>
            </div>
        </div>
    </div>
</div>