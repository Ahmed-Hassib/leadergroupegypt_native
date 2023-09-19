<!-- start edit profile page -->
<div class="container" dir="<?php echo @$page_dir ?>">
  <!-- start header -->
  <header class="header">
    <!-- start missing data page -->
    <div class="page-error">
      <img src="<?php echo $assets ?>images/warning.svg" class="img-fluid" alt="<?php echo lang("MISSING DATA") ?>">
      <h5 class="mt-4 h5 text-danger"><?php echo lang("MISSING DATA") ?></h5>
      <a class="btn btn-outline-primary" href="<?php echo isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '../dashboard/index.php'; ?>">
        <i class="bi bi-arrow-return-left"></i>
        <?php echo lang('BACK') ?>
      </a>
    </div>
    <!-- end missing data page -->
  </header>
</div>