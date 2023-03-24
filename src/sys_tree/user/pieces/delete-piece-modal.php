<!-- Modal -->
<div class="modal fade" id="deletePieceModal" tabindex="-1" aria-labelledby="deletePieceModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="width: 500px" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-capitalize " id="exampleModalLabel"><?php echo language('CONFIRM', @$_SESSION['systemLang'])." ".language('DELETE', @$_SESSION['systemLang'])." ".language('PIECE/CLIENT', @$_SESSION['systemLang']) ?></h5>
      </div>
      <div class="modal-body">
        <h5 class="h5"><?php echo language('ARE YOU SURE TO DELETE', @$_SESSION['systemLang']) ?>&nbsp;<span class="text-danger">'<?php echo $piece_data['full_name'] ?>'</span>&nbsp;<?php echo @$_SESSION['systemLang'] == "ar" ? "؟" : "?" ?></h5>
      </div>
      <div class="modal-footer">
        <a href="?name=<?php echo $page_title ?>&do=delete-piece&piece-id=<?php echo $piece_data['id'] ?>" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'ltr' : 'rtl' ?>" class="btn btn-danger text-capitalize fs-12 py-1 <?php if ($_SESSION['pcs_delete'] == 0) {echo 'd-none';} ?>"><i class="bi bi-trash"></i>&nbsp;<?php echo language('DELETE', @$_SESSION['systemLang']) ?></a>
        <button type="button" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'ltr' : 'rtl' ?>" class="btn btn-outline-secondary fs-12 py-1" data-bs-dismiss="modal"><?php echo language('CLOSE', @$_SESSION['systemLang']) ?></button>
      </div>
    </div>
  </div>
</div>