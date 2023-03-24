<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') { ?>
  <!-- start device page -->
  <div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
    <!-- start header -->
    <header class="header mb-3">
      <?php
      // get model id
      $model_id = isset($_POST['deleted-model-id']) && !empty($_POST['deleted-model-id']) ? $_POST['deleted-model-id'] : '';      
      // create an object of Model class
      $model_obj = new Models();
      // check if name exist or not
      $is_exist = $model_obj->is_exist("`model_id`", "`devices_model`", $model_id);
      // check if company is exist or not
      if (!empty($model_id) && $is_exist == true) {
        // call delete_model function
        $model_obj->delete_model($model_id);
        // echo success message
        $msg = '<div class="alert alert-success text-capitalize" dir=""><i class="bi bi-check-circle-fill"></i>&nbsp;' . language('MODEL WAS DELETED SUCCESSFULLY', @$_SESSION['systemLang']) . '</div>';
      } else { ?>
        <!-- start page not found 404 -->
        <div class="page-error">
            <img src="<?php echo $assets ?>images/no-data-founded.svg" class="img-fluid" alt="<?php echo language("NO DATA FOUNDED", @$_SESSION['systemLang']) ?>">
        </div>
        <!-- end page not found 404 -->
      <?php
        // error message
        $msg = '<div class="alert alert-danger text-capitalize"><i class="bi bi-exclamation-triangle-fill"></i>&nbsp;'. language('NO DATA FOUNDED', @$_SESSION['systemLang']) .'</div>';
      }
      // redirect to home page
      redirectHome($msg, "back");
      ?>
    </header>
  </div>
<?php } else {
    // include_once permission error module
    include_once $globmod . 'permission-error.php';
} ?>