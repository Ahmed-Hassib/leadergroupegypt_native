<!-- START LANDING -->
<div class="landing">
  <div class="container">
    <div class="text">
      <h1>
        <?php echo lang('SPONSOR') ?>
      </h1>
      <p class="badge bg-warning text-white">
        <?php echo lang('GALLERY', $lang_file) ?>
      </p>
    </div>
    <div class="image">
      <img src="<?php echo $assets ?>leadergroupegypt-shadow.png" alt="Leader Group Egypt">
    </div>
  </div>
  <a href="#articles" class="go-down">
    <i class="bi bi-chevron-double-down"></i>
  </a>
</div>
<!-- END LANDING -->
<?php
// create an object of Gallery class
$gallery_obj = new Gallery();
// get all gallery images
$gallery_imgs = $gallery_obj->get_active_imgs();
// check if count of images > 0
if ($gallery_imgs != null && count($gallery_imgs) > 0) {
  ?>
  <!-- START GALLERY -->
  <div class="gallery no-wave-all" id="gallery">
    <div class="container">
      <?php foreach ($gallery_imgs as $key => $img) { ?>
        <?php if (file_exists($gallery_img . $img['img_name'])) { ?>
          <div class="box">
            <div class="image">
              <?php $is_resized = resize_img($gallery_img, $img['img_name']); ?>
              <img
                src="<?php echo $is_resized ? $gallery_img . "resized/" . $img['img_name'] : $gallery_img . $img['img_name'] ?>"
                alt="gallery image #<?php echo $key + 1 ?>">
            </div>
          </div>
        <?php } ?>
      <?php } ?>
    </div>
  </div>
  <!-- END GALLERY -->
<?php } ?>