<!-- Modal -->
<div class="modal fade" id="addNewDirectionModal" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>" >
  <div class="modal-dialog modal-dialog-centered modal-type-dialog" >
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="m-auto modal-title h5 " id="staticBackdropLabel"><?php echo language("ADD NEW DIRECTION", @$_SESSION['systemLang']) ?></h5>
      </div>
      <div class="modal-body">
        <!-- start add new user form -->
        <form action="<?php echo $sys_tree_user ?>directions/index.php?do=insert-new-direction" method="POST" id="addNewDirection" onchange="form_validation(this)">
          <!-- start direction name field -->
          <div class="mb-sm-2 mb-md-3 row">
            <label for="direction-name" class="col-sm-12 col-md-4 col-form-label text-capitalize" ><?php echo language('DIRECTION NAME', @$_SESSION['systemLang']) ?></label>
            <div class="col-sm-12 col-md-8">
              <input type="text" class="form-control" name="direction-name" id="direction-name" placeholder="<?php echo language('DIRECTION NAME', @$_SESSION['systemLang']) ?>" onkeyup="direction_validation(this)" required>
              <div id="passHelp" class="form-text"><?php echo language('MAKE SURE YOU ENTER THE FULL NAME OF THE DIRECTION', @$_SESSION['systemLang']) ?></div>
            </div>
          </div>
          <!-- end direction name field -->
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary py-1 px-5 fs-12" form="addNewDirection" onclick="form_validation(this.form, 'submit')"><?php echo language("ADD", @$_SESSION['systemLang']) ?></button>
        <button type="button" class="btn btn-outline-secondary py-1 px-3 fs-12" data-bs-dismiss="modal"><?php echo language("CLOSE", @$_SESSION['systemLang']) ?></button>
      </div>
    </div>
  </div>
</div>