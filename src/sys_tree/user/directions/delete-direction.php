<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
  // get direction id
  $direction_id = isset($_POST['deleted-dir-id']) && !empty($_POST['deleted-dir-id']) ? $_POST['deleted-dir-id'] : '';
  // create an object of Direction class
  $dir_obj = new Direction();
  // check if direction is exist
  $is_exist = $dir_obj->is_exist("`direction_id`", "`direction`", $direction_id);
  // direction name validation
  if (!empty($direction_id) && $is_exist == true) {
    // count pieces on this direction
    $pieces_counter = $dir_obj->count_records("`id`", "`pieces_info`", "WHERE `direction_id` = $direction_id");
    // check if direction name is exist or not
    if ($pieces_counter > 0) {
      // echo danger message
      $msg = '<div class="alert alert-danger text-capitalize" dir=""><i class="bi bi-exclamation-triangle-fill"></i>&nbsp;' . language('CANNOT DELETE THIS DIRECTION BECAUSE THIS DIR CONTAINS ONE PIECE OR MORE', @$_SESSION['systemLang']) . '</div>';
      // waiting time
      $seconds = 5;
    } else {
      // call delete direction function
      $dir_obj->delete_direction($direction_id);
      // echo success message
      $msg = '<div class="alert alert-success text-capitalize" dir=""><i class="bi bi-check-circle-fill"></i>&nbsp;' . language('DIRECTION DELETED SUCCESSFULLY', @$_SESSION['systemLang']) . '</div>';
      // waiting time
      $seconds = 3;
    }
  } else {
    // data missed
    $msg = '<div class="alert alert-warning text-capitalize" dir=""><i class="bi bi-check-circle-fill"></i>&nbsp;' . language('DIRECTION NAME CANNOT BE EMPTY', @$_SESSION['systemLang']) . '</div>';
  }
?>
<!-- start pieces type page -->
<div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
  <!-- start header -->
  <header class="header mb-3">
    <?php redirectHome($msg, "back", $seconds); ?>
  </header>
</div>
<?php } else {

  // include permission error module
  include_once $globmod . 'permission-error.php';

} ?>