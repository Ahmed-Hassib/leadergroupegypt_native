<!-- start edit profile page -->
<div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
  <!-- start header -->
  <header class="header">
    <!-- start access denied -->
    <div class="page-error">
      <img src="<?php echo $assets ?>images/access-denied.svg" class="img-fluid" alt="<?php echo language("YOU DON`T HAVE THE PERMISSION TO ACCESS THIS PAGE") ?>">
    </div>
    <!-- end access denied -->
    <?php
      // error message
      $msg = '<div class="alert alert-warning text-capitalize"><i class="bi bi-exclamation-triangle-fill"></i>&nbsp;'.language('YOU DON`T HAVE THE PERMISSION TO ACCESS THIS PAGE').'</div>';
      // redirect to home page
      redirectHome($msg);
    ?>
  </header>
</div>