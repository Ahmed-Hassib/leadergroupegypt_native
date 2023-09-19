<div class="container page-container" dir="<?php echo $page_dir ?>">
  <!-- add new section form -->
  <form action="?do=insert-section" method="post" id="add-new-section">
    <div class="section-content">
      <div class="form-header">
        <h3 class="h3 text-capitalize"><?php echo lang('SECTION INFO', $lang_file) ?></h3>
      </div>
      <div class="form-content">
        <div class="form-floating">
          <input type="text" class="form-control" name="name-ar" id="name-ar" placeholder="<?php echo lang('AR TITLE', $lang_file) ?>" required>
          <label for="name-ar"><?php echo lang('AR TITLE', $lang_file) ?></label>
        </div>
        <div class="form-floating">
          <input type="text" class="form-control" name="name-en" id="name-en" placeholder="<?php echo lang('EN TITLE', $lang_file) ?>" required>
          <label for="name-en"><?php echo lang('EN TITLE', $lang_file) ?></label>
        </div>
        <div class="form-floating">
          <input type="text" class="form-control" name="desc-ar" id="desc-ar" placeholder="<?php echo lang('AR DESC', $lang_file) ?>" required>
          <label for="desc-ar"><?php echo lang('AR DESC', $lang_file) ?></label>
        </div>
        <div class="form-floating">
          <input type="text" class="form-control" name="desc-en" id="desc-en" placeholder="<?php echo lang('EN DESC', $lang_file) ?>" required>
          <label for="desc-en"><?php echo lang('EN DESC', $lang_file) ?></label>
        </div>
        <div class="row">
          <label for="is-active" class="col-sm-4 col-form-label text-capitalize"><?php echo lang('SEC STATUS', $lang_file) ?></label>
          <div class="mt-2 col-sm-8">
            <!-- active -->
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="is-active" id="active" value="1">
              <label class="form-check-label text-capitalize" for="active"><?php echo lang('ACTIVE') ?></label>
            </div>
            <!-- inactive -->
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="is-active" id="inactive" value="0">
              <label class="form-check-label text-capitalize" for="inactive"><?php echo lang('INACTIVE') ?></label>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="section-content">
      <div class="form-header">
        <h3 class="h3 text-capitalize"><?php echo lang('CONTENT INFO', $lang_file) ?></h3>
        <button type="button" class="btn btn-outline-primary py-1 floating-button floating-button-<?php echo $page_dir == 'rtl' ? 'left' : 'right' ?>" onclick="add_new_content('.form-content.form-content__content', 'section-content')">
          <i class="bi bi-plus"></i>
          <span><?php echo lang('ADD NEW CONTENT', $lang_file) ?></span>
        </button>
      </div>
      <div id="section-content">
        <div class="form-content form-content__content">
          <div class="form-floating">
            <input type="text" class="form-control" name="card-title-ar[]" id="card-title-ar" placeholder="<?php echo lang('EN CARD TITLE', $lang_file) ?>">
            <label for="card-title-ar"><?php echo lang('AR CARD TITLE', $lang_file) ?></label>
          </div>
          <div class="form-floating">
            <input type="text" class="form-control" name="card-title-en[]" id="card-title-en" placeholder="<?php echo lang('EN CARD TITLE', $lang_file) ?>">
            <label for="card-title-en"><?php echo lang('EN CARD TITLE', $lang_file) ?></label>
          </div>
          <div class="form-floating">
            <input type="text" class="form-control" name="card-desc-ar[]" id="card-desc-ar" placeholder="<?php echo lang('AR CARD DESC', $lang_file) ?>">
            <label for="card-desc-ar"><?php echo lang('AR CARD DESC', $lang_file) ?></label>
          </div>
          <div class="form-floating">
            <input type="text" class="form-control" name="card-desc-en[]" id="card-desc-en" placeholder="<?php echo lang('EN CARD DESC', $lang_file) ?>">
            <label for="card-desc-en"><?php echo lang('EN CARD DESC', $lang_file) ?></label>
          </div>
          <div class="content-link">
            <label for="have-link"><?php echo lang('HAVE LINK', $lang_file) ?></label>
            <!-- have link -->
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" name="have-link[]" id="have-link" value="1" onchange="enable(this, 'link')">
              <label class="form-check-label text-capitalize" for="have-link"><?php echo lang('YES') ?></label>
            </div>
            <!-- link -->
            <div class="form-floating">
              <input type="text" class="form-control" name="link[]" id="link" placeholder="<?php echo lang('LINK') ?>" disabled>
              <label class="text-capitalize" for="link"><?php echo lang('LINK') ?></label>
            </div>
          </div>
          <div class="content-status">
            <label for="is-active-content"><?php echo lang('STATUS', $lang_file) ?></label>
            <!-- have link -->
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" name="is-active-content[]" id="is-active-content" value="1" onchange="enable(this, 'link')">
              <label class="form-check-label text-capitalize" for="is-active-content"><?php echo lang('ACTIVE') ?></label>
            </div>
            <!-- have link -->
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" name="is-active-content[]" id="is-active-content" value="1" onchange="enable(this, 'link')">
              <label class="form-check-label text-capitalize" for="is-active-content"><?php echo lang('INACTIVE') ?></label>
            </div>
          </div>
          <!-- button to delete section -->
          <button type="button" class="btn btn-outline-danger delete-content" onclick="delete_content(this)">
            <i class="bi bi-trash"></i>
            <?php echo lang('DELETE') ?>
          </button>
        </div>
      </div>
    </div>
  </form>
  <!-- form button -->
  <div class="dashboard-buttons" dir="<?php echo $page_dir == 'rtl' ? 'ltr' : 'rtl' ?>">
    <button type="submit" form="add-new-section" class="btn btn-primary py-1">
      <span><?php echo lang('ADD') ?></span>
      <i class="bi bi-plus"></i>
    </button>
  </div>
</div>