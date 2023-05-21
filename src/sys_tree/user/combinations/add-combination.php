<?php
if (!isset($db_obj)) {
    // create an object of Database class
  $db_obj = new Database();
}
// get counter of employees, clients and pieces
$emp_counter = $db_obj->count_records("`UserID`", "`users`", "WHERE `isTech` = 1 AND `company_id` = ".$_SESSION['company_id']);
?>
<!-- start add new user page -->
<div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
  <!-- start form -->
  <form class="mb-3 custom-form" action="?do=insert-combination-info" method="POST" id="add-new-combination" onchange="form_validation(this)">
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
    </div>
    <div class="row row-cols-sm-1 row-cols-md-2 g-3">
      <!-- first column -->
      <div class="col-12">
        <div class="section-block">
          <div class="section-header">
            <h5><?php echo language('RESPONSIBLE FOR COMB INFO', @$_SESSION['systemLang']) ?></h5>
            <hr />
          </div>
          <!-- Administrator name -->
          <div class="mb-sm-2 mb-md-3 row">
            <label for="admin-name" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('ADMIN NAME', @$_SESSION['systemLang']) ?></label>
            <div class="col-sm-12 col-md-8">
              <input type="hidden" class="form-control" id="admin-id" name="admin-id" value="<?php echo $_SESSION['UserID'] ?>" autocomplete="off" required />
              <input type="text" class="form-control" id="admin-name" name="admin-name" placeholder="administrator name" value="<?php echo $_SESSION['UserName'] ?>" autocomplete="off" required readonly />
            </div>
          </div>
          <!-- Technical name -->
          <div class="mb-sm-2 mb-md-3 row">
            <label for="technical-id" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('TECHNICAL NAME', @$_SESSION['systemLang']) ?></label>
            <div class="col-sm-12 col-md-8">
              <select class="form-select" id="technical-id" name="technical-id">
                <option  value="default" disabled selected><?php echo language('SELECT', @$_SESSION['systemLang'])." ".language('TECHNICAL NAME', @$_SESSION['systemLang']) ?></option>
                <?php 
                // get Employees ID and Names
                $usersRows = $db_obj->select_specific_column("`UserID`, `UserName`", "`users`", "WHERE `isTech` = 1 AND `company_id` = ".$_SESSION['company_id']);
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
        </div>
      </div>
      <div class="col-12">
        <div class="section-block">
          <div class="section-header">
            <h5><?php echo language('CLIENT INFO', @$_SESSION['systemLang']) ?></h5>
            <hr />
          </div>
          <!-- client-nameme -->
          <div class="mb-sm-2 mb-md-3 row">
            <label for="client-name" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('CLIENT NAME', @$_SESSION['systemLang']) ?></label>
            <div class="col-sm-12 col-md-8">
              <input type="text" class="form-control" name="client-name" placeholder="<?php echo language('CLIENT NAME', @$_SESSION['systemLang']) ?>" required onkeyup="fullname_validation(this, null, true);">
            </div>
          </div>
          <!-- phone -->
          <div class="mb-sm-2 mb-md-3 row">
            <label for="client-phone" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('PHONE', @$_SESSION['systemLang']) ?></label>
            <div class="col-sm-12 col-md-8 position-relative">
              <input type="text" name="client-phone" id="client-phone" class="form-control w-100" placeholder="<?php echo language('PHONE', @$_SESSION['systemLang']) ?>" required/>
            </div>
          </div>
          <!-- address -->
          <div class="mb-sm-2 mb-md-3 row">
            <label for="client-address" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('THE ADDRESS', @$_SESSION['systemLang']) ?></label>
            <div class="col-sm-12 col-md-8 position-relative">
              <input type="text" name="client-address" id="client-address" class="form-control w-100" placeholder="<?php echo language('THE ADDRESS', @$_SESSION['systemLang']) ?>" required />
            </div>
          </div>
          <!-- notes -->
          <div class="mb-sm-2 mb-md-3 row">
            <label for="client-notes" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('THE NOTES', @$_SESSION['systemLang']) ?></label>
            <div class="col-sm-12 col-md-8 position-relative">
              <textarea type="text" name="client-notes" id="client-notes" class="form-control w-100" rows="5" placeholder="<?php echo language('THE NOTES', @$_SESSION['systemLang']) ?>" style="resize: none; direction: <?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>" required ></textarea>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- submit -->
    <div class="mt-3 hstack gap-2">
      <div class="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'me-auto' : 'ms-auto' ?>">
        <button type="button" form="add-new-combination" class="btn btn-primary text-capitalize form-control bg-gradient fs-12 <?php if ($_SESSION['comb_add'] == 0 || $emp_counter == 0) {echo 'disabled';} ?>" id="add-combination" onclick="form_validation(this.form, 'submit')">
          <?php echo language('ADD THE COMBINATION', @$_SESSION['systemLang']) ?>
        </button>
      </div>
    </div>
  </form>
  <!-- end form -->
</div>