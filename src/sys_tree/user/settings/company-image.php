<div class="section-block">
  <!-- section header -->
  <div class="section-header">
    <h5 class="text-capitalize "><?php echo language('COMPANY BRAND', @$_SESSION['systemLang']) ?></h5>
    <hr />
  </div>
  <!-- start company image -->
  <div class="mb-4 row" id="company-image-container">
    <?php 
    if (!isset($db_obj)) {
      $db_obj = new Database();
    }
    $company_img_name = $db_obj->select_specific_column("`company_img`", "`companies`", "WHERE `company_id` = ".$_SESSION['company_id'])[0]['company_img'];
    $company_img_name = empty($company_img_name) ? 'leadergroupegypt.jpg' : $company_img_name;
    $company_img_path = empty($_SESSION['company_img']) ? $uploads . "companies-img" : $uploads . "companies-img/".$_SESSION['company_id']; 
    ?>
    <img src="<?php echo "$company_img_path/$company_img_name" ?>" class="company-img" alt="" id="company-img" >
    <form action="?do=change-company-img" method="POST" id="change-company-image" enctype="multipart/form-data">
      <!-- company image form -->
      <input type="file" class="d-none" name="company-img-input" id="company-img-input" onchange="change_company_img(this)" accept="image/*">
    </form>
    <?php if (empty($_SESSION['company_img'])) { ?>
      <span class="text-center text-muted" id="company-img-status"><?php echo language('THIS IS DEFAULT IMAGE OF THE SYSTEM', @$_SESSION['systemLang']) ?></span>
    <?php } ?>
  </div>
  <!-- end company image -->
  <?php if ($_SESSION['change_company_img'] == 1) { ?>
  <!-- start control buttons -->
  <div class="hstack gap-3">
    <div class="mx-auto">
      <!-- edit image button -->
      <button type="button" role="button" class="btn btn-outline-primary fs-12 py-1 text-capitalize" onclick="click_input()">
        <i class="bi bi-pencil-square"></i>
        <?php echo language('CHANGE IMAGE', @$_SESSION['systemLang']) ?>
      </button>
      <?php if (!empty($_SESSION['company_img'])) { ?>
      <!-- delete image button -->
      <button type="button" role="button" class="btn btn-danger fs-12 py-1 text-capitalize" onclick="delete_company_image('company')">
        <i class="bi bi-trash"></i>
        <?php echo language('DELETE IMAGE', @$_SESSION['systemLang']) ?>
      </button>
      <?php } ?>

      <button type="submit" class="btn btn-success fs-12 py-1 text-capitalize d-none" form="change-company-image" id="change-company-img-btn">
        <i class="bi bi-check-all"></i>
        <?php echo language('SAVE CHANGES', @$_session['systemLang']) ?>
      </button>
    </div>
  </div>
  <!-- end control buttons -->
  <?php } ?>
</div>