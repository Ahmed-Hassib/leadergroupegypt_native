<?php
if (!isset($db_obj)) {
  // create an object of Database class
  $db_obj = new Database();
}
// get counter of employees, clients and pieces
$emp_counter = $db_obj->count_records("`UserID`", "`users`", "WHERE `job_title_id` = 2 AND `company_id` = ".$_SESSION['company_id']);
$pcs_counter = $db_obj->count_records("`id`", "`pieces_info`", "WHERE `company_id` = " . $_SESSION['company_id']);
?>
<!-- start add new user page -->
<div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
  <!-- start form -->
  <form class="custom-form" action="?do=insert-new-malfunction" method="POST" id="add-malfunction" onchange="form_validation(this)">
    <!-- horzontal stack -->
    <div class="vstack gap-1">
      <!-- note for required inputs -->
      <h6 class="h6 text-decoration-underline text-capitalize text-danger fw-bold">
        <span><?php echo language('NOTE', @$_SESSION['systemLang']) ?>:</span>&nbsp;
        <span><?php echo language('THIS SIGN * IS REFERE TO REQUIRED FIELDS', @$_SESSION['systemLang']) ?></span>
      </h6>
      <?php if ($emp_counter == 0) { ?>
      <!-- note for empty employees -->
      <h6 class="h6 text-decoration-underline text-capitalize text-danger fw-bold">
        <span><?php echo language('NOTE', @$_SESSION['systemLang']) ?>:</span>&nbsp;
        <span><?php echo language('YOUR COMPANY HAS NO TECHNICAL MEN, YOU CANNOT ADD ANY MALFUNCTIONS', @$_SESSION['systemLang']) ?></span>
      </h6>
      <?php } ?>
      <?php if ($pcs_counter == 0) { ?>
      <!-- note for empty pieces -->
      <h6 class="h6 text-decoration-underline text-capitalize text-danger fw-bold">
        <span><?php echo language('NOTE', @$_SESSION['systemLang']) ?>:</span>&nbsp;
        <span><?php echo language('YOUR COMPANY HAS NO CLIENTS OR PIECES, YOU CANNOT ADD ANY MALFUNCTIONS', @$_SESSION['systemLang']) ?></span>
      </h6>
      <?php } ?>
    </div>
    <!-- form inputs -->
    <div class="mb-3 row row-cols-sm-1 row-cols-md-2 g-3">
      <!-- first column -->
      <div class="col-12">
        <div class="section-block">
          <div class="section-header">
            <h5 class="h5 text-capitalize"><?php echo language('RESPONSIBLE FOR MALFUNCTION', @$_SESSION['systemLang']) ?></h5>
            <hr />
          </div>
          <!-- Administrator name -->
          <div class="mb-sm-2 mb-md-3 row">
            <label for="admin-name" class="col-sm-12 col-form-label text-capitalize"><?php echo language('ADMIN NAME', @$_SESSION['systemLang']) ?></label>
            <div class="col-sm-12 position-relative">
              <input type="hidden" class="form-control" id="admin-id" name="admin-id" value="<?php echo $_SESSION['UserID'] ?>" autocomplete="off" required />
              <input type="text" class="form-control" id="admin-name" name="admin-name" placeholder="administrator name" value="<?php echo $_SESSION['UserName'] ?>" autocomplete="off" required readonly />
            </div>
          </div>
          <!-- Technical name -->
          <div class="mb-sm-2 mb-md-3 row">
            <label for="technical-id" class="col-sm-12 col-form-label text-capitalize"><?php echo language('TECHNICAL NAME', @$_SESSION['systemLang']) ?></label>
            <div class="col-sm-12 position-relative">
              <select class="form-select" id="technical-id" name="technical-id" required <?php if ($emp_counter == 0) { echo 'disabled'; }?>>
                <option  value="default" disabled selected><?php echo language('SELECT', @$_SESSION['systemLang'])." ".language('TECHNICAL NAME', @$_SESSION['systemLang']) ?></option>
                <?php 
                // get Employees ID and Names
                $usersRows = $db_obj->select_specific_column("`UserID`, `UserName`", "`users`", "WHERE `isTech` = 1 AND `job_title_id` = 2 AND `company_id` = ".$_SESSION['company_id']);
                // check the length of result
                if (count($usersRows) > 0) {
                  // loop on result ..
                  foreach ($usersRows as $userRow) { ?>
                    <!-- get all information of pieces -->
                    <option value="<?php echo $userRow['UserID'] ?>">
                      <?php echo $userRow['UserName']; ?>
                    </option>
                  <?php }
                } else {
                  echo "<option disabled>". language("NOT AVAILABLE NOW", @$_SESSION['systemLang']) ."</option>";
                }
                ?>
              </select>
            </div>
          </div>
          <!-- phone -->
          <div class="mb-sm-2 mb-md-3 row">
            <label for="client-name" class="col-sm-12 col-form-label text-capitalize"><?php echo language('CLIENT NAME', @$_SESSION['systemLang']) ?></label>
            <div class="col-sm-12 position-relative position-relative">
              <input type="hidden" name="client-id" id="client-id" class="form-control w-100" placeholder="Client ID" />
              <input type="text" name="client-name" id="client-name" class="form-control w-100" placeholder="<?php echo language('ADMIN NAME', @$_SESSION['systemLang']) ?>" onkeyup="search_name(this)" data-company-id="<?php echo $_SESSION['company_id'] ?>" required  <?php if ($pcs_counter == 0) { echo 'disabled'; } ?> />
              <div class="result w-100">
                <ul class="clients-names" id="clients-names"></ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- forth column -->
      <div class="col-12">
        <div class="section-block">
          <div class="section-header">
            <h5><?php echo language('MALFUNCTION DESCRIPTION', @$_SESSION['systemLang']) ?></h5>
            <hr />
          </div>
          <!-- notes -->
          <div class="mb-sm-2 mb-md-3 row">
            <label for="descreption" class="col-sm-12 col-form-label text-capitalize"><?php echo language('MALFUNCTION DESCRIPTION', @$_SESSION['systemLang']) ?></label>
            <div class="col-sm-12 position-relative">
              <textarea name="descreption" id="descreption" title="<?php echo language('MALFUNCTION DESCRIPTION', @$_SESSION['systemLang']) ?>" class="form-control w-100" style="height: 10rem; resize: none; direction: <?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>" placeholder="<?php echo language('MALFUNCTION DESCRIPTION', @$_SESSION['systemLang']) ?>" required></textarea>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- submit -->
    <div class="hstack gap-3">
      <div class="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'me-auto' : 'ms-auto' ?>">
        <button type="button" form="add-malfunction" class="btn btn-primary text-capitalize form-control bg-gradient fs-12 <?php if ($_SESSION['mal_add'] == 0 || $emp_counter == 0 || $pcs_counter == 0) {echo 'disabled';} ?>" id="add-malfunctions" onclick="form_validation(this.form, 'submit')">
          <?php echo language('ADD', @$_SESSION['systemLang'])." ".language('THE MALFUNCTION', @$_SESSION['systemLang']) ?>
        </button>
      </div>
    </div>
  </form>
  <!-- end form -->
</div>