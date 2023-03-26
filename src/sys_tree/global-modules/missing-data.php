
<div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
  <!-- start header -->
  <header class="header">
    <!-- start missing data page -->
    <div class="page-error">
      <img src="<?php echo $assets ?>images/warning.svg" class="img-fluid" alt="<?php echo language("THERE IS AN ERROR OR MISSING DATA", @$_SESSION['systemLang']) ?>">
      <?php $msg = '<div class="alert alert-danger text-capitalize"><i class="bi bi-exclamation-triangle-fill"></i>&nbsp;'. language('THERE IS AN ERROR OR MISSING DATA', @$_SESSION['systemLang']) .'</div>'; ?>
      <?php redirectHome($msg, 'back'); ?>
    </div>
    <!-- end missing data page -->
  </header>
</div>