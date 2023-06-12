<!-- start home stats container -->
<div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
  <!-- start new design -->
  <div class="mb-3 row row-cols-sm-2 row-cols-md-3 g-3 justify-content-sm-center">
    <div class="col-6">
      <div class="card card-stat bg-gradient">
        <div class="card-body">
          <span class="icon-container <?php echo @$_SESSION['systemLang'] == 'ar' ? 'icon-container-left' : 'icon-container-right' ?>"><i class="bi bi-mailbox"></i></span>
          <span>
            <a href="?do=personal-comp-sugg&userid=<?php echo $_SESSION['UserID'] ?>&type=0" class="stretched-link text-capitalize">
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
            <a href="?do=personal-comp-sugg&userid=<?php echo $_SESSION['UserID'] ?>&type=1" class="stretched-link text-capitalize">
              <?php echo language('THE COMPLAINTS', @$_SESSION['systemLang']) ?>
            </a>
          </span>
        </div>
      </div>
    </div>
  </div>
</div>