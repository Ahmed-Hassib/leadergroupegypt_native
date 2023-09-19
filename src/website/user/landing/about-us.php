<?php
// create an object of AboutUs class
$about_obj = new AboutUs();
// gte all active text
$active_text = $about_obj->get_active_texts();
// check if more than 1
if ($active_text != null && count($active_text) > 0) {
  ?>
  <div class="about-us" id="about-us">
    <h2 class="main-title">
      <?php echo lang('ABOUT US', $lang_file) ?>
    </h2>
    <div class="container">
      <!-- about us image -->
      <div class="about-us-img">
        <img src="<?php echo $website_assets ?>about_us.svg" alt="">
      </div>
      <!-- about us text -->
      <div class="about-us-text">
        <?php foreach ($active_text as $key => $text) { ?>
          <p class="lead text-capitalize">
            <?php echo ($page_dir == 'rtl' ? $text['text_ar'] : $text['text_en']) . "." ?>
          </p>
        <?php } ?>
      </div>
    </div>
  </div>
<?php } ?>