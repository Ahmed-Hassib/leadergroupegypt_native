<?php
// create an object of Service class
$services_obj = new Service();
// get all services images
$services_info = $services_obj->get_active_services();
// get services status
// check if count of images > 0
if ($services_info != null && count($services_info) > 0) {
  ?>
  <!-- START SERVICES -->
  <div class="services <?php echo isset($features_status) && $features_status == null ? 'no-wave-all' : '' ?>" id="services">
    <h2 class="main-title">
      <?php echo lang('OUR SERVICES') ?>
    </h2>
    <div class="container">
      <?php foreach ($services_info as $key => $service) { ?>
        <?php if ($key >= 9)
          continue; ?>
        <?php if (file_exists($services_img . $service['service_img'])) { ?>
          <div class="box">
            <?php $is_resized = resize_img($services_img, $service['service_img']); ?>
            <img
              src="<?php echo $is_resized ? $services_img . "resized/" . $service['service_img'] : $services_img . $service['service_img'] ?>"
              alt="service image #<?php echo $key + 1 ?>">

            <!-- <img src="<?php echo $services_img . $service['service_img'] ?>" alt=""> -->
            <div class="info">
              <?php if ($service['is_active'] != 2) { ?>
                <?php if (strlen($service['link_1']) > 0) { ?>
                  <a class="btn btn-primary" href="<?php echo $service['link_1'] ?>">
                    <?php echo $page_dir == 'rtl' ? $service['link_1_ar'] : $service['link_1_en'] ?>
                  </a>
                <?php } ?>
                <?php if (strlen($service['link_2']) > 0) { ?>
                  <a class="btn btn-outline-success" href="<?php echo $service['link_2'] ?>">
                    <?php echo $page_dir == 'rtl' ? $service['link_2_ar'] : $service['link_2_en'] ?>
                  </a>
                <?php } ?>
              <?php } else { ?>
                <h3 class="badge bg-warning px-3 py-2">
                  <?php echo lang('WAITING') ?>...
                </h3>
              <?php } ?>
            </div>
          </div>
        <?php } ?>
      <?php } ?>
    </div>
  </div>
  <!-- END SERVICES -->
<?php } ?>