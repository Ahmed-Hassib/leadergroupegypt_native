<?php
// get piece id from $_GET variable
$piece_id = isset($_GET['piece-id']) && !empty($_GET['piece-id']) ? $_GET['piece-id'] : 0;
if (!isset($pcs_obj)) {
  // create an object of Piece Class
  $pcs_obj = new Pieces();
}
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

  // $API->connect($ipRB, $Username, $clave);
  // $users =  $API->comm("/ip/firewall/nat/print", array(
  //   "?comment" => "mohamady"
  // ));
  $users = [];
  $target_user = !empty($users) && count($users) > 0 ? $users[1] : -1;
?>
<!-- start add new user page -->
<div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
  <!-- start form -->
  <form class="custom-form need-validation" action="?name=<?php echo $page_title ?>&do=update-piece-info" method="POST"
    id="update-piece-info" onchange="form_validation(this)">
    <div class="hstack gap-3">
      <?php if ($_SESSION['pcs_update'] == 1) { ?>
      <!-- submit -->
      <button type="button" form="update-piece-info"
        class="btn btn-primary text-capitalize bg-gradient fs-12 p-1 <?php echo @$_SESSION['systemLang'] == 'ar' ? 'me-auto' : 'ms-auto' ?>"
        id="edit-piece-1" onclick="form_validation(this.form, 'submit')">
        <i class="bi bi-check-all"></i>
        <?php echo language('SAVE CHANGES', @$_SESSION['systemLang']) ?>
      </button>
      <?php } ?>

      <?php if ($target_user != -1) { ?>
      <a class="btn btn-outline-primary fs-12 w-auto py-1 px-2"
        href="?do=prepare-ip&id=<?php echo base64_encode($target_user['.id']) ?>&address=<?php echo $piece_data['ip'] ?>&port=<?php echo $piece_data['port'] != 0 ? $piece_data['port'] : '443' ?>"
        target='_blank'><?php echo language('VISIT DEVICE', @$_SESSION['systemLang']) ?></a>
      <?php } ?>

      <?php if ($_SESSION['pcs_delete'] == 1) { ?>
      <!-- delete button -->
      <button type="button" class="btn btn-outline-danger py-1 fs-12" data-bs-toggle="modal"
        data-bs-target="#deletePieceModal" data-piece-id="<?php echo $piece_data['id'] ?>"
        data-piece-name="<?php echo $piece_data['full_name'] ?>" data-page-title="<?php echo $page_title ?>"
        onclick="confirm_delete_piece(this)">
        <i class="bi bi-trash"></i>
        <?php echo language('DELETE', @$_SESSION['systemLang']); ?>
      </button>
      <?php } ?>
    </div>
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
          <div class="mb-3 form-floating">
            <input type="text" class="form-control" id="full-name" name="full-name"
              placeholder="<?php echo language('FULLNAME', @$_SESSION['systemLang']) ?>"
              onblur="fullname_validation(this, <?php echo $piece_data['id'] ?>)"
              onblur="fullname_validation(this, <?php echo $piece_data['id'] ?>)"
              value="<?php echo $piece_data['full_name'] ?>" autocomplete="off" required />
            <label for="full-name"><?php echo language('FULLNAME', @$_SESSION['systemLang']) ?></label>
          </div>
          <!-- address -->
          <div class="mb-3 form-floating">
            <input type="text" name="address" id="address" class="form-control w-100"
              value="<?php echo $piece_data['address'] ?>"
              placeholder="<?php echo language('THE ADDRESS', @$_SESSION['systemLang']) ?>" />
            <label for="address"><?php echo language('THE ADDRESS', @$_SESSION['systemLang']) ?></label>
          </div>
          <!-- phone -->
          <div class="mb-3 form-floating">
            <input type="text" name="phone-number" id="phone-number" class="form-control w-100"
              placeholder="<?php echo language('PHONE', @$_SESSION['systemLang']) ?>"
              value="<?php echo $piece_data['phone'] ?>" />
            <label for="phone-number"><?php echo language('PHONE', @$_SESSION['systemLang']) ?></label>
          </div>

          <!-- is client -->
          <div class="mb-3 row">
            <label for="is-client"
              class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('THE TYPE', @$_SESSION['systemLang']) ?></label>
            <div class="mt-2 col-sm-12 col-md-8 position-relative">
              <!-- TRANSMITTER -->
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="is-client" id="transmitter" value="1"
                  <?php echo $piece_data['is_client'] == 0 && $piece_data['device_type'] == 1 ? 'checked' : '' ?>>
                <label class="form-check-label text-capitalize"
                  for="transmitter"><?php echo language('TRANSMITTER', @$_SESSION['systemLang']) ?></label>
              </div>
              <!-- RECEIVER -->
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="is-client" id="receiver" value="2"
                  <?php echo $piece_data['is_client'] == 0 && $piece_data['device_type'] == 2 ? 'checked' : '' ?>>
                <label class="form-check-label text-capitalize"
                  for="receiver"><?php echo language('RECEIVER', @$_SESSION['systemLang']) ?></label>
              </div>
              <?php if ($piece_data['is_client'] == -1) { ?>
              <!-- CLIENT -->
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="is-client" id="client" value="0">
                <label class="form-check-label text-capitalize"
                  for="client"><?php echo language('CLIENT', @$_SESSION['systemLang']) ?></label>
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

          <!-- internet source -->
          <div class="mb-3 form-floating">
            <input type="text" name="internet-source" id="internet-source" class="form-control"
              placeholder="<?php echo language('INTERNET SOURCE', @$_SESSION['systemLang']) ?>"
              value="<?php echo $piece_data['internet_source']  ?>" />
            <label for="internet-source">
              <?php echo language('INTERNET SOURCE', @$_SESSION['systemLang']); ?>
            </label>
          </div>

          <!-- notes -->
          <div class="mb-3 form-floating">
            <textarea name="notes" id="notes" title="put some notes hete if exist" class="form-control w-100"
              style="height: 8rem; resize: none; direction: <?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>"
              placeholder="<?php echo language('PUT YOUR NOTES HERE', @$_SESSION['systemLang']) ?>"><?php echo $piece_data['notes']  ?></textarea>
            <label for="notes"><?php echo language('THE NOTES', @$_SESSION['systemLang']) ?></label>
          </div>
          <!-- visit time -->
          <div class="mb-3 row">
            <label for="visit-time"
              class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('VISIT TIME', @$_SESSION['systemLang']) ?></label>
            <div class="mt-2 col-sm-12 col-md-8">
              <!-- ANY TIME -->
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="visit-time" id="visit-time-piece" value="1"
                  <?php echo $piece_data['visit_time'] == 1 ? 'checked' : '' ?>>
                <label class="form-check-label text-capitalize"
                  for="visit-time-piece"><?php echo language('ANY TIME', @$_SESSION['systemLang']) ?></label>
              </div>
              <!-- ADVANCE CONNECTION -->
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="visit-time" id="visit-time-client" value="2"
                  <?php echo $piece_data['visit_time'] == 2 ? 'checked' : '' ?>>
                <label class="form-check-label text-capitalize"
                  for="visit-time-client"><?php echo language('ADVANCE CONNECTION', @$_SESSION['systemLang']) ?></label>
              </div>
            </div>
          </div>
          <!-- malfunctions counter -->
          <?php $malCounter = $pcs_obj->count_records("`mal_id`", "`malfunctions`", "WHERE `client_id` = " . $piece_data['id']) ?>
          <?php if ($malCounter > 0) { ?>
          <div class="mb-3 row align-items-center">
            <label for="malfunction-counter" class="col-sm-12 col-md-4 col-form-label text-capitalize">
              <?php echo language('ALL MALFUNCTION OF THIS PIECE', @$_SESSION['systemLang']); ?>
            </label>
            <div class="col-sm-12 col-md-8 position-relative">
              <span class="me-5 text-start"
                dir="<?php echo @$_SESSION['systemLang'] == "ar" ? "rtl" : "ltr" ?>"><?php echo $malCounter . " " . ($malCounter > 2 ? language("MALFUNCTIONS", @$_SESSION['systemLang']) : language("MALFUNCTION", @$_SESSION['systemLang'])) ?></span>
              <?php if ($_SESSION['mal_show']) { ?>
              <a href="<?php echo $nav_up_level ?>malfunctions/index.php?do=show-pieces-malfunctions&pieceid=<?php echo $piece_data['id'] ?>"
                class="mt-2 text-start"
                dir="<?php echo @$_SESSION['systemLang'] == "ar" ? "rtl" : "ltr" ?>"><?php echo language("SHOW DETAILS", @$_SESSION['systemLang']) ?>&nbsp;<i
                  class="bi bi-arrow-up-left-square"></i></a>
              <?php } ?>
            </div>
          </div>
          <?php } ?>
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
                          // get all directions
                          $dirs = $pcs_obj->select_specific_column("*", "`direction`", "WHERE `company_id` = " . $_SESSION['company_id'] . " ORDER BY `direction_name` ASC");
                          // counter
                          $dirs_count = count($dirs);
                          // directions data
                          $dir_data = $dirs;
                          // check the row dirs_count
                          if ($dirs_count > 0) { ?>
                      <option value="default" disabled>
                        <?php echo language('SELECT', @$_SESSION['systemLang']) . " " . language('THE DIRECTION', @$_SESSION['systemLang']) ?>
                      </option>
                      <?php foreach ($dir_data as $dir) { ?>
                      <option value="<?php echo $dir['direction_id'] ?>"
                        data-dir-company="<?php echo $_SESSION['company_id'] ?>"
                        <?php echo $piece_data['direction_id'] == $dir['direction_id'] ? 'selected' : ''  ?>>
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
                      <?php
                        $condition = "LEFT JOIN `direction` ON `direction`.`direction_id` = `pieces_info`.`direction_id` WHERE `pieces_info`.`direction_id` = " . $piece_data['direction_id'] . " AND `pieces_info`.`is_client` = 0 AND `pieces_info`.`company_id` = " . $_SESSION['company_id'];
                        $sources = $pcs_obj->select_specific_column("`pieces_info`.`id`, `pieces_info`.`full_name`, `pieces_info`.`ip`", "`pieces_info`", $condition);
                        // counter
                        $sources_count = count($sources);
                        // directions data
                        $sources_data = $sources;
                        // check the row sources_count
                        if ($sources_count) { ?>
                      <option value="default" disabled>
                        <?php echo language('SELECT', @$_SESSION['systemLang']) . " " . language('THE SOURCE', @$_SESSION['systemLang']) ?>
                      </option>
                      <?php foreach ($sources_data as $source) { ?>
                      <option value="<?php echo $source['id'] ?>" <?php if ($piece_data['source_id'] == $source['id'] || ($piece_data['source_id'] == 0 && $piece_data['ip'] == $source['ip'])) {
                                                                          echo 'selected';
                                                                        }  ?>>
                        <?php echo  $source['full_name'] . " - " . $source['ip'] ?>
                      </option>
                      <?php } ?>
                      <?php } else { ?>
                      <option value="default" disabled selected>
                        <?php echo language('NOT AVAILABLE NOW', @$_SESSION['systemLang']) ?></option>
                      <?php } ?>
                    </select>
                    <label for="sources"><?php echo language('THE SOURCE', @$_SESSION['systemLang']) ?></label>

                  </div>
                </div>

                <!-- alternative source -->
                <div class="col-12">
                  <div class="mb-3 form-floating">
                    <select class="form-select" id="alternative-sources" name="alt-source-id">
                      <?php if ($sources_count) { ?>
                      <option value="default" selected disabled>
                        <?php echo language('SELECT', @$_SESSION['systemLang']) . " " . language('ALTERNATIVE SOURCE', @$_SESSION['systemLang']) ?>
                      </option>
                      <?php foreach ($sources_data as $alt_source) { ?>
                      <option value="<?php echo $alt_source['id'] ?>"
                        <?php if ($piece_data['alt_source_id'] == $alt_source['id'] || ($piece_data['alt_source_id'] == 0 && $piece_data['ip'] == $alt_source['ip'])) echo 'selected'; ?>>
                        <?php echo  $alt_source['full_name'] . " - " . $alt_source['ip'] ?>
                      </option>
                      <?php } ?>
                      <?php } else { ?>
                      <option value="default" disabled selected>
                        <?php echo language('NOT AVAILABLE NOW', @$_SESSION['systemLang']) ?></option>';
                      <?php } ?>
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
                      <?php
                        // check the row devices_count
                        if ($devices_count > 0) {
                        ?>
                      <option value="default" disabled selected>
                        <?php echo language('SELECT', @$_SESSION['systemLang']) . " " . language('DEVICE TYPE', @$_SESSION['systemLang']) ?>
                      </option>
                      <?php foreach ($devices_data as $device) { ?>
                      <option value="<?php echo $device['device_id'] ?>"
                        <?php echo $piece_data['device_id'] == $device['device_id'] ? 'selected' : '' ?>>
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
                    <?php
                      // get all pieces devices_model
                      $model_query = "SELECT *FROM `devices_model` WHERE `device_id` = ?";
                      $stmt = $con->prepare($model_query);
                      $stmt->execute(array($piece_data['device_id']));
                      $model_count = $stmt->rowCount();
                      $models_data =  $stmt->fetchAll();
                      ?>
                    <select class="form-select" name="device-model" id="device-model">
                      <?php if ($model_count > 0) { ?>
                      <option value="default" disabled selected>
                        <?php echo language('SELECT', @$_SESSION['systemLang']) . " " . language('DEVICE MODEL', @$_SESSION['systemLang']) ?>
                      </option>
                      <?php foreach ($models_data as $model) { ?>
                      <option value="<?php echo $model['model_id'] ?>"
                        <?php echo $piece_data['device_model'] == $model['model_id'] ? 'selected' : '' ?>>
                        <?php echo $model['model_name'] ?>
                      </option>
                      <?php } ?>
                      <?php } else { ?>
                      <option value="default" disabled selected>
                        <?php echo language('NOT AVAILABLE NOW', @$_SESSION['systemLang']) ?></option>';
                      <?php } ?>
                    </select>
                    <?php if ($model_count == 0 && $piece_data['device_model'] > 0) {  ?>
                    <div id="emailHelp" class="form-text text-danger">
                      <?php echo language('THERE IS NO MODELS TO SELECT PLEASE ADD SOME DEVICES MODELS', @$_SESSION['systemLang']) ?>
                    </div>
                    <?php } ?>
                    <label for="device-model"><?php echo language('DEVICE MODEL', @$_SESSION['systemLang']) ?></label>
                  </div>
                </div>


                <!-- connection type -->
                <div class="col-12">
                  <div class="mb-3 form-floating">
                    <?php $conn_type_data = $db_obj->select_specific_column("*", "`connection_types`", "WHERE `company_id` = " . $_SESSION['company_id']); ?>
                    <select class="form-select text-uppercase" name="conn-type" id="conn-type">
                      <option value="default" selected disabled>
                        <?php echo language('SELECT', @$_SESSION['systemLang']) . " " . language('CONNECTION TYPE', @$_SESSION['systemLang']) ?>
                      </option>
                      <?php if (count($conn_type_data) > 0) { ?>
                      <?php foreach ($conn_type_data as $conn_type_row) { ?>
                      <option value="<?php echo $conn_type_row['id'] ?>"
                        <?php echo $piece_data['connection_type'] == $conn_type_row['id'] ? 'selected' : '' ?>>
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
                          onblur="ip_validation(this, <?php echo $piece_data['id'] ?>)"
                          onkeyup="ip_validation(this, <?php echo $piece_data['id'] ?>)"
                          value="<?php echo $piece_data['ip'] ?>" autocomplete="off" required />
                        <label for="ip"><span
                            class="text-uppercase"><?php echo language('IP', @$_SESSION['systemLang']) ?></span></label>
                      </div>
                    </div>
                    <div class="col-sm-4 position-relative">
                      <div class="form-floating">
                        <input type="number" class="form-control" id="port" name="port" placeholder="port"
                          value="<?php echo $piece_data['port'] ?>" autocomplete="off" required />
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
                    <input type="text" class="form-control" id="mac-add" name="mac-add"
                      onblur="mac_validation(this, <?php echo $piece_data['id'] ?>)"
                      onkeyup="mac_validation(this, <?php echo $piece_data['id'] ?>)"
                      placeholder="<?php echo language('MAC ADD', @$_SESSION['systemLang']) ?>"
                      value="<?php echo $piece_data['mac_add'] ?>" />
                    <label for="mac-add"><?php echo language('MAC ADD', @$_SESSION['systemLang']) ?></label>
                  </div>
                </div>

                <!-- user name -->
                <div class="col-12">
                  <div class="mb-3 form-floating">
                    <input type="text" class="form-control" id="user-name" name="user-name"
                      placeholder="<?php echo language('USERNAME', @$_SESSION['systemLang']) ?>"
                      value="<?php echo $piece_data['username'] ?>" autocomplete="off" required />
                    <label for="user-name"><?php echo language('USERNAME', @$_SESSION['systemLang']) ?></label>
                  </div>
                </div>

                <!-- password -->
                <div class="col-12">
                  <div class="mb-3 form-floating">
                    <input type="password" class="form-control" id="password" name="password"
                      placeholder="<?php echo language('PASSWORD', @$_SESSION['systemLang']) ?>"
                      value="<?php echo $piece_data['password'] ?>" autocomplete="off" required />
                    <i class="bi bi-eye-slash show-pass <?php echo @$_SESSION['systemLang'] == 'ar' ? 'show-pass-left' : 'show-pass-right' ?>"
                      onclick="show_pass(this)"></i>
                    <label for="password"><?php echo language('PASSWORD', @$_SESSION['systemLang']) ?></label>
                  </div>
                  <div id="passHelp" class="form-text text-warning ">
                    <?php echo language('DON`T SHARE THIS PASSWORD WITH ANYONE', @$_SESSION['systemLang']) ?></div>
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
                      placeholder="<?php echo language('PASSWORD CONNECTION', @$_SESSION['systemLang']) ?>"
                      value="<?php echo $piece_data['password_connection'] ?>" />
                    <i class="bi bi-eye-slash show-pass <?php echo @$_SESSION['systemLang'] == 'ar' ? 'show-pass-left' : 'show-pass-right' ?>"
                      onclick="show_pass(this)"></i>
                    <label
                      for="password-connection"><?php echo language('PASSWORD CONNECTION', @$_SESSION['systemLang']) ?></label>
                  </div>
                  <div id="passHelp" class="form-text text-warning ">
                    <?php echo language('DON`T SHARE THIS PASSWORD WITH ANYONE', @$_SESSION['systemLang']) ?></div>
                </div>
                <!-- ssid -->
                <div class="col-12">
                  <div class="mb-3 form-floating">
                    <input type="text" class="form-control" id="ssid" name="ssid"
                      placeholder="<?php echo language('SSID', @$_SESSION['systemLang']) ?>"
                      value="<?php echo $piece_data['ssid'] ?>" />
                    <label for="ssid"><?php echo language('SSID', @$_SESSION['systemLang']) ?></label>
                  </div>
                </div>
                <!-- frequency -->
                <div class="col-12">
                  <div class="mb-3 form-floating">
                    <input type="text" class="form-control" id="frequency" name="frequency"
                      placeholder="<?php echo language('FREQUENCY', @$_SESSION['systemLang']) ?>"
                      value="<?php echo $piece_data['frequency'] ?>" onkeyup="integer_input_validation(this)"
                      onblur="integer_input_validation(this)" />
                    <label for="frequency"><?php echo language('FREQUENCY', @$_SESSION['systemLang']) ?></label>
                  </div>
                </div>
                <!-- wave -->
                <div class="col-12">
                  <div class="mb-3 form-floating">
                    <input type="text" class="form-control" id="wave" name="wave"
                      placeholder="<?php echo language('THE WAVE', @$_SESSION['systemLang']) ?>"
                      value="<?php echo $piece_data['wave'] ?>" onkeyup="integer_input_validation(this)"
                      onblur="integer_input_validation(this)" />
                    <label for="wave"><?php echo language('THE WAVE', @$_SESSION['systemLang']) ?></label>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="hstack gap-3">
      <?php if ($_SESSION['pcs_update'] == 1) { ?>
      <!-- submit -->
      <button type="button" form="update-piece-info"
        class="btn btn-primary text-capitalize bg-gradient fs-12 p-1 <?php echo @$_SESSION['systemLang'] == 'ar' ? 'me-auto' : 'ms-auto' ?>"
        id="edit-piece-2" onclick="form_validation(this.form, 'submit')">
        <i class="bi bi-check-all"></i>
        <?php echo language('SAVE CHANGES', @$_SESSION['systemLang']) ?>
      </button>
      <?php } ?>

      <?php if ($target_user != -1) { ?>
      <a class="btn btn-outline-primary fs-12 w-auto py-1 px-2"
        href="?do=prepare-ip&id=<?php echo base64_encode($target_user['.id']) ?>&address=<?php echo $piece_data['ip'] ?>&port=<?php echo $piece_data['port'] != 0 ? $piece_data['port'] : '443' ?>"
        target='_blank'><?php echo language('VISIT DEVICE', @$_SESSION['systemLang']) ?></a>
      <?php } ?>

      <?php if ($_SESSION['pcs_delete'] == 1) { ?>
      <!-- delete button -->
      <button type="button" class="btn btn-outline-danger py-1 fs-12" data-bs-toggle="modal"
        data-bs-target="#deletePieceModal" data-piece-id="<?php echo $piece_data['id'] ?>"
        data-piece-name="<?php echo $piece_data['full_name'] ?>" data-page-title="<?php echo $page_title ?>"
        onclick="confirm_delete_piece(this)">
        <i class="bi bi-trash"></i>
        <?php echo language('DELETE', @$_SESSION['systemLang']); ?>
      </button>
      <?php } ?>
    </div>
  </form>
  <!-- end form -->
</div>
<?php } else {
  // include missing data modeule
  include_once $globmod . "missing-data-no-redirect.php";
}