<!-- start home stats container -->
<div class="container" dir="<?php echo $page_dir ?>">
  <?php if ((base64_decode($_SESSION['sys']['job_title_id']) == 1 || $_SESSION['sys']['change_mikrotik'] == 1) && isset($_GET['msg']) && !empty($_GET['msg']) && $_GET['msg'] == 'mikrotik-ok') { ?>
    <div>
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
          <?php $company_id = base64_decode($_SESSION['sys']['company_id']) ?>
          <?php $company_name = str_replace_whitespace($_SESSION['sys']['company_name']) ?>
          <pre><code>/interface sstp-client add connect-to=leadergroupegypt.com disabled=no name=<?php echo $company_name ?> password=<?php echo $_SESSION["sys"]["mikrotik"]["password"] ?> user=<?php echo $company_name ?></code></pre>
          <pre><i class="bi bi-exclamation-triangle-fill"></i><?php echo lang('UPDATE MIKROTIK PORT 444', $lang_file) ?></pre>
          <pre><code>/interface eoip add name=<?php echo $company_name . '-eoip' ?> remote-address=199.198.197.1 local-address=<?php echo $_SESSION['sys']['mikrotik']['remote_ip'] ?> tunnel-id=<?php echo intval($company_id) + 1200 ?></code></pre>
          <pre><code>/ip address add address=<?php echo $_SESSION['sys']['mikrotik']['ip_list'] . '/24' ?> network=199.198.197.1 comment=<?php echo $company_name ?> interface=<?php echo $company_name . '-eoip' ?></code></pre>
        </div>
      </div>
    </div>
  <?php } ?>
  <div class="services-container">
    <?php
    if (base64_decode($_SESSION['sys']['job_title_id']) == 1 || $_SESSION['sys']['change_mikrotik'] == 1) {
      // mikrotek info
      include_once 'mikrotik-info.php';
    }
    ?>

    <!-- whatsapp info setting -->
    <?php # include_once 'whatsapp-info.php' 
    ?>

  </div>

  <!-- payment methods -->
  <?php # include_once 'payment-methods.php' 
  ?>
</div>