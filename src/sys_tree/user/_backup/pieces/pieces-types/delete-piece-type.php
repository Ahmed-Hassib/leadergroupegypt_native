
<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') { ?>
<!-- start pieces type page -->
<div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
    <!-- start header -->
    <header class="header mb-3">
       <?php
            // get type id
            $typeid = isset($_POST['deleted-type-id']) && !empty($_POST['deleted-type-id']) ? $_POST['deleted-type-id'] : '';
            // create an object of PiecesTypes class
            $pcs_type = new PiecesTypes();
            // check if name exist or not
            $is_exist = $pcs_type->is_exist("`type_id`", "`types`", $typeid);
            // check if type is exist or not
            if (!empty($typeid) && $is_exist == true) {
                // update all pieces with this deleted type to 0
                $updateQ = "UPDATE `pieces` SET `type_id` = 0 WHERE `type_id` = $typeid";
                $stmt = $con->prepare($updateQ);
                $stmt->execute();

                // call delete_type function
                $pcs_type->delete_type($typeid);
            
                // echo success message
                $msg = '<div class="alert alert-success text-capitalize" dir=""><i class="bi bi-check-circle-fill"></i>&nbsp;' . language('PIECE TYPE DELETED SUCCESSFULLY', @$_SESSION['systemLang']) . '</div>';
            } else { ?>
                <!-- start page not found 404 -->
                <div class="page-error">
                    <img src="<?php echo $assets ?>images/no-data-founded.svg" class="img-fluid" alt="<?php echo language("NO DATA FOUNDED", @$_SESSION['systemLang']) ?>">
                </div>
                <!-- end page not found 404 -->
            <?php
                // error message
                $msg = '<div class="alert alert-danger text-capitalize"><i class="bi bi-exclamation-triangle-fill"></i>&nbsp;'. language('NO DATA FOUNDED', @$_SESSION['systemLang']) .'</div>';
            }
            // redirect to home page
            redirectHome($msg, "back");
        ?>
    </header>
</div>
<?php } else {
    // include permission error module
    include_once $globmod . 'permission-error.php';
} ?>