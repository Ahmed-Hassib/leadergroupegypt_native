
<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
  // get direction name
  $dir_name = isset($_POST['direction-name']) && !empty($_POST['direction-name']) ? $_POST['direction-name'] : '';
  // direction name validation
  if (!empty($dir_name)) {
    // create an object of Direction class
    $dir_obj = new Direction();
    // check if name is exist or not
    $is_exist = $dir_obj->count_records("`direction_id`", "`direction`", "WHERE `direction_name` = $dir_name AND `company_id` = " . $_SESSION['company_id']);

    // check if direction is exist or not
    if ($is_exist == true) {
      // echo danger message
      $msg = '<div class="alert alert-danger text-capitalize" dir=""><i class="bi bi-exclamation-triangle-fill"></i>&nbsp;' . language('THIS NAME IS ALREADY EXIST', @$_SESSION['systemLang']) . '</div>';
    } else {
      // call insert direction function
      $dir_obj->insert_new_direction($dir_name, $_SESSION['UserID'], $_SESSION['company_id']);

      // echo success message
      $msg = '<div class="alert alert-success text-capitalize" dir=""><i class="bi bi-check-circle-fill"></i>&nbsp;' . language('A NEW DIRECTION ADDED SUCCESSFULLY', @$_SESSION['systemLang']) . '</div>';
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
    <?php redirectHome($msg, "back"); ?>
  </header>
</div>

<?php } else {
  // include permission error module
  include_once $globmod . 'permission-error.php';
} ?>