<!-- start home stats container -->
<div class="container" dir="<?php echo $page_dir ?>">
  <div>
    <?php if ((base64_decode($_SESSION['sys']['job_title_id']) == 1 || $_SESSION['sys']['change_mikrotik'] == 1) && isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], '?do=change-mikrotik')) { ?>
      <div class="alert alert-info w-100%" role="alert">
        <h5 class="alert-heading">
          <i class="bi bi-exclamation-triangle-fill"></i>
          <?php echo lang('ATTENTION PLEASE') ?>
        </h5>
        <hr>
        <p>
          <?php echo lang('MIKROTIK VPN CODE', 'pieces') ?>
        </p>
        <div class="code-snippet">
          <pre><code>/interface sstp-client add connect-to=leadergroupegypt.com disabled=no name=<?php echo $_SESSION['sys']['company_name'] ?> password=<?php echo $_SESSION["sys"]["mikrotik"]["password"] ?> user=<?php echo $_SESSION['sys']['company_name'] ?> port=444</code></pre>
        </div>
      </div>
    <?php } ?>
  </div>
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