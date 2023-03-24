<!-- Modal -->
<div class="modal fade" id="addNewPieceConnTypeModal" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-type-dialog" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="m-auto modal-title h5 " id="staticBackdropLabel"><?php echo language("ADD NEW CONNECTION TYPE", @$_SESSION['systemLang']) ?></h5>
      </div>
      <div class="modal-body">
        <form action="??name=<?php echo $page_title ?>&do=show-connections-types&action=insert-piece-conn-type" method="POST" id="addPieceConnType" onchange="form_validation(this)">
          <!-- start connection type name -->
          <div class="mb-sm-2 mb-md-3 row">
            <label for="conn-type-name" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('THE TYPE', @$_SESSION['systemLang']) ?></label>
            <div class="col-sm-12 col-md-8">
              <input type="text" class="form-control" id="conn-type-name" name="conn-type-name" autocomplete="off" required />
            </div>
          </div>
          <!-- end type name -->
          <!-- start type note -->
          <div class="mb-sm-2 mb-md-3 row">
            <label for="conn-type-note" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('THE NOTES', @$_SESSION['systemLang']) ?></label>
            <div class="col-sm-12 col-md-8">
              <textarea class="form-control" style="resize: none" id="conn-type-note" name="conn-type-note"  placeholder="<?php echo language('PUT YOUR NOTES HERE', @$_SESSION['systemLang']) ?>" rows="5" cols="5"></textarea>
            </div>
          </div>
          <!-- end type note -->
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary py-1 px-5 fs-12" form="addPieceConnType" onclick="form_validation(this.form, 'submit')"><?php echo language("ADD", @$_SESSION['systemLang']) ?></button>
        <button type="button" class="btn btn-outline-secondary py-1 px-3 fs-12" data-bs-dismiss="modal"><?php echo language("CLOSE", @$_SESSION['systemLang']) ?></button>
      </div>
    </div>
  </div>
</div>