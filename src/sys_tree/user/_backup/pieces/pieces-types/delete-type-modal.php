<!-- Modal -->
<div class="modal fade" id="deletePieceTypeModal" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-type-dialog" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="m-auto modal-title h5 " id="staticBackdropLabel"><?php echo language("DELETE PIECE TYPE", @$_SESSION['systemLang']) ?></h5>
            </div>
            <div class="modal-body">
                <form action="?do=piecesTypes&action=deletePieceType" method="POST" id="deletePieceType">
                    <!-- type id -->
                    <input type="hidden" name="deleted-type-id" id="deleted-type-id">
                    <!-- start type name -->
                    <div class="mb-sm-2 mb-md-3 row">
                        <label for="deleted-type-name" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('THE TYPE', @$_SESSION['systemLang']) ?></label>
                        <div class="col-sm-12 col-md-8">
                            <?php 
                            // create an object of PiecesTypes class
                            $pcs_type_modal = new PiecesTypes();
                            // get all pieces types
                            $pcs_type_modal_data = $pcs_type_modal->get_all_types($_SESSION['company_id']);
                            // types count
                            $pcs_type_modal_data_count =  $pcs_type_modal_data[0];
                            // types rows
                            $pcs_type_modal_data_rows = $pcs_type_modal_data[1];
                            ?>
                            <select class="form-select" id="deleted-type-name" name="deleted-type-name" onchange="document.getElementById('deleted-type-id').value = this.value;" required>
                                <option value="default" disabled selected><?php echo language('SELECT', @$_SESSION['systemLang'])." ".language('THE TYPE', @$_SESSION['systemLang']) ?></option>
                                <!-- loop on pieces types -->
                                <?php foreach ($pcs_type_modal_data_rows as $type) { ?>
                                    <option value="<?php echo $type['type_id'] ?>"><?php echo $type['type_name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <!-- end type name -->
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger py-1 fs-12" form="deletePieceType" onclick="form_validation(this.form, 'submit')"><i class="bi bi-trash"></i><?php echo language("DELETE", @$_SESSION['systemLang']) ?></button>
                <button type="button" class="btn btn-outline-secondary py-1 px-3 fs-12" data-bs-dismiss="modal"><?php echo language("CLOSE", @$_SESSION['systemLang']) ?></button>
            </div>
        </div>
    </div>
</div>