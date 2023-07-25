<div class="section-block">
  <!-- section header -->
  <div class="section-header" >
    <h5 class="text-capitalize "><?php echo language('SYSTEM LANGUAGE', @$_SESSION['systemLang']) ?></h5>
    <hr />
  </div>
  <!-- language form -->
  <form action="?do=change-lang" method="POST">
    <!-- hidden input for employee id -->
    <input type="hidden" name="id" value="<?php echo $_SESSION['UserID'] ?>">
    <!-- strat language field -->
    <div class="mb-3 row">
      <div class="col-sm-12 col-md-8">
        <!-- arabic language -->
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="language" id="languageAr" value="0" <?php echo @$_SESSION['systemLang'] == "ar" ? "checked" : "" ?>>
          <label class="form-check-label text-capitalize" for="languageAr">
            <?php echo language('ARABIC', @$_SESSION['systemLang']) ?>
          </label>
        </div>
        <!-- english language -->
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="language" id="languageEn" value="1" <?php echo @$_SESSION['systemLang'] == "en" ? "checked" : "" ?> disabled>
          <label class="form-check-label text-capitalize" for="languageEn">
            <span><?php echo language('ENGLISH', @$_SESSION['systemLang']) ?>&nbsp;</span>
            <span class="badge bg-secondary"><?php echo language("UNDER DEVELOPING", @$_SESSION['systemLang']) ?></span>
          </label>
        </div>
      </div>
    </div>
    <!-- end language field -->
    <!-- strat submit -->
    <div class="hstack gap-3">
      <button type="submit" class="me-auto btn btn-primary text-capitalize fs-12 py-1"><i class="bi bi-check-all me-1"></i>&nbsp;<?php echo language('SAVE CHANGES', @$_SESSION['systemLang']) ?></button>
    </div>
    <!-- end submit -->
  </form>
</div>
