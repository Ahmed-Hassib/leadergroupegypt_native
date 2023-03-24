<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
  // get connection type name
  $conn_type_name = isset($_POST['conn-type-name']) && !empty($_POST['conn-type-name']) ? $_POST['conn-type-name'] : '';
  // get connection type notes
  $conn_type_note = isset($_POST['conn-type-note']) && !empty($_POST['conn-type-note']) ? $_POST['conn-type-note'] : '';
  // create an object of PiecesConn class
  $conn_obj = new PiecesConn();
  // type name validation
  if (!empty($conn_type_name)) {
    // check if connection name is exist
    $is_exist = $conn_obj->count_records("`connection_name`", "`connection_types`", "WHERE `connection_name` = $conn_type_name AND `company_id` = " . $_SESSION['company_id']);
    // if true show an error message
    if ($is_exist == true) {
      // echo danger message
      $msg = '<div class="alert alert-danger text-capitalize" dir=""><i class="bi bi-exclamation-triangle-fill"></i>&nbsp;' . language('THIS NAME IS ALREADY EXIST', @$_SESSION['systemLang']) . '</div>';
    } else {
      // call insert new connection function
      $conn_obj->insert_new_conn_type($conn_type_name, $conn_type_note, $_SESSION['company_id']);
      // echo success message
      $msg = '<div class="alert alert-success text-capitalize" dir=""><i class="bi bi-check-circle-fill"></i>&nbsp;' . language('A NEW CONNECTION TYPE ADDED SUCCESSFULLY', @$_SESSION['systemLang']) . '</div>';
    }
  } else {
    // data missed
    $msg = '<div class="alert alert-warning text-capitalize" dir=""><i class="bi bi-check-circle-fill"></i>&nbsp;' . language('CONNECTION TYPE CANNOT BE EMPTY', @$_SESSION['systemLang']) . '</div>';
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