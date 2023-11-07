<?php
// create an object of AboutUs class
$about_obj = !isset($about_obj) ? new AboutUs() : $about_obj;

// get text id
$text_id = isset($_GET['id']) && !empty($_GET['id']) ? base64_decode($_GET['id']) : null;

// check if text id exists or not
if ($about_obj->is_exist("`id`", "`about_us`", $text_id)) {
  // get text info
  $text_info = $about_obj->get_text($text_id)[0];
  ?>
  <div class="container page-container" dir="<?php echo $page_dir ?>">
    <!-- add new text form -->
    <form action="?do=update-text" method="post" id="edit-text" onchange="form_validation(this)">
      <div class="text-content">
        <div class="form-header">
          <h3 class="h3 text-capitalize">
            <?php echo lang('TEXT INFO', $lang_file) ?>
          </h3>
        </div>
        <div id="section-content">
          <div class="form-content form-content__content form-edit">
            <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
            <div class="form-floating">
              <textarea type="text" class="form-control" name="text-ar" id="text-ar"
                placeholder="<?php echo lang('AR TEXT', $lang_file) ?>"
                required><?php echo $text_info['text_ar'] ?></textarea>
              <label for="text-ar">
                <?php echo lang('AR TEXT', $lang_file) ?>
              </label>
            </div>
            <div class="form-floating">
              <textarea type="text" class="form-control" name="text-en" id="text-en"
                placeholder="<?php echo lang('EN TEXT', $lang_file) ?>" dir="ltr"
                required><?php echo $text_info['text_en'] ?></textarea>
              <label for="text-en">
                <?php echo lang('EN TEXT', $lang_file) ?>
              </label>
            </div>
            <div class="form-floating">
              <select name="is-active" class="form-select" required>
                <option value="default" selected disabled>
                  <?php echo lang('SELECT STATUS', $lang_file) ?>
                </option>
                <option value="1" <?php echo $text_info['is_active'] == '1' ? 'selected' : null ?>><?php echo lang('ACTIVE') ?></option>
                <option value="0" <?php echo $text_info['is_active'] == '0' ? 'selected' : null ?>><?php echo lang('INACTIVE') ?></option>
              </select>
              <label for="is-active" class="col-sm-4 col-form-label text-capitalize">
                <?php echo lang('STATUS', $lang_file) ?>
              </label>
            </div>
          </div>
        </div>
      </div>
      <!-- submit button -->
      <div class="dashboard-buttons" dir="<?php echo $page_dir == 'rtl' ? 'ltr' : 'rtl' ?>">
        <button type="button" data-href="?do=delete-text&id=<?php echo base64_encode($text_info['id']) ?>&back=true"
          class="btn btn-outline-danger py-0" onclick="confirm_delete(this)">
          <i class="bi bi-trash"></i>
          <?php echo lang('DELETE') ?>
        </button>
        <button type="button" class="btn btn-primary" onclick="form_validation(this.form, this)">
          <i class="bi bi-check-all"></i>
          <?php echo lang('SAVE') ?>
        </button>
      </div>
    </form>
  </div>

  <?php
} else {
  // include no data founded module
  include_once $globmod . 'no-data-founded.php';
}