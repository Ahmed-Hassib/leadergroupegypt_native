<?php
// create an object of Features class
$features_obj = new Features();
// get feature id
$feature_id = isset($_GET['id']) && !empty($_GET['id']) ? base64_decode($_GET['id']) : null;
// check if id exists
$is_exists = $features_obj->count_records("`id`", "`features`", "WHERE `id` = $feature_id");
// check counter
if ($is_exists > 0) {
  // get feature data 
  $feature_info = $features_obj->get_feature($feature_id);
  ?>
  <!-- START LANDING -->
  <div class="landing">
    <div class="container">
      <div class="text">
        <h1>
          <?php echo lang('SPONSOR') ?>
        </h1>
        <p class="badge bg-warning text-white">
          <span>
            <?php echo lang('FEATURES', $lang_file) ?>
          </span>
          <span>&nbsp;-&nbsp;</span>
          <span>
            <?php echo $page_dir == 'rtl' ? $feature_info['feature_name_ar'] : $feature_info['feature_name_en'] ?>
          </span>
        </p>
      </div>
      <div class="image">
        <img loading="lazy" rel="preload" as="image" loading="lazy" src="<?php echo $assets ?>leadergroupegypt-shadow.png" alt="Leader Group Egypt">
      </div>
    </div>
    <a href="#features" class="go-down">
      <i class="bi bi-chevron-double-down"></i>
    </a>
  </div>
  <!-- END LANDING -->
  <!-- START FEATURES -->
  <div class="features" id="features">
    <h2 class="main-title">
      <?php echo $page_dir == 'rtl' ? $feature_info['feature_name_ar'] : $feature_info['feature_name_en'] ?>
    </h2>
    <div class="feature-details-content">
      <div class="container">
        <?php $features_details = $features_obj->get_feature_details($feature_id); ?>
        <ul class="feature-list <?php echo $page_dir == 'rtl' ? 'arabic-list' : 'english-list' ?>">
          <?php foreach ($features_details as $key => $detail) { ?>
            <?php if (!empty($detail['detail_name_ar']) && !empty($detail['detail_name_en'])) { ?>
              <li>
                <h4 class="h4 list-header">
                  <?php echo $page_dir == 'rtl' ? $detail['detail_name_ar'] : $detail['detail_name_en'] ?>
                </h4>
                <p class="lead list-text">
                  <?php echo $page_dir == 'rtl' ? $detail['detail_ar'] : $detail['detail_en'] ?>
                </p>
              </li>
            <?php } else { ?>
              <p class="lead list-text">
                <?php echo $page_dir == 'rtl' ? $detail['detail_ar'] : $detail['detail_en'] ?>
              </p>
            <?php } ?>
          <?php } ?>
        </ul>
      </div>
    </div>
  </div>
  <!-- END FEATURES -->
<?php } else {
  // include no data module
  include_once $globmod . 'no-data-founded.php';
}
?>