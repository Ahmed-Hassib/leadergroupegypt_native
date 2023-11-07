<div class="container page-container" dir="<?php echo $page_dir ?>">
  <!-- add new member form -->
  <form action="?do=insert-member" method="post" id="add-new-member" onchange="form_validation(this)"
    enctype="multipart/form-data">
    <div class="member-content">
      <div class="form-header">
        <h3 class="h3 text-capitalize">
          <?php echo lang('MEMBER INFO', $lang_file) ?>
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
        <div class="form-content form-content__content add-members">
          <div class="member-img">
            <div class="img-control">
              <div class="img-btn-controls">
                <!-- member image form -->
                <input type="file" class="d-none" name="member-img-input[]" id="member-img-input"
                  onchange="change_section_img(this)" accept="image/*">
                <!-- edit image button -->
                <button type="button" role="button" class="btn btn-outline-primary fs-12 py-1 text-capitalize change"
                  onclick="click_input(this)">
                  <i class="bi bi-image"></i>
                  <?php echo lang('CHANGE IMG', $lang_file) ?>
                </button>
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
            </div>
            <!-- image preview -->
            <div class="img-container-preview">
              <img src="<?php echo $assets ?>leadergroupegypt-shadow.png" alt="default image">
            </div>
          </div>
          <div class="form-floating">
            <input type="text" class="form-control" name="name[]" id="name"
              placeholder="<?php echo lang('MEMBER NAME', $lang_file) ?>" required>
            <label for="name">
              <?php echo lang('MEMBER NAME', $lang_file) ?>
            </label>
          </div>
          <div class="form-floating">
            <input type="text" class="form-control" name="job-title[]" id="job-title"
              placeholder="<?php echo lang('JOB TITLE', $lang_file) ?>" required>
            <label for="job-title">
              <?php echo lang('JOB TITLE', $lang_file) ?>
            </label>
          </div>
          <div class="input-group" dir="ltr">
            <div class="input-group-text"><i class="bi bi-facebook"></i></div>
            <div class="form-floating">
              <input type="text" class="form-control" name="facebook[]" id="facebook"
              placeholder="<?php echo lang('facebook', $lang_file) ?>" dir="ltr" onblur="link_validation(this, this.value, 'facebook')">
              <label for="facebook">
                <?php echo lang('facebook', $lang_file) ?>
              </label>
            </div>
          </div>
          <div class="input-group" dir="ltr">
            <div class="input-group-text"><i class="bi bi-instagram"></i></div>
            <div class="form-floating">
              <input type="text" class="form-control" name="instagram[]" id="instagram"
              placeholder="<?php echo lang('instagram', $lang_file) ?>" dir="ltr" onblur="link_validation(this, this.value, 'instagram')">
              <label for="instagram">
                <?php echo lang('instagram', $lang_file) ?>
              </label>
            </div>
          </div>
          <div class="input-group" dir="ltr">
            <div class="input-group-text"><i class="bi bi-twitter"></i></div>
            <div class="form-floating">
              <input type="text" class="form-control" name="twitter[]" id="twitter"
              placeholder="<?php echo lang('twitter', $lang_file) ?>" dir="ltr" onblur="link_validation(this, this.value, 'twitter')">
              <label for="twitter">
                <?php echo lang('twitter', $lang_file) ?>
              </label>
            </div>
          </div>
          <div class="input-group" dir="ltr">
            <div class="input-group-text"><i class="bi bi-linkedin"></i></div>
            <div class="form-floating">
              <input type="text" class="form-control" name="linkedin[]" id="linkedin"
              placeholder="<?php echo lang('linkedin', $lang_file) ?>" dir="ltr" onblur="link_validation(this, this.value, 'linkedin')">
              <label for="linkedin">
                <?php echo lang('linkedin', $lang_file) ?>
              </label>
            </div>
          </div>
          <div class="input-group" dir="ltr">
            <div class="input-group-text"><i class="bi bi-youtube"></i></div>
            <div class="form-floating">
              <input type="text" class="form-control" name="youtube[]" id="youtube"
              placeholder="<?php echo lang('youtube', $lang_file) ?>" dir="ltr" onblur="link_validation(this, this.value, 'youtube')">
              <label for="youtube">
                <?php echo lang('youtube', $lang_file) ?>
              </label>
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
    <!-- submit button -->
    <div class="dashboard-buttons" dir="<?php echo $page_dir == 'rtl' ? 'ltr' : 'rtl' ?>">
      <button type="button" class="btn btn-primary" onclick="form_validation(this.form, this)">
        <i class="bi bi-check-all"></i>
        <?php echo lang('SAVE') ?>
      </button>
    </div>
  </form>
</div>