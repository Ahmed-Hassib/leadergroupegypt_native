<div class="container page-container" dir="<?php echo $page_dir ?>">
  <!-- add new service form -->
  <form action="?do=insert-service" method="post" id="add-new-service" onchange="form_validation(this)" enctype="multipart/form-data">
    <div class="service-content">
      <div class="form-header">
        <h3 class="h3 text-capitalize"><?php echo lang('SERVICE INFO', $lang_file) ?></h3>

        <button type="button" class="btn btn-outline-primary py-1 floating-button floating-button-<?php echo $page_dir == 'rtl' ? 'left' : 'right' ?>" onclick="add_new_content('.form-content.form-content__content', 'section-content')">
          <i class="bi bi-plus"></i>
          <span><?php echo lang('ADD NEW', $lang_file) ?></span>
        </button>
      </div>
      <div id="section-content">
        <div class="form-content form-content__content add-services">
          <div class="service-img">
            <div class="img-control">
              <div class="img-btn-controls">
                <!-- service image form -->
                <input type="file" class="d-none" name="service-img-input[]" id="service-img-input" onchange="change_service_img(this)" accept="image/*">
                <!-- edit image button -->
                <button type="button" role="button" class="btn btn-outline-primary fs-12 py-1 text-capitalize change" onclick="click_input(this)">
                  <i class="bi bi-image"></i>
                  <?php echo lang('CHANGE IMG', $lang_file) ?>
                </button>
              </div>
              <div class="form-floating">
                <select name="is-active[]" class="form-select" required>
                  <option value="default" selected disabled><?php echo lang('SELECT STATUS', $lang_file) ?></option>
                  <option value="2"><?php echo lang('WAITING') ?></option>
                  <option value="1"><?php echo lang('ACTIVE') ?></option>
                  <option value="0"><?php echo lang('INACTIVE') ?></option>
                </select>
                <label for="is-active" class="col-sm-4 col-form-label text-capitalize"><?php echo lang('STATUS', $lang_file) ?></label>
              </div>
            </div>
            <!-- image preview -->
            <div class="img-container-preview">
              <img src="<?php echo $assets ?>leadergroupegypt-shadow.png" alt="default image">
            </div>
          </div>
          <div class="form-floating">
            <input type="text" class="form-control" name="name-1-ar[]" id="name-1-ar" placeholder="<?php echo lang('LINK 1 AR', $lang_file) ?>">
            <label for="name-1-ar"><?php echo lang('LINK 1 AR', $lang_file) ?></label>
          </div>
          <div class="form-floating">
            <input type="text" class="form-control" name="name-1-en[]" id="name-1-en" placeholder="<?php echo lang('LINK 1 EN', $lang_file) ?>" dir="ltr">
            <label for="name-1-en"><?php echo lang('LINK 1 EN', $lang_file) ?></label>
          </div>
          <div class="form-floating">
            <input type="text" class="form-control" name="link-1[]" id="link-1" placeholder="<?php echo lang('LINK 1', $lang_file) ?>" dir="ltr">
            <label for="link-1"><?php echo lang('LINK 1', $lang_file) ?></label>
          </div>
          <div class="form-floating">
            <input type="text" class="form-control" name="name-2-ar[]" id="name-2-ar" placeholder="<?php echo lang('LINK 2 AR', $lang_file) ?>">
            <label for="name-2-ar"><?php echo lang('LINK 2 AR', $lang_file) ?></label>
          </div>
          <div class="form-floating">
            <input type="text" class="form-control" name="name-2-en[]" id="name-2-en" placeholder="<?php echo lang('LINK 2 EN', $lang_file) ?>" dir="ltr">
            <label for="name-2-en"><?php echo lang('LINK 2 EN', $lang_file) ?></label>
          </div>
          <div class="form-floating">
            <input type="text" class="form-control" name="link-2[]" id="link-2" placeholder="<?php echo lang('LINK 2', $lang_file) ?>" dir="ltr">
            <label for="link-2"><?php echo lang('LINK 2', $lang_file) ?></label>
          </div>
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