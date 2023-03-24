<!-- start edit profile page -->
<div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
  <!-- start header -->
  <header class="header">
    <!-- start warning page -->
    <div class="page-error">
        <img src="<?php echo $assets ?>images/warning.svg" class="img-fluid" alt="<?php echo language("THERE IS AN ERROR OR MISSING DATA", @$_SESSION['systemLang']) ?>">
    </div>
    <!-- end warning page -->
    <?php
    // error message
    $msg = '<div class="alert alert-danger text-capitalize"><i class="bi bi-exclamation-triangle-fill"></i>&nbsp;'. language('THERE IS AN ERROR OR MISSING DATA', @$_SESSION['systemLang']) .'</div>';
    // redirect to home page
    redirectHome($msg, 'back');
    ?>
  </header>
</div>