<?php
// create an object of Features class
$features_obj = !isset($features_obj) ? new Features() : $features_obj;
// get feature id
$feature_id = isset($_GET['id']) && !empty($_GET['id']) ? base64_decode($_GET['id']) : null;
// check if feature id exists or not
if ($features_obj->is_exist("`id`", "`features`", $feature_id)) {
  // get feature info
  $feature_info = $features_obj->get_feature($feature_id);
  ?>
  <div class="container page-container" dir="<?php echo $page_dir ?>">
    <!-- add new feature form -->
    <form action="?do=update-feature" method="post" id="update-feature" onchange="form_validation(this)"
      enctype="multipart/form-data">
      <div class="feature-content">
        <div class="form-header">
          <h3 class="h3 text-capitalize">
            <?php echo lang('FEATURE INFO', $lang_file) ?>
          </h3>
        </div>
        <div id="section-content">
          <div class="form-content form-content__content add-features">
            <div class="feature-img">
              <div class="img-control">
                <div class="img-btn-controls">
                  <!-- feature id -->
                  <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
                  <!-- feature image form -->
                  <input type="file" class="d-none" name="feature-img-input" id="feature-img-input"
                    onchange="change_feature_img(this)" accept="image/*">
                  <!-- edit image button -->
                  <button type="button" role="button" class="btn btn-outline-primary fs-12 py-1 text-capitalize change"
                    onclick="click_input(this)">
                    <i class="bi bi-image"></i>
                    <?php echo lang('CHANGE IMG', 'services') ?>
                  </button>
                </div>
                <div class="form-floating">
                  <select name="is-active" class="form-select" required>
                    <option value="default" disabled>
                      <?php echo lang('SELECT STATUS', $lang_file) ?>
                    </option>
                    <option value="1" <?php $feature_info['is_active'] == '1' ? 'selected' : '' ?>>
                      <?php echo lang('ACTIVE') ?>
                    </option>
                    <option value="0" <?php $feature_info['is_active'] == '0' ? 'selected' : '' ?>>
                      <?php echo lang('INACTIVE') ?>
                    </option>
                  </select>
                  <label for="is-active" class="col-sm-4 col-form-label text-capitalize">
                    <?php echo lang('STATUS', $lang_file) ?>
                  </label>
                </div>
              </div>
              <!-- image preview -->
              <div class="img-container-preview">
                <?php if (file_exists($features_img . $feature_info['feature_img'])) { ?>
                  <?php $is_resized = resize_img($features_img, $feature_info['feature_img']); ?>
                  <img
                    src="<?php echo $is_resized ? $features_img . "resized/" . $feature_info['feature_img'] : $features_img . $feature_info['feature_img'] ?>"
                    alt="image">
                <?php } else { ?>
                  <img src="<?php echo $assets ?>leadergroupegypt-shadow.png" alt="default image">
                <?php } ?>
              </div>
            </div>
            <!-- feature name in arabic -->
            <div class="form-floating">
              <input type="text" class="form-control" name="ar-name" id="ar-name"
                placeholder="<?php echo lang('AR FEATURE NAME', $lang_file) ?>"
                value="<?php echo $feature_info['feature_name_ar'] ?>" required>
              <label for="ar-name">
                <?php echo lang('AR FEATURE NAME', $lang_file) ?>
              </label>
            </div>
            <!-- feature name in english -->
            <div class="form-floating">
              <input type="text" class="form-control" name="en-name" id="en-name" dir="ltr"
                placeholder="<?php echo lang('EN FEATURE NAME', $lang_file) ?>"
                value="<?php echo $feature_info['feature_name_en'] ?>" required>
              <label for="en-name">
                <?php echo lang('EN FEATURE NAME', $lang_file) ?>
              </label>
            </div>
            <!-- feature desc in arabic -->
            <div class="form-floating">
              <input type="text" class="form-control" name="ar-desc" id="ar-desc"
                placeholder="<?php echo lang('AR DESC FEATURE', $lang_file) ?>"
                value="<?php echo $feature_info['feature_desc_ar'] ?>" required>
              <label for="ar-desc">
                <?php echo lang('AR DESC FEATURE', $lang_file) ?>
              </label>
              <div id="featureDeskHelp" class="form-text text-info">
                <i class="bi bi-exclamation-triangle"></i>
                <?php echo lang('FEATURE DESC NOTE', $lang_file) ?>
              </div>
            </div>
            <!-- feature desc in english -->
            <div class="form-floating">
              <input type="text" class="form-control" name="en-desc" id="en-desc" dir="ltr"
                placeholder="<?php echo lang('EN DESC FEATURE', $lang_file) ?>"
                value="<?php echo $feature_info['feature_desc_en'] ?>" required>
              <label for="en-desc">
                <?php echo lang('EN DESC FEATURE', $lang_file) ?>
              </label>
              <div id="featureDeskHelp" class="form-text text-info">
                <i class="bi bi-exclamation-triangle"></i>
                <?php echo lang('FEATURE DESC NOTE', $lang_file) ?>
              </div>
            </div>
            <!-- feature details container -->
            <div class="feature-details" id="feature-details">
              <?php
              // get features details info
              $features_details = $features_obj->get_feature_details($feature_info['id']);
              // check counter of feature details
              if (count($features_details) > 0) {
                // loop on features details
                foreach ($features_details as $key => $detail) {
                  ?>
                  <div class="feature-details__content" id="feature-details__content">
                    <header>
                      <h4 class="h4 text-capitalize">
                        <?php echo lang('FEATURE DETAILS', $lang_file) ?>
                      </h4>
                    </header>
                    <!-- detail name in arabic -->
                    <div class="form-floating">
                      <input type="text" class="form-control" name="ar-detail-name[]" id="ar-detail-name"
                        value="<?php echo $detail['detail_name_ar'] ?>"
                        placeholder="<?php echo lang('AR DETAIL NAME', $lang_file) ?>">
                      <label for="ar-detail-name">
                        <?php echo lang('AR DETAIL NAME', $lang_file) ?>
                      </label>
                    </div>
                    <!-- detail name in english -->
                    <div class="form-floating">
                      <input type="text" class="form-control" name="en-detail-name[]" id="en-detail-name" dir="ltr"
                        value="<?php echo $detail['detail_name_en'] ?>"
                        placeholder="<?php echo lang('EN DETAIL NAME', $lang_file) ?>">
                      <label for="en-detail-name">
                        <?php echo lang('EN DETAIL NAME', $lang_file) ?>
                      </label>
                    </div>
                    <!-- feature text in arabic -->
                    <div class="form-floating">
                      <textarea type="text" class="form-control" name="ar-text[]" id="ar-text"
                        placeholder="<?php echo lang('AR TEXT FEATURE', $lang_file) ?>"><?php echo $detail['detail_ar'] ?></textarea>
                      <label for="ar-text">
                        <?php echo lang('AR TEXT FEATURE', $lang_file) ?>
                      </label>
                    </div>
                    <!-- feature text in english -->
                    <div class="form-floating">
                      <textarea type="text" class="form-control" name="en-text[]" id="en-text" dir="ltr"
                        placeholder="<?php echo lang('EN TEXT FEATURE', $lang_file) ?>"><?php echo $detail['detail_en'] ?></textarea>
                      <label for="en-text">
                        <?php echo lang('EN TEXT FEATURE', $lang_file) ?>
                      </label>
                    </div>
                    <!-- details control buttons button -->
                    <div class="details-btn">
                      <button type="button" class="btn btn-outline-primary add-details py-1"
                        onclick="add_new_content('.form-content .feature-details .feature-details__content', 'feature-details')">
                        <i class="bi bi-plus"></i>
                        <?php echo lang('ADD DETAILS', $lang_file) ?>
                      </button>
                      <button type="button" class="btn btn-outline-danger delete-details py-1"
                        onclick="delete_feature_detail(this)"
                        data-feature-detail-id="<?php echo base64_encode($detail['id']) ?>">
                        <i class="bi bi-trash"></i>
                        <?php echo lang('DELETE DETAILS', $lang_file) ?>
                      </button>
                    </div>
                  </div>
                <?php } ?>
              <?php } else { ?>
                <div class="feature-details__content" id="feature-details__content">
                  <header>
                    <h4 class="h4 text-capitalize">
                      <?php echo lang('FEATURE DETAILS', $lang_file) ?>
                    </h4>
                  </header>
                  <!-- detail name in arabic -->
                  <div class="form-floating">
                    <input type="text" class="form-control" name="ar-detail-name[]" id="ar-detail-name"
                      placeholder="<?php echo lang('AR DETAIL NAME', $lang_file) ?>">
                    <label for="ar-detail-name">
                      <?php echo lang('AR DETAIL NAME', $lang_file) ?>
                    </label>
                  </div>
                  <!-- detail name in english -->
                  <div class="form-floating">
                    <input type="text" class="form-control" name="en-detail-name[]" id="en-detail-name" dir="ltr"
                      placeholder="<?php echo lang('EN DETAIL NAME', $lang_file) ?>">
                    <label for="en-detail-name">
                      <?php echo lang('EN DETAIL NAME', $lang_file) ?>
                    </label>
                  </div>
                  <!-- feature text in arabic -->
                  <div class="form-floating">
                    <textarea type="text" class="form-control" name="ar-text[]" id="ar-text"
                      placeholder="<?php echo lang('AR TEXT FEATURE', $lang_file) ?>"></textarea>
                    <label for="ar-text">
                      <?php echo lang('AR TEXT FEATURE', $lang_file) ?>
                    </label>
                  </div>
                  <!-- feature text in english -->
                  <div class="form-floating">
                    <textarea type="text" class="form-control" name="en-text[]" id="en-text" dir="ltr"
                      placeholder="<?php echo lang('EN TEXT FEATURE', $lang_file) ?>"></textarea>
                    <label for="en-text">
                      <?php echo lang('EN TEXT FEATURE', $lang_file) ?>
                    </label>
                  </div>
                  <!-- details control buttons button -->
                  <div class="details-btn">
                    <button type="button" class="btn btn-outline-primary add-details py-1"
                      onclick="add_new_content('.form-content .feature-details .feature-details__content', 'feature-details')">
                      <i class="bi bi-plus"></i>
                      <?php echo lang('ADD DETAILS', $lang_file) ?>
                    </button>
                    <button type="button" class="btn btn-outline-danger delete-details py-1"
                      onclick="delete_content(this.parentElement)">
                      <i class="bi bi-trash"></i>
                      <?php echo lang('DELETE DETAILS', $lang_file) ?>
                    </button>
                  </div>
                </div>
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
        <button type="button" class="btn btn-danger" onclick="confirm_delete_feature(this)" data-href="?do=delete-feature&id=<?php echo $_GET['id'] ?>">
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