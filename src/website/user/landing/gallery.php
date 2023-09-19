<?php
// create an object of Gallery class
$gallery_obj = new Gallery();
// get all gallery images
$gallery_imgs = $gallery_obj->get_active_imgs();
// check if count of images > 0
if ($gallery_imgs != null && count($gallery_imgs) > 0) {
  // get number of displayed content
  $num_displayed = intval($gallery_obj->select_specific_column("`num_content`", "`sections`", "WHERE `section_id` = 2 AND `section_name` = 'gallery'")[0]['num_content'] ?? 9);
  ?>
  <!-- START GALLERY -->
  <div class="gallery <?php echo $active_text == null ? 'no-wave-all' : '' ?>" id="gallery">
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
              <img src="<?php echo $gallery_img . $img['img_name'] ?>" alt="gallery image #<?php echo $key + 1 ?>">
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