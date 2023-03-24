<!-- start edit profile page -->
<div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
  <!-- start header -->
  <header class="header">
    <!-- start missing data page -->
    <div class="page-error">
      <img src="<?php echo $assets ?>images/warning.svg" class="img-fluid" alt="<?php echo language("THERE IS AN ERROR OR MISSING DATA", @$_SESSION['systemLang']) ?>">
      <h5 class="mt-4 h5 text-danger"><?php echo language("THERE IS AN ERROR OR MISSING DATA", @$_SESSION['systemLang']) ?></h5>
      <a class="btn btn-outline-primary" href="<?php echo isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '../dashboard/index.php'; ?>">
        <i class="bi bi-arrow-return-left"></i>
        <?php echo language('BACK', @$_SESSION['systemLang']) ?>
      </a>
    </div>
    <!-- end missing data page -->
  </header>
</div>