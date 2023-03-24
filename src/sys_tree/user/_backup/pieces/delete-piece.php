<?php
// create an object of Piece Class
$pcs_obj = new Pieces();
// check if Get request pieceid is numeric and get the integer value
$piece_id = isset($_GET['pieceid']) && is_numeric($_GET['pieceid']) ? intval($_GET['pieceid']) : 0;
// get piece name
$piece_name = $pcs_obj->select_specific_column("`piece_name`", "`pieces`", "WHERE `piece_id` = ".$piece_id)[0]['piece_name'];
// get user info from database
$is_exist = $pcs_obj->is_exist('piece_id', 'pieces', $piece_id);
// check if exist
if ($is_exist == true) {
    // select type of the given id
    $src_piece = $pcs_obj->select_specific_column("`type_id`", "`pieces`", "WHERE `piece_id` = " . $piece_id )[0]['type_id'];
    // check the piece type
    if ($src_piece != 4) {
        // check if the piece have a children or not
        $count_child = $pcs_obj->count_records("`piece_id`", "`pieces`", "WHERE `source_id` = " . $piece_id );
    } else {
        $count_child = 0;
    }
?>
    <!-- start edit profile page -->
    <div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
        <!-- start header -->
        <header class="header mb-5">
            <?php if ($is_exist > 0 && $count_child == 0) {
                // call delete function
                $pcs_obj->delete_piece($piece_id); 
                // log message
                $logMsg = "Delete piece or client with name `" . $piece_name . "`";
                createLogs($_SESSION['UserName'], $logMsg, 3);
                // page message
                $msg = '<div class="alert alert-success text-capitalize"><i class="bi bi-check-circle-fill"></i>&nbsp;' . language("PIECE/CLIENT DELETED SUCCESSFULLY", @$_SESSION['systemLang']) .'</div>';
                redirectHome($msg);
            } elseif ($is_exist == 0) { 
                // include no data founded module
                include_once $globmod . 'no-data-founded.php';
            } else {
                // log message
                $logMsg = "You cannot delete the piece because it hase more than 1 child..";
                createLogs($_SESSION['UserName'], $logMsg, 2);
                $msg = '<div class="alert alert-danger text-capitalize"><i class="bi bi-exclamation-triangle-fill"></i>&nbsp;'. language('YOU CANNOT DELETE THIS PIECE BECAUSE IT HAVE MORE THAN 1 CHILD', @$_SESSION['systemLang']) .'</div>';
                redirectHome($msg, 'back');
            } ?>
        </header>
        <!-- end header  -->
    </div>
<?php } else {
    // include page error (page not found) module
    include_once $globmod . 'page-error.php';
} ?>