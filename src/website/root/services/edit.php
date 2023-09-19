<?php
// create an object of Service class
$service_obj = !isset($service_obj) ? new Service() : $service_obj;

// get service id
$service_id = isset($_GET['id']) && !empty($_GET['id']) ? base64_decode($_GET['id']) : null;

// check if service id exists or not
if ($service_obj->is_exist("`id`", "`services`", $service_id)) {
  // get service info
  $service_info = $service_obj->get_service($service_id)[0];
?>
  <div class="container page-container" dir="<?php echo $page_dir ?>">
    <!-- add new service form -->
    <form action="?do=update-service" method="post" id="edit-service" onchange="form_validation(this)" enctype="multipart/form-data">
      <div class="service-content">
        <div class="form-header">
          <h3 class="h3 text-capitalize"><?php echo lang('SERVICE INFO', $lang_file) ?></h3>
        </div>
        <div id="section-content">
          <div class="form-content form-content__content edit-services">
            <div class="service-img">
              <div class="img-control">
                <div class="img-btn-controls">
                  <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
                  <!-- service image form -->
                  <input type="file" class="d-none" name="service-img-input" id="service-img-input" onchange="change_service_img(this)" accept="image/*">
                  <!-- edit image button -->
                  <button type="button" role="button" class="btn btn-outline-primary fs-12 py-1 text-capitalize change" onclick="click_input(this)">
                    <i class="bi bi-image"></i>
                    <?php echo lang('CHANGE IMG', $lang_file) ?>
                  </button>
                </div>
                <div class="form-floating">
                  <select name="is-active" class="form-select" required>
                    <option value="default" selected disabled><?php echo lang('SELECT STATUS', $lang_file) ?></option>
                    <option value="2" <?php echo $service_info['is_active'] == 2 ? 'selected' : '' ?>><?php echo lang('WAITING') ?></option>
                    <option value="1" <?php echo $service_info['is_active'] == 1 ? 'selected' : '' ?>><?php echo lang('ACTIVE') ?></option>
                    <option value="0" <?php echo $service_info['is_active'] == 0 ? 'selected' : '' ?>><?php echo lang('INACTIVE') ?></option>
                  </select>
                  <label for="is-active" class="col-sm-4 col-form-label text-capitalize"><?php echo lang('STATUS', $lang_file) ?></label>
                </div>
              </div>
              <!-- image preview -->
              <div class="img-container-preview">
                <?php if (file_exists($services_img . $service_info['service_img'])) { ?>
                  <img src="<?php echo $services_img . $service_info['service_img'] ?>" alt="image">
                <?php } else { ?>
                  <img src="<?php echo $assets ?>leadergroupegypt-shadow.png" alt="default image">
                <?php } ?>
              </div>
            </div>
            <div class="form-floating">
              <input type="text" class="form-control" name="name-1-ar" id="name-1-ar" placeholder="<?php echo lang('LINK 1 AR', $lang_file) ?>" value="<?php echo $service_info['link_1_ar'] ?>">
              <label for="name-1-ar"><?php echo lang('LINK 1 AR', $lang_file) ?></label>
            </div>
            <div class="form-floating">
              <input type="text" class="form-control" name="name-1-en" id="name-1-en" placeholder="<?php echo lang('LINK 1 EN', $lang_file) ?>" value="<?php echo $service_info['link_1_en'] ?>" dir="ltr">
              <label for="name-1-en"><?php echo lang('LINK 1 EN', $lang_file) ?></label>
            </div>
            <div class="form-floating">
              <input type="text" class="form-control" name="link-1" id="link-1" placeholder="<?php echo lang('LINK 1', $lang_file) ?>" value="<?php echo $service_info['link_1'] ?>" dir="ltr">
              <label for="link-1"><?php echo lang('LINK 1', $lang_file) ?></label>
            </div>
            <div class="form-floating">
              <input type="text" class="form-control" name="name-2-ar" id="name-2-ar" placeholder="<?php echo lang('LINK 2 AR', $lang_file) ?>" value="<?php echo $service_info['link_2_ar'] ?>">
              <label for="name-2-ar"><?php echo lang('LINK 2 AR', $lang_file) ?></label>
            </div>
            <div class="form-floating">
              <input type="text" class="form-control" name="name-2-en" id="name-2-en" placeholder="<?php echo lang('LINK 2 EN', $lang_file) ?>" value="<?php echo $service_info['link_2_en'] ?>" dir="ltr">
              <label for="name-2-en"><?php echo lang('LINK 2 EN', $lang_file) ?></label>
            </div>
            <div class="form-floating">
              <input type="text" class="form-control" name="link-2" id="link-2" placeholder="<?php echo lang('LINK 2', $lang_file) ?>" value="<?php echo $service_info['link_2'] ?>" dir="ltr">
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

<?php
} else {
  // include no data founded module
  include_once $globmod . 'no-data-founded.php';
}
