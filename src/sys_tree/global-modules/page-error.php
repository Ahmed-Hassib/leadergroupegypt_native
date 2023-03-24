<!-- start edit profile page -->
<div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
    <!-- start header -->
    <header class="header">
        <!-- start page not found 404 -->
        <div class="page-error">
            <img src="<?php echo $assets ?>images/page-not-found.svg" class="img-fluid" alt="<?php echo language("NO PAGE WITH THIS NAME", @$_SESSION['systemLang']) ?>">
        </div>
        <!-- end page not found 404 -->
        
        <?php
        // error message
        $msg = '<div class="alert alert-warning text-capitalize"><i class="bi bi-exclamation-triangle-fill"></i>&nbsp;'.language("NO PAGE WITH THIS NAME", @$_SESSION['systemLang']).'</div>';
        // redirect to home page
        redirectHome($msg, 'back');
        ?>
    </header>    
</div>