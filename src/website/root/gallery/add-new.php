<div class="container page-container" dir="<?php echo $page_dir ?>">
  <!-- add new img form -->
  <form action="?do=insert-img" method="post" id="add-new-img" onchange="form_validation(this)" enctype="multipart/form-data">
    <div class="img-content">
      <div class="form-header">
        <h3 class="h3 text-capitalize"><?php echo lang('IMG INFO', $lang_file) ?></h3>

        <button type="button" class="btn btn-outline-primary py-1 floating-button floating-button-<?php echo $page_dir == 'rtl' ? 'left' : 'right' ?>" onclick="add_new_content('.form-content.form-content__content', 'section-content')">
          <i class="bi bi-plus"></i>
          <span><?php echo lang('ADD NEW', $lang_file) ?></span>
        </button>
      </div>
      <div id="section-content">
        <div class="form-content form-content__content add-img">
          <div class="img-control">
            <div class="img-btn-controls">
              <!-- gallery image form -->
              <input type="file" class="d-none" name="gallery-img-input[]" id="gallery-img-input" onchange="change_gallery_img(this)" accept="image/*">
              <!-- edit image button -->
              <button type="button" role="button" class="btn btn-outline-primary fs-12 py-1 text-capitalize change" onclick="click_input(this)">
                <i class="bi bi-image"></i>
                <?php echo lang('CHANGE IMG', $lang_file) ?>
              </button>
            </div>
            <div class="form-floating">
              <select name="is-active[]" class="form-select" required>
                <option value="default" selected disabled><?php echo lang('SELECT STATUS', $lang_file) ?></option>
                <option value="1"><?php echo lang('ACTIVE') ?></option>
                <option value="0"><?php echo lang('INACTIVE') ?></option>
              </select>
              <label for="is-active" class="col-sm-4 col-form-label text-capitalize"><?php echo lang('STATUS', $lang_file) ?></label>
            </div>
          </div>
          <!-- image preview -->
          <div class="img-container-preview"><img src="<?php echo $assets ?>leadergroupegypt-shadow.png" alt="default image"></div>
          <!-- button to delete section -->
          <button type="button" class="btn btn-outline-danger delete-content" onclick="delete_content(this)">
            <i class="bi bi-trash"></i>
            <?php echo lang('DELETE') ?>
          </button>
        </div>
      </div>
    </div>
    <!-- submit button -->
    <div class="dashboard-buttons" dir="<?php echo $page_dir == 'rtl' ? 'ltr' : 'rtl' ?>">
      <button type="button" class="btn btn-primary" onclick="form_validation(this.form, this)">
        <i class="bi bi-check-all"></i>
        <?php echo lang('SAVE') ?>
      </button>
    </div>
  </form>
</div>