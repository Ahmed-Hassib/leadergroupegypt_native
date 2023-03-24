
<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') { ?>
<!-- start pieces type page -->
<div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
    <!-- start header -->
    <header class="header mb-3">
        <?php
            // get deleted connection type id
            $deletedConnTypeid = isset($_POST['deleted-conn-type-id']) && !empty($_POST['deleted-conn-type-id']) ? $_POST['deleted-conn-type-id'] : '';
            // create an object of PiecesConn class
            $conn_obj = new PiecesConn();
            // check if id is exist
            $is_exist_id = $conn_obj->is_exist("`id`", "`conn_types`", $deletedConnTypeid);
            // check if type is exist or not
            if (!empty($deletedConnTypeid) && $is_exist_id == true) {
                // update all pieces with this deleted type to 0
                $updateQ = "UPDATE `pieces` SET `conn_type` = 0 WHERE `conn_type` = $deletedConnTypeid";
                $stmt = $con->prepare($updateQ);
                $stmt->execute();

                // call delete function
                $conn_obj->delete_conn_type($deletedConnTypeid);
            
                // echo success message
                $msg = '<div class="alert alert-success text-capitalize" dir=""><i class="bi bi-check-circle-fill"></i>&nbsp;' . language('CONNECTION TYPE DELETED SUCCESSFULLY', @$_SESSION['systemLang']) . '</div>';
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