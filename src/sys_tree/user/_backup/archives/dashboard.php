<!-- start home stats container -->
<div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
    <!-- start header -->
    <header class="header">
        <h1 class="h1 text-capitalize"><?php echo language('ARCHIVE', @$_SESSION['systemLang']) ?></h1>
    </header>
    <!-- end header -->
    <div class="mb-3 row row-cols-sm-1 row-cols-md-4 g-3">
        <div class="col-sm-12">
            <div class="card card-stat bg-primary bg-gradient">
                <div class="card-body">
                    <i class="bi bi-people"></i>
                    <span>
                        <a href="?do=piecesArchive" class="stretched-link text-capitalize">
                            <?php echo language('PIECES/CLIENTS ARCHIVE', @$_SESSION['systemLang']) ?>
                        </a>
                    </span>
                </div>
            </div>
        </div>
        <!-- <div class="col-sm-12">
            <div class="card card-stat bg-danger bg-gradient">
                <div class="card-body">
                    <i class="bi bi-folder-x"></i>
                    <span>
                        <a href="?do=malfunctionsArchive" class="stretched-link text-capitalize">
                            <?php echo language('MALFUNCTIONS ARCHIVE', @$_SESSION['systemLang']) ?>
                        </a>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="card card-stat bg-success bg-gradient">
                <div class="card-body">
                    <i class="bi bi-terminal"></i>
                    <span>
                        <a href="?do=combinationsArchive" class="stretched-link text-capitalize">
                            <?php echo language('COMBINATIONS ARCHIVE', @$_SESSION['systemLang']) ?>
                        </a>
                    </span>
                </div>
            </div>
        </div> -->
    </div>
</div>