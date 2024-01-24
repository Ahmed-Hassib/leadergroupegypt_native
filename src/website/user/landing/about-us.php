<?php
// create an object of AboutUs class
$about_obj = new AboutUs();
// get section info
$about_us_info = $about_obj->select_specific_column("*", "`sections`", "WHERE `section_id` = '" . $about_obj->SECTION_ID . "'");
// get section status
$about_us_status = count($about_us_info) > 0 ? boolval($about_us_info[0]['is_active']) : false;
// gte all active text
$active_text = $about_obj->get_active_texts();
// check if more than 1
if ($about_us_status && $active_text != null && count($active_text) > 0) {
  ?>
  <div class="about-us" id="about-us">
    <h2 class="main-title">
      <?php echo lang('ABOUT US', $lang_file) ?>
    </h2>
    <div class="container">
      <!-- about us image -->
      <div class="about-us-img">
        <img loading="lazy" src="<?php echo $website_assets ?>about_us.svg" alt="">
      </div>
      <!-- about us text -->
      <!-- display about text from 1 to 3 -->
      <div class="about-us-text">
        <?php for ($i = 0; $i <= 2; $i++) { ?>
          <p class="lead text-capitalize">
            <?php echo ($page_dir == 'rtl' ? $active_text[$i]['text_ar'] : $active_text[$i]['text_en']) . "." ?>
          </p>
        <?php } ?>
      </div>
      <!-- display about text from 1 to the end -->
      <?php if (count($active_text) > 4) { ?>
        <div class="about-us-text" style="grid-column: 1/3 !important;">
          <?php for ($i = 3; $i < count($active_text); $i++) { ?>
            <p class="lead text-capitalize">
              <?php echo ($page_dir == 'rtl' ? $active_text[$i]['text_ar'] : $active_text[$i]['text_en']) . "." ?>
            </p>
          <?php } ?>
        </div>
      <?php } ?>
    </div>
  </div>
<?php } ?>