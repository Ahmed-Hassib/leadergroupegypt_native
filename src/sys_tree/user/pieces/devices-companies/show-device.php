<!-- start edit profile page -->
<div class="container" dir="<?php echo $page_dir ?>">
  <div class="mb-3 hstack gap-3">
    <?php if ($_SESSION['sys']['pcs_add'] == 1) { ?>
      <button type="button" class="btn btn-outline-primary py-1 fs-12" data-bs-toggle="modal" data-bs-target="#addNewDeviceModel">
        <i class="bi bi-plus"></i>
        <?php echo lang('ADD MODEL', $lang_file) ?>
      </button>
    <?php } ?>
  </div>
  <!-- add new device model -->
  <?php
  // create an object of Devices class
  $dev_obj = !isset($dev_obj) ? new Devices() : $dev_obj;
  // get device id
  $device_id = isset($_GET['device-id']) && !empty($_GET['device-id']) ? base64_decode($_GET['device-id']) : 0;
  // check if company is exit
  $is_exist = $dev_obj->is_exist("`device_id`", "`devices_info`", $device_id);
  // check the value
  if (!empty($device_id) && $is_exist) {
    // get all info about given device id
    $device_info = $dev_obj->get_device_info($device_id);
    // device_info counter
    $device_counter = $device_info[0];
    // device_info data
    $device_data = $device_info[1];
    // check the counter
    if ($device_counter > 0) { ?>
      <!-- start form -->
      <form class="mb-3 custom-form need-validation" action="?do=devices-companies&action=update-device" method="POST" id="editDeviceInfo">
        <!-- horzontal stack -->
        <div class="hstack gap-3">
          <h6 class="h6 text-decoration-underline text-capitalize text-danger fw-bold">
            <span><?php echo lang('*REQUIRED') ?></span>
          </h6>
        </div>
        <!-- start piece info -->
        <div class="mb-3 row row-cols-sm-1 row-cols-md-2 g-3 align-items-stretch justify-content-start">
          <!-- first column -->
          <div class="col-12">
            <div class="section-block">
              <div class="section-header">
                <h5><?php echo lang('COMPANY INFO', $lang_file) ?></h5>
                <hr />
              </div>
              <!-- device id -->
              <input type="hidden" class="form-control" id="device-id" name="device-id" value="<?php echo base64_encode($device_data['device_id']); ?>" placeholder="ID" autocomplete="off" />
              <!-- manufacture company name -->
              <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                <select class="form-select" id="manufacture-company-id" name="manufacture-company-id" required>
                  <?php
                  // get all manufucture companies
                  $man_companies = $dev_obj->select_specific_column("*", "`manufacture_companies`", "WHERE `company_id` = " . base64_decode($_SESSION['sys']['company_id']));
                  // data counter
                  $companies_counter = count($man_companies);
                  // check the return value
                  if ($companies_counter > 0) {
                    // companies data
                    $companies_data = $man_companies;
                    // loop on companies
                  ?>
                    <option value="default" selected disabled><?php echo lang('SELECT MAN COMPANY', $lang_file) ?></option>
                    <?php foreach ($companies_data as $key => $company) { ?>
                      <option value="<?php echo base64_encode($company['man_company_id']) ?>" <?php echo $company['man_company_id'] ==  $device_data['device_company_id'] ? 'selected' : '' ?>><?php echo $company['man_company_name'] ?></option>
                    <?php } ?>
                  <?php } ?>
                </select>
                <label for="manufacture-company-id"><?php echo lang('COMPANY NAME', $lang_file) ?></label>
              </div>
            </div>
          </div>
          <!-- second column -->
          <div class="col-12">
            <div class="section-block">
              <div class="section-header">
                <h5><?php echo lang('DEV INFO', $lang_file) ?></h5>
                <hr />
              </div>
              <!-- manufacture company name -->
              <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                <input type="text" class="form-control" id="device-name" name="device-name" value="<?php echo $device_data['device_name']; ?>" placeholder="<?php echo lang('DEVICE NAME', $lang_file) ?>" autocomplete="off" required />
                <label for="device-name"><?php echo lang('DEVICE NAME', $lang_file) ?></label>
              </div>
            </div>
          </div>
        </div>

        <!-- submit -->
        <div class="hstack gap-2">
          <?php if ($_SESSION['sys']['pcs_add'] == 1) { ?>
            <!-- save changes button -->
            <button type="button" form="editDeviceInfo" class="btn btn-primary text-capitalize bg-gradient fs-12 p-1 <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'me-auto' : 'ms-auto' ?>" id="edit-device-info" onclick="form_validation(this.form, 'submit')">
              <i class="bi bi-check-all"></i>
              <?php echo lang('SAVE'); ?>
            </button>
          <?php } ?>
          <!-- delete device info -->
          <button type="button" class="btn btn-outline-danger text-capitalize bg-gradient fs-12 p-1" data-bs-toggle="modal" data-bs-target="#deleteDeviceModal" data-id="<?php echo $device_data['device_id'] ?>" data-name="<?php echo $device_data['device_name'] ?>" onclick="put_data_into_modal(this, 'delete', 'deleted-device-id', 'deleted-device-name');">
            <i class="bi bi-trash"></i>
            <?php echo lang("DELETE DEVICE INFO", $lang_file) ?>
          </button>
        </div>
      </form>
      <!-- end form -->

      <?php
      // get all devices companies data
      $device_models = $dev_obj->get_all_device_models($device_data['device_id']);
      // get counter
      $device_models_counter = $device_models[0];
      // get companies data
      $device_models_data = $device_models[1];

      ?>
      <!-- start piece info -->
      <div class="mb-3 row row-cols-sm-1 g-3 align-items-stretch justify-content-start">
        <!-- first column -->
        <div class="col-12">
          <div class="section-block">
            <div class="section-header">
              <h5><?php echo lang('DEV MODELS', $lang_file) ?></h5>
              <hr>
            </div>
            <?php if ($device_models_counter > 0) { ?>
              <!-- start table container -->
              <div class="table-responsive-sm w-100">
                <!-- strst users table -->
                <table class="table table-bordered display compact table-style w-100">
                  <thead class="primary text-capitalize">
                    <tr>
                      <!-- <th style="width: 10px !important;"></th> -->
                      <th>#</th>
                      <th><?php echo lang('MODEL NAME', $lang_file) ?></th>
                      <th><?php echo lang('ADDED BY') ?></th>
                      <th><?php echo lang('ADDED DATE') ?></th>
                      <th><?php echo lang('CONTROL') ?></th>
                    </tr>
                  </thead>
                  <tbody id="devices-companies">
                    <?php foreach ($device_models_data as $key => $model) { ?>
                      <tr>
                        <!-- <td><input type="checkbox" name="id[]" id="check-<?php echo $key ?>"></td> -->
                        <td><?php echo ++$key ?></td>
                        <!-- device`s model name -->
                        <td><?php echo $model['model_name'] ?></td>
                        <!-- added by -->
                        <td>
                          <?php
                          // get username that add model
                          $added_by_name =  $dev_obj->select_specific_column("`UserName`", "`users`", "WHERE `UserID` = " . $model['added_by'])[0]['UserName'];
                          // check permission
                          if ($_SESSION['sys']['user_update'] == 1) { ?>
                            <a href="<?php echo $nav_up_level ?>users/index.php?do=edit-user-info&userid=<?php echo base64_encode($model['added_by']) ?>"><?php echo $added_by_name ?></a>
                          <?php } else { ?>
                            <span><?php echo $added_by_name ?></span>
                          <?php } ?>
                        </td>
                        <!-- added date -->
                        <td><?php echo $model['added_date'] ?></td>
                        <!-- control buttons -->
                        <td>
                          <!-- edit button -->
                          <button type="button" class="btn btn-outline-success py-1 fs-12" data-bs-toggle="modal" data-bs-target="#editDeviceModel" data-name="<?php echo $model['model_name'] ?>" data-id="<?php echo base64_encode($model['model_id']) ?>" onclick="put_data_into_modal(this, 'edit', 'model-id', 'old-model-name')"><i class="bi bi-pencil-square"></i></button>
                          <!-- edit button -->
                          <button type="button" class="btn btn-outline-danger py-1 fs-12" data-bs-toggle="modal" data-bs-target="#deleteDeviceModel" data-name="<?php echo $model['model_name'] ?>" data-id="<?php echo base64_encode($model['model_id']) ?>" onclick="put_data_into_modal(this, 'delete', 'deleted-model-id', 'deleted-model-name')"><i class="bi bi-trash"></i></button>
                        </td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            <?php } else {
              // include no data founded
              include_once $globmod . 'no-data-founded-no-redirect.php';
            } ?>
          </div>
        </div>
      </div>
  <?php
    } else {
      // include no data founded
      include_once $globmod . 'no-data-founded-no-redirect.php';
    }
  } else {
    // include page not founded module
    include_once $globmod . 'no-data-founded-no-redirect.php';
  } ?>
</div>

<!-- include add new model modal -->
<?php include_once 'devices-companies/add-model-modal.php'; ?>
<!-- include delete device modal -->
<?php include_once 'devices-companies/delete-device-modal.php'; ?>
<!-- include edit device model modal -->
<?php include_once 'devices-companies/edit-model-modal.php'; ?>
<!-- include delete device model modal -->
<?php include_once 'devices-companies/delete-model-modal.php'; ?>