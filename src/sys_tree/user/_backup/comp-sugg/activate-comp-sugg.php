<?php
// get complaint or suggestion id
$compSuggID = isset($_POST['id']) && intval($_POST['id']) ? intval($_POST['id']) : 0;
// get admin comment
$adminComment = isset($_POST['admin-comment']) && !empty($_POST['admin-comment']) ? $_POST['admin-comment'] : "";
// check if the current complaint or suggestion id is exist or not
$check = checkItem("`id`", "`comp_sugg`", $compSuggID);
?>
<!-- start edit profile page -->
<div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
    <!-- start header -->
    <header class="header">
        <h1 class="text-capitalize"><?php echo language('EDIT', @$_SESSION['systemLang']). " " .language('COMPLAINTS OR SUGGESTIONS') ?></h1>
        <?php
        // check the result of the query
        if ($check > 0) {
            // query
            $q = "UPDATE `comp_sugg` SET `admin_comment` = ?, `activate_status` = 1 WHERE `id` = ?";
            // prepare the query
            $stmt = $con->prepare($q);
            // execute the query
            $stmt->execute(array($adminComment, $compSuggID));
            // show the successfull messgae
            $msg  = '<div class="alert alert-success text-capitalize"><i class="bi bi-check-circle-fill"></i>&nbsp;the complaint or suggestion updated succefully!</div>';
            // redirect to the previuos page
            redirectHome($msg, 'back');
        } else {
            // show the warning messgae
            $msg  = '<div class="alert alert-success text-capitalize"><i class="bi bi-check-circle-fill"></i>&nbsp;there is no such id like ' . $malID . '</div>';
            redirectHome($msg);
        }
        ?>
    </header>
</div>