
<div class="mb-4 row">
  <div class="col-sm-12 col-md-3"><?php echo language('THE EMPLOYEES', @$_SESSION['systemLang']) ?></div>
  <div class="col-sm-12 col-md-8">
    <div class="row row-cols-sm-1 row-cols-md-3 row-cols-lg-5 align-items-start g-sm-1 gx-md-5">
      <div class="col-sm-12">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" <?php if ($_SESSION['user_update'] == 0 || $_SESSION['permission_update'] == 0) {echo 'disabled';} ?> <?php if ($permissions['user_add'] == 1) {echo 'checked';} ?> value="1" name="userAdd" id="usersPage1">
          <label class="form-check-label" for="usersPage1">
            <?php echo language("ADD", @$_SESSION['systemLang']) ?>
          </label>
        </div>
      </div>
      <div class="col-sm-12">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" <?php if ($_SESSION['user_update'] == 0 || $_SESSION['permission_update'] == 0) {echo 'disabled';} ?> <?php if ($permissions['user_update'] == 1) {echo 'checked';} ?> value="1" name="userUpdate" id="usersPage2">
          <label class="form-check-label" for="usersPage2">
            <?php echo language("EDIT", @$_SESSION['systemLang']) ?>
          </label>
        </div>
      </div>
      <div class="col-sm-12">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" <?php if ($_SESSION['user_update'] == 0 || $_SESSION['permission_update'] == 0) {echo 'disabled';} ?> <?php if ($permissions['user_delete'] == 1) {echo 'checked';} ?> value="1" name="userDelete" id="usersPage3">
          <label class="form-check-label" for="usersPage3">
            <?php echo language("DELETE", @$_SESSION['systemLang']) ?>
          </label>
        </div>
      </div>
      <div class="col-sm-12">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" <?php if ($_SESSION['user_update'] == 0 || $_SESSION['permission_update'] == 0) {echo 'disabled';} ?> <?php if ($permissions['user_show'] == 1) {echo 'checked';} ?> value="1" name="userShow" id="usersPage4">
          <label class="form-check-label" for="usersPage4">
            <?php echo language("SHOW", @$_SESSION['systemLang']) ?>
          </label>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="mb-4 row">
  <div class="col-sm-12 col-md-3"><?php echo language('PIECES/CLIENTS', @$_SESSION['systemLang']) ?></div>
  <div class="col-sm-12 col-md-8">
    <div class="row row-cols-sm-1 row-cols-md-3 row-cols-lg-5 align-items-start g-sm-1 gx-md-5">
      <div class="col-sm-12">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" <?php if ($_SESSION['user_update'] == 0 || $_SESSION['permission_update'] == 0) {echo 'disabled';} ?> <?php if ($permissions['pcs_add'] == 1) {echo 'checked';} ?> value="1" name="pcsAdd" id="pcsPage1">
          <label class="form-check-label" for="pcsPage1">
            <?php echo language("ADD", @$_SESSION['systemLang']) ?>
          </label>
        </div>
      </div>
      <div class="col-sm-12">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" <?php if ($_SESSION['user_update'] == 0 || $_SESSION['permission_update'] == 0) {echo 'disabled';} ?> <?php if ($permissions['pcs_update'] == 1) {echo 'checked';} ?> value="1" name="pcsUpdate" id="pcsPage2">
          <label class="form-check-label" for="pcsPage2">
            <?php echo language("EDIT", @$_SESSION['systemLang']) ?>
          </label>
        </div>
      </div>
      <div class="col-sm-12">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" <?php if ($_SESSION['user_update'] == 0 || $_SESSION['permission_update'] == 0) {echo 'disabled';} ?> <?php if ($permissions['pcs_delete'] == 1) {echo 'checked';} ?> value="1" name="pcsDelete" id="pcsPage3">
          <label class="form-check-label" for="pcsPage3">
            <?php echo language("DELETE", @$_SESSION['systemLang']) ?>
          </label>
        </div>
      </div>
      <div class="col-sm-12">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" <?php if ($_SESSION['user_update'] == 0 || $_SESSION['permission_update'] == 0) {echo 'disabled';} ?> <?php if ($permissions['pcs_show'] == 1) {echo 'checked';} ?> value="1" name="pcsShow" id="pcsPage4">
          <label class="form-check-label" for="pcsPage4">
            <?php echo language("SHOW", @$_SESSION['systemLang']) ?>
          </label>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="mb-4 row">
  <div class="col-sm-12 col-md-3"><?php echo language('CONNECTION TYPES', @$_SESSION['systemLang']) ?></div>
  <div class="col-sm-12 col-md-8">
    <div class="row row-cols-sm-1 row-cols-md-3 row-cols-lg-5 align-items-start g-sm-1 gx-md-5">
      <div class="col-sm-12">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" <?php if ($_SESSION['user_update'] == 0 || $_SESSION['permission_update'] == 0) {echo 'disabled';} ?> <?php if ($permissions['connection_add'] == 1) {echo 'checked';} ?> value="1" name="connectionAdd" id="connectionPage1">
          <label class="form-check-label" for="connectionPage1">
            <?php echo language("ADD", @$_SESSION['systemLang']) ?>
          </label>
        </div>
      </div>
      <div class="col-sm-12">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" <?php if ($_SESSION['user_update'] == 0 || $_SESSION['permission_update'] == 0) {echo 'disabled';} ?> <?php if ($permissions['connection_update'] == 1) {echo 'checked';} ?> value="1" name="connectionUpdate" id="connectionPage2">
          <label class="form-check-label" for="connectionPage2">
            <?php echo language("EDIT", @$_SESSION['systemLang']) ?>
          </label>
        </div>
      </div>
      <div class="col-sm-12">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" <?php if ($_SESSION['user_update'] == 0 || $_SESSION['permission_update'] == 0) {echo 'disabled';} ?> <?php if ($permissions['connection_delete'] == 1) {echo 'checked';} ?> value="1" name="connectionDelete" id="connectionPage3">
          <label class="form-check-label" for="connectionPage3">
            <?php echo language("DELETE", @$_SESSION['systemLang']) ?>
          </label>
        </div>
      </div>
      <div class="col-sm-12">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" <?php if ($_SESSION['user_update'] == 0 || $_SESSION['permission_update'] == 0) {echo 'disabled';} ?> <?php if ($permissions['connection_show'] == 1) {echo 'checked';} ?> value="1" name="connectionShow" id="connectionPage4">
          <label class="form-check-label" for="connectionPage4">
            <?php echo language("SHOW", @$_SESSION['systemLang']) ?>
          </label>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="mb-4 row">
  <div class="col-sm-12 col-md-3"><?php echo language('THE DIRECTIONS', @$_SESSION['systemLang']) ?></div>
  <div class="col-sm-12 col-md-8">
    <div class="row row-cols-sm-1 row-cols-md-3 row-cols-lg-5 align-items-start g-sm-1 gx-md-5">
      <div class="col-sm-12">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" <?php if ($_SESSION['user_update'] == 0 || $_SESSION['permission_update'] == 0) {echo 'disabled';} ?> <?php if ($permissions['dir_add'] == 1) {echo 'checked';} ?> value="1" name="dirAdd" id="dirPage1">
          <label class="form-check-label" for="dirPage1">
            <?php echo language("ADD", @$_SESSION['systemLang']) ?>
          </label>
        </div>
      </div>
      <div class="col-sm-12">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" <?php if ($_SESSION['user_update'] == 0 || $_SESSION['permission_update'] == 0) {echo 'disabled';} ?> <?php if ($permissions['dir_update'] == 1) {echo 'checked';} ?> value="1" name="dirUpdate" id="dirPage2">
          <label class="form-check-label" for="dirPage2">
            <?php echo language("EDIT", @$_SESSION['systemLang']) ?>
          </label>
        </div>
      </div>
      <div class="col-sm-12">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" <?php if ($_SESSION['user_update'] == 0 || $_SESSION['permission_update'] == 0) {echo 'disabled';} ?> <?php if ($permissions['dir_delete'] == 1) {echo 'checked';} ?> value="1" name="dirDelete" id="dirPage3">
          <label class="form-check-label" for="dirPage3">
            <?php echo language("DELETE", @$_SESSION['systemLang']) ?>
          </label>
        </div>
      </div>
      <div class="col-sm-12">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" <?php if ($_SESSION['user_update'] == 0 || $_SESSION['permission_update'] == 0) {echo 'disabled';} ?> <?php if ($permissions['dir_show'] == 1) {echo 'checked';} ?> value="1" name="dirShow" id="dirPage4">
          <label class="form-check-label" for="dirPage4">
            <?php echo language("SHOW", @$_SESSION['systemLang']) ?>
          </label>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="mb-4 row">
  <div class="col-sm-12 col-md-3"><?php echo language('THE MALFUNCTIONS', @$_SESSION['systemLang']) ?></div>
  <div class="col-sm-12 col-md-8">
    <div class="row row-cols-sm-1 row-cols-md-3 row-cols-lg-5 align-items-start g-sm-1 gx-md-5">
      <div class="col-sm-12">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" <?php if ($_SESSION['user_update'] == 0 || $_SESSION['permission_update'] == 0) {echo 'disabled';} ?> <?php if ($permissions['mal_add'] == 1) {echo 'checked';} ?> value="1" name="malAdd" id="malAdd">
          <label class="form-check-label" for="malAdd">
            <?php echo language("ADD", @$_SESSION['systemLang']) ?>
          </label>
        </div>
      </div>
      <div class="col-sm-12">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" <?php if ($_SESSION['user_update'] == 0 || $_SESSION['permission_update'] == 0) {echo 'disabled';} ?> <?php if ($permissions['mal_update'] == 1) {echo 'checked';} ?> value="1" name="malUpdate" id="malUpdate">
          <label class="form-check-label" for="malUpdate">
            <?php echo language("EDIT", @$_SESSION['systemLang']) ?>
          </label>
        </div>
      </div>
      <div class="col-sm-12">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" <?php if ($_SESSION['user_update'] == 0 || $_SESSION['permission_update'] == 0) {echo 'disabled';} ?> <?php if ($permissions['mal_delete'] == 1) {echo 'checked';} ?> value="1" name="malDelete" id="malDelete">
          <label class="form-check-label" for="malDelete">
            <?php echo language("DELETE", @$_SESSION['systemLang']) ?>
          </label>
        </div>
      </div>
      <div class="col-sm-12">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" <?php if ($_SESSION['user_update'] == 0 || $_SESSION['permission_update'] == 0) {echo 'disabled';} ?> <?php if ($permissions['mal_show'] == 1) {echo 'checked';} ?> value="1" name="malShow" id="malShow">
          <label class="form-check-label" for="malShow">
            <?php echo language("SHOW", @$_SESSION['systemLang']) ?>
          </label>
        </div>
      </div>
      <div class="col-sm-12">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" <?php if ($_SESSION['user_update'] == 0 || $_SESSION['permission_update'] == 0) {echo 'disabled';} ?> <?php if ($permissions['mal_review'] == 1) {echo 'checked';} ?> value="1" name="malReview" id="malReview">
          <label class="form-check-label" for="malReview">
            <?php echo language("RATING", @$_SESSION['systemLang']) ?>
          </label>
        </div>
      </div>
    </div>
    <div class="row row-cols-sm-1 row-cols-md-3 align-items-start g-sm-1 gx-md-5">
      <div class="col-sm-12">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" <?php if ($_SESSION['user_update'] == 0 || $_SESSION['permission_update'] == 0) {echo 'disabled';} ?> <?php if ($permissions['mal_media_delete'] == 1) {echo 'checked';} ?> value="1" name="malMediaDelete" id="malMediaDelete">
          <label class="form-check-label" for="malMediaDelete">
            <?php echo language("DELETE MEDIA", @$_SESSION['systemLang']) ?>
          </label>
        </div>
      </div>
      <div class="col-sm-12">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" <?php if ($_SESSION['user_update'] == 0 || $_SESSION['permission_update'] == 0) {echo 'disabled';} ?> <?php if ($permissions['mal_media_download'] == 1) {echo 'checked';} ?> value="1" name="malMediaDownload" id="malMediaDownload">
          <label class="form-check-label" for="malMediaDownload">
            <?php echo language("DOWNLOAD MEDIA", @$_SESSION['systemLang']) ?>
          </label>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="mb-4 row">
  <div class="col-sm-12 col-md-3"><?php echo language('THE COMBINATIONS', @$_SESSION['systemLang']) ?></div>
  <div class="col-sm-12 col-md-8">
    <div class="row row-cols-sm-1 row-cols-md-3 row-cols-lg-5 align-items-start g-sm-1 gx-md-5">
      <div class="col-sm-12">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" <?php if ($_SESSION['user_update'] == 0 || $_SESSION['permission_update'] == 0) {echo 'disabled';} ?> <?php if ($permissions['comb_add'] == 1) {echo 'checked';} ?> value="1" name="combAdd" id="combAdd">
          <label class="form-check-label" for="combAdd">
            <?php echo language("ADD", @$_SESSION['systemLang']) ?>
          </label>
        </div>
      </div>
      <div class="col-sm-12">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" <?php if ($_SESSION['user_update'] == 0 || $_SESSION['permission_update'] == 0) {echo 'disabled';} ?> <?php if ($permissions['comb_update'] == 1) {echo 'checked';} ?> value="1" name="combUpdate" id="combUpdate">
          <label class="form-check-label" for="combUpdate">
            <?php echo language("EDIT", @$_SESSION['systemLang']) ?>
          </label>
        </div>
      </div>
      <div class="col-sm-12">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" <?php if ($_SESSION['user_update'] == 0 || $_SESSION['permission_update'] == 0) {echo 'disabled';} ?> <?php if ($permissions['comb_delete'] == 1) {echo 'checked';} ?> value="1" name="combDelete" id="combDelete">
          <label class="form-check-label" for="combDelete">
            <?php echo language("DELETE", @$_SESSION['systemLang']) ?>
          </label>
        </div>
      </div>
      <div class="col-sm-12">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" <?php if ($_SESSION['user_update'] == 0 || $_SESSION['permission_update'] == 0) {echo 'disabled';} ?> <?php if ($permissions['comb_show'] == 1) {echo 'checked';} ?> value="1" name="combShow" id="combShow">
          <label class="form-check-label" for="combShow">
            <?php echo language("SHOW", @$_SESSION['systemLang']) ?>
          </label>
        </div>
      </div>
      <div class="col-sm-12">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" <?php if ($_SESSION['user_update'] == 0 || $_SESSION['permission_update'] == 0) {echo 'disabled';} ?> <?php if ($permissions['comb_review'] == 1) {echo 'checked';} ?> value="1" name="combReview" id="combReview">
          <label class="form-check-label" for="combReview">
            <?php echo language("RATING", @$_SESSION['systemLang']) ?>
          </label>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="mb-4 row">
  <div class="col-sm-12 col-md-3"><?php echo language('PERMISSIONS', @$_SESSION['systemLang']) ?></div>
  <div class="col-sm-12 col-md-8">
    <div class="row row-cols-sm-1 row-cols-md-3 row-cols-lg-5 align-items-start g-sm-1 gx-md-5">
      <div class="col-sm-12">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" <?php if ($_SESSION['user_update'] == 0 || $_SESSION['permission_update'] == 0) {echo 'disabled';} ?> <?php if ($permissions['permission_update'] == 1) {echo 'checked';} ?> value="1" name="permissionUpdate" id="permissionUpdate">
          <label class="form-check-label" for="permissionUpdate">
            <?php echo language("EDIT", @$_SESSION['systemLang']) ?>
          </label>
        </div>
      </div>
      <div class="col-sm-12">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" <?php if ($_SESSION['user_update'] == 0 || $_SESSION['permission_update'] == 0) {echo 'disabled';} ?> <?php if ($permissions['permission_show'] == 1) {echo 'checked';} ?> value="1" name="permissionShow" id="permissionShow">
          <label class="form-check-label" for="permissionShow">
            <?php echo language("SHOW", @$_SESSION['systemLang']) ?>
          </label>
        </div>
      </div>
    </div>
  </div>
</div>