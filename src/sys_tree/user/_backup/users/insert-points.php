<!-- start edit profile page -->
<div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
    <!-- start header -->
    <header class="header">
        <!-- show page header -->
        <h1 class="text-capitalize"><?php echo language('ADD POINTS TO EMPLOYEE', @$_SESSION['systemLang']) ?></h1>
        <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // check if Get request userid is numeric and get the integer value
                $userid = isset($_POST['userid']) && is_numeric($_POST['userid']) ? intval($_POST['userid']) : 0;
                $username = selectSpecificColumn("`UserName`", "`users`", "WHERE `UserID` = ".$userid)[0]['UserName'];
                // get points info
                $points     = intval($_POST['points']);
                $pointsType = intval($_POST['points-type']);
                $comment    = $_POST['comment'];
                
                // validate the form
                $formErorr = array();   // error array 
            
                // loop on form error array
                foreach ($formErorr as $error) {
                    echo '<div class="alert alert-danger text-capitalize w-50 mx-auto align-left">' . $error . '</div>';
                }

                if (empty($formErorr)) {
                    // prepare the query
                    $stmt = $con->prepare("INSERT INTO `users_points` (`UserID`, `points`, `points_type`, `points_date`, `comment`, `added_by`) VALUES (?, ?, ?, now(), ?, ?)");
                    $stmt->execute(array($userid, $points, $pointsType, $comment, $_SESSION['UserID']));
                    // log message
                    $logMsg = "Add user points -> added " . $points . ($pointsType == 0 ? " negative" : " positive") . " points to username: " . $username . ".";
                    // createLogs($_SESSION['UserName'], $logMsg);
                    // error message
                    $msg  = '<div class="alert alert-success text-capitalize"><i class="bi bi-check-circle-fill"></i>&nbsp;You added ' . $points . ' points ' . ($pointsType == 1 ? "positive" : "negative") . ' to ' . $username . ' successfully!</div>';
                    redirectHome($msg, "back");
                }
            } else {
                // error message
                $msg = '<div class="alert alert-warning text-capitalize"><i class="bi bi-exclamation-triangle-fill"></i>&nbsp;'.language('YOU CANNOT ACCESS THIS PAGE DIRECTLY', @$_SESSION['systemLang']).'</div>';
                // log message
                $logMsg = "You cannot access this page directly..";
                // createLogs($_SESSION['UserName'], $logMsg, 2);
                // redirect to home page
                redirectHome($msg);
            } ?> 
    </header>
</div>