<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') { ?>
<!-- start pieces type page -->
<div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
    <!-- start header -->
    <header class="header mb-3">
        <?php
            // get direction id
            $directionid = isset($_POST['deleted-dir-id']) && !empty($_POST['deleted-dir-id']) ? $_POST['deleted-dir-id'] : '';
            // create an object of Direction class
            $dir_obj = new Direction();
            // check if direction is exist
            $is_exist = $dir_obj->is_exist("`direction_id`", "`direction`", $directionid);
            // direction name validation
            if (!empty($directionid) && $is_exist == true) {
                // check if direction name is exist or not
                if ($dir_obj->count_records("`piece_id`", "`pieces`", "WHERE `direction_id` = $directionid") > 0) {
                    // echo danger message
                    $msg = '<div class="alert alert-danger text-capitalize" dir=""><i class="bi bi-exclamation-triangle-fill"></i>&nbsp;' . language('CANNOT DELETE THIS DIRECTION BECAUSE THIS DIR CONTAINS ONE PIECE OR MORE', @$_SESSION['systemLang']) . '</div>';
                    // waiting time
                    $seconds = 5;
                } else {
                    // call delete direction function
                    $dir_obj->delete_direction($directionid);
                    // echo success message
                    $msg = '<div class="alert alert-success text-capitalize" dir=""><i class="bi bi-check-circle-fill"></i>&nbsp;' . language('DIRECTION DELETED SUCCESSFULLY', @$_SESSION['systemLang']) . '</div>';
                    // waiting time
                    $seconds = 3;
                }
            } else {
                // data missed
                $msg = '<div class="alert alert-warning text-capitalize" dir=""><i class="bi bi-check-circle-fill"></i>&nbsp;' . language('DIRECTION NAME CANNOT BE EMPTY', @$_SESSION['systemLang']) . '</div>';
            }
            // redirect to home page
            redirectHome($msg, "back", $seconds);
        ?>
    </header>
</div>
<?php } else {

    // include permission error module
    include_once $globmod . 'permission-error.php';

} ?>