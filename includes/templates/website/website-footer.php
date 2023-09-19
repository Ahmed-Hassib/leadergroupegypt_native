<!-- START FOOTER -->
<footer class="footer">
  <div class="container">
    <div class="box">
      <h3>
        <?php echo lang('SPONSOR') ?>
      </h3>
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
        <?php
        // create an object of AboutUs class
        $about_obj = new AboutUs();
        // get company brief
        $brief = $about_obj->select_specific_column("*", "`about_us`", "")[0];
        // display brief
        echo $page_dir == 'rtl' ? $brief['text_ar'] : $brief['text_en'];
        ?>
      </p>
    </div>
    <!-- important links -->
    <?php include_once 'important-links.php' ?>
    <!-- company info -->
    <div class="box">
      <div class="line">
        <i class="bi bi-geo-alt"></i>
        <div class="info">شبين الكوم، المنوفية</div>
      </div>
      <div class="line">
        <i class="bi bi-alarm"></i>
        <div class="info">ساعات العمل: من 10 صباحاً حتي 5 مساءً</div>
      </div>
      <div class="line">
        <i class="bi bi-telephone-forward"></i>
        <div class="info">
          <span dir="ltr">+201000000000</span>
          <span dir="ltr">+201000000000</span>
        </div>
      </div>
    </div>
  </div>
  <p class="copyright text-uppercase">
    <span>made with&nbsp;</span>
    <span class="text-danger"><i class="bi bi-heart-fill"></i>&nbsp;</span>
    <span class="fw-bold">by ahmed hassib</span>&nbsp;&amp;&nbsp;<span class="fw-bold">leader group <span
        class="text-danger">egypt</span></span>
  </p>
</footer>
<!-- START FOOTER -->