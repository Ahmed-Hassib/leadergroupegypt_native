<?php
// create an object of Features class
$features_obj = new Features();
// get section info
$features_info = $features_obj->select_specific_column("*", "`sections`", "WHERE `section_id` = '" . $features_obj->SECTION_ID . "'");
// get section status
$features_status = count($features_info) > 0 ? boolval($features_info[0]['is_active']) : false;
// get all features images
$features_info = $features_obj->get_active_features();
// check if count of images > 0
if ($features_status && $features_info != null && count($features_info) > 0) {
  // get number of displayed content
  $num_displayed = intval($features_obj->select_specific_column("`num_content`", "`sections`", "WHERE `section_id` = '" . $features_obj->SECTION_ID . "' AND `section_name` = 'features'")[0]['num_content'] ?? 9);
  ?>
  <!-- START FEATURES -->
  <div class="features <?php echo isset($features_status) && $features_status == null ? 'no-wave-all' : '' ?>" id="features">
    <h2 class="main-title">
      <?php echo lang('FEATURES', $lang_file) ?>
    </h2>
    <div class="container">
      <?php foreach ($features_info as $key => $feature) { ?>
        <div class="box quality">
          <div class="img-holder">
            <?php if (file_exists($features_img . $feature['feature_img'])) { ?>
              <?php $is_resized = resize_img($features_img, $feature['feature_img']); ?>
              <img
                src="<?php echo $is_resized ? $features_img . "resized/" . $feature['feature_img'] : $features_img . $feature['feature_img'] ?>"
                alt="image">
            <?php } else { ?>
              <img src="<?php echo $assets ?>leadergroupegypt-shadow.png" alt="default image">
            <?php } ?>
          </div>
          <h2 class="text-uppercase"><?php echo $page_dir == 'rtl' ? $feature['feature_name_ar'] : $feature['feature_name_en'] ?></h2>
          <p><?php echo $page_dir == 'rtl' ? $feature['feature_desc_ar'] : $feature['feature_desc_en'] ?></p>
          <a href="">
            <?php echo lang('READ MORE') ?>
          </a>
        </div>
      <?php } ?>
    </div>
  </div>
  <!-- END FEATURES -->
<?php } ?>