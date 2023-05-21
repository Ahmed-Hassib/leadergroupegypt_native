<?php 
// chekc request method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // get device id
  $model_id = isset($_POST['model-id']) && !empty($_POST['model-id']) ? $_POST['model-id'] : '';
  // get device name
  $model_name = isset($_POST['new-model-name']) && !empty($_POST['new-model-name']) ? $_POST['new-model-name'] : '';
  // check if company id is not empty
  if (!empty($model_id) && !empty($model_name)) {
?>
  <!-- start devices page -->
  <div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
    <!-- start header -->
    <header class="header mb-3">
      <?php
      if (!isset($model_obj)) {
        // create an object of Model class
        $model_obj = new Models();
      }
      // check if name exist or not
      $is_exist_model_id   = $model_obj->is_exist("`model_id`", "`devices_model`", $model_id);
      $is_exist_model_name = $model_obj->count_records("`model_id`", "`devices_model`", "WHERE `model_id` <> $model_id AND `model_name` = $model_name");

      // check if type is exist or not
      if ($is_exist_model_id) {
        if ($is_exist_model_name) {
          // echo danger message
          $msg = '<div class="alert alert-danger text-capitalize" dir=""><i class="bi bi-exclamation-triangle-fill"></i>&nbsp;' . language('THIS NAME IS ALREADY EXIST', @$_SESSION['systemLang']) . '</div>';
        } else {
          // call insert_new_type function
          $model_obj->update_model($model_name, $model_id);
          // echo success message
          $msg = '<div class="alert alert-success text-capitalize" dir=""><i class="bi bi-check-circle-fill"></i>&nbsp;' . language('MODEL WAS UPDATED SUCCESSFULLY', @$_SESSION['systemLang']) . '</div>';
        }
        // redirect to home page
        redirectHome($msg, "back");
      } else {
        // include not data founded module
        include_once $globmod . "no-data-founded.php";
      }
      ?>
    </header>
  </div>
        
<?php
  } else {
    // include_once permission error module
    include_once $globmod . 'missing-data.php';
  }
} else {
  // include_once permission error module
  include_once $globmod . 'permission-error.php';
} ?>
