<?php
// create an object of Gallery class
$gallery_obj = new Gallery();
// get section info
$gallery_info = $gallery_obj->select_specific_column("*", "`sections`", "WHERE `section_id` = '" . $gallery_obj->SECTION_ID . "'");
// get section status
$gallery_status = count($gallery_info) > 0 ? boolval($gallery_info[0]['is_active']) : false;
// get all gallery images
$gallery_imgs = $gallery_obj->get_active_imgs();
// check if count of images > 0
if ($gallery_status && $gallery_imgs != null && count($gallery_imgs) > 0) {
  // get number of displayed content
  $num_displayed = intval($gallery_obj->select_specific_column("`num_content`", "`sections`", "WHERE `section_id` = 2 AND `section_name` = 'gallery'")[0]['num_content'] ?? 9);
  ?>
  <!-- START GALLERY -->
  <div class="gallery <?php echo isset($about_us_status) && $about_us_status == null ? 'no-wave-all' : '' ?>" id="gallery">
    <h2 class="main-title">
      <?php echo lang('GALLERY', $lang_file) ?>
    </h2>
    <div class="container">
      <?php foreach ($gallery_imgs as $key => $img) { ?>
        <?php if ($key >= $num_displayed)
          continue; ?>
        <?php if (file_exists($gallery_img . $img['img_name'])) { ?>
          <div class="box">
            <div class="image">
              <?php $is_resized = resize_img($gallery_img, $img['img_name']); ?>
              <img
                src="<?php echo $is_resized == true ? $gallery_img . "resized/" . $img['img_name'] : $gallery_img . $img['img_name'] ?>"
                alt="gallery image #<?php echo $key + 1 ?>" data-ext="<?php echo $is_resized ?>">
            </div>
          </div>
        <?php } ?>
      <?php } ?>
      <?php if (count($gallery_imgs) > $num_displayed) { ?>
        <a href="<?php echo $website_user ?>gallery/index.php" class="btn btn-outline-primary mx-auto"
          style="grid-column: 2/3; height: fit-content; align-self: end;">
          <i class="bi bi-arrow-up-right-square"></i>
          <?php echo lang('SHOW MORE') ?>
        </a>
      <?php } ?>
    </div>
  </div>
  <!-- END GALLERY -->
<?php } ?>