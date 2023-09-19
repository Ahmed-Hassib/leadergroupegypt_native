<div class="section-block">
  <!-- section header -->
  <div class="section-header">
    <h5 class="text-capitalize "><?php echo lang('COMPANY BRAND', $lang_file) ?></h5>
    <hr />
  </div>
  <!-- start company image -->
  <div class="company-img-container" id="company-image-container">
    <?php
    $db_obj = !isset($db_obj) ? new Database() : $db_obj;
    $company_img_name = $db_obj->select_specific_column("`company_img`", "`companies`", "WHERE `company_id` = " . base64_decode($_SESSION['sys']['company_id']))[0]['company_img'];
    $company_img_name = empty($company_img_name) ? 'leadergroupegypt.jpg' : $company_img_name;
    $company_img_path = empty($_SESSION['sys']['company_img']) ? $uploads . "companies-img" : $uploads . "companies-img/" . base64_decode($_SESSION['sys']['company_id']);
    ?>
    <img src="<?php echo "$company_img_path/$company_img_name" ?>" class="company-img" alt="" id="company-img">
    <form action="?do=change-company-img" method="POST" id="change-company-image" enctype="multipart/form-data">
      <!-- company image form -->
      <input type="file" class="d-none" name="company-img-input" id="company-img-input" onchange="change_company_img(this)" accept="image/*">
    </form>
    <?php if (empty($_SESSION['sys']['company_img'])) { ?>
      <span class="text-center text-muted" id="company-img-status"><?php echo lang('DEFAULT IMG', $lang_file) ?></span>
    <?php } ?>
  </div>
  <!-- end company image -->
  <?php if ($_SESSION['sys']['change_company_img'] == 1) { ?>
    <!-- start control buttons -->
    <div class="company-img-btn company-img-btn-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'left':'right' ?>">
        <!-- edit image button -->
        <button type="button" role="button" class="btn btn-outline-primary fs-12 py-1 text-capitalize" onclick="click_input()">
          <i class="bi bi-pencil-square"></i>
          <?php echo lang('CHANGE IMG', $lang_file) ?>
        </button>
        <?php if (!empty($_SESSION['sys']['company_img'])) { ?>
          <!-- delete image button -->
          <button type="button" role="button" class="btn btn-danger fs-12 py-1 text-capitalize" onclick="delete_company_image('company')">
            <i class="bi bi-trash"></i>
            <?php echo lang('DELETE') ?>
          </button>
        <?php } ?>

        <button type="submit" class="btn btn-success fs-12 py-1 text-capitalize d-none" form="change-company-image" id="change-company-img-btn">
          <i class="bi bi-check-all"></i>
          <?php echo lang('SAVE') ?>
        </button>
    </div>
    <!-- end control buttons -->
  <?php } ?>
</div>