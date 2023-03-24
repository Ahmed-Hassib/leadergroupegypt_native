<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') { ?>
<!-- start pieces type page -->
<div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
    <!-- start header -->
    <header class="header mb-3">
        <?php
            // get type name
            $typeName = isset($_POST['type-name']) && !empty($_POST['type-name']) ? $_POST['type-name'] : '';
            // get type notes
            $typeNote = isset($_POST['type-note']) && !empty($_POST['type-note']) ? $_POST['type-note'] : '';
            // create an object of PiecesTypes class
            $pcs_type = new PiecesTypes();
            // check if name exist or not
            $is_exist = $pcs_type->is_exist("`type_name`", "`types`", $typeName);
            // type name validation
            if (!empty($typeName)) {
                // check if type is exist or not
                if ($is_exist == true) {
                    // echo danger message
                    $msg = '<div class="alert alert-danger text-capitalize" dir=""><i class="bi bi-exclamation-triangle-fill"></i>&nbsp;' . language('THIS NAME IS ALREADY EXIST', @$_SESSION['systemLang']) . '</div>';
                } else {
                    // call insert_new_type function
                    $pcs_type->insert_new_type($typeName, $typeNote, $_SESSION['company_id']);
                    // echo success message
                    $msg = '<div class="alert alert-success text-capitalize" dir=""><i class="bi bi-check-circle-fill"></i>&nbsp;' . language('A NEW PIECE TYPE ADDED SUCCESSFULLY', @$_SESSION['systemLang']) . '</div>';
                }
            } else {
                // data missed
                $msg = '<div class="alert alert-warning text-capitalize" dir=""><i class="bi bi-check-circle-fill"></i>&nbsp;' . language('PIECE TYPE CANNOT BE EMPTY', @$_SESSION['systemLang']) . '</div>';
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