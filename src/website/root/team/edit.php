<?php
// create an object of TeamMember class
$member_obj = !isset($member_obj) ? new TeamMember() : $member_obj;

// get member id
$member_id = isset($_GET['id']) && !empty($_GET['id']) ? base64_decode($_GET['id']) : null;

// check if member id exists or not
if ($member_obj->is_exist("`id`", "`team_members`", $member_id)) {
  // get member info
  $member_info = $member_obj->get_member($member_id)[0];
  ?>
  <div class="container page-container" dir="<?php echo $page_dir ?>">
    <!-- add new member form -->
    <form action="?do=update-member" method="post" id="edit-member" onchange="form_validation(this)"
      enctype="multipart/form-data">
      <div class="member-content">
        <div class="form-header">
          <h3 class="h3 text-capitalize">
            <?php echo lang('MEMBER INFO', $lang_file) ?>
          </h3>
        </div>
        <div id="section-content">
          <div class="form-content form-content__content add-members">
            <div class="member-img">
              <div class="img-control">
                <div class="img-btn-controls">
                  <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
                  <!-- member image form -->
                  <input type="file" class="d-none" name="member-img-input" id="member-img-input"
                    onchange="change_section_img(this)" accept="image/*">
                  <!-- edit image button -->
                  <button type="button" role="button" class="btn btn-outline-primary fs-12 py-1 text-capitalize change"
                    onclick="click_input(this)">
                    <i class="bi bi-image"></i>
                    <?php echo lang('CHANGE IMG', $lang_file) ?>
                  </button>
                </div>
                <div class="form-floating">
                  <select name="is-active" class="form-select" required>
                    <option value="default" selected disabled>
                      <?php echo lang('SELECT STATUS', $lang_file) ?>
                    </option>
                    <option <?php echo $member_info['is_active'] == '1' ? 'selected' : '' ?> value="1">
                      <?php echo lang('ACTIVE') ?>
                    </option>
                    <option <?php echo $member_info['is_active'] == '0' ? 'selected' : '' ?> value="0">
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
                <?php if (!empty($member_info['img']) && file_exists($members_img . $member_info['img'])) { ?>
                  <img loading="lazy" src="<?php echo $members_img . $member_info['img'] ?>" alt="image">
                <?php } else { ?>
                  <img loading="lazy" src="<?php echo $assets ?>leadergroupegypt-shadow.png" alt="default image">
                <?php } ?>
              </div>
            </div>
            <div class="form-floating">
              <input type="text" class="form-control" name="name" id="name"
                placeholder="<?php echo lang('MEMBER NAME', $lang_file) ?>" value="<?php echo $member_info['name'] ?>"
                required>
              <label for="name">
                <?php echo lang('MEMBER NAME', $lang_file) ?>
              </label>
            </div>
            <div class="form-floating">
              <input type="text" class="form-control" name="job-title" id="job-title"
                placeholder="<?php echo lang('JOB TITLE', $lang_file) ?>" value="<?php echo $member_info['job_title'] ?>"
                required>
              <label for="job-title">
                <?php echo lang('JOB TITLE', $lang_file) ?>
              </label>
            </div>
            <div class="input-group" dir="ltr">
              <div class="input-group-text"><i class="bi bi-facebook"></i></div>
              <div class="form-floating">
                <input type="text" class="form-control" name="facebook" id="facebook"
                  placeholder="<?php echo lang('facebook', $lang_file) ?>" dir="ltr"
                  onblur="link_validation(this, this.value, 'facebook')" value="<?php echo $member_info['facebook'] ?>">
                <label for="facebook">
                  <?php echo lang('facebook', $lang_file) ?>
                </label>
              </div>
            </div>
            <div class="input-group" dir="ltr">
              <div class="input-group-text"><i class="bi bi-instagram"></i></div>
              <div class="form-floating">
                <input type="text" class="form-control" name="instagram" id="instagram"
                  placeholder="<?php echo lang('instagram', $lang_file) ?>" dir="ltr"
                  onblur="link_validation(this, this.value, 'instagram')" value="<?php echo $member_info['instagram'] ?>">
                <label for="instagram">
                  <?php echo lang('instagram', $lang_file) ?>
                </label>
              </div>
            </div>
            <div class="input-group" dir="ltr">
              <div class="input-group-text"><i class="bi bi-twitter"></i></div>
              <div class="form-floating">
                <input type="text" class="form-control" name="twitter" id="twitter"
                  placeholder="<?php echo lang('twitter', $lang_file) ?>" dir="ltr"
                  onblur="link_validation(this, this.value, 'twitter')" value="<?php echo $member_info['twitter'] ?>">
                <label for="twitter">
                  <?php echo lang('twitter', $lang_file) ?>
                </label>
              </div>
            </div>
            <div class="input-group" dir="ltr">
              <div class="input-group-text"><i class="bi bi-linkedin"></i></div>
              <div class="form-floating">
                <input type="text" class="form-control" name="linkedin" id="linkedin"
                  placeholder="<?php echo lang('linkedin', $lang_file) ?>" dir="ltr"
                  onblur="link_validation(this, this.value, 'linkedin')" value="<?php echo $member_info['linkedin'] ?>">
                <label for="linkedin">
                  <?php echo lang('linkedin', $lang_file) ?>
                </label>
              </div>
            </div>
            <div class="input-group" dir="ltr">
              <div class="input-group-text"><i class="bi bi-youtube"></i></div>
              <div class="form-floating">
                <input type="text" class="form-control" name="youtube" id="youtube"
                  placeholder="<?php echo lang('youtube', $lang_file) ?>" dir="ltr"
                  onblur="link_validation(this, this.value, 'youtube')" value="<?php echo $member_info['youtube'] ?>">
                <label for="youtube">
                  <?php echo lang('youtube', $lang_file) ?>
                </label>
              </div>
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