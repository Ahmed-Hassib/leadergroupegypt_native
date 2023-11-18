<?php
// create an object of Malfunction class
$mal_obj = !isset($mal_obj) ? new Malfunction() : $mal_obj;
// get malfunction id 
$mal_id = isset($_GET['malid']) && !empty($_GET['malid']) ? base64_decode($_GET['malid']) : 0;
// check if malid exist
$is_exist_mal = $mal_obj->is_exist("`mal_id`", "`malfunctions`", $mal_id);
// check
if ($is_exist_mal == true) {
  // get malfunction details
  $mal_details = $mal_obj->get_spec_malfunction($mal_id, base64_decode($_SESSION['sys']['company_id']));
  // malfunction status
  $mal_status_exist = $mal_details[0];
  // malfunction info
  if ($mal_status_exist == true) {
    // get mal info
    $mal_info = $mal_details[1][0];
  }

  // check if malfunction is showed or not
  if ($mal_info['isShowed'] == 0) {
    if (base64_decode($_SESSION['sys']['UserID']) == $mal_info['tech_id']) {
      // update some info of this malfunction
      $q = "UPDATE `malfunctions` SET `isShowed` = 1, `showed_date` = ?, `showed_time` = ? WHERE `mal_id` = ? AND `company_id` = ?";
      $stmt = $con->prepare($q);
      $stmt->execute(array(get_date_now(), get_time_now(), $mal_id, base64_decode($_SESSION['sys']['company_id']))); // execute data 
    }
  }
  ?>
  <!-- start add new user page -->
  <div class="container" dir="<?php echo $page_dir ?>">
    <!-- start form -->
    <form class="custom-form" action="?do=update-malfunction-info" method="POST" enctype="multipart/form-data"
      id="edit-malfunction-info">
      <!-- submit -->
      <div class="mb-3 hstack gap-2">
        <?php if ($_SESSION['sys']['mal_update'] == 1) { ?>
          <div class="<?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'me-auto' : 'ms-auto' ?>">
            <button type="submit" form="edit-malfunction-info"
              class="btn btn-primary text-capitalize form-control bg-gradient fs-12 py-1" id="update-malfunctions">
              <i class="bi bi-check-all"></i>&nbsp;
              <?php echo lang('SAVE') ?>
            </button>
          </div>
        <?php } ?>
        <?php if ($_SESSION['sys']['mal_delete'] == 1) { ?>
          <div>
            <button type="button" class="btn btn-outline-danger text-capitalize form-control bg-gradient fs-12 py-1"
              data-bs-toggle="modal" data-bs-target="#delete-malfunction-modal"
              data-mal-id="<?php echo base64_encode($mal_info['mal_id']) ?>" onclick="put_mal_data_into_modal(this)">
              <i class="bi bi-trash"></i>&nbsp;
              <?php echo lang('DELETE') ?>
            </button>
          </div>
        <?php } ?>
      </div>
      <!-- form content -->
      <div class="edit-mal-content" id="malfuction-body">
        <!-- the employees that responsible for the malfunctions -->
        <div class="edit-mal-content__subinfo">
          <div class="section-block">
            <div class="section-header">
              <h5>
                <?php echo lang('RESP MAL', $lang_file) ?>
              </h5>
              <hr />
            </div>
            <!-- malfunctions id -->
            <input type="hidden" name="mal-id" id="mal-id" value="<?php echo base64_encode($mal_info['mal_id']) ?>">
            <!-- Administrator name -->
            <div
              class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
              <?php $admin_name = $mal_obj->select_specific_column("`UserName`", "`users`", "WHERE `UserID` = '" . $mal_info['mng_id'] . "' LIMIT 1")[0]['UserName']; ?>
              <input type="hidden" class="form-control" id="admin-id" name="admin-id"
                value="<?php echo base64_encode($mal_info['mng_id']) ?>" autocomplete="off" required />
              <input type="text" class="form-control" id="admin-name" name="admin-name"
                placeholder="<?php echo lang('ADMIN NAME', $lang_file) ?>" value="<?php echo $admin_name ?>"
                autocomplete="off" required disabled />
              <label for="admin-name">
                <?php echo lang('ADMIN NAME', $lang_file) ?>
              </label>
            </div>
            <!-- Technical name -->
            <div
              class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
              <!-- select tag for technical -->
              <select class="form-select" id="technical-id" name="tech-id" <?php echo $_SESSION['sys']['isTech'] == 1 || $_SESSION['sys']['mal_update'] == 0 || $mal_info['mal_status'] == 1 ? 'disabled' : '' ?>>
                <option value="default" disabled selected>
                  <?php echo lang('SELECT TECH NAME', $lang_file) ?>
                </option>
                <?php $users_rows = $mal_obj->select_specific_column("`UserID`, `UserName`", "`users`", "WHERE `isTech` = 1 AND `company_id` = " . base64_decode($_SESSION['sys']['company_id'])); ?>
                <?php if (count($users_rows) > 0) { ?>
                  <?php foreach ($users_rows as $user_row) { ?>
                    <option value="<?php echo base64_encode($user_row['UserID']) ?>" <?php echo $user_row['UserID'] == $mal_info['tech_id'] ? 'selected' : '' ?>>
                      <?php echo $user_row['UserName']; ?>
                    </option>
                  <?php } ?>
                <?php } ?>
              </select>
              <label for="technical-id">
                <?php echo lang('TECH NAME', $lang_file) ?>
              </label>
              <?php if (count($users_rows) <= 0) { ?>
                <div class="text-danger fw-bold">
                  <i class="bi bi-exclamation-triangle-fill"></i>
                  <?php echo lang("NO DATA") ?>
                </div>
              <?php } ?>
              <input type="hidden" name="technical-id-value" id="technical-id-value" value="">
            </div>
          </div>
          <div class="section-block">
            <header class="section-header">
              <h5 class="h5">
                <?php echo lang("STATUS", $lang_file) ?>
              </h5>
              <hr>
            </header>
            <!-- status -->
            <div
              class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
              <select name="mal-status" id="mal-status" class="form-select" <?php echo $_SESSION['sys']['mal_update'] == 0 || $_SESSION['sys']['isTech'] == 0 || $mal_info['mal_status'] == 1 ? 'disabled' : '' ?>>
                <option value="default" disabled>
                  <?php echo lang("SELECT STATUS", $lang_file) ?>
                </option>
                <option value="<?php echo base64_encode(0) ?>" <?php echo $mal_info['mal_status'] == 0 ? 'selected' : '' ?>>
                  <?php echo lang('UNFINISHED', $lang_file) ?>
                </option>
                <option value="<?php echo base64_encode(1) ?>" <?php echo $mal_info['mal_status'] == 1 ? 'selected' : '' ?>>
                  <?php echo lang('FINISHED', $lang_file) ?>
                </option>
                <option value="<?php echo base64_encode(2) ?>" <?php echo $mal_info['mal_status'] == 2 ? 'selected' : '' ?>>
                  <?php echo lang('DELAYED', $lang_file) ?>
                </option>
              </select>
              <label for="mal-status" class="col-sm-12 col-form-label text-capitalize pt-0">
                <?php echo lang('STATUS', $lang_file) ?>
              </label>
            </div>
          </div>
        </div>
        <!-- client information -->
        <div class="section-block">
          <div class="section-header">
            <h5>
              <?php echo lang('VICTIM INFO', $lang_file) ?>
            </h5>
            <hr />
          </div>
          <?php $client_details = $mal_obj->select_specific_column("`id`, `full_name`, `ip`, `is_client`, `notes`, `visit_time`", "`pieces_info`", "WHERE `id` = '" . $mal_info['client_id'] . "' LIMIT 1")[0]; ?>
          <div class="victim-info-content">
            <!-- client name -->
            <div class="victim-info-content__row">
              <label for="client-name">
                <?php echo lang('CLT NAME', 'clients') ?>
              </label>
              <div class="col-sm-12 col-md-7 position-relative position-relative">
                <input type="hidden" name="client-id" id="client-id" class="form-control w-100"
                  placeholder="<?php echo lang('CLT NAME', 'clients') ?>"
                  value="<?php echo base64_encode($mal_info['client_id']) ?>" />
                <?php if ($_SESSION['sys']['pcs_show'] == 1) { ?>
                  <a class="text-primary"
                    href="<?php echo $nav_up_level ?>pieces/index.php?do=edit-piece&piece-id=<?php echo base64_encode($mal_info['client_id']) ?>"
                    target="_blank">
                    <?php echo $client_details['full_name'] ?>&nbsp;<i class="bi bi-arrow-up-left-square"></i>
                  </a>
                <?php } else { ?>
                  <span class="text-primary">
                    <?php echo $client_details['full_name'] ?>
                  </span>
                <?php } ?>
              </div>
            </div>
            <!-- client address -->
            <div class="victim-info-content__row">
              <label for="client-addr">
                <?php echo lang('ADDR', $lang_file) ?>
              </label>
              <div class="col-sm-12 col-md-7 position-relative position-relative">
                <?php $client_addr = $mal_obj->select_specific_column("`address`", "`pieces_addr`", "WHERE `id` = '" . $mal_info['client_id'] . "' LIMIT 1"); ?>
                <?php if (!empty($client_addr)) { ?>
                  <span class="text-primary">
                    <?php echo $client_addr[0]['address']; ?>
                  </span>
                <?php } else { ?>
                  <span class="text-danger fw-bold">
                    <?php echo lang('NO DATA'); ?>
                  </span>
                <?php } ?>
              </div>
            </div>
            <!-- client address -->
            <div class="victim-info-content__row">
              <label for="client-addr">
                <?php echo lang('PHONE', $lang_file) ?>
              </label>
              <div class="col-sm-12 col-md-7 position-relative position-relative">
                <?php $client_phone = $mal_obj->select_specific_column("`phone`", "`pieces_phones`", "WHERE `id` = '" . $mal_info['client_id'] . "' LIMIT 1"); ?>
                <?php if (!empty($client_phone)) { ?>
                  <span class="text-primary">
                    <?php echo $client_phone[0]['phone']; ?>
                  </span>
                <?php } else { ?>
                  <span class="text-danger fw-bold">
                    <?php echo lang('NO DATA'); ?>
                  </span>
                <?php } ?>
              </div>
            </div>
            <!-- client ip -->
            <div class="victim-info-content__row">
              <label for="client-ip"><span class="text-uppercase">
                  <?php echo lang('IP') ?>
                </span></label>
              <div class="col-sm-12 col-md-7 position-relative position-relative">
                <?php if (!empty($client_details['ip'] != 1)) { ?>
                  <span class="text-primary">
                    <?php echo $client_details['ip']; ?>
                  </span>
                <?php } else { ?>
                  <span class="text-danger fw-bold">
                    <?php echo lang('NO DATA'); ?>
                  </span>
                <?php } ?>
              </div>
            </div>
            <!-- piece notes -->
            <div class="victim-info-content__row">
              <label for="client-notes"><span class="text-uppercase">
                  <?php echo lang('NOTE') ?>
                </span></label>
              <div class="col-sm-12 col-md-7 position-relative position-relative">
                <?php if (!empty($client_details['notes'] != 1)) { ?>
                  <span class="text-primary">
                    <?php echo $client_details['notes']; ?>
                  </span>
                <?php } else { ?>
                  <span class="text-danger fw-bold">
                    <?php echo lang('NO DATA'); ?>
                  </span>
                <?php } ?>
              </div>
            </div>
            <!-- piece visit-time -->
            <div class="victim-info-content__row">
              <label for="client-visit-time"><span class="text-uppercase">
                  <?php echo lang('VISIT TIME', 'pieces') ?>
                </span></label>
              <div class="col-sm-12 col-md-7 position-relative position-relative">
                <?php if (!empty($client_details['visit_time'] > 0)) { ?>
                  <span class="text-primary">
                    <?php echo $client_details['visit_time'] == 1 ? lang('ANY TIME', 'pieces') : lang('ADVANCE CONNECTION', 'pieces'); ?>
                  </span>
                <?php } else { ?>
                  <span class="text-danger fw-bold">
                    <?php echo lang('NOT ASSIGNED'); ?>
                  </span>
                <?php } ?>
              </div>
            </div>
            <!-- malfunctions counter -->
            <?php $malCounter = $mal_obj->count_records("`mal_id`", "`malfunctions`", "WHERE `client_id` = " . $mal_info['client_id']) ?>
            <div class="victim-info-content__row">
              <label for="malfunction-counter">
                <?php
                $is_client = $mal_obj->select_specific_column("`is_client`", "`pieces_info`", "WHERE `id` = " . $mal_info['client_id'])[0]['is_client'];
                if ($is_client <= 0) {
                  $label = 'PCS MALS';
                  $file = 'pieces';
                } else {
                  $label = 'CLT MALS';
                  $file = 'clients';
                }
                echo lang($label, $file);
                ?>
              </label>
              <div class="col-sm-12 col-md-7 position-relative">
                <span class="text-start" dir="<?php echo @$_SESSION['sys']['lang'] == "ar" ? "rtl" : "ltr" ?>">
                  <?php echo $malCounter . " " . ($malCounter > 2 ? lang("MALS", $lang_file) : lang("MAL", $lang_file)) ?>
                </span>
                <a href="?do=show-pieces-malfunctions&pieceid=<?php echo base64_encode($mal_info['client_id']) ?>"
                  class="mt-2 text-start" dir="<?php echo @$_SESSION['sys']['lang'] == "ar" ? "rtl" : "ltr" ?>">
                  <?php echo lang("DETAILS") ?>&nbsp;<i class="bi bi-arrow-up-left-square"></i>
                </a>
              </div>
            </div>
          </div>
        </div>

        <!-- malfunction date and time -->
        <div class="section-block">
          <div class="section-header">
            <h5>
              <?php echo lang('DATE & TIME INFO', $lang_file) ?>
            </h5>
            <hr />
          </div>
          <div class="date-time-content">
            <!-- added date -->
            <div class="date-time-content__row">
              <label for="added-date">
                <?php echo lang('ADDED DATE') ?>
              </label>
              <div class="position-relative">
                <span class="text-primary" dir='ltr'>
                  <?php echo date_format(date_create($mal_info['added_date']), 'd/m/Y') ?>
                </span>
              </div>
            </div>
            <!-- added time -->
            <div class="date-time-content__row">
              <label for="added-time">
                <?php echo lang('ADDED TIME') ?>
              </label>
              <div class="position-relative">
                <span class="text-primary" dir='ltr'>
                  <?php echo date_format(date_create($mal_info['added_time']), 'h:i:s a') ?>
                </span>
              </div>
            </div>
            <!-- showed date -->
            <div class="date-time-content__row">
              <label for="showed-date">
                <?php echo lang('SHOWED DATE') ?>
              </label>
              <div class="position-relative">
                <?php if ($mal_info['isShowed']) { ?>
                  <span class="text-primary" dir='ltr'>
                    <?php echo date_format(date_create($mal_info['showed_date']), 'd/m/Y') ?>
                  </span>
                <?php } else { ?>
                  <span class="text-danger fw-bold">
                    <?php echo lang('NOT SHOWED', $lang_file) ?>
                  </span>
                <?php } ?>
              </div>
            </div>
            <!-- showed time -->
            <div class="date-time-content__row">
              <label for="showed-time">
                <?php echo lang('SHOWED TIME') ?>
              </label>
              <div class="position-relative">
                <?php if ($mal_info['isShowed']) { ?>
                  <span class="text-primary" dir='ltr'>
                    <?php echo date_format(date_create($mal_info['showed_time']), 'h:i:s a') ?>
                  </span>
                <?php } else { ?>
                  <span class="text-danger fw-bold">
                    <?php echo lang('NOT SHOWED', $lang_file) ?>
                  </span>
                <?php } ?>
              </div>
            </div>
            <!-- repaired date -->
            <div class="date-time-content__row">
              <label for="repaired-date">
                <?php echo $mal_info['mal_status'] == 1 && $mal_info['isAccepted'] != 2 ? lang('FINISHED DATE') : lang('DELAYED DATE'); ?>
              </label>
              <div class="position-relative">
                <?php if ($mal_info['mal_status'] != 0) { ?>
                  <span class="text-primary" dir='ltr'>
                    <?php echo date_format(date_create($mal_info['repaired_date']), 'd/m/Y') ?>
                  </span>
                <?php } else { ?>
                  <span class="text-danger fw-bold">
                    <?php echo lang('NOT ASSIGNED') ?>
                  </span>
                <?php } ?>
              </div>
            </div>
            <!-- repaired time -->
            <div class="date-time-content__row">
              <label for="repaired-time">
                <?php echo $mal_info['mal_status'] == 1 && $mal_info['isAccepted'] != 2 ? lang('FINISHED TIME') : lang('DELAYED TIME'); ?>
              </label>
              <div class="position-relative">
                <?php if ($mal_info['mal_status'] != 0) { ?>
                  <span class="text-primary" dir='ltr'>
                    <?php echo date_format(date_create($mal_info['repaired_time']), 'h:i:s a') ?>
                  </span>
                <?php } else { ?>
                  <span class="text-danger fw-bold">
                    <?php echo lang('NOT ASSIGNED') ?>
                  </span>
                <?php } ?>
              </div>
            </div>
            <?php if ($mal_info['mal_status'] == 1) { ?>
              <!-- diff time -->
              <div class="date-time-content__row period">
                <label for="showed-time">
                  <?php echo lang('FINISHED PERIOD') ?>
                </label>
                <div class="position-relative">
                  <?php
                  $diff = [];
                  if ($mal_info['showed_time'] != '00:00:00' && $mal_info['repaired_time'] != '00:00:00') {
                    $showed_date = date_create($mal_info['showed_date']); // showed date
                    $repaired_date = date_create($mal_info['repaired_date']); // repaired date
                    // get the diffrence of days
                    $diff_date = date_diff($showed_date, $repaired_date, true);

                    $showed_time = date_create($mal_info['showed_time']); // showed time
                    $repaired_time = date_create($mal_info['repaired_time']); // repaired time
                    // get the diffrence
                    $diff_time = date_diff($repaired_time, $showed_time, true);

                    $days = $diff_date->d;
                    $hours = $diff_time->h;
                    $minutes = $diff_time->i;
                    $seconds = $diff_time->s;
                    ?>
                    <span class="text-primary">
                      <?php echo ($days > 0 ? "$days " . lang($days > 1 ? 'DAYS' : 'DAY') . ", " : '') . ($hours > 0 ? " $hours " . lang($hours > 1 ? 'HOURS' : 'HOUR') . ", " : '') . ($minutes > 0 ? " $minutes " . lang($minutes > 1 ? 'MINUTES' : 'MINUTE') . ", " : '') . ($seconds > 0 ? " $seconds " . lang($seconds > 1 ? 'SECONDS' : 'SECOND') . ". " : '') ?>
                    </span>
                  <?php } else { ?>
                    <span class="text-danger">
                      <?php echo lang('PERIOD NOTE', $lang_file) ?>
                    </span>
                  <?php } ?>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
        <!-- additional info -->
        <div class="section-block">
          <div class="section-header">
            <h5>
              <?php echo lang('MAL INFO', $lang_file) ?>
            </h5>
            <hr />
          </div>
          <!-- description -->
          <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
            <textarea name="descreption" id="descreption" title="describe the malfunction" class="form-control w-100"
              style="height: 5rem; resize: none; direction: <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'rtl' : 'ltr' ?>"
              placeholder="Describe the malfunction" required <?php echo $_SESSION['sys']['isTech'] == 1 || $mal_info['mal_status'] == 1 ? 'disabled' : '' ?>><?php echo $mal_info['descreption'] ?></textarea>
            <label for="descreption">
              <?php echo lang('MAL DESC', $lang_file) ?>
            </label>
          </div>
          <!-- technical man comment -->
          <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
            <textarea name="comment" id="comment" class="form-control w-100"
              style="height: 5rem; resize: none; direction: <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'rtl' : 'ltr' ?>"
              <?php echo $_SESSION['sys']['mal_update'] == 0 || $_SESSION['sys']['isTech'] == 0 || $mal_info['mal_status'] == 1 ? 'disabled' : '' ?>><?php echo empty($mal_info['tech_comment']) && $mal_info['mal_status'] == 1 ? "لا يوجد تعليق من الفني" : $mal_info['tech_comment']; ?></textarea>
            <label for="comment">
              <?php echo lang('TECH COMMENT', $lang_file) ?>
            </label>
          </div>
          <!-- cost -->
          <div class="mb-3">
            <div class="input-group" dir="ltr">
              <span class="input-group-text">
                <?php echo lang('L.E') ?>
              </span>
              <div class="form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                <input type="text" name="cost" id="cost" class="form-control"
                  placeholder="<?php echo lang('MAL COST', $lang_file) ?>" value="<?php echo $mal_info['cost'] ?>" <?php echo $_SESSION['sys']['mal_update'] == 0 || $_SESSION['sys']['isTech'] == 0 || $mal_info['mal_status'] == 1 ? 'disabled' : '' ?>
                  onblur="arabic_to_english_nums(this)" onkeyup="arabic_to_english_nums(this)">
                <label for="cost">
                  <?php echo lang('MAL COST', $lang_file) ?>
                </label>
              </div>
            </div>
            <div id="costHelp" class="form-text text-info">
              <i class="bi bi-exclamation-triangle-fill"></i>&nbsp;
              <?php echo lang('ENG NUM') ?>
            </div>
          </div>
          <?php if ($_SESSION['sys']['isTech'] == 1 && $_SESSION['sys']['mal_update'] == 1) { ?>
            <!-- cost receipt -->
            <div class="input-group mb-3" dir="ltr">
              <input type="file" class="form-control form-control-<?php echo $page_dir == 'rtl' ? 'left' : 'right' ?>" id="cost-receipt" name="cost-receipt" accept="image/*"
                onchange="change_cost_receipt_img(this, 'cost-image-preview')">
              <label class="input-group-text" for="cost-receipt">
                <?php echo lang('COST RECEIPT', $lang_file) ?>
              </label>
            </div>
          <?php } ?>

          <div id="cost-image-preview" class="w-100">
            <?php $cost_media_path = $uploads . "malfunctions/" . base64_decode($_SESSION['sys']['company_id']) . "/" . $mal_info['cost_receipt']; ?>
            <?php if (!empty($mal_info['cost_receipt']) && file_exists($cost_media_path)) { ?>
              <img src="<?php echo $cost_media_path ?>" alt="<?php echo lang('COST RECEIPT', $lang_file) ?>"
                style="border: 5px solid #0d6efd; border-radius: 1rem; max-width: 100%; cursor: pointer;"
                onclick="open_media(this.src, 'jpg')">
            <?php } ?>
          </div>
        </div>
        <!-- malfunction review -->
        <div class="section-block">
          <div class="section-header">
            <h5>
              <?php echo lang('MAL REVIEW', $lang_file) ?>
            </h5>
            <hr />
          </div>
          <!-- quality of employee -->
          <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
            <select name="technical-qty" id="technical-qty" class="form-select" <?php echo $_SESSION['sys']['mal_review'] == 0 || ($mal_info['mal_status'] == 0 && $_SESSION['sys']['isTech'] == 0) || $mal_info['isAccepted'] == 2 || $mal_info['isReviewed'] == 1 ? 'disabled' : '' ?>>
              <option value="default" disabled <?php echo $mal_info['isReviewed'] == 0 ? "selected" : '' ?>>
                <?php echo lang('SELECT QTY', $lang_file) ?>
              </option>
              <option value="<?php echo base64_encode(1) ?>" <?php echo $mal_info['isReviewed'] == 1 && $mal_info['qty_emp'] == 1 ? "selected" : '' ?>>
                <?php echo lang('BAD') ?>
              </option>
              <option value="<?php echo base64_encode(2) ?>" <?php echo $mal_info['isReviewed'] == 1 && $mal_info['qty_emp'] == 2 ? "selected" : '' ?>>
                <?php echo lang('GOOD') ?>
              </option>
              <option value="<?php echo base64_encode(3) ?>" <?php echo $mal_info['isReviewed'] == 1 && $mal_info['qty_emp'] == 3 ? "selected" : '' ?>>
                <?php echo lang('VERY GOOD') ?>
              </option>
            </select>
            <label for="technical-qty">
              <?php echo lang('TECH QTY', $lang_file) ?>
            </label>
          </div>
          <!-- quality of service -->
          <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
            <select name="service-qty" id="service-qty" class="form-select" <?php echo $_SESSION['sys']['mal_review'] == 0 || ($mal_info['mal_status'] == 0 && $_SESSION['sys']['isTech'] == 0) || $mal_info['isAccepted'] == 2 || $mal_info['isReviewed'] == 1 ? 'disabled' : '' ?>>
              <option value="default" disabled <?php echo $mal_info['isReviewed'] == 0 ? "selected" : '' ?>>
                <?php echo lang('SELECT QTY', $lang_file) ?>
              </option>
              <option value="<?php echo base64_encode(1) ?>" <?php echo $mal_info['isReviewed'] == 1 && $mal_info['qty_service'] == 1 ? "selected" : '' ?>>
                <?php echo lang('BAD') ?>
              </option>
              <option value="<?php echo base64_encode(2) ?>" <?php echo $mal_info['isReviewed'] == 1 && $mal_info['qty_service'] == 2 ? "selected" : '' ?>>
                <?php echo lang('GOOD') ?>
              </option>
              <option value="<?php echo base64_encode(3) ?>" <?php echo $mal_info['isReviewed'] == 1 && $mal_info['qty_service'] == 3 ? "selected" : '' ?>>
                <?php echo lang('VERY GOOD') ?>
              </option>
            </select>
            <label for="service-qty">
              <?php echo lang('SERVICE QTY', $lang_file) ?>
            </label>
          </div>
          <!-- money review -->
          <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
            <select name="money-review" id="money-review" class="form-select" <?php echo $_SESSION['sys']['mal_review'] == 0 || ($mal_info['mal_status'] == 0 && $_SESSION['sys']['isTech'] == 0) || $mal_info['isAccepted'] == 2 || $mal_info['isReviewed'] == 1 ? 'disabled' : '' ?>>
              <option value="default" disabled <?php echo $mal_info['isReviewed'] == 0 ? "selected" : '' ?>>
                <?php echo lang('SELECT QTY', $lang_file) ?>
              </option>
              <option value="<?php echo base64_encode(1) ?>" <?php echo $mal_info['isReviewed'] == 1 && $mal_info['money_review'] == 1 ? "selected" : '' ?>>
                <?php echo lang('RIGHT') ?>
              </option>
              <option value="<?php echo base64_encode(2) ?>" <?php echo $mal_info['isReviewed'] == 1 && $mal_info['money_review'] == 2 ? "selected" : '' ?>>
                <?php echo lang('WRONG') ?>
              </option>
            </select>
            <label for="money-review">
              <?php echo lang('COST REVIEW', $lang_file) ?>
            </label>
          </div>
          <!-- employee review comment -->
          <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
            <textarea name="review-comment" id="review-comment" title="review comment" class="form-control w-100"
              style="height: 5rem; resize: none; direction: <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'rtl' : 'ltr' ?>"
              <?php echo $_SESSION['sys']['mal_review'] == 0 || ($mal_info['mal_status'] == 0 && $_SESSION['sys']['isTech'] == 0) || $mal_info['isAccepted'] == 2 || $mal_info['isReviewed'] == 1 ? 'disabled' : '' ?> placeholder="<?php echo lang('NOTE') ?>"><?php echo $mal_info['qty_comment'] ?></textarea>
            <label for="review-comment">
              <?php echo lang('NOTE') ?>
            </label>
          </div>
          <?php if ($mal_info['isReviewed']) { ?>
            <!-- reviewed date -->
            <div class="mb-1 row align-items-center">
              <label for="reviewed-date">
                <?php echo lang('REVIEWED DATE') ?>
              </label>
              <div class="col-sm-12 position-relative">
                <span class="text-primary" dir='ltr'>
                  <?php echo date_format(date_create($mal_info['reviewed_date']), 'd/m/Y') ?>
                </span>
              </div>
            </div>
            <!-- reviewed time -->
            <div class="mb-1 row align-items-center">
              <label for="reviewed-time">
                <?php echo lang('REVIEWED TIME') ?>
              </label>
              <div class="position-relative">
                <span class="text-primary" dir='ltr'>
                  <?php echo date_format(date_create($mal_info['reviewed_time']), 'h:i:s a') ?>
                </span>
              </div>
            </div>
          <?php } ?>
          <?php if ($mal_info['isReviewed'] != 0 && $mal_info['mal_status'] == 0 && $_SESSION['sys']['isTech'] == 0) { ?>
            <div class="mb-1 row align-items-center">
              <i class="bi bi-exclamation-triangle-fill"></i>&nbsp;
              <span class="text-warning" dir="<?php echo @$_SESSION['sys']['lang'] == 0 ? 'rtl' : 'ltr' ?>"
                style="text-align: <?php echo @$_SESSION['sys']['lang'] == 0 ? 'right' : 'left' ?>">
                <?php echo lang('REVIEW ERROR', $lang_file) ?>
              </span>
            </div>
          <?php } ?>
        </div>

        <!-- the malfunctions media -->
        <div class="section-block">
          <div class="section-header media-section">
            <h5 style="<?php echo $_SESSION['sys']['isTech'] == 0 ? 'padding-bottom: 0!important' : ''; ?>">
              <?php echo lang('MEDIA', $lang_file) ?>
            </h5>
            <!-- add new malfunction -->
            <?php if ($_SESSION['sys']['isTech'] == 1 && $_SESSION['sys']['mal_update'] == 1) { ?>
              <button type="button" role="button" class="btn btn-outline-primary py-1 fs-12 media-button"
                onclick="add_new_media()">
                <i class="bi bi-card-image"></i>
                <?php echo lang('ADD MEDIA', $lang_file) ?>
              </button>
            <?php } ?>
            <hr />
          </div>
          <!-- malfunction media -->
          <?php $mal_media = $mal_obj->get_malfunction_media($mal_id); ?>
          <div class="media-container" id="media-container">
            <?php if ($mal_media != null && count($mal_media) > 0) { ?>
              <?php foreach ($mal_media as $key => $media) { ?>
                <?php $media_source = $uploads . "malfunctions/" . base64_decode($_SESSION['sys']['company_id']) . "/" . $media['media'] ?>
                <?php if (file_exists($media_source)) { ?>
                  <div class="media-content">
                    <?php if ($media['type'] == 'img') { ?>
                      <img src="<?php echo $media_source ?>" alt="">
                    <?php } else { ?>
                      <video src="<?php echo $media_source ?>" controls>
                        <source src="<?php echo $media_source ?>" type="video/*">
                      </video>
                    <?php } ?>
                    <div class="control-btn">
                      <?php if ($_SESSION['sys']['mal_media_download'] == 1) { ?>
                        <button type="button" class="btn btn-primary py-1 ms-1"
                          onclick="download_media('<?php echo $media_source ?>', '<?php echo $media['type'] == 'img' ? 'jpg' : 'mp4' ?>')"
                          src="<?php echo $media_source ?>"><i class='bi bi-download'></i></a>
                        <?php } ?>
                        <?php if ($_SESSION['sys']['mal_media_delete'] == 1) { ?>
                          <button type="button" class="btn btn-danger py-1 ms-1" onclick="delete_media(this)"
                            data-media-id="<?php echo base64_encode($media['id']); ?>"
                            data-media-name="<?php echo $media['media']; ?>"><i class="bi bi-trash"></i></button>
                        <?php } ?>
                        <button type="button" class="btn btn-primary"
                          onclick="open_media('<?php echo $media_source ?>', '<?php echo $media['type'] == 'img' ? 'jpg' : 'mp4' ?>')"><i
                            class="bi bi-eye"></i></button>
                    </div>
                  </div>
                <?php } else { ?>
                  <div class="alert alert-danger">
                    <h6 class="h6 text-danger fw-bold">
                      <i class="bi bi-exclamation-triangle-fill"></i>
                      <?php echo lang('MEDIA FAILED') ?>
                    </h6>
                  </div>
                <?php } ?>
              <?php } ?>
            <?php } else { ?>
              <div class="alert alert-danger">
                <h6 class="h6 text-danger fw-bold">
                  <i class="bi bi-exclamation-triangle-fill"></i>
                  <?php echo lang('NO DATA') ?>
                </h6>
              </div>
            <?php } ?>
          </div>
          <!-- malfunction media file info -->
          <div class="d-none" id="file-inputs"></div>
        </div>

        <?php
        // get malfunction updates info
        $mal_updates = $mal_obj->get_malfunction_updates($mal_id);
        // check malfunctions updates details
        if ($mal_updates != null && count($mal_updates) > 0) {
          ?>
          <div class="malfunction-info-container__row section-block">
            <div class="section-header">
              <h5>
                <?php echo lang('MAL UPDATES', $lang_file) ?>
              </h5>
              <hr />
            </div>
            <div class="table-responsive-sm">
              <table class="table table-bordered table-striped table-striped no-index  display compact w-100">
                <thead class="primary text-capitalize">
                  <tr>
                    <td>#</td>
                    <td>
                      <?php echo lang('UPDATED BY', $lang_file) ?>
                    </td>
                    <td>
                      <?php echo lang('UPDATED AT', $lang_file) ?>
                    </td>
                    <td style="min-width: 300px">
                      <?php echo lang('UPDATES', $lang_file) ?>
                    </td>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($mal_updates as $key => $update) { ?>
                    <tr>
                      <td>
                        <?php echo ++$key ?>
                      </td>
                      <td>
                        <?php if ($update['updated_by'] == 0) {
                          echo lang('SYS TREE');
                        } else { ?>
                          <?php $username = $mal_obj->select_specific_column("`UserName`", "`users`", "WHERE `UserID` = " . $update['updated_by'])[0]['UserName']; ?>
                          <?php if ($_SESSION['sys']['user_show']) { ?>
                            <a
                              href="<?php echo $nav_up_level ?>users/index.php?do=edit-user-info&userid=<?php echo base64_encode($update['updated_by']); ?>">
                              <?php echo $username ?>
                            </a>
                          <?php } else { ?>
                            <?php echo $username ?>
                          <?php } ?>
                        <?php } ?>
                      </td>
                      <td>
                        <?php echo date('d/m/Y h:ia', strtotime($update['updated_at'])) ?>
                      </td>
                      <td>
                        <?php echo lang(strtoupper($update['updates']), $lang_file) ?>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        <?php } ?>
      </div>
      <!-- submit -->
      <div class="mt-3 hstack gap-2">
        <?php if ($_SESSION['sys']['mal_update'] == 1) { ?>
          <div class="<?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'me-auto' : 'ms-auto' ?>">
            <button type="submit" form="edit-malfunction-info"
              class="btn btn-primary text-capitalize form-control bg-gradient fs-12 py-1" id="update-malfunctions">
              <i class="bi bi-check-all"></i>&nbsp;
              <?php echo lang('SAVE') ?>
            </button>
          </div>
        <?php } ?>
        <?php if ($_SESSION['sys']['mal_delete'] == 1) { ?>
          <div>
            <button type="button" class="btn btn-outline-danger text-capitalize form-control bg-gradient fs-12 py-1"
              data-bs-toggle="modal" data-bs-target="#delete-malfunction-modal"
              data-mal-id="<?php echo base64_encode($mal_info['mal_id']) ?>" onclick="put_mal_data_into_modal(this)">
              <i class="bi bi-trash"></i>&nbsp;
              <?php echo lang('DELETE') ?>
            </button>
          </div>
        <?php } ?>
      </div>
    </form>
    <!-- end form -->
    <!-- media modal -->
    <div id="media-modal" class="media-modal">
      <span class="close" id="media-modal-close">&times;</span>
      <div id="media-modal-content"></div>
    </div>
  </div>

  <?php if ($_SESSION['sys']['mal_delete'] == 1) {
    include_once 'delete-malfunction-modal.php';
  } ?>
<?php } else {
  // prepare flash session variables
  $_SESSION['flash_message'] = 'NO DATA';
  $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
  $_SESSION['flash_message_class'] = 'danger';
  $_SESSION['flash_message_status'] = false;
  $_SESSION['flash_message_lang_file'] = 'global_';
  // redirect to the previous page 
  redirect_home(null, 'back', 0);
}