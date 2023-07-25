<div class="section-block">
  <!-- section header -->
  <div class="section-header">
    <h5 class="text-capitalize "><?php echo language('OTHER', @$_SESSION['systemLang']) ?></h5>
    <hr />
  </div>

  <div class="mb-1">
    <form action="?do=others" method="POST" id="other-settings">
      <!-- ping counter -->
      <div class="mb-3 form-row form-check-inline">
        <label class="form-label text-capitalize" for="ping-counter">
          <?php echo language('PING COUNTER', @$_SESSION['systemLang']) ?>
        </label>
        <input class="form-control" type="number" name="ping-counter" id="ping-counter" value="<?php echo $_SESSION['ping_counter'] ?>">
      </div>

      <div class="hstack gap-3">
        <!-- submit button -->
        <button type="submit" class="me-auto btn btn-primary text-capitalize fs-12 py-1"><i class="bi bi-check-all me-1"></i><?php echo language('SAVE CHANGES', @$_SESSION['systemLang']) ?></button>
      </div>
    </form>
  </div>
</div>