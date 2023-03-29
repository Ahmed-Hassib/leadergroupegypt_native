<?php
// get combination id
$comb_id = isset($_GET['comb-id']) && intval($_GET['comb-id']) ? intval($_GET['comb-id']) : 0;
// create an object of Combination class
$comb_obj = new Combination();
// check if the current combination id is exist or not
$is_exist = $comb_obj->is_exist("`comb_id`", "`combinations`", $comb_id);

if ($is_exist == true) {
  // call delete function
  $is_deleted = $comb_obj->delete_combination($comb_id);

  // check if deleted
  if ($is_deleted == true) {
    // show the successfull messgae
    $msg  = '<div class="alert alert-success text-capitalize"><i class="bi bi-check-circle-fill"></i>'.language("COMBINATION WAS DELETED SUCCESSFULLY").'</div>';
  } else {
    // show the successfull messgae
    $msg  = '<div class="alert alert-success text-capitalize"><i class="bi bi-exclamation-triangle-fill"></i>'.language("A PROBLEM WAS HAPPENED WHILE INSERTING A THE COMBINATION").'</div>';
  }
?>
  <!-- start edit profile page -->
  <div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
    <!-- start header -->
    <header class="header">
      <?php redirectHome($msg); ?>
    </header>
  </div>
<?php
} else {
  // include no data founded moule
  include_once $globmod . 'no-data-founded.php';
}
?>