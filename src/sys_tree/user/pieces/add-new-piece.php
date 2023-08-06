<!-- start add new user page -->
<div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
  <!-- start form -->
  <form class="custom-form" action="?name=<?php echo $page_title ?>&do=insert-piece-info" method="POST" id="addPiece"
    onchange="form_validation(this)">
    <?php if ($_SESSION['pcs_add'] == 1) { ?>
    <!-- submit -->
    <div class="hstack gap-3">
      <button type="button" form="addPiece"
        class="btn btn-primary text-capitalize bg-gradient fs-12 p-1 <?php echo @$_SESSION['systemLang'] == 'ar' ? 'me-auto' : 'ms-auto' ?>"
        id="add-piece-1" onclick="form_validation(this.form, 'submit')">
        <i class="bi bi-plus"></i>
        <?php echo language('ADD NEW PIECE', @$_SESSION['systemLang']); ?>
      </button>
    </div>
    <?php } ?>
    <!-- horzontal stack -->
    <div class="hstack gap-3">
      <h6 class="h6 text-decoration-underline text-capitalize text-danger fw-bold">
        <span><?php echo language('NOTE', @$_SESSION['systemLang']) ?>:</span>&nbsp;
        <span><?php echo language('THIS SIGN * IS REFERE TO REQUIRED FIELDS', @$_SESSION['systemLang']) ?></span>
      </h6>
    </div>
    <!-- start piece info -->
    <div class="mb-3 row row-cols-sm-1 row-cols-md-2 g-3 align-items-stretch justify-content-start">
      <!-- first column -->
      <div class="col-12">
        <div class="section-block">
          <div class="section-header">
            <h5><?php echo language('PIECE INFO', @$_SESSION['systemLang']); ?>
            </h5>
            <hr />
          </div>
          <!-- full name -->
          <div class="mb-sm-2 mb-md-3">
            <div class="form-floating">
              <input type="text" class="form-control" id="full-name" name="full-name"
                placeholder="<?php echo language('FULLNAME', @$_SESSION['systemLang']) ?>"
                onblur="fullname_validation(this)" autocomplete="off" required />
              <label for="full-name" class="text-capitalize">
                <?php echo language('PIECE NAME', @$_SESSION['systemLang']); ?>
              </label>
            </div>
          </div>

          <!-- address -->
          <div class="mb-sm-2 mb-md-3">
            <div class="form-floating">
              <input type="text" name="address" id="address" class="form-control w-100"
                placeholder="<?php echo language('THE ADDRESS', @$_SESSION['systemLang']) ?>" />
              <label for="address">
                <?php echo language('THE PROPERTY ADDRESS', @$_SESSION['systemLang']); ?>
              </label>
            </div>
          </div>

          <!-- phone -->
          <div class="mb-sm-2 mb-md-3">
            <div class="form-floating">
              <input type="text" name="phone-number" id="phone-number" class="form-control w-100"
                placeholder="<?php echo language('PHONE', @$_SESSION['systemLang']) ?>" />
              <label for="phone-number">
                <?php echo language('THE REAL ESTATE AGENT PHONE', @$_SESSION['systemLang']); ?>
              </label>
            </div>
          </div>

          <!-- is client -->
          <div class="mb-sm-2 mb-md-3 row">
            <label for="is-client"
              class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('THE TYPE', @$_SESSION['systemLang']) ?></label>
            <div class="mt-2 col-sm-12 col-md-8">
              <!-- TRANSMITTER -->
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="is-client" id="piece" value="1">
                <label class="form-check-label text-capitalize"
                  for="piece"><?php echo language('TRANSMITTER', @$_SESSION['systemLang']) ?></label>
              </div>
              <!-- RECEIVER -->
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="is-client" id="client" value="2">
                <label class="form-check-label text-capitalize"
                  for="client"><?php echo language('RECEIVER', @$_SESSION['systemLang']) ?></label>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- additional info -->
      <div class="col-12">
        <div class="section-block">
          <div class="section-header">
            <h5><?php echo language('ADDITIONAL INFO', @$_SESSION['systemLang']) ?></h5>
            <hr />
          </div>

          <!-- internet source -->
          <div class="mb-sm-2 mb-md-3">
            <div class="form-floating">
              <input type="text" name="internet-source" id="internet-source" class="form-control w-100"
                placeholder="<?php echo language('INTERNET SOURCE', @$_SESSION['systemLang']) ?>" />
              <label for="internet-source" class="col-sm-12 col-form-label text-capitalize">
                <?php echo language('INTERNET SOURCE', @$_SESSION['systemLang']); ?>
              </label>
            </div>
          </div>

          <!-- notes -->
          <div class="mb-sm-2 mb-md-3">
            <div class="form-floating">
              <textarea name="notes" id="notes" title="put some notes hete if exist" class="form-control w-100"
                style="height: 8rem; resize: none; direction: <?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>"
                placeholder="<?php echo language('PUT YOUR NOTES HERE', @$_SESSION['systemLang']) ?>"></textarea>
              <label for="notes"
                class="col-sm-12 col-form-label text-capitalize"><?php echo language('THE NOTES', @$_SESSION['systemLang']) ?></label>
            </div>
          </div>
          <!-- visit time -->
          <div class="mb-sm-2 mb-md-3 row">
            <label for="visit-time"
              class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('VISIT TIME', @$_SESSION['systemLang']) ?></label>
            <div class="mt-2 col-sm-12 col-md-8">
              <!-- ANY TIME -->
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="visit-time" id="visit-time-piece" value="1">
                <label class="form-check-label text-capitalize"
                  for="visit-time-piece"><?php echo language('ANY TIME', @$_SESSION['systemLang']) ?></label>
              </div>
              <!-- ADVANCE CONNECTION -->
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="visit-time" id="visit-time-client" value="2">
                <label class="form-check-label text-capitalize"
                  for="visit-time-client"><?php echo language('ADVANCE CONNECTION', @$_SESSION['systemLang']) ?></label>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- connection info -->
    <div class="mb-3 row row-cols-sm-1 g-3 align-items-stretch justify-content-start">
      <!-- first column -->
      <div class="col-12">
        <div class="section-block">
          <div class="section-header">
            <h5><?php echo language('CONNECTION INFO', @$_SESSION['systemLang']) ?></h5>
            <hr />
          </div>
          <div class="row row-cols-sm-1 row-cols-md-2 alignitems-stretch justify-content-start flex-row">
            <!-- first column -->
            <div class="col-12">
              <div class="row row-cols-sm-1">
                <!-- direction -->
                <div class="col-12">
                  <div class="mb-3 form-floating">
                    <select class="form-select" id="direction" name="direction" required
                      onchange="get_sources(this, <?php echo $_SESSION['company_id'] ?>, '<?php echo $dirs . $_SESSION['company_name'] ?>', ['sources', 'alternative-sources']);">
                      <?php
                        if (!isset($dir_obj)) {
                          // create an object of Direction class
                          $dir_obj = new Direction();
                        }
                        // get all directions
                        $dirs = $dir_obj->get_all_directions($_SESSION['company_id']);
                        // counter
                        $dirs_count = $dirs[0];
                        // directions data
                        $dir_data = $dirs[1];
                        // check the row dirs_count
                        if ($dirs_count > 0) { ?>
                      <option value="default" disabled selected>
                        <?php echo language('SELECT', @$_SESSION['systemLang'])." ". language('THE DIRECTION', @$_SESSION['systemLang']) ?>
                      </option>
                      <?php foreach ($dir_data as $dir) { ?>
                      <option value="<?php echo $dir['direction_id'] ?>"
                        data-dir-company="<?php echo $_SESSION['company_id'] ?>">
                        <?php echo  $dir['direction_name'] ?>
                      </option>
                      <?php } ?>
                      <?php } else { ?>
                      <option value="default" disabled selected>
                        <?php echo language('NOT AVAILABLE NOW', @$_SESSION['systemLang']) ?></option>';
                      <?php } ?>
                    </select>
                    <label for="direction"><?php echo language('THE DIRECTION', @$_SESSION['systemLang']) ?></label>
                  </div>
                </div>

                <!-- source -->
                <div class="col-12">
                  <div class="mb-3 form-floating">
                    <select class="form-select" id="sources" name="source-id" required>
                      <option value="default" selected disabled>
                        <?php echo language('SELECT', @$_SESSION['systemLang'])." ". language('THE SOURCE', @$_SESSION['systemLang']) ?>
                      </option>
                    </select>
                    <label for="sources"><?php echo language('THE SOURCE', @$_SESSION['systemLang']) ?></label>
                  </div>
                </div>

                <!-- alternative source -->
                <div class="col-12">
                  <div class="mb-3 form-floating">
                    <select class="form-select" id="alternative-sources" name="alt-source-id">
                      <option value="default" selected disabled>
                        <?php echo language('SELECT', @$_SESSION['systemLang'])." ". language('ALTERNATIVE SOURCE', @$_SESSION['systemLang']) ?>
                      </option>
                    </select>
                    <label
                      for="alternative-sources"><?php echo language('ALTERNATIVE SOURCE', @$_SESSION['systemLang']) ?></label>
                  </div>
                </div>
              </div>
            </div>

            <!-- second column -->
            <div class="col-12">
              <div class="row row-cols-sm-1">
                <!-- device type -->
                <div class="col-12">
                  <div class="mb-3 form-floating">
                    <?php
                      $dev_query = "SELECT `devices_info`.*, `manufacture_companies`.`company_id` FROM `devices_info` LEFT JOIN `manufacture_companies` ON `manufacture_companies`.`man_company_id` = `devices_info`.`device_company_id` WHERE `manufacture_companies`.`company_id` = ?;";
                      $stmt = $con->prepare($dev_query);
                      $stmt->execute(array($_SESSION['company_id']));
                      $devices_count = $stmt->rowCount();
                      $devices_data =  $stmt->fetchAll();
                      ?>
                    <select class="form-select" id="device-id" name="device-id"
                      onchange="get_devices_models(this, '<?php echo $dev_models . $_SESSION['company_name'] ?>')">
                      <?php if ($devices_count > 0) { ?>
                      <option value="default" disabled selected>
                        <?php echo language('SELECT', @$_SESSION['systemLang'])." ". language('DEVICE TYPE', @$_SESSION['systemLang']) ?>
                      </option>
                      <?php foreach ($devices_data as $device) { ?>
                      <option value="<?php echo $device['device_id'] ?>">
                        <?php echo $device['device_name'] ?>
                      </option>
                      <?php } ?>
                      <?php } else { ?>
                      <option value="default" disabled selected>
                        <?php echo language('NOT AVAILABLE NOW', @$_SESSION['systemLang']) ?></option>';
                      <?php } ?>
                    </select>
                    <?php if ($devices_count == 0) {  ?>
                    <div id="emailHelp" class="form-text text-danger">
                      <?php echo language('THERE IS NO DEVICES TO SELECT PLEASE ADD SOME DEVICES', @$_SESSION['systemLang']) ?>
                    </div>
                    <?php } ?>
                    <label for="device-id"><?php echo language('DEVICE TYPE', @$_SESSION['systemLang']) ?></label>
                  </div>
                </div>

                <!-- device model -->
                <div class="col-12">
                  <div class="mb-3 form-floating">
                    <select class="form-select" name="device-model" id="device-model">
                      <option value="default" disabled selected>
                        <?php echo language('SELECT', @$_SESSION['systemLang'])." ". language('DEVICE MODEL', @$_SESSION['systemLang']) ?>
                      </option>
                    </select>
                    <label for="device-model"><?php echo language('DEVICE MODEL', @$_SESSION['systemLang']) ?></label>
                  </div>
                </div>

                <!-- connection type -->
                <div class="col-12">
                  <div class="mb-3 form-floating">
                    <?php $conn_type_data = $db_obj->select_specific_column("*", "`connection_types`", "WHERE `company_id` = ".$_SESSION['company_id']); ?>
                    <select class="form-select text-uppercase" name="conn-type" id="conn-type">
                      <option value="default" selected disabled>
                        <?php echo language('SELECT', @$_SESSION['systemLang'])." ". language('CONNECTION TYPE', @$_SESSION['systemLang']) ?>
                      </option>
                      <?php if (count($conn_type_data) > 0) { ?>
                      <?php foreach ($conn_type_data as $conn_type_row) { ?>
                      <option value='<?php echo $conn_type_row['id'] ?>'>
                        <?php echo $conn_type_row['connection_name'] ?>
                      </option>
                      <?php } ?>
                      <?php } else { ?>
                      <option value="default" disabled selected>
                        <?php echo language('NOT AVAILABLE NOW', @$_SESSION['systemLang']) ?></option>';
                      <?php } ?>
                    </select>
                    <label for="conn-type"><?php echo language('CONNECTION TYPE', @$_SESSION['systemLang']) ?></label>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- second column -->
      <div class="col-12">
        <div class="section-block">
          <div class="section-header">
            <h5><?php echo language('PIECE INFO', @$_SESSION['systemLang']) ?></h5>
            <hr />
          </div>
          <div class="row row-cols-sm-1 row-cols-md-2 align-items-stretch justify-content-start">
            <!-- first column -->
            <div class="col-12">
              <div class="row row-cols-sm-1 align-items-stretch justify-content-start">
                <!-- IP -->
                <div class="col-12">
                  <div class="mb-sm-2 mb-md-3 row">
                    <div class="col-sm-8">
                      <div class="form-floating">
                        <input type="text" class="form-control" id="ip" name="ip" placeholder="xxx.xxx.xxx.xxx"
                          autocomplete="off" required />
                        <label for="ip"><span
                            class="text-uppercase"><?php echo language('IP', @$_SESSION['systemLang']) ?></span></label>
                      </div>
                    </div>
                    <div class="col-sm-4 position-relative">
                      <div class="form-floating">
                        <input type="text" class="form-control" id="port" name="port" placeholder="port"
                          autocomplete="off" required />
                        <label for="port">Port</label>
                      </div>
                    </div>
                    <div id="ipHelp" class="form-text text-warning">
                      <?php echo language('IF PIECE/CLIENT NOT HAVE AN IP PRESS 0.0.0.0', @$_SESSION['systemLang']) ?>
                    </div>
                  </div>
                </div>

                <!-- MAC ADD -->
                <div class="col-12">
                  <div class="mb-3 form-floating">
                    <label for="mac-add"><?php echo language('MAC ADD', @$_SESSION['systemLang']) ?></label>
                    <input type="text" class="form-control" id="mac-add" name="mac-add" onblur="mac_validation(this)"
                      placeholder="<?php echo language('MAC ADD', @$_SESSION['systemLang']) ?>" />
                  </div>
                </div>

                <!-- user name -->
                <div class="col-12">
                  <div class="mb-3 form-floating">
                    <input type="text" class="form-control" id="user-name" name="user-name"
                      placeholder="<?php echo language('USERNAME', @$_SESSION['systemLang']) ?>" autocomplete="off"
                      required />
                    <label for="user-name"><?php echo language('USERNAME', @$_SESSION['systemLang']) ?></label>
                  </div>
                </div>

                <!-- password -->
                <div class="col-12">
                  <div class="mb-3 form-floating">
                    <input type="password" class="form-control" id="password" name="password"
                      placeholder="<?php echo language('PASSWORD', @$_SESSION['systemLang']) ?>" autocomplete="off"
                      required />
                    <i class="bi bi-eye-slash show-pass <?php echo @$_SESSION['systemLang'] == 'ar' ? 'show-pass-left' : 'show-pass-right' ?>"
                      onclick="show_pass(this)"></i>
                    <label for="password"><?php echo language('PASSWORD', @$_SESSION['systemLang']) ?></label>
                    <div id="passHelp" class="form-text text-warning ">
                      <?php echo language('DON`T SHARE THIS PASSWORD WITH ANYONE', @$_SESSION['systemLang']) ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- second column -->
            <div class="col-12">
              <div class="row row-cols-sm-1">
                <!-- password-connection -->
                <div class="col-12">
                  <div class="mb-3 form-floating">
                    <input type="password" class="form-control" id="password-connection" name="password-connection"
                      placeholder="<?php echo language('PASSWORD CONNECTION', @$_SESSION['systemLang']) ?>" />
                    <i class="bi bi-eye-slash show-pass <?php echo @$_SESSION['systemLang'] == 'ar' ? 'show-pass-left' : 'show-pass-right' ?>"
                      onclick="show_pass(this)"></i>
                    <label
                      for="password-connection"><?php echo language('PASSWORD CONNECTION', @$_SESSION['systemLang']) ?></label>
                    <div id="passHelp" class="form-text text-warning ">
                      <?php echo language('DON`T SHARE THIS PASSWORD WITH ANYONE', @$_SESSION['systemLang']) ?>
                    </div>
                  </div>
                </div>
                <!-- ssid -->
                <div class="col-12">
                  <div class="mb-3 form-floating">
                    <input type="text" class="form-control" id="ssid" name="ssid"
                      placeholder="<?php echo language('SSID', @$_SESSION['systemLang']) ?>" />
                    <label for="ssid"><?php echo language('SSID', @$_SESSION['systemLang']) ?></label>
                  </div>
                </div>
                <!-- frequency -->
                <div class="col-12">
                  <div class="mb-3 form-floating">
                    <input type="text" class="form-control" id="frequency" name="frequency"
                      placeholder="<?php echo language('FREQUENCY', @$_SESSION['systemLang']) ?>"
                      onkeyup="integer_input_validation(this)" />
                    <label for="frequency"><?php echo language('FREQUENCY', @$_SESSION['systemLang']) ?></label>
                  </div>
                </div>
                <!-- wave -->
                <div class="col-12">
                  <div class="mb-3 form-floating">
                    <input type="text" class="form-control" id="wave" name="wave"
                      placeholder="<?php echo language('THE WAVE', @$_SESSION['systemLang']) ?>"
                      onkeyup="integer_input_validation(this)" />
                    <label for="wave"><?php echo language('THE WAVE', @$_SESSION['systemLang']) ?></label>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php if ($_SESSION['pcs_add'] == 1) { ?>
    <!-- submit -->
    <div class="hstack gap-3">
      <button type="button" form="addPiece"
        class="btn btn-primary text-capitalize bg-gradient fs-12 p-1 <?php echo @$_SESSION['systemLang'] == 'ar' ? 'me-auto' : 'ms-auto' ?>"
        id="add-piece-2" onclick="form_validation(this.form, 'submit')">
        <i class="bi bi-plus"></i>
        <?php echo language('ADD NEW PIECE', @$_SESSION['systemLang']); ?>
      </button>
    </div>
    <?php } ?>
  </form>
  <!-- end form -->
</div>