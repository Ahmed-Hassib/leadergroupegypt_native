<!-- start home stats container -->
<div class="container" dir="<?php echo $page_dir ?>">
  <div class="settings-container">
    <!-- company image info -->
    <?php include_once 'company-image.php' ?>

    <!-- system info -->
    <?php include_once 'system-info.php' ?>

    <!-- system language setting -->
    <?php include_once 'system-lang.php' ?>

    <?php
    if (base64_decode($_SESSION['sys']['job_title_id']) == 1 || $_SESSION['sys']['change_mikrotik'] == 1) {
      // mikrotek info
      include_once 'mikrotik-info.php';
    }
    ?>

    <!-- other setting -->
    <?php include_once 'others.php' ?>
  </div>
</div>