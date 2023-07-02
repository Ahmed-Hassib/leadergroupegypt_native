<!-- start edit profile page -->
<div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
  <div class="mb-3 hstack gap-3">
    <?php if ($_SESSION['pcs_add'] == 1) { ?>
    <button type="button" class="btn btn-outline-primary py-1 fs-12" data-bs-toggle="modal" data-bs-target="#addNewDevice">
      <i class="bi bi-plus"></i>
      <?php echo language('ADD NEW DEVICE', @$_SESSION['systemLang']) ?>
    </button>
    <?php } ?>
  </div>
  <!-- add new device modal -->

  <?php 
  // get devices company id
  $dev_company_id = isset($_GET['dev-company-id']) && !empty($_GET['dev-company-id']) ? intval($_GET['dev-company-id']) : 0;
  if (!isset($dev_obj)) {
    // create an object of Devices class
    $dev_obj = new Devices();
  }
  // get company name
  @$dev_company_name = $dev_obj->select_specific_column("`man_company_name`", "`manufacture_companies`", "WHERE `man_company_id` = " . $dev_company_id)[0]['man_company_name'];
  // check if company is exit
  $is_exist = $dev_obj->is_exist("`man_company_id`", "`manufacture_companies`", $dev_company_id);
  // check the value
  if (!empty($dev_company_id) && $is_exist) {
    // get all devices of this company
    $devices = $dev_obj->get_all_company_devices($dev_company_id);
    // devices counter
    $devices_counter = $devices[0];
    // devices data
    $devices_data = $devices[1];
    // check the counter
    if ($devices_counter > 0) { ?>
      <!-- start company name displaying -->
      <div class="my-2 text-center">
        <h4 class="h4 mx-auto">
          <?php echo language('SHOW ALL DEVICES OF COMPANY', @$_SESSION['systemLang']) ?>
          <span>:&nbsp;</span>
          <span class="badge bg-primary"><?php echo $dev_company_name ?></span>
        </h4>
      </div>
      <!-- start company name displaying -->
      <!-- start table container -->
      <div class="table-responsive-sm w-100">
        <!-- strst users table -->
        <table class="table table-bordered display compact table-style w-100">
          <thead class="primary text-capitalize">
            <tr>
              <th>#</th>
              <th><?php echo language('DEVICE NAME', @$_SESSION['systemLang']) ?></th>
              <th><?php echo language('TOTAL MODELS', @$_SESSION['systemLang']) ?></th>
              <th><?php echo language('ADDED BY', @$_SESSION['systemLang']) ?></th>
              <th><?php echo language('ADDED DATE', @$_SESSION['systemLang']) ?></th>
              <th><?php echo language('CONTROL', @$_SESSION['systemLang']) ?></th>
            </tr>
          </thead>
          <tbody id="devices-info">
            <?php foreach ($devices_data as $key => $device) { ?>
              <tr>
                <td><?php echo ++$key ?></td>

                <!-- display company name -->
                <td><?php echo $device['device_name'] ?></td>

                <!-- display total number of models -->
                <td>
                  <?php echo $dev_obj->count_records("`model_id`", "`devices_model`", "WHERE `device_id` = " .  $device['device_id']) ?>
                </td>

                <!-- display added by account -->
                <td>
                  <?php 
                  // get username that add device
                  $added_by_name =  $dev_obj->select_specific_column("`UserName`", "`users`", "WHERE `UserID` = ". $device['added_by'])[0]['UserName']; 
                  // check permission
                  if ($_SESSION['user_update'] == 1) { ?> 
                      <a href="<?php echo $nav_up_level ?>users/index.php?do=edit-user-info&userid=<?php echo $device['added_by'] ?>"><?php echo $added_by_name ?></a>
                  <?php } else { ?> 
                      <span><?php echo $added_by_name ?></span>
                  <?php } ?>
                </td>

                <!-- display added date -->
                <td><?php echo $device['added_date'] ?></td>

                <!-- controls buttons -->
                <td>
                  <?php if ($_SESSION['pcs_update'] == 1) { ?>
                    <!-- edit button -->
                    <a class="btn btn-success text-capitalize fs-12" href="?do=devices-companies&action=show-device&device-id=<?php echo $device['device_id']; ?>" target=""><i class="bi bi-pencil-square"></i></a>
                  <?php } ?>
                  <!-- delete device info -->
                  <button type="button" class="btn btn-outline-danger text-capitalize bg-gradient fs-12 p-1" data-bs-toggle="modal" data-bs-target="#deleteDeviceModal" data-id="<?php echo $device['device_id'] ?>" data-name="<?php echo $device['device_name'] ?>" onclick="put_data_into_modal(this, 'delete', 'deleted-device-id', 'deleted-device-name', true);"><i class="bi bi-trash"></i></button>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    <?php 
    } else { 
      // include no data founded
      include_once $globmod . 'no-data-founded-no-redirect.php';
    }
  } else {
    // include no data founded
    include_once $globmod . 'no-data-founded.php';
    
  } ?>
</div>

<?php if ($_SESSION['pcs_add'] == 1) { include_once 'add-device-modal.php'; } # include add new device modal ?>
<?php if ($_SESSION['pcs_delete'] == 1) { include_once 'delete-device-modal.php'; } # include delete device model modal ?>
