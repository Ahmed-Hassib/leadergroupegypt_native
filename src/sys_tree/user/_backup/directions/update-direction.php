
<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') { ?>
<!-- start pieces type page -->
<div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
    <!-- start header -->
    <header class="header mb-3">
        <?php
            // get direction id
            $directionid = isset($_POST['updated-dir-id']) && !empty($_POST['updated-dir-id']) ? $_POST['updated-dir-id'] : '';
            // get direction new name
            $newDirectionName = isset($_POST['new-direction-name']) && !empty($_POST['new-direction-name']) ? $_POST['new-direction-name'] : '';
            // create an object of Direction class
            $dir_obj = new Direction();
            // check if direction is exist
            $is_exist = $dir_obj->is_exist("`direction_id`", "`direction`", $directionid);

            // direction name validation
            if (!empty($newDirectionName) && $is_exist == true) {
                // check if direction name is exist or not
                if ($dir_obj->count_records("`direction_name`", "`direction`", "WHERE `direction_id` <> $directionid AND `direction_name` = '$newDirectionName'") > 0) {
                    // echo danger message
                    $msg = '<div class="alert alert-danger text-capitalize" dir=""><i class="bi bi-exclamation-triangle-fill"></i>&nbsp;' . language('THIS NAME IS ALREADY EXIST', @$_SESSION['systemLang']) . '</div>';
                } else {
                    // call update direction function
                    $dir_obj->update_direction($newDirectionName, $directionid);
                    // echo success message
                    $msg = '<div class="alert alert-success text-capitalize" dir=""><i class="bi bi-check-circle-fill"></i>&nbsp;' . language('DIRECTION UPDATED SUCCESSFULLY', @$_SESSION['systemLang']) . '</div>';
                }
            } else {
                // data missed
                $msg = '<div class="alert alert-warning text-capitalize" dir=""><i class="bi bi-check-circle-fill"></i>&nbsp;' . language('DIRECTION NAME CANNOT BE EMPTY', @$_SESSION['systemLang']) . '</div>';
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