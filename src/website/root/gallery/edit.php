<?php
// create an object of Gallery class
$gallery_obj = !isset($gallery_obj) ? new Gallery() : $gallery_obj;

// get img id
$img_id = isset($_GET['id']) && !empty($_GET['id']) ? base64_decode($_GET['id']) : null;

// check if img id exists or not
if ($gallery_obj->is_exist("`id`", "`gallery`", $img_id)) {
  // get img info
  $img_info = $gallery_obj->get_img($img_id)[0];
?>
  <div class="container page-container" dir="<?php echo $page_dir ?>">
    <!-- add new img form -->
    <form action="?do=update-img" method="post" id="edit-img" onchange="form_validation(this)" enctype="multipart/form-data">
      <div class="img-content">
        <div class="form-header">
          <h3 class="h3 text-capitalize"><?php echo lang('IMG INFO', $lang_file) ?></h3>
        </div>
        <div id="section-content">
          <div class="form-content form-content__content form-edit">
            <input type="hidden" name="id" id="id" value="<?php echo base64_encode($img_id) ?>">
            <div class="img-control">
              <div class="img-btn-controls">
                <!-- gallery image form -->
                <input type="file" class="d-none" name="gallery-img-input" id="gallery-img-input" onchange="change_section_img(this)" accept="image/*">
                <!-- edit image button -->
                <button type="button" role="button" class="btn btn-outline-primary fs-12 py-1 text-capitalize change" onclick="click_input(this)">
                  <i class="bi bi-image"></i>
                  <?php echo lang('CHANGE IMG', $lang_file) ?>
                </button>
              </div>
              <div class="form-floating">
                <select name="is-active" class="form-select" required>
                  <option value="default" selected disabled><?php echo lang('SELECT STATUS', $lang_file) ?></option>
                  <option value="1" <?php echo $img_info['is_active'] == 1 ? 'selected' : '' ?>><?php echo lang('ACTIVE') ?></option>
                  <option value="0" <?php echo $img_info['is_active'] == 0 ? 'selected' : '' ?>><?php echo lang('INACTIVE') ?></option>
                </select>
                <label for="is-active" class="col-sm-4 col-form-label text-capitalize"><?php echo lang('STATUS', $lang_file) ?></label>
              </div>
            </div>
            <!-- image preview -->
            <div class="img-container-preview">
              <?php if (file_exists($gallery_img . $img_info['img_name'])) { ?>
                <img loading="lazy" src="<?php echo $gallery_img . $img_info['img_name'] ?>" alt="image">
              <?php } else { ?>
                <img loading="lazy" src="<?php echo $assets ?>leadergroupegypt-shadow.png" alt="default image">
              <?php } ?>
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

<?php
} else {
  // include no data founded module
  include_once $globmod . 'no-data-founded.php';
}
