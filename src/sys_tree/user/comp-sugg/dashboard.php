<!-- start home stats container -->
<div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
    <!-- start header -->
    <div class="header">
        <h1 class="h1 text-capitalize"><?php echo language('MANAGE', @$_SESSION['systemLang']) . " " . language('COMPLAINTS & SUGGESTIONS', @$_SESSION['systemLang']) ?></h1>
    </div>
    <!-- first row -->
    <div class="mb-5 row row-cols-sm-1 row-cols-md-4 g-3">
        <div class="col-sm-12">
            <div class="card card-stat bg-primary">
                <div class="card-body">
                    <i class="bi bi-file-person"></i>
                    <span>
                        <a href="?do=personalCompSugg&userid=<?php echo $_SESSION['UserID'] ?>" class="stretched-link text-capitalize">
                            <?php echo language('PERSONAL COMP/SUGG', @$_SESSION['systemLang']) ?>
                        </a>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="card card-stat bg-success">
                <div class="card-body">
                    <i class="bi bi-mailbox"></i>
                    <!-- <h5 class="card-title text-capitalize"></h5> -->
                    <span>
                        <a href="?do=showCompSugg&type=0" class="stretched-link text-capitalize">
                            <?php echo language('THE SUGGESTIONS', @$_SESSION['systemLang']) ?>
                        </a>
                    </span>
                </div>
            </div>
        </div>
        
        <div class="col-sm-12">
            <div class="card card-stat bg-danger">
                <div class="card-body">
                    <i class="bi bi-journal-x"></i>
                    <!-- <h5 class="card-title text-capitalize"></h5> -->
                    <span>
                        <a href="?do=showCompSugg&type=1" class="stretched-link text-capitalize">
                            <?php echo language('THE COMPLAINTS', @$_SESSION['systemLang']) ?>
                        </a>
                    </span>
                </div>
            </div>
        </div>

        <div class="col-sm-12 <?php if ($_SESSION['sugg_show'] == 0) {echo 'd-none';}  ?>">
            <div class="card card-stat bg-add">
                <div class="card-body">
                    <!-- <h5 class="card-title text-capitalize"></h5> -->
                    <span>
                        <a href="?do=addNewComSugg" class="stretched-link text-capitalize">
                            <i class="bi bi-plus"></i>
                            <?php echo language('ADD NEW SUGG/COMP', @$_SESSION['systemLang']) ?>
                        </a>
                    </span>
                </div>
            </div>
        </div>
        
    </div>
</div>