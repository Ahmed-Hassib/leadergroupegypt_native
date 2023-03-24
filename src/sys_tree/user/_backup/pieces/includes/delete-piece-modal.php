<!-- Modal -->
<div class="modal fade" id="deletePieceModal" tabindex="-1" aria-labelledby="deletePieceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="width: 500px" >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-capitalize " id="exampleModalLabel"><?php echo language('CONFIRM', @$_SESSION['systemLang'])." ".language('DELETE', @$_SESSION['systemLang'])." ".language('PIECE/CLIENT', @$_SESSION['systemLang']) ?></h5>
            </div>
            <div class="modal-body">
                <h4 class="h4  text-danger"><?php echo language('ARE YOU SURE TO DELETE', @$_SESSION['systemLang'])." '" .$pcs_data['piece_name']. "' ". (@$_SESSION['systemLang'] == "ar" ? "؟" : "?") ?> </h4>
            </div>
            <div class="modal-footer">
                <a href="?do=deletePiece&pieceid=<?php echo $pcs_data['piece_id'] ?>" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'ltr' : 'rtl' ?>" class="btn btn-danger text-capitalize <?php if ($_SESSION['pcs_delete'] == 0) {echo 'd-none';} ?>"><i class="bi bi-trash"></i>&nbsp;<?php echo language('DELETE', @$_SESSION['systemLang']) ?></a>
                <button type="button" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'ltr' : 'rtl' ?>" class="btn btn-outline-secondary" data-bs-dismiss="modal"><?php echo language('CLOSE', @$_SESSION['systemLang']) ?></button>
            </div>
        </div>
    </div>
</div>