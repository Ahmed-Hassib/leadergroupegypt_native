<!-- start edit profile page -->
<div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
    <!-- start header -->
    <header class="header">
        <!-- show page header -->
        <h1 class="text-capitalize"><?php echo language('ADD', @$_SESSION['systemLang'])." ".language('COMPLAINTS OR SUGGESTIONS', @$_SESSION['systemLang']) ?></h1>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // check if Get request userid is numeric and get the integer value
            $userid = isset($_POST['userid']) && is_numeric($_POST['userid']) ? intval($_POST['userid']) : 0;
            // get type
            $type       = intval($_POST['type']);
            $comment    = $_POST['comment'];
            
            // validate the form
            $formErorr = array();   // error array 
        
            // loop on form error array
            foreach ($formErorr as $error) {
                echo '<div class="alert alert-danger text-capitalize w-50 mx-auto align-left">' . $error . '</div>';
            }

            if (empty($formErorr)) {
                // prepare the query
                $stmt = $con->prepare("INSERT INTO `comp_sugg` (`UserID`, `type`, `sugg`, `added_date`) VALUES (?, ?, ?, now())");
                $stmt->execute(array($userid, $type, $comment));
                // log message
                $logMsg = "Add complaint or suggestion -> added a new " . ($type == 0 ? "suggestion" : "complaint") . "..";
                // createLogs($_SESSION['UserName'], $logMsg);
                // error message
                $msg  = '<div class="alert alert-success text-capitalize"><i class="bi bi-check-circle-fill"></i>&nbsp;You added a new ' . ($type == 0 ? "suggestion" : "complaint") . ' successfully!</div>';
                redirectHome($msg, "back");
            } ?>
        <?php } else {
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