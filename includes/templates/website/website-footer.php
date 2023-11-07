<?php
// create an object of Compnay class
$cmp_obj = new CompanyInfo();
// get company info
$cmp_info = $cmp_obj->get_info();
// get company phones
$cmp_phones = $cmp_obj->get_phones();
// check result
$cmp_info = empty($cmp_info) || $cmp_info == null ? null : $cmp_info[0];
?>
<!-- START FOOTER -->
<footer class="footer">
  <div class="container">
    <div class="box">
      <h3>
        <?php echo lang('SPONSOR') ?>
      </h3>
      <?php if ($cmp_info != null) { ?>
        <ul class="social">
          <li>
            <a href="https://www.facebook.com/LeaderGroupEGYPT" target="_blank" class="facebook">
              <i class="bi bi-facebook"></i>
            </a>
          </li>
          <li>
            <a href="https://www.instagram.com/leadergroupegypt/" target="_blank" class="instagram">
              <i class="bi bi-instagram"></i>
            </a>
          </li>
          <li>
            <a href="https://www.linkedin.com/in/leadergroup-egypt-53b371263/" target="_blank" class="linkedin">
              <i class="bi bi-linkedin"></i>
            </a>
          </li>
        </ul>
        <!-- company brief -->
        <p class="text" dir="<?php echo $page_dir ?>">
          <?php echo $page_dir == 'ltr' ? $cmp_info['desc_en'] : $cmp_info['desc'] ?>
        </p>
      <?php } ?>
    </div>
    <!-- important links -->
    <?php include_once 'important-links.php' ?>

    <?php if ($cmp_info != null) { ?>
      <!-- company info -->
      <div class="box">
        <div class="line">
          <i class="bi bi-geo-alt"></i>
          <div class="info">
            <?php echo $page_dir == 'ltr' ? $cmp_info['address_en'] : $cmp_info['address'] ?>
          </div>
        </div>
        <div class="line">
          <i class="bi bi-alarm"></i>
          <div class="info">
            <?php
            // formate start time
            $start_time = date_format(date_create($cmp_info['start_job_time']), 'h:i');
            // get start time period
            $start_time_period = date_format(date_create($cmp_info['start_job_time']), 'a');
            // formate end time
            $end_time = date_format(date_create($cmp_info['end_job_time']), 'h:i');
            // get end time period
            $end_time_period = date_format(date_create($cmp_info['end_job_time']), 'a');
            // mesaage
            $message = lang('JOB TIME') . ": " . lang('FROM') . " $start_time " . lang(strtoupper($start_time_period)) . " " . lang('TO') . " $end_time " . lang(strtoupper($end_time_period));
            // print message
            echo $message;
            ?>
          </div>
        </div>
        <?php if ($cmp_phones != null) { ?>
          <div class="line">
            <i class="bi bi-telephone-forward"></i>
            <div class="info">
              <?php foreach ($cmp_phones as $key => $phone) { ?>
                <span dir="ltr">
                  <?php echo $phone['phone'] ?>
                </span>
              <?php } ?>
            </div>
          </div>
        <?php } ?>
      </div>
    <?php } ?>
  </div>
  <p class="copyright text-uppercase">
    <span>made with&nbsp;</span>
    <span class="text-danger"><i class="bi bi-heart-fill"></i>&nbsp;</span>
    <span class="fw-bold">by ahmed hassib</span>&nbsp;&amp;&nbsp;<span class="fw-bold">leader group <span
        class="text-danger">egypt</span></span>
  </p>
</footer>
<!-- START FOOTER -->