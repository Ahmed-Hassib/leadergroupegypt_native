<?php
// create an object of Link class
$link_obj = !isset($link_obj) ? new Link() : $link_obj;

// get link id
$link_id = isset($_GET['id']) && !empty($_GET['id']) ? base64_decode($_GET['id']) : null;

// check if link id exists or not
if ($link_obj->is_exist("`id`", "`important_links`", $link_id)) {
  // get link info
  $link_info = $link_obj->get_link($link_id)[0];
?>
  <div class="container page-container" dir="<?php echo $page_dir ?>">
    <!-- add new link form -->
    <form action="?do=update-link" method="post" id="edit-link" onchange="form_validation(this)">
      <div class="link-content">
        <div class="form-header">
          <h3 class="h3 text-capitalize"><?php echo lang('LINK INFO', $lang_file) ?></h3>
        </div>
        <div id="section-content">
          <div class="form-content form-content__content form-edit">
            <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
            <div class="form-floating">
              <input type="text" class="form-control" name="name-ar" id="name-ar" placeholder="<?php echo lang('AR NAME', $lang_file) ?>" value="<?php echo $link_info['link_name_ar'] ?>" required>
              <label for="name-ar"><?php echo lang('AR NAME', $lang_file) ?></label>
            </div>
            <div class="form-floating">
              <input type="text" class="form-control" name="name-en" id="name-en" placeholder="<?php echo lang('EN NAME', $lang_file) ?>" value="<?php echo $link_info['link_name_en'] ?>" dir="ltr" required>
              <label for="name-en"><?php echo lang('EN NAME', $lang_file) ?></label>
            </div>
            <div class="form-floating">
              <select name="is-active" class="form-select" required>
                <option value="default" selected disabled><?php echo lang('SELECT STATUS', $lang_file) ?></option>
                <option value="1" <?php echo $link_info['is_active'] == '1' ? 'selected' : null ?>><?php echo lang('ACTIVE') ?></option>
                <option value="0" <?php echo $link_info['is_active'] == '0' ? 'selected' : null ?>><?php echo lang('INACTIVE') ?></option>
              </select>
              <label for="is-active" class="col-sm-4 col-form-label text-capitalize"><?php echo lang('STATUS', $lang_file) ?></label>
            </div>
            <div class="form-floating">
              <input type="text" class="form-control" name="link" id="link" placeholder="<?php echo lang('LINK', $lang_file) ?>" value="<?php echo $link_info['link'] ?>" dir="ltr" required>
              <label for="link"><?php echo lang('LINK', $lang_file) ?></label>
            </div>
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

<?php
} else {
  // include no data founded module
  include_once $globmod . 'no-data-founded.php';
}
