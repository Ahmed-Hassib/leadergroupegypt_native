<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
  // get connection type id
  $conn_id = isset($_POST['conn-type-id']) && !empty($_POST['conn-type-id']) ? $_POST['conn-type-id'] : '';
  // get connection type name
  $new_conn_name = isset($_POST['new-conn-type-name']) && !empty($_POST['new-conn-type-name']) ? $_POST['new-conn-type-name'] : '';
  // get connection type notes
  $new_conn_note = isset($_POST['new-conn-type-note']) && !empty($_POST['new-conn-type-note']) ? $_POST['new-conn-type-note'] : '';
  // create an object of PiecesConn class
  $conn_obj = new PiecesConn();
  // check the type exist to update 
  $is_exist = $conn_obj->is_exist("`id`", "`connection_types`", $conn_id);
  // type name validation
  if (!empty($new_conn_name) && $is_exist == true) {
    // check the new name
    $is_exist_name = $conn_obj->count_records("`connection_name`", "`connection_types`", "WHERE `id` <> $conn_id AND `connection_name` = '$new_conn_name'");
    // check if new type name is exist or not
    if ($is_exist_name == true) {
      // echo danger message
      $msg = '<div class="alert alert-danger text-capitalize" dir=""><i class="bi bi-exclamation-triangle-fill"></i>&nbsp;' . language('THIS NAME IS ALREADY EXIST', @$_SESSION['systemLang']) . '</div>';
    } else {
      // call update function
      $conn_obj->update_conn_type($new_conn_name, $new_conn_note, $conn_id);
      // echo success message
      $msg = '<div class="alert alert-success text-capitalize" dir=""><i class="bi bi-check-circle-fill"></i>&nbsp;' . language('CONNECTION TYPE UPDATED SUCCESSFULLY', @$_SESSION['systemLang']) . '</div>';
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