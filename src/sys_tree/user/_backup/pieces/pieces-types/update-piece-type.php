
<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') { ?>
<!-- start pieces type page -->
<div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
    <!-- start header -->
    <header class="header mb-3">
        <?php
            // get type id
            $typeid         = isset($_POST['type-id']) && !empty($_POST['type-id']) ? $_POST['type-id'] : '';
            // get type name
            $newTypeName    = isset($_POST['new-type-name']) && !empty($_POST['new-type-name']) ? $_POST['new-type-name'] : '';
            // get type notes
            $newTypeNote    = isset($_POST['new-type-note']) && !empty($_POST['new-type-note']) ? $_POST['new-type-note'] : '';
            // create an object of PiecesTypes class
            $pcs_type = new PiecesTypes();
            // check if name exist or not
            $is_exist = $pcs_type->is_exist("`type_id`", "`types`", $typeid);
            // check if type is exist or not
            if ($is_exist == true) {
                // type name validation
                if (!empty($newTypeName)) {
                    // check if type is exist or not
                    if ($pcs_type->count_records("type_id", "types", "WHERE `type_id` <> $typeid AND `type_name` = '$newTypeName'") > 0) {
                        // echo danger message
                        $msg = '<div class="alert alert-danger text-capitalize" dir=""><i class="bi bi-exclamation-triangle-fill"></i>&nbsp;' . language('THIS NAME IS ALREADY EXIST', @$_SESSION['systemLang']) . '</div>';
                    } else {
                        // call update_type function
                        $pcs_type->update_type($newTypeName, $newTypeNote, $typeid);
                        
                        // echo success message
                        $msg = '<div class="alert alert-success text-capitalize" dir=""><i class="bi bi-check-circle-fill"></i>&nbsp;' . language('PIECE TYPE UPDATED SUCCESSFULLY', @$_SESSION['systemLang']) . '</div>';
                    }
                } else {
                    // data missed
                    $msg = '<div class="alert alert-warning text-capitalize" dir=""><i class="bi bi-check-circle-fill"></i>&nbsp;' . language('PIECE TYPE CANNOT BE EMPTY', @$_SESSION['systemLang']) . '</div>';
                }
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
    // include_once permission error module
    include_once $globmod . 'permission-error.php';
} ?>