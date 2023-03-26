<!-- start edit profile page -->
<div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
  <!-- start header -->
  <header class="header">
    <!-- start page not found 404 -->
    <div class="page-error">
      <img src="<?php echo $assets ?>images/access-denied.svg" class="img-fluid" alt="<?php echo language("NO PAGE WITH THIS NAME", @$_SESSION['systemLang']) ?>">
      <?php $msg = '<div class="alert alert-danger text-capitalize"><i class="bi bi-exclamation-triangle-fill"></i>&nbsp;'. language('THERE IS AN ERROR OR MISSING DATA', @$_SESSION['systemLang']) .'</div>'; ?>
      <?php redirectHome($msg, 'back'); ?>
    </div>
    <!-- end page not found 404 -->
  </header>
</div>