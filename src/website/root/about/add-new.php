<div class="container page-container" dir="<?php echo $page_dir ?>">
  <!-- add new text form -->
  <form action="?do=insert-text" method="post" id="add-new-text" onchange="form_validation(this)">
    <div class="text-content">
      <div class="form-header">
        <h3 class="h3 text-capitalize">
          <?php echo lang('TEXT INFO', $lang_file) ?>
        </h3>

        <button type="button"
          class="btn btn-outline-primary py-1 floating-button floating-button-<?php echo $page_dir == 'rtl' ? 'left' : 'right' ?>"
          onclick="add_new_content('.form-content.form-content__content', 'section-content')">
          <i class="bi bi-plus"></i>
          <span>
            <?php echo lang('ADD NEW', $lang_file) ?>
          </span>
        </button>
      </div>
      <div id="section-content">
        <?php if (isset($_SESSION['website']['request_data']) && !empty($_SESSION['website']['request_data'])) { ?>
          <?php foreach ($_SESSION['website']['request_data'] as $key => $value) { ?>
            <div class="form-content form-content__content">
              <div class="form-floating">
                <textarea type="text" class="form-control" name="text-ar[]" id="text-ar"
                  placeholder="<?php echo lang('AR TEXT', $lang_file) ?>"
                  value="<?php echo $_SESSION['website']['request_data'][$key]['ar'] ?>" style="height: 150px !important;"
                  required></textarea>
                <label for="text-ar">
                  <?php echo lang('AR TEXT', $lang_file) ?>
                </label>
              </div>
              <div class="form-floating">
                <textarea type="text" class="form-control" name="text-en[]" id="text-en" dir="ltr"
                  placeholder="<?php echo lang('EN TEXT', $lang_file) ?>"
                  value="<?php echo $_SESSION['website']['request_data'][$key]['en'] ?>" style="height: 150px !important;"
                  required></textarea>
                <label for="text-en">
                  <?php echo lang('EN TEXT', $lang_file) ?>
                </label>
              </div>
              <div class="form-floating">
                <select name="is-active[]" class="form-select" required>
                  <option value="default" selected disabled>
                    <?php echo lang('SELECT STATUS', $lang_file) ?>
                  </option>
                  <option value="1" <?php echo $_SESSION['website']['request_data'][$key]['status'] == '1' ? 'selected' : null ?>><?php echo lang('ACTIVE') ?></option>
                  <option value="0" <?php echo $_SESSION['website']['request_data'][$key]['status'] == '0' ? 'selected' : null ?>><?php echo lang('INACTIVE') ?></option>
                </select>
                <label for="is-active" class="col-sm-4 col-form-label text-capitalize">
                  <?php echo lang('STATUS', $lang_file) ?>
                </label>
              </div>
              <!-- button to delete section -->
              <button type="button" class="btn btn-outline-danger delete-content" onclick="delete_content(this)">
                <i class="bi bi-trash"></i>
                <?php echo lang('DELETE') ?>
              </button>
            </div>
          <?php } ?>
        <?php } else { ?>
          <div class="form-content form-content__content">
            <div class="form-floating">
              <textarea type="text" class="form-control" name="text-ar[]" id="text-ar"
                placeholder="<?php echo lang('AR TEXT', $lang_file) ?>" style="height: 150px !important;"
                required></textarea>
              <label for="text-ar">
                <?php echo lang('AR TEXT', $lang_file) ?>
              </label>
            </div>
            <div class="form-floating">
              <textarea type="text" class="form-control" name="text-en[]" id="text-en" dir="ltr"
                placeholder="<?php echo lang('EN TEXT', $lang_file) ?>" style="height: 150px !important;"
                required></textarea>
              <label for="text-en">
                <?php echo lang('EN TEXT', $lang_file) ?>
              </label>
            </div>
            <div class="form-floating">
              <select name="is-active[]" class="form-select" required>
                <option value="default" selected disabled>
                  <?php echo lang('SELECT STATUS', $lang_file) ?>
                </option>
                <option value="1">
                  <?php echo lang('ACTIVE') ?>
                </option>
                <option value="0">
                  <?php echo lang('INACTIVE') ?>
                </option>
              </select>
              <label for="is-active" class="col-sm-4 col-form-label text-capitalize">
                <?php echo lang('STATUS', $lang_file) ?>
              </label>
            </div>
            <!-- button to delete section -->
            <button type="button" class="btn btn-outline-danger delete-content" onclick="delete_content(this)">
              <i class="bi bi-trash"></i>
              <?php echo lang('DELETE') ?>
            </button>
          </div>
        <?php } ?>
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