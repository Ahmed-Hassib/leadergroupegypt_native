<!-- start home stats container -->
<div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
    <!-- start stats -->
    <div class="stats">
        <!-- buttons section -->
        <div class="mb-3 hstack gap-3">
            <div class="<?php if ($_SESSION['pcs_show'] == 0) {echo 'd-none';} ?>">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-outline-primary shadow-sm py-1" data-bs-toggle="modal" data-bs-target="#addNewPieceTypeModal">
                    <h6 class="h6 mb-0 text-center text-capitalize fs-12">
                        <i class="bi bi-file-plus"></i>
                        <?php echo language("ADD NEW PIECE TYPE", @$_SESSION['systemLang']) ?>
                    </h6>
                </button>
            </div>

            <div class="<?php if ($_SESSION['pcs_update'] == 0) {echo 'd-none';} ?>">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-outline-primary shadow-sm py-1" data-bs-toggle="modal" data-bs-target="#editPieceTypeModal">
                    <h6 class="h6 mb-0 text-center text-capitalize fs-12">
                        <i class="bi bi-pencil-square"></i>
                        <?php echo language("EDIT PIECE TYPES", @$_SESSION['systemLang']) ?>
                    </h6>
                </button>
            </div>

            <div class="<?php if ($_SESSION['pcs_delete'] == 0) {echo 'd-none';} ?>">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-outline-danger shadow-sm py-1" data-bs-toggle="modal" data-bs-target="#deletePieceTypeModal">
                    <h6 class="h6 mb-0 text-center text-capitalize fs-12">
                        <i class="bi bi-trash"></i>
                        <?php echo language("DELETE PIECE TYPE", @$_SESSION['systemLang']) ?>
                    </h6>
                </button>
            </div>
        </div>

        <!-- start new design -->
        <div class="mb-3 row row-cols-sm-1 g-3 align-items-stretch justify-content-start">
            <!-- pieces types statistics -->
            <div class="col-12">
                <div class="section-block">
                    <div class="section-header">
                        <h5 class="h5 text-capitalize"><?php echo language('PIECES TYPES STATISTICS', @$_SESSION['systemLang']) ?></h5>
                        <p class="text-muted "><?php echo language('HERE WILL SHOW SOME STATISTICS ABOUT THE NUMBERS OF PIECES TYPES', @$_SESSION['systemLang']) ?></p>
                        <hr>
                    </div>
                    <?php 
                        // create an object of PiecesTypes class
                        $types_obj = new PiecesTypes();
                        // get all connections 
                        $types_data = $types_obj->get_all_types($_SESSION['company_id']);
                        // data counter
                        $types_count = $types_data[0];
                        // data rows
                        $types_rows = $types_data[1];
                        // check types count
                        if ($types_count > 0) {
                    ?>
                        <div class="row row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3">
                            <?php

                            // loop on types
                            foreach ($types_rows as $key => $type) {
                                // get count of pieces
                                $pcs_count = $types_obj->count_records("`piece_id`", "`pieces`", "WHERE `type_id` = ".$type['type_id']);
                            ?>
                                <div class="col-12">
                                    <div class="card card-stat bg-primary shadow-sm border border-1">
                                        <div class="card-body">
                                            <h5 class="h5 card-title text-uppercase"><?php echo $type['type_name'] ?></h5>
                                            <span class="nums">
                                                <a href="?name=pieces&do=piecesTypes&action=showPiecesType&typeid=<?php echo $type['type_id'] ?>" class="num stretched-link text-black" data-goal="<?php echo $pcs_count ?>">0</a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <!-- show the number of clients that not assigned the connection type -->
                            <div class="col-12">
                                <div class="card card-stat bg-danger shadow-sm border border-1">
                                    <div class="card-body">
                                        <?php $notAssigned = $types_obj->count_records("`piece_id`", "`pieces`", "WHERE `type_id` = 0 AND `company_id` = ".$_SESSION['company_id']); ?>
                                        <h5 class="h5 card-title text-uppercase"><?php echo language('NOT ASSIGNED', @$_SESSION['systemLang']) ?></h5>
                                        <span class="nums">
                                            <a href="?name=pieces&do=piecesTypes&action=showPiecesType&typeid=0" class="num stretched-link text-black" data-goal="<?php echo $notAssigned ?>">0</a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } else { ?>
                        <h5 class="h5 text-capitalize text-danger"><?php echo language('THERE IS NO CONNECTION TYPES TO SHOW', @$_SESSION['systemLang']) ?></h5>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-outline-primary shadow-sm py-1" data-bs-toggle="modal" data-bs-target="#addNewPieceConnTypeModal">
                            <h6 class="h6 mb-0 text-center text-capitalize fs-12">
                                <i class="bi bi-file-plus"></i>
                                <?php echo language("ADD NEW CONNECTION TYPE", @$_SESSION['systemLang']) ?>
                            </h6>
                        </button>
                    <?php } ?>
                </div>
            </div>
            
        </div>
    </div>
    
</div>

<!-- include add new type modal -->
<?php include_once 'add-type-modal.php' ?>
<!-- include edit type modal -->
<?php include_once 'edit-type-modal.php' ?>
<!-- include delete type modal
<?php # include_once 'delete-type-modal.php' ?> -->