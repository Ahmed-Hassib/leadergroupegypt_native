
<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
  // get direction id
  $direction_id = isset($_POST['updated-dir-id']) && !empty($_POST['updated-dir-id']) ? $_POST['updated-dir-id'] : '';
  // get direction new name
  $new_direction_name = isset($_POST['new-direction-name']) && !empty($_POST['new-direction-name']) ? $_POST['new-direction-name'] : '';
  // create an object of Direction class
  $dir_obj = new Direction();
  // check if direction is exist
  $is_exist = $dir_obj->is_exist("`direction_id`", "`direction`", $direction_id);

  // direction name validation
  if (!empty($new_direction_name) && $is_exist == true) {
    // directions counter that have the same name in the same company
    $directions_counter = $dir_obj->count_records("`direction_id`", "`direction`", "WHERE `direction_id` != $direction_id AND `direction_name` = '$new_direction_name' AND `company_id` = " . $_SESSION['company_id']);
    // check if direction name is exist or not
    if ($directions_counter > 0) {
      // echo danger message
      $msg = '<div class="alert alert-danger text-capitalize" dir=""><i class="bi bi-exclamation-triangle-fill"></i>&nbsp;' . language('THIS NAME IS ALREADY EXIST', @$_SESSION['systemLang']) . '</div>';
    } else {
      // call update direction function
      $dir_obj->update_direction($new_direction_name, $direction_id);
      // echo success message
      $msg = '<div class="alert alert-success text-capitalize" dir=""><i class="bi bi-check-circle-fill"></i>&nbsp;' . language('DIRECTION UPDATED SUCCESSFULLY', @$_SESSION['systemLang']) . '</div>';
    }
  } else {
    // data missed
    $msg = '<div class="alert alert-warning text-capitalize" dir=""><i class="bi bi-exclamation-triangle-fill"></i>&nbsp;' . language('DIRECTION NAME CANNOT BE EMPTY', @$_SESSION['systemLang']) . '</div>';
  }
  ?>
  <!-- start pieces type page -->
  <div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
    <!-- start header -->
    <header class="header mb-3">
      <?php redirectHome($msg, "back"); ?>
    </header>
  </div>
<?php } else {
  // include permission error module
  include_once $globmod . 'permission-error.php';

} ?>