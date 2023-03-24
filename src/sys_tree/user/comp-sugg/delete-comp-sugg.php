<?php
// get complaint or suggestion id
$compSuggID = isset($_GET['compSuggID']) && intval($_GET['compSuggID']) ? intval($_GET['compSuggID']) : 0;
// check if the current complaint or suggestion id is exist or not
$check = checkItem("`id`", "`comp_sugg`", $compSuggID);
?>
<!-- start edit profile page -->
<div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
    <!-- start header -->
    <header class="header">
        <h1 class="text-capitalize"><?php echo language('DELETE', @$_SESSION['systemLang']). " " .language('COMPLAINTS OR SUGGESTIONS') ?></h1>
        <?php
        // echo $compSuggID;
        if ($check > 0) {
            $stmt = $con->prepare("DELETE FROM `comp_sugg` WHERE `id` = :compSuggID");
            $stmt->bindParam(":compSuggID", $compSuggID);
            $stmt->execute();
            // show the successfull messgae
            $msg  = '<div class="alert alert-success text-capitalize"><i class="bi bi-check-circle-fill"></i>&nbsp;the complaint or suggestion deleted succefully!</div>';
            redirectHome($msg, 'back');
        } else {
            // show the warning messgae
            $msg  = '<div class="alert alert-success text-capitalize"><i class="bi bi-check-circle-fill"></i>&nbsp;there is no such id like ' . $malID . '</div>';
            redirectHome($msg);
        }
        ?>
    </header>
</div>