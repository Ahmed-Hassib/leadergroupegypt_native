
<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
  // get deleted connection type id
  $conn_id = isset($_POST['deleted-conn-type-id']) && !empty($_POST['deleted-conn-type-id']) ? $_POST['deleted-conn-type-id'] : '';
  // create an object of PiecesConn class
  $conn_obj = new PiecesConn();
  // check if id is exist
  $is_exist_id = $conn_obj->is_exist("`id`", "`connection_types`", $conn_id);
  // check if type is exist or not
  if (!empty($conn_id) && $is_exist_id == true) {
    // update all pieces with this deleted type to 0
    $updated_query = "UPDATE `pieces_info` SET `connection_type` = 0 WHERE `connection_type` = $conn_id";
    $stmt = $con->prepare($updated_query);
    $stmt->execute();

    // call delete function
    $conn_obj->delete_conn_type($conn_id);
  
    // echo success message
    $msg = '<div class="alert alert-success text-capitalize" dir=""><i class="bi bi-check-circle-fill"></i>&nbsp;' . language('CONNECTION TYPE DELETED SUCCESSFULLY', @$_SESSION['systemLang']) . '</div>';
  } else {
    $msg  = '<div class="page-error">';
    $msg .= '<img src="' . $assets .'"images/no-data-founded.svg" class="img-fluid" alt="'. language("NO DATA FOUNDED", @$_SESSION['systemLang']) . '">';
    $msg .= '</div>';
    // error message
    $msg = '<div class="alert alert-danger text-capitalize"><i class="bi bi-exclamation-triangle-fill"></i>&nbsp;'. language('NO DATA FOUNDED', @$_SESSION['systemLang']) .'</div>';
  }
  // redirect to home page
  
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