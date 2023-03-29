<?php
// get piece id from $_GET variable
$piece_id = isset($_GET['piece-id']) && !empty($_GET['piece-id']) ? $_GET['piece-id'] : 0;
// create an object of Pieces class
$pcs_obj = new Pieces();
// check piece id 
$is_exist_id = $pcs_obj->is_exist("`id`", "`pieces_info`", $piece_id);
// get piece or client info
$piece_info = $pcs_obj->get_spec_piece($piece_id);
// get boolean value of piece data is exist
$is_exist_data = $piece_info[0];
// condition
if ($piece_id != 0 && $is_exist_id && $is_exist_data) {
  // get all data of givin piece id
  $piece_data = $piece_info[1];
?>
  <!-- start add new user page -->
  <div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
    <!-- start form -->
    <form class="custom-form need-validation" action="?name=<?php echo $page_title ?>&do=update-piece-info" method="POST" id="update-piece-info" onchange="form_validation(this)">
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
              <h5><?php echo language('PERSONAL INFO', @$_SESSION['systemLang']) ?></h5>
              <hr />
            </div>
            <!-- piece id -->
            <input type="hidden" name="piece-id" id="piece-id" value="<?php echo $piece_data['id'] ?>">
            <!-- full name -->
            <div class="mb-sm-2 mb-md-3 row">
              <label for="full-name" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('FULLNAME', @$_SESSION['systemLang']) ?></label>
              <div class="col-sm-12 col-md-8">
                <input type="text" class="form-control" id="full-name" name="full-name" placeholder="<?php echo language('FULLNAME', @$_SESSION['systemLang']) ?>" onkeyup="fullname_validation(this, <?php echo $piece_data['id'] ?>)" value="<?php echo $piece_data['full_name'] ?>" autocomplete="off" required />
              </div>
            </div>

            <!-- address -->
            <div class="mb-sm-2 mb-md-3 row">
              <label for="address" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('THE ADDRESS', @$_SESSION['systemLang']) ?></label>
              <div class="col-sm-12 col-md-8">
                <input type="text" name="address" id="address" class="form-control w-100" value="<?php echo $piece_data['address'] ?>" placeholder="<?php echo language('THE ADDRESS', @$_SESSION['systemLang']) ?>" />
              </div>
            </div>

            <!-- phone -->
            <div class="mb-sm-2 mb-md-3 row">
              <label for="phone-number" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('PHONE', @$_SESSION['systemLang']) ?></label>
              <div class="col-sm-12 col-md-8">
                <input type="text" name="phone-number" id="phone-number" class="form-control w-100" placeholder="<?php echo language('PHONE', @$_SESSION['systemLang']) ?>" value="<?php echo $piece_data['phone'] ?>" />
              </div>
            </div>

            <!-- is client -->
            <div class="mb-sm-2 mb-md-3 row">
              <label for="is-client" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('THE TYPE', @$_SESSION['systemLang']) ?></label>
              <div class="mt-2 col-sm-12 col-md-8">
                <?php if ($page_title == 'pieces') { ?>
                  <!-- TRANSMITTER -->
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="is-client" id="piece" value="1" <?php echo $piece_data['is_client'] == 0 && $piece_data['device_type'] == 1 ? 'checked' : '' ?>>
                    <label class="form-check-label text-capitalize" for="piece"><?php echo language('TRANSMITTER', @$_SESSION['systemLang']) ?></label>
                  </div>
                  <!-- RECEIVER -->
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="is-client" id="client" value="2" <?php echo $piece_data['is_client'] == 0 && $piece_data['device_type'] == 2 ? 'checked' : '' ?>>
                    <label class="form-check-label text-capitalize" for="client"><?php echo language('RECEIVER', @$_SESSION['systemLang']) ?></label>
                  </div>
                <?php } elseif ($page_title == 'clients') { ?>
                  <!-- CLIENT -->
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="is-client" id="client" value="0" <?php echo $piece_data['is_client'] == 1 ? 'checked' : '' ?>>
                    <label class="form-check-label text-capitalize" for="client"><?php echo language('CLIENT', @$_SESSION['systemLang']) ?></label>
                  </div>
                <?php } ?>
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
            <!-- notes -->
            <div class="mb-3 row">
              <label for="notes" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('THE NOTES', @$_SESSION['systemLang']) ?></label>
              <div class="col-sm-12 col-md-8">
                <textarea name="notes" id="notes" title="put some notes hete if exist" class="form-control w-100" style="height: 10rem; resize: none; direction: <?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>" placeholder="<?php echo language('PUT YOUR NOTES HERE', @$_SESSION['systemLang']) ?>"><?php echo $piece_data['notes']  ?></textarea>
              </div>
            </div>
            <!-- malfunctions counter -->
            <?php $malCounter = countRecords("`mal_id`", "`malfunctions`", "WHERE `client_id` = ".$piece_data['id']) ?>
            <div class="mb-3 row">
              <label for="malfunction-counter" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('MALFUNCTIONS COUNTER', @$_SESSION['systemLang']) ?></label>
              <div class="col-sm-12 col-md-8">
                <span class="mt-2 me-5 text-start" dir="<?php echo @$_SESSION['systemLang'] == "ar" ? "rtl" : "ltr" ?>"><?php echo $malCounter . " " . ($malCounter > 2 ? language("MALFUNCTIONS", @$_SESSION['systemLang']) : language("MALFUNCTION", @$_SESSION['systemLang'])) ?></span>
                <a href="<?php echo $nav_up_level ?>malfunctions/index.php?do=show-pieces-malfunctions&pieceid=<?php echo $piece_data['id'] ?>" class="mt-2 text-start" dir="<?php echo @$_SESSION['systemLang'] == "ar" ? "rtl" : "ltr" ?>"><?php echo language("SHOW DETAILS", @$_SESSION['systemLang']) ?></a>
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
                    <div class="mb-sm-2 mb-md-3 row">
                      <label for="direction" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('THE DIRECTION', @$_SESSION['systemLang']) ?></label>
                      <div class="col-sm-12 col-md-8">
                        <select class="form-select" id="direction" name="direction" required onchange="get_sources(this, <?php echo $_SESSION['company_id'] ?>, '<?php echo $dirs . $_SESSION['company_name'] ?>', ['sources', 'alternative-sources']);">
                          <?php
                          // create an object of Direction class
                          $dir_obj = new Direction();
                          // get all directions
                          $dirs = $dir_obj->get_all_directions($_SESSION['company_id']);
                          // counter
                          $dirs_count = $dirs[0];
                          // directions data
                          $dir_data = $dirs[1];
                          // check the row dirs_count
                          if ($dirs_count > 0) { ?>
                            <option value="default" disabled selected><?php echo language('SELECT', @$_SESSION['systemLang'])." ". language('THE DIRECTION', @$_SESSION['systemLang']) ?></option>
                            <?php foreach ($dir_data as $dir) { ?>
                              <option value="<?php echo $dir['direction_id'] ?>" data-dir-company="<?php echo $_SESSION['company_id'] ?>" <?php echo $piece_data['direction_id'] == $dir['direction_id'] ? 'selected' : ''  ?>>
                                <?php echo  $dir['direction_name'] ?>
                              </option>
                            <?php } ?>
                          <?php } else { ?>
                            <option value="default" disabled selected><?php echo language('NOT AVAILABLE NOW', @$_SESSION['systemLang']) ?></option>';
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                  </div>

                  <!-- source -->
                  <div class="col-12">
                    <div class="mb-3 row">
                      <label for="sources" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('THE SOURCE', @$_SESSION['systemLang']) ?></label>
                      <div class="col-sm-12 col-md-8">
                        <select class="form-select" id="sources" name="source-id" required>
                          <?php
                          $sources = $dir_obj->get_direction_sources($piece_data['direction_id'], $_SESSION['company_id']);
                          // counter
                          $sources_count = $sources[0];
                          // directions data
                          $sources_data = $sources[1];
                          // check the row sources_count
                          if ($sources_count) { ?>
                            <option value="default" disabled selected><?php echo language('SELECT', @$_SESSION['systemLang'])." ". language('THE SOURCE', @$_SESSION['systemLang']) ?></option>
                            <?php foreach ($sources_data as $source) { ?>
                              <option value="<?php echo $source['id'] ?>" <?php echo $piece_data['source_id'] == $source['id'] || ($piece_data['source_id'] == 0 && $piece_data['ip'] == $source['ip']) ? 'selected' : ''  ?>>
                                <?php echo  $source['full_name'] . " - " . $source['ip'] ?>
                              </option>
                            <?php } ?>
                          <?php } else { ?>
                            <option value="default" disabled selected><?php echo language('NOT AVAILABLE NOW', @$_SESSION['systemLang']) ?></option>';
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                  </div>

                  <!-- alternative source -->
                  <div class="col-12">
                    <div class="mb-3 row">
                      <label for="alternative-sources" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('ALTERNATIVE SOURCE', @$_SESSION['systemLang']) ?></label>
                      <div class="col-sm-12 col-md-8">
                        <select class="form-select" id="alternative-sources" name="alt-source-id">
                          <?php if ($sources_count) { ?>
                            <option value="default" selected disabled><?php echo language('SELECT', @$_SESSION['systemLang'])." ". language('ALTERNATIVE SOURCE', @$_SESSION['systemLang']) ?></option>
                            <?php foreach ($sources_data as $alt_source) { ?>
                              <option value="<?php echo $alt_source['id'] ?>" <?php echo $piece_data['alt_source_id'] == $alt_source['id'] || ($piece_data['alt_source_id'] == 0 && $piece_data['ip'] == $alt_source['ip']) ? 'selected' : ''  ?>>
                                <?php echo  $alt_source['full_name'] . " - " . $alt_source['ip'] ?>
                              </option>
                            <?php } ?>
                          <?php } else { ?>
                            <option value="default" disabled selected><?php echo language('NOT AVAILABLE NOW', @$_SESSION['systemLang']) ?></option>';
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- second column -->
              <div class="col-12">
                <div class="row row-cols-sm-1">
                  <!-- device type -->
                  <div class="col-12">
                    <div class="mb-sm-2 mb-md-3 row">
                      <label for="device-id" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('DEVICE TYPE', @$_SESSION['systemLang']) ?></label>
                      <div class="col-sm-12 col-md-8">
                        <?php
                          $dev_query = "SELECT `devices_info`.*, `manufacture_companies`.`company_id` FROM `devices_info` LEFT JOIN `manufacture_companies` ON `manufacture_companies`.`man_company_id` = `devices_info`.`device_company_id` WHERE `manufacture_companies`.`company_id` = ?;";
                          $stmt = $con->prepare($dev_query);
                          $stmt->execute(array($_SESSION['company_id']));
                          $devices_count = $stmt->rowCount();
                          $devices_data =  $stmt->fetchAll();
                          ?>
                        <select class="form-select" id="device-id" name="device-id" onchange="get_devices_models(this, '<?php echo $dev_models . $_SESSION['company_name'] ?>')">
                          <?php
                          // check the row devices_count
                          if ($devices_count > 0) { 
                          ?>
                            <option value="default" disabled selected><?php echo language('SELECT', @$_SESSION['systemLang'])." ". language('DEVICE TYPE', @$_SESSION['systemLang']) ?></option>
                            <?php foreach ($devices_data as $device) { ?>
                                <option value="<?php echo $device['device_id'] ?>" <?php echo $piece_data['device_id'] == $device['device_id'] ? 'selected' : '' ?>>
                                    <?php echo $device['device_name'] ?>
                                </option>
                            <?php } ?>
                          <?php } else { ?>
                            <option value="default" disabled selected><?php echo language('NOT AVAILABLE NOW', @$_SESSION['systemLang']) ?></option>';
                          <?php } ?>
                        </select>
                        <?php if ($devices_count == 0) {  ?>
                          <div id="emailHelp" class="form-text text-danger"><?php echo language('THERE IS NO DEVICES TO SELECT PLEASE ADD SOME DEVICES', @$_SESSION['systemLang']) ?></div>
                        <?php } ?>
                      </div>
                    </div>
                  </div>

                  <!-- device model -->
                  <div class="col-12">
                    <div class="mb-3 row">
                      <?php
                      // get all pieces devices_model
                      $model_query = "SELECT *FROM `devices_model` WHERE `device_id` = ?";
                      $stmt = $con->prepare($model_query);
                      $stmt->execute(array($piece_data['device_id']));
                      $model_count = $stmt->rowCount();
                      $models_data =  $stmt->fetchAll();
                      ?>
                      <label for="device-model" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('DEVICE MODEL', @$_SESSION['systemLang']) ?></label>
                      <div class="mt-1 col-sm-12 col-md-8">
                        <select class="form-select" name="device-model" id="device-model">
                          <?php if ($model_count > 0) { ?>
                          <option value="default" disabled selected><?php echo language('SELECT', @$_SESSION['systemLang'])." ". language('DEVICE MODEL', @$_SESSION['systemLang']) ?></option>
                            <?php foreach ($models_data as $model) { ?>
                                <option value="<?php echo $model['model_id'] ?>" <?php echo $piece_data['device_model'] == $model['model_id'] ? 'selected' : '' ?>>
                                    <?php echo $model['model_name'] ?>
                                </option>
                            <?php } ?>
                          <?php } else { ?>
                            <option value="default" disabled selected><?php echo language('NOT AVAILABLE NOW', @$_SESSION['systemLang']) ?></option>';
                          <?php } ?>
                        </select>
                        <?php if ($model_count == 0 && $piece_data['device_model'] > 0) {  ?>
                          <div id="emailHelp" class="form-text text-danger"><?php echo language('THERE IS NO MODELS TO SELECT PLEASE ADD SOME DEVICES MODELS', @$_SESSION['systemLang']) ?></div>
                        <?php } ?>
                      </div>
                    </div>
                  </div>


                  <!-- connection type -->
                  <div class="col-12">
                    <div class="mb-sm-2 mb-md-3 row">
                      <label for="conn-type" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('CONNECTION TYPE', @$_SESSION['systemLang']) ?></label>
                      <div class="col-sm-12 col-md-8">
                        <?php $conn_type_data = $db_obj->select_specific_column("*", "`connection_types`", "WHERE `company_id` = ".$_SESSION['company_id']); ?>
                        <select class="form-select text-uppercase" name="conn-type" id="conn-type">
                          <option value="default" selected disabled><?php echo language('SELECT', @$_SESSION['systemLang'])." ". language('CONNECTION TYPE', @$_SESSION['systemLang']) ?></option>
                          <?php if (count($conn_type_data) > 0) { ?>
                            <?php foreach ($conn_type_data as $conn_type_row) { ?>
                              <option value="<?php echo $conn_type_row['id'] ?>" <?php echo $piece_data['connection_type'] == $conn_type_row['id'] ? 'selected' : '' ?>>
                                <?php echo $conn_type_row['connection_name'] ?>
                              </option>
                            <?php } ?>
                          <?php } else { ?>
                            <option value="default" disabled selected><?php echo language('NOT AVAILABLE NOW', @$_SESSION['systemLang']) ?></option>';
                          <?php } ?>
                        </select>
                      </div>
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
                      <label for="ip" class="col-sm-12 col-md-4 col-form-label"><span class="text-uppercase"><?php echo language('IP', @$_SESSION['systemLang']) ?></span></label>
                      <div class="col-sm-12 col-md-8">
                        <input type="text" class="form-control" id="ip" name="ip" placeholder="xxx.xxx.xxx.xxx" onkeyup="ip_validation(this, <?php echo $piece_data['id'] ?>)" value="<?php echo $piece_data['ip'] ?>" autocomplete="off" required />
                        <div id="ipHelp" class="form-text text-warning"><?php echo language('IF PIECE/CLIENT NOT HAVE AN IP PRESS 0.0.0.0', @$_SESSION['systemLang']) ?></div>
                      </div>
                    </div>
                  </div>

                  <!-- MAC ADD -->
                  <div class="col-12">
                    <div class="mb-sm-2 mb-md-3 row">
                      <label for="mac-add" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('MAC ADD', @$_SESSION['systemLang']) ?></label>
                      <div class="col-sm-12 col-md-8">
                        <input type="text" class="form-control" id="mac-add" name="mac-add" onkeyup="mac_validation(this, <?php echo $piece_data['id'] ?>)" placeholder="<?php echo language('MAC ADD', @$_SESSION['systemLang']) ?>" value="<?php echo $piece_data['mac_add'] ?>" />
                      </div>
                    </div>
                  </div>

                  <!-- user name -->
                  <div class="col-12">
                    <div class="mb-sm-2 mb-md-3 row">
                      <label for="user-name" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('USERNAME', @$_SESSION['systemLang']) ?></label>
                      <div class="col-sm-12 col-md-8">
                        <input type="text" class="form-control" id="user-name" name="user-name" placeholder="<?php echo language('USERNAME', @$_SESSION['systemLang']) ?>" value="<?php echo $piece_data['username'] ?>" autocomplete="off" required />
                      </div>
                    </div>
                  </div>

                  <!-- password -->
                  <div class="col-12">
                    <div class="mb-sm-2 mb-md-3 row">
                      <label for="password" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('PASSWORD', @$_SESSION['systemLang']) ?></label>
                      <div class="col-sm-12 col-md-8">
                        <input type="text" class="form-control" id="password" name="password" placeholder="<?php echo language('PASSWORD', @$_SESSION['systemLang']) ?>" value="<?php echo $piece_data['password'] ?>" autocomplete="off" required />
                        <div id="passHelp" class="form-text text-warning "><?php echo language('DON`T SHARE THIS PASSWORD WITH ANYONE', @$_SESSION['systemLang']) ?></div>
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
                    <div class="mb-sm-2 mb-md-3 row">
                      <label for="password-connection" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('PASSWORD CONNECTION', @$_SESSION['systemLang']) ?></label>
                      <div class="col-sm-12 col-md-8">
                        <input type="password" class="form-control" id="password-connection" name="password-connection" placeholder="<?php echo language('PASSWORD CONNECTION', @$_SESSION['systemLang']) ?>" value="<?php echo $piece_data['password_connection'] ?>"  />
                        <i class="bi bi-eye-slash show-pass <?php echo @$_SESSION['systemLang'] == 'ar' ? 'show-pass-left' : 'show-pass-right' ?>" onclick="showPass(this)"></i>
                        <div id="passHelp" class="form-text text-warning "><?php echo language('DON`T SHARE THIS PASSWORD WITH ANYONE', @$_SESSION['systemLang']) ?></div>
                      </div>
                    </div>
                  </div>
                  <!-- ssid -->
                  <div class="col-12">
                    <div class="mb-sm-2 mb-md-3 row">
                      <label for="ssid" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('SSID', @$_SESSION['systemLang']) ?></label>
                      <div class="col-sm-12 col-md-8">
                        <input type="text" class="form-control" id="ssid" name="ssid" placeholder="<?php echo language('SSID', @$_SESSION['systemLang']) ?>" value="<?php echo $piece_data['ssid'] ?>" />
                      </div>
                    </div>
                  </div>
                  <!-- frequency -->
                  <div class="col-12">
                    <div class="mb-sm-2 mb-md-3 row">
                      <label for="frequency" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('FREQUENCY', @$_SESSION['systemLang']) ?></label>
                      <div class="col-sm-12 col-md-8">
                          <input type="text" class="form-control" id="frequency" name="frequency" placeholder="<?php echo language('FREQUENCY', @$_SESSION['systemLang']) ?>" value="<?php echo $piece_data['frequency'] ?>"  onkeyup="double_input_validation(this)" />
                      </div>
                    </div>
                  </div>
                  <!-- wave -->
                  <div class="col-12">
                    <div class="mb-sm-2 mb-md-3 row">
                      <label for="wave" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('THE WAVE', @$_SESSION['systemLang']) ?></label>
                      <div class="col-sm-12 col-md-8">
                        <input type="text" class="form-control" id="wave" name="wave" placeholder="<?php echo language('THE WAVE', @$_SESSION['systemLang']) ?>" value="<?php echo $piece_data['wave'] ?>" onkeyup="double_input_validation(this)" />
                      </div>
                    </div>
                  </div>
                </div>
              </div>                       
            </div>
          </div>
        </div>
      </div>

      <!-- submit -->
      <div class="hstack gap-3">
        <button type="button" form="update-piece-info" class="btn btn-primary text-capitalize bg-gradient fs-12 p-1 <?php echo @$_SESSION['systemLang'] == 'ar' ? 'me-auto' : 'ms-auto' ?>" id="edit-piece" <?php if ($_SESSION['pcs_add'] == 0) {echo 'disabled';} ?> onclick="form_validation(this.form, 'submit')">
          <i class="bi bi-check-all"></i>
          <?php echo language('SAVE CHANGES', @$_SESSION['systemLang']) ?>
        </button>
        <!-- delete button -->
        <button type="button" class="btn btn-outline-danger py-1 fs-12" data-bs-toggle="modal" data-bs-target="#deletePieceModal">
            <i class="bi bi-trash"></i>
            <?php echo language('DELETE', @$_SESSION['systemLang']); ?>
        </button>
      </div>
    </form>
    <!-- end form -->
  </div>

  <?php include_once "delete-piece-modal.php"  ?>
<?php } else {
  // include missing data modeule
  include_once $globmod . "missing-data-no-redirect.php";
}

