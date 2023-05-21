<?php
if (!isset($mal_obj)) {
  // create an object of Malfunction class
  $mal_obj = new Malfunction();
}
// get malfunction id
$mal_id = isset($_GET['mal-id']) && intval($_GET['mal-id']) ? intval($_GET['mal-id']) : 0;
// check if the current malfunction id is exist or not
$is_exist = $mal_obj->is_exist("`mal_id`", "`malfunctions`", $mal_id);
?>
<?php if ($is_exist == true) { 
  // call delete function
  $is_deleted = $mal_obj->delete_malfunction($mal_id);
  // check if deleted
  if ($is_deleted) {
    // show the successfull messgae
    $msg  = '<div class="alert alert-success text-capitalize"><i class="bi bi-check-circle-fill"></i>&nbsp;'.language("MALFUNCTION WAS DELETED SUCCESSFULLY").'</div>';
  } else {
    // show warning message
    $msg  = '<div class="alert alert-success text-capitalize"><i class="bi bi-exclamation-triangle-fill"></i>&nbsp;'.language("A PROBLEM WAS HAPPENED WHILE DELETING THE MALFUNCTION").'</div>';
  }
  ?>
  <!-- start edit profile page -->
  <div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
    <!-- start header -->
    <header class="header">
      <?php redirectHome($msg); ?>
    </header>
  </div>
<?php } else {
  // include no data founded
  include_once $globmod . 'no-data-founded-no-redirect.php';
}
?>