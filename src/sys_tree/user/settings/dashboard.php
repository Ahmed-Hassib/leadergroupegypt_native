<!-- start home stats container -->
<div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
  <div class="mb-3 row row-cols-sm-1 align-items-stretch g-3 ">
    <!-- company image info -->
    <div class="col-sm-12">
      <?php include_once 'company-image.php' ?>
    </div>
  </div>
  <div class="mb-3 row row-cols-sm-1 row-cols-md-2 align-items-stretch g-3 ">
    <!-- system info -->
    <div class="col-12">
      <?php include_once 'system-info.php' ?>
    </div>
    
    <!-- system language setting -->
    <div class="col-12">
      <?php include_once 'system-lang.php' ?>
    </div>
    
    <!-- other setting -->
    <div class="col-12">
      <?php include_once 'others.php' ?>
    </div>
  </div>
</div>
