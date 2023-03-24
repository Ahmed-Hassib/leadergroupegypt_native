<?php $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;  ?>
<!-- start edit profile page -->
<div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
    <!-- start header -->
    <header class="header">
        <?php
        // check the user privildge if he had a permission of full control
        if ($_SESSION['points_delete'] == 1) {
            // get user info from database
            $check = checkItem("`id`", "`users_points`", $id);
            // check the row count
            if ($check > 0) {
                // prepare the query
                $stmt = $con->prepare("DELETE FROM `users_points` WHERE `id` = ?");
                $stmt->execute(array($id));
                // log message
                $logMsg = "Delete complaint or suggestion successfully..";
                // createLogs($_SESSION['UserName'], $logMsg);
                // show message
                $msg = '<div class="alert alert-success text-capitalize"><i class="bi bi-check-circle-fill"></i>&nbsp;DELETED SUCCESSFULY!</div>';
            } else {
                $msg = '<div class="alert alert-warning text-capitalize"><i class="bi bi-exclamation-triangle-fill"></i>&nbsp;there is no such id like ' . $id . '</div>';
            }
            redirectHome($msg, 'back');
        } else {
            // log message
            $logMsg = "You don`t have the permission to Delete the complaint or suggestion..";
            // createLogs($_SESSION['UserName'], $logMsg, 3);
            $msg = '<div class="alert alert-danger  text-capitalize">'.language('YOU DON`T HAVE THE PERMISSION TO DELETE USER POINTS', @$_SESSION['systemLang']).'<p class="lead">'.language('PLEASE CALL ADMINS', @$_SESSION['systemLang']).'</p></div>';
            redirectHome($msg);
        } ?>
        <!-- end header  -->
    </header>
</div>