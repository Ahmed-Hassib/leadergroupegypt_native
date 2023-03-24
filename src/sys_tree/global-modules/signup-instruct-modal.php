<!-- Vertically centered scrollable modal -->
<!-- Modal -->
<div class="modal fade" id="signup-instruction" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" dir="rtl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?php echo language('SIGNUP INSTRUCTIONS', @$_SESSION['systemLang']) ?></h5>
        <button type="button" class="btn-close btn-close-<?php echo @$_SESSION['systemLang'] == 'ar' ? 'left' : 'rigt' ?>" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <!-- header of list -->
          <h6 class="h6 text-capitalize text-primary">
            <i class="bi bi-bounding-box-circles fs-12"></i>
            <?php echo language('WHEN REGISTERING THE ABBRERVIATED NAME OF THE COMPANY AND THE USERNAME OF ADMIN, PLEASE NOTE THE FOLLOWING', @$_SESSION['systemLang']) ?>
          </h6>
          <!-- list note -->
          <ol>
            <li><?php echo language('IT SHOULD NOT CONTAIN SPACES', @$_SESSION['systemLang']) ?></li>
            <li><?php echo language('IT SHOULD NOT CONTAIN SPECIAL CHARACTERS', @$_SESSION['systemLang']) ?></li>
            <li><?php echo language('IT CAN ONLY CONTAIN UNDERSCORE "_"', @$_SESSION['systemLang']) ?></li>
          </ol>
        </div>
        <div class="mb-3">
          <!-- header of list -->
          <h6 class="h6 text-capitalize text-primary">
            <i class="bi bi-bounding-box-circles fs-12"></i>
            <?php echo language('WHEN REGISTERING THE ABBRERVIATED NAME OF THE COMPANY, IT MUST BE TAKEN INTO ACCOUNT THAT ITS LENGTH DOES NOT EXCEED 11 CHARACTERS', @$_SESSION['systemLang']) ?>
          </h6>
        </div>
        <div class="mb-3">
          <!-- header of list -->
          <h6 class="h6 text-capitalize text-primary">
            <i class="bi bi-bounding-box-circles fs-12"></i>
            <?php echo language('WHEN LOGGING IN, BE SURE TO WRITE THE USERNAME FOLLOWED BY "@" SIGN, THEN THE COMPANY`S ABBREVIATED NAME', @$_SESSION['systemLang']) ?>
          </h6>
        </div>
        <hr>
        <!-- company name -->
        <div class="form-check">
          <div class="row g-0 justify-content-start align-items-center">
            <div class="col-1">
              <input class="form-check-input" type="checkbox" name="show-instructions" id="show-instructions" onchange="showing_instruction(this)">
            </div>
            <div class="col-11">
              <label for="show-instructions" class="form-check-label"><?php echo language("DON`T SHOW THIS AGAIN", @$_SESSION['systemLang']) ?></label>
            </div>
          </div>
        </div>
      </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-primary me-auto" data-bs-dismiss="modal"><?php echo language('UNDERSTAND', @$_SESSION['systemLang']) ?></button>
      </div>
    </div>
  </div>
</div>