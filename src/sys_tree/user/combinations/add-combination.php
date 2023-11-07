<?php
// create an object of Database class
$db_obj = !isset($db_obj) ? new Database() : $db_obj;
// get counter of employees, clients and pieces
$emp_counter = $db_obj->count_records("`UserID`", "`users`", "WHERE `isTech` = 1 AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']));
// check the permission
if ($_SESSION['sys']['comb_add'] == 1) {
  // check technical counter
  if ($emp_counter > 0) {
?>
    <!-- start add new user page -->
    <div class="container" dir="<?php echo $page_dir ?>">
      <!-- start form -->
      <form class="mb-3 custom-form" action="?do=insert-combination-info" method="POST" id="add-new-combination" onchange="form_validation(this)">
        <!-- horzontal stack -->
        <div class="vstack gap-1">
          <!-- note for required inputs -->
          <h6 class="h6 text-decoration-underline text-capitalize text-danger fw-bold">
            <span><?php echo lang('*REQUIRED') ?></span>
          </h6>
        </div>
        <div class="add-combination-container">
          <!-- responsible for combination -->
          <div class="section-block">
            <div class="section-header">
              <h5><?php echo lang('RESP COMB', $lang_file) ?></h5>
              <hr />
            </div>
            <!-- Administrator name -->
            <div class="mb-3 form-floating">
              <input type="hidden" class="form-control" id="admin-id" name="admin-id" value="<?php echo $_SESSION['sys']['UserID'] ?>" autocomplete="off" required />
              <input type="text" class="form-control" id="admin-name" name="admin-name" placeholder="<?php echo lang('ADMIN NAME', $lang_file) ?>" value="<?php echo $_SESSION['sys']['UserName'] ?>" autocomplete="off" required readonly />
              <label for="admin-name"><?php echo lang('ADMIN NAME', $lang_file) ?></label>
            </div>
            <!-- Technical name -->
            <div class="mb-3 form-floating">
              <select class="form-select" id="technical-id" name="technical-id">
                <option value="default" disabled selected><?php echo lang('SELECT TECH NAME', $lang_file) ?></option>
                <?php
                // get Employees ID and Names
                $usersRows = $db_obj->select_specific_column("`UserID`, `UserName`", "`users`", "WHERE `isTech` = 1 AND `job_title_id` = 2 AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']));
                // check the length of result
                if (count($usersRows) > 0) {
                  // loop on result ..
                  foreach ($usersRows as $userRow) { ?>
                    <option value="<?php echo base64_encode($userRow['UserID']) ?>" <?php echo isset($_SESSION['request_data']) && base64_decode($_SESSION['request_data']['technical-id']) == $userRow['UserID'] ? 'selected' : '' ?>><?php echo $userRow['UserName']; ?></option>
                  <?php } ?>
                <?php } ?>
              </select>
              <label for="technical-id"><?php echo lang('TECH NAME', $lang_file) ?></label>
            </div>
          </div>
          <!-- beneficiary info -->
          <div class="section-block">
            <div class="section-header">
              <h5><?php echo lang('BENEFICIARY INFO', $lang_file) ?></h5>
              <hr />
            </div>
            <!-- client-nameme -->
            <div class="mb-3 form-floating">
              <input type="text" class="form-control" name="client-name" placeholder="<?php echo lang('BENEFICIARY NAME', $lang_file) ?>" value="<?php echo isset($_SESSION['request_data']) ? $_SESSION['request_data']['client-name'] : '' ?>" required onkeyup="fullname_validation(this, null, true);">
              <label for="client-name"><?php echo lang('BENEFICIARY NAME', $lang_file) ?></label>
            </div>
            <!-- phone -->
            <div class="mb-3 form-floating">
              <input type="text" name="client-phone" id="client-phone" class="form-control w-100" placeholder="<?php echo lang('PHONE', $lang_file) ?>" value="<?php echo isset($_SESSION['request_data']) ? $_SESSION['request_data']['client-phone'] : '' ?>" required />
              <label for="client-phone"><?php echo lang('PHONE', $lang_file) ?></label>
            </div>
            <!-- address -->
            <div class="mb-3 form-floating">
              <input type="text" name="client-address" id="client-address" class="form-control w-100" placeholder="<?php echo lang('ADDR', $lang_file) ?>" value="<?php echo isset($_SESSION['request_data']) ? $_SESSION['request_data']['client-address'] : '' ?>" required />
              <label for="client-address"><?php echo lang('ADDR', $lang_file) ?></label>
            </div>
            <!-- notes -->
            <div class="mb-3 form-floating">
              <textarea type="text" name="client-notes" id="client-notes" class="form-control w-100" style="resize: none;height:120px;" placeholder="<?php echo lang('NOTE') ?>" style="resize: none; direction: <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'rtl' : 'ltr' ?>" required><?php echo isset($_SESSION['request_data']) ? $_SESSION['request_data']['client-notes'] : '' ?></textarea>
              <label for="client-notes"><?php echo lang('NOTE') ?></label>
            </div>
          </div>
        </div>
        <!-- submit -->
        <div class="mt-3 hstack gap-2">
          <div class="<?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'me-auto' : 'ms-auto' ?>">
            <button type="button" form="add-new-combination" style="min-width: 150px" class="btn btn-primary text-capitalize form-control bg-gradient fs-12" id="add-combination" onclick="form_validation(this.form, 'submit')">
              <?php echo lang('ADD') ?>
            </button>
          </div>
        </div>
      </form>
      <!-- end form -->
    </div>
<?php
  } else {
    // prepare flash session variables
    $_SESSION['flash_message'] = '*TECH REQUIRED';
    $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
    $_SESSION['flash_message_class'] = 'danger';
    $_SESSION['flash_message_status'] = false;
    $_SESSION['flash_message_lang_file'] = 'global_';
    // redirect to the previous page
    redirect_home(null, 'back', 0);
  }
} else {
  // prepare flash session variables
  $_SESSION['flash_message'] = 'NO DATA';
  $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
  $_SESSION['flash_message_class'] = 'danger';
  $_SESSION['flash_message_status'] = false;
  $_SESSION['flash_message_lang_file'] = 'global_';
  // redirect to the previous page
  redirect_home(null, 'back', 0);
}

// remove previous data
if (isset($_SESSION['request_data']) && !empty($_SESSION['request_data'])) {
  unset($_SESSION['request_data']);
}
?>