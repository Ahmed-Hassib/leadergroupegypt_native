<!-- START PAGE NOT FOUND SECTION -->
<div class="page-error">
    <div class="container">
        <!-- 404 IMAGE -->
        <img src="<?php echo $assets ?>images/page-not-found.svg" class="img-fluid" style="width: 400px" alt="<?php echo language("NO PAGE WITH THIS NAME", @$_SESSION['systemLang']) ?>">
        <!-- TEXT INFO BOX -->
        <div class="my-2">
            <h5 class="h5 text-danger text-capitalize">
                <i class="bi bi-exclamation-triangle-fill"></i>&nbsp;
                <?php echo language("NO PAGE WITH THIS NAME", @$_SESSION['systemLang']) ?> 
            </h5> 
            
            <!-- BACK HOME BUTTON -->
            <a href="index.php" class="mt-3 btn btn-outline-primary"><?php echo language('HOME') ?></a>
        </div>
    </div>
</div>
<!-- END PAGE NOT FOUND SECTION -->