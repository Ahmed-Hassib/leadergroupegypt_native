<!-- START LANDING -->
<div class="landing">
  <div class="container">
    <div class="text">
      <!-- welcome statement -->
      <h1 class="h1 text-capitalize">
        <?php echo lang('WELCOME TO', $lang_file) . "&nbsp;" . lang('SPONSOR') ?>
      </h1>
      <p class="lead text-capitalize mb-3">
        <?php echo lang('CHOOSE SERVICE OF BUSINESS', $lang_file) ?>
      </p>
      <!-- whats app contact button -->
      <a href="https://wa.me/+201016100346" target="_blank" class="btn btn-outline-success">
        <i class="bi bi-whatsapp"></i>
        <span>whatsapp</span>
      </a>
      <!-- messnger contact button -->
      <a href="http://m.me/LeaderGroupEGYPT" target="_blank" class="btn btn-outline-primary">
        <i class="bi bi-messenger"></i>
        <span>messenger</span>
      </a>
    </div>

    <?php $landing_img_name = "leadergroupegypt-shadow.png"; ?>
    <?php $landing_img_path = $landing_img . "leadergroupegypt-shadow.png"; ?>
    <?php $landing_resized_img_path = $landing_img . "resized/leadergroupegypt-shadow.png"; ?>
    <?php if (file_exists($landing_img_path)) { ?>
      <div class="image">
        <?php $is_resized = resize_img($landing_img, $landing_img_name); ?>
        <img src="<?php echo $is_resized ? $landing_resized_img_path : $landing_img_path ?>" alt="Leader Group Egypt">
      </div>
    <?php } ?>
  </div>
  <a href="#articles" class="go-down">
    <i class="bi bi-chevron-double-down"></i>
  </a>
</div>
<!-- END LANDING -->