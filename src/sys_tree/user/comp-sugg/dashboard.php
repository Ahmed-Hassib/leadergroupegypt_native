<!-- start home stats container -->
<div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
  <!-- start new design -->
  <div class="mb-3 row row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3 justify-content-sm-center">
    <div class="col-6">
      <div class="card card-stat bg-gradient">
        <div class="card-body">
          <span class="icon-container <?php echo @$_SESSION['systemLang'] == 'ar' ? 'icon-container-left' : 'icon-container-right' ?>"><i class="bi bi-mailbox"></i></span>
          <span>
            <a href="?do=personalCompSugg&userid=<?php echo $_SESSION['UserID'] ?>" class="stretched-link text-capitalize">
              <?php echo language('THE SUGGESTIONS', @$_SESSION['systemLang']) ?>
            </a>
          </span>
        </div>
      </div>
    </div>
    <div class="col-6">
      <div class="card card-stat bg-gradient">
        <div class="card-body">
          <span class="icon-container <?php echo @$_SESSION['systemLang'] == 'ar' ? 'icon-container-left' : 'icon-container-right' ?>"><i class="bi bi-journal-x"></i></span>
          <span>
            <a href="<?php echo $nav_up_level ?>directions/index.php" class="stretched-link text-capitalize">
              <?php echo language('THE COMPLAINTS', @$_SESSION['systemLang']) ?>
            </a>
          </span>
        </div>
      </div>
    </div>
  </div>
</div>