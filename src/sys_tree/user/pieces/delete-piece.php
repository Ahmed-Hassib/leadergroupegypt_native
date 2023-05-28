<?php
if (!isset($pcs_obj)) {
  // create an object of Piece Class
  $pcs_obj = new Pieces();
}
// check if Get request piece-id is numeric and get the integer value
$piece_id = isset($_GET['piece-id']) && is_numeric($_GET['piece-id']) ? intval($_GET['piece-id']) : 0;
// get piece name
$piece_name = $pcs_obj->select_specific_column("`full_name`", "`pieces_info`", "WHERE `id` = $piece_id")[0]['full_name'];
// get user info from database
$is_exist = $pcs_obj->is_exist("`id`", "`pieces_info`", $piece_id);
// check if exist
if ($is_exist == true) {
  // check if the piece have a children or not
  $count_child = $pcs_obj->count_records("`id`", "`pieces_info`", "WHERE `source_id` = $piece_id AND `company_id` = ".$_SESSION['company_id']);
?>
  <!-- start edit profile page -->
  <div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
    <!-- start header -->
    <header class="header mb-5">
      <?php 
      if ($is_exist > 0 && $count_child == 0) {
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
        include_once $globmod . 'no-data-founded-no-redirect.php';
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