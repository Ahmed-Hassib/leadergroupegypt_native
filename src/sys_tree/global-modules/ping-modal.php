<!-- modal to show -->
<div class="modal fade" id="pingModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 500px" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
    <div class="modal-content">
      <div class="modal-header" dir="ltr">
        <h5 class="modal-title text-capitalize" id="exampleModalLabel">Ping</h5>
      </div>
      <div class="modal-body">
        <div id="ping-loader">
          <svg class="ping-loader" viewBox="25 25 50 50">
            <circle r="20" cy="50" cx="50"></circle>
          </svg>
        </div>
        <div id="ping-status"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary py-1 fs-12" data-bs-dismiss="modal" onclick="reset_modal()"><?php echo language('CLOSE', @$_SESSION['systemLang']) ?></button>
      </div>
    </div>
  </div>
</div>