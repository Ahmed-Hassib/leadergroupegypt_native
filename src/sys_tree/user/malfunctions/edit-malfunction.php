<?php 
// create an object of Malfunction class
$mal_obj = new Malfunction();
// get malfunction id 
$mal_id = isset($_GET['malid']) && !empty($_GET['malid']) ? intval($_GET['malid']) : 0;
// check if malid exist
$is_exist_mal = $mal_obj->is_exist("`mal_id`", "`malfunctions`", $mal_id);
// check
if ($is_exist_mal == true) {
  // get malfunction details
  $mal_details = $mal_obj->get_spec_malfunction($mal_id, $_SESSION['company_id']);
  // malfunction status
  $mal_status_exist = $mal_details[0];
  // malfunction info
  if ($mal_status_exist == true) {
    // get mal info
    $mal_info = $mal_details[1][0];
  }

  // check if malfunction is showed or not
  if ($mal_info['isShowed'] == 0) {
    if ($_SESSION['UserID'] == $mal_info['tech_id']) {
      // update some info of this malfunction
      $q = "UPDATE `malfunctions` SET `isShowed` = 1, `showed_date` = CURRENT_DATE(), `showed_time` = CURRENT_TIME() WHERE `mal_id` = ? AND `company_id` = ?";
      $stmt = $con->prepare($q);     
      $stmt->execute(array($mal_id,  $_SESSION['company_id']));               // execute data 
    }
  }
?>
  <!-- start add new user page -->
  <div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
    <!-- start form -->
    <form class="custom-form" action="?do=update-malfunction-info" method="POST" enctype="multipart/form-data" id="edit-malfunction-info">
      <!-- submit -->
      <div class="mb-3 hstack gap-2">
        <div class="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'me-auto' : 'ms-auto' ?>">
        <button type="submit" form="edit-malfunction-info" class="btn btn-primary text-capitalize form-control bg-gradient fs-12 py-1" id="update-malfunctions" <?php if (($_SESSION['mal_update'] == 0 && $mal_info['isReviewed'] == 1) || ($_SESSION['UserID'] != $mal_info['tech_id'] && $_SESSION['mal_update'] == 0)) {echo 'disabled';} ?>>
          <i class="bi bi-check-all"></i>&nbsp;<?php echo language('SAVE CHANGES', @$_SESSION['systemLang']) ?>
        </button>
        </div>
        <div>
        <button type="button" class="btn btn-outline-danger text-capitalize form-control bg-gradient fs-12 py-1" data-bs-toggle="modal" data-bs-target="#deleteMalModal" <?php if ($_SESSION['mal_delete'] == 0) {echo 'readonly';} ?> >
          <i class="bi bi-trash"></i>&nbsp;<?php echo language('DELETE', @$_SESSION['systemLang']) ?>
        </button>
        </div>
      </div>
      <!-- form content -->
      <div class="mb-3 row row-cols-sm-1 row-cols-md-2 g-3">
        <!-- the employees that responsible for the malfunctions -->
        <div class="col-12">
          <div class="row g-3">
            <div class="col-12">
                <div class="section-block">
                  <div class="section-header">
                    <h5><?php echo language('RESPONSIBLE FOR REPAIR INFO', @$_SESSION['systemLang']) ?></h5>
                    <hr />
                  </div>
                  <!-- malfunctions id -->
                  <input type="hidden" name="mal-id" id="mal-id" value="<?php echo $mal_info['mal_id'] ?>">
                  <!-- Administrator name -->
                  <div class="mb-sm-2 mb-md-3 row align-items-center">
                    <label for="admin-name" class="col-sm-12 col-form-label text-capitalize"><?php echo language('ADMIN NAME', @$_SESSION['systemLang']) ?></label>
                    <div class="col-sm-12 position-relative">
                      <?php $admin_name = $mal_obj->select_specific_column("`UserName`", "`users`", "WHERE `UserID` = '" . $mal_info['mng_id'] . "' LIMIT 1")[0]['UserName']; ?>
                      <input type="hidden" class="form-control" id="admin-id" name="admin-id" value="<?php echo $mal_info['mng_id'] ?>" autocomplete="off" required />
                      <input type="text" class="form-control" id="admin-name" name="admin-name" placeholder="<?php echo language('ADMIN NAME', @$_SESSION['systemLang']) ?>" value="<?php echo $admin_name ?>" autocomplete="off" required disabled />
                    </div>
                  </div>
                  <!-- Technical name -->
                  <div class="mb-sm-2 mb-md-3 row align-items-center">
                    <label for="technical-id" class="col-sm-12 col-form-label text-capitalize"><?php echo language('TECHNICAL NAME', @$_SESSION['systemLang']) ?></label>
                    <div class="col-sm-12 position-relative">
                      <!-- select tag for technical -->
                      <select class="form-select" id="technical-id" name="tech-id" <?php if ($_SESSION['isTech'] == 1 || $_SESSION['mal_update'] == 0 || $mal_info['mal_status'] == 1) {echo 'disabled';} ?>>
                        <option  value="default" disabled selected><?php echo language('SELECT', @$_SESSION['systemLang'])." ".language('THE TECHNICAL', @$_SESSION['systemLang']) ?></option>
                        <?php $usersRows = $mal_obj->select_specific_column("`UserID`, `UserName`", "`users`", "WHERE `isTech` = 1 AND `company_id` = " . $_SESSION['company_id']); ?>
                        <?php if (count($usersRows) > 0) { ?>
                          <?php foreach ($usersRows as $userRow) { ?>
                            <option value="<?php echo $userRow['UserID'] ?>" <?php if ($userRow['UserID'] == $mal_info['tech_id']) { echo 'selected'; } ?>>
                              <?php echo $userRow['UserName']; ?>
                            </option>
                          <?php } ?>
                        <?php } else { ?>
                          <option><?php echo language('NOT AVAILABLE NOW', @$_SESSION['systemLang']) ?></option>
                        <?php } ?>
                      </select>
                      <input type="hidden" name="technical-id" id="technical-id-value" value="">
                    </div>
                  </div>
                </div>
            </div>
            <div class="col-12">
              <div class="section-block">
                <header class="section-header">
                  <h5 class="h5"><?php echo language("MALFUNCTION STATUS", @$_SESSION['systemLang']) ?></h5>
                  <hr>
                </header>
                <!-- status -->
                <div class="mb-sm-2 mb-md-3 row align-items-center">
                  <label for="mal-status" class="col-sm-12 col-form-label text-capitalize pt-0"><?php echo language('STATUS', @$_SESSION['systemLang']) ?></label>
                  <div class="col-sm-12 position-relative" id="mal-status">
                    <select name="mal-status" id="mal-status" class="form-select" <?php if ($_SESSION['isTech'] == 0 || $mal_info['mal_status'] == 1) {echo 'disabled';} ?>>
                      <option value="default" disabled selected><?php echo language("SELECT", @$_SESSION['systemLang']).' '.language("STATUS", @$_SESSION['systemLang']) ?></option>
                      <option value="0" <?php if ($mal_info['mal_status'] == 0) { echo 'selected'; } ?>><?php echo language('UNREPAIRED', @$_SESSION['systemLang']) ?></option>
                      <option value="1" <?php if ($mal_info['mal_status'] == 1) { echo 'selected'; } ?>><?php echo language('REPAIRED', @$_SESSION['systemLang']) ?></option>
                      <option value="2" <?php if ($mal_info['mal_status'] == 2) { echo 'selected'; } ?>><?php echo language('DELAYED', @$_SESSION['systemLang']) ?></option>
                    </select>
                  </div>
                </div>
                <!-- tech_status -->
                <div class="mb-sm-2 mb-md-3 row align-items-center">
                  <label for="tech-status" class="col-sm-12 col-form-label text-capitalize pt-0"><?php echo language('TECH STATUS', @$_SESSION['systemLang']) ?></label>
                  <div class="col-sm-12 position-relative" id="tech-status">
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="tech-status" id="tech-status-not-accepted" value="0" <?php if ($mal_info['isAccepted'] == 0) { echo 'checked'; } ?> <?php if ($_SESSION['isTech'] == 0 || $mal_info['mal_status'] == 1) {echo 'disabled';} ?> onclick="document.querySelector('#tech-status-comment').removeAttribute('disabled'); document.querySelector('#tech-status-comment').setAttribute('required', 'required')">
                      <label class="form-check-label" for="tech-status-not-accepted"><?php echo language('NOT ACCEPTED', @$_SESSION['systemLang']) ?></label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="tech-status" id="tech-status-delayed" value="2" <?php if ($mal_info['isAccepted'] == 2) { echo 'checked'; } ?> <?php if ($_SESSION['isTech'] == 0 || $mal_info['mal_status'] == 1) {echo 'disabled';} ?> onclick="document.querySelector('#tech-status-comment').removeAttribute('disabled'); document.querySelector('#tech-status-comment').setAttribute('required', 'required')">
                      <label class="form-check-label" for="tech-status-delayed"><?php echo language('DELAYED', @$_SESSION['systemLang']) ?></label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>    
        <!-- client information -->
        <div class="col-12">
          <div class="section-block">
            <div class="section-header">
              <h5><?php echo language('PIECE/CLIENT INFO', @$_SESSION['systemLang']) ?></h5>
              <hr />
            </div>
            
            <!-- client name -->
            <div class="mb-1 row align-items-center">
              <label for="client-name" class="col-sm-12 col-form-label text-capitalize"><?php echo language('CLIENT NAME', @$_SESSION['systemLang']) ?></label>
              <div class="col-sm-12 position-relative position-relative">
                <?php $client_details = $mal_obj->select_specific_column("`id`, `full_name`, `ip`, `is_client`", "`pieces_info`", "WHERE `id` = '" . $mal_info['client_id'] . "' LIMIT 1")[0]; ?>
                <input type="hidden" name="client-id" id="client-id" class="form-control w-100" placeholder="Client ID" value="<?php echo $mal_info['client_id'] ?>" />
                <a class="text-primary" href="<?php echo $nav_up_level ?>pieces/index.php?name=<?php echo $client_details['is_client'] == 1 ? 'clients' : 'pieces' ?>&do=edit-piece&piece-id=<?php echo $mal_info['client_id']?>" target="_blank"><?php echo $client_details['full_name'] ?></a>
              </div>
            </div>
            <!-- client address -->
            <div class="mb-1 row align-items-center">
              <label for="client-addr" class="col-sm-12 col-form-label text-capitalize"><?php echo language('THE ADDRESS', @$_SESSION['systemLang']) ?></label>
              <div class="col-sm-12 position-relative position-relative">
                <?php $client_addr = $mal_obj->select_specific_column("`address`", "`pieces_addr`", "WHERE `id` = '" . $mal_info['client_id'] . "' LIMIT 1"); ?>
                <?php if (!empty($client_addr)) { ?> 
                  <span class="text-primary"><?php echo $client_addr[0]['address']; ?></span>
                <?php } else { ?>
                  <span class="text-danger"><?php echo language('NO DATA ENTERED', @$_SESSION['systemLang']); ?></span>
                <?php } ?>
              </div>
            </div>
            <!-- client address -->
            <div class="mb-1 row align-items-center">
              <label for="client-addr" class="col-sm-12 col-form-label text-capitalize"><?php echo language('PHONE', @$_SESSION['systemLang']) ?></label>
              <div class="col-sm-12 position-relative position-relative">
                <?php $client_phone = $mal_obj->select_specific_column("`phone`", "`pieces_phones`", "WHERE `id` = '" . $mal_info['client_id'] . "' LIMIT 1"); ?>
                <?php if (!empty($client_phone)) { ?> 
                  <span class="text-primary"><?php echo $client_phone[0]['phone']; ?></span>
                <?php } else { ?>
                  <span class="text-danger"><?php echo language('NO DATA ENTERED', @$_SESSION['systemLang']); ?></span>
                <?php } ?>
              </div>
            </div>
            <!-- client ip -->
            <div class="mb-1 row align-items-center">
              <label for="client-ip" class="col-sm-12 col-form-label text-capitalize"><span class="text-uppercase"><?php echo language('IP', @$_SESSION['systemLang']) ?></span></label>
              <div class="col-sm-12 position-relative position-relative">
                <?php if (!empty($client_details['ip'] != 1)) { ?> 
                  <span class="text-primary"><?php echo $client_details['ip']; ?></span>
                <?php } else { ?>
                  <span class="text-danger"><?php echo language('NO DATA ENTERED', @$_SESSION['systemLang']); ?></span>
                <?php } ?>
              </div>
            </div>
            <!-- malfunctions counter -->
            <?php $malCounter = countRecords("`mal_id`", "`malfunctions`", "WHERE `client_id` = ".$mal_info['client_id']) ?>
            <div class="mb-1 row align-items-center">
              <label for="malfunction-counter" class="col-sm-12 col-form-label text-capitalize"><?php echo language('MALFUNCTIONS COUNTER', @$_SESSION['systemLang']) ?></label>
              <div class="col-sm-12 position-relative">
                <span class="text-start" dir="<?php echo @$_SESSION['systemLang'] == "ar" ? "rtl" : "ltr" ?>"><?php echo $malCounter . " " . ($malCounter > 2 ? language("MALFUNCTIONS", @$_SESSION['systemLang']) : language("MALFUNCTION", @$_SESSION['systemLang'])) ?></span>
                <a href="?do=show-pieces-malfunctions&pieceid=<?php echo $mal_info['client_id'] ?>" class="mt-2 text-start" dir="<?php echo @$_SESSION['systemLang'] == "ar" ? "rtl" : "ltr" ?>"><?php echo language("SHOW DETAILS", @$_SESSION['systemLang']) ?></a>
              </div>
            </div>
          </div>
        </div>
        
        <!-- malfunction date and time -->
        <div class="col-12">
          <div class="section-block">
            <div class="section-header">
              <h5><?php echo language('DATE & TIME INFO', @$_SESSION['systemLang']) ?></h5>
              <hr />
            </div>
            <!-- added date -->
            <div class="mb-1 row align-items-center">
              <label for="added-date" class="col-sm-12 col-form-label text-capitalize"><?php echo language('ADDED DATE', @$_SESSION['systemLang']) ?></label>
              <div class="col-sm-12 position-relative">
                <span class="text-primary" dir='ltr'><?php echo date_format(date_create($mal_info['added_date']), 'd/m/Y') ?></span>
              </div>
            </div>
            <!-- added time -->
            <div class="mb-1 row align-items-center">
              <label for="added-time" class="col-sm-12 col-form-label text-capitalize"><?php echo language('ADDED TIME', @$_SESSION['systemLang']) ?></label>
              <div class="col-sm-12 position-relative">
                <span class="text-primary" dir='ltr'><?php echo date_format(date_create($mal_info['added_time']), 'h:i:s a') ?></span>
              </div>
            </div>
            <!-- showed date -->
            <div class="mb-1 row align-items-center">
              <label for="showed-date" class="col-sm-12 col-form-label text-capitalize"><?php echo language('SHOWED DATE', @$_SESSION['systemLang']) ?></label>
              <div class="col-sm-12 position-relative">
                <?php if ($mal_info['isShowed']) { ?>
                  <span class="text-primary" dir='ltr'><?php echo date_format(date_create($mal_info['showed_date']), 'd/m/Y') ?></span>
                <?php } else { ?>
                  <span class="pt-2 text-danger"><?php echo language('NOT SHOWED BY THE TECHNICAL', @$_SESSION['systemLang']) ?></span>
                <?php } ?>
              </div>
            </div>
            <!-- showed time -->
            <div class="mb-1 row align-items-center">
              <label for="showed-time" class="col-sm-12 col-form-label text-capitalize"><?php echo language('SHOWED TIME', @$_SESSION['systemLang']) ?></label>
              <div class="col-sm-12 position-relative">
                <?php if ($mal_info['isShowed']) { ?>
                  <span class="text-primary" dir='ltr'><?php echo date_format(date_create($mal_info['showed_time']), 'h:i:s a') ?></span>
                <?php } else { ?>
                  <span class="pt-2 text-danger"><?php echo language('NOT SHOWED BY THE TECHNICAL', @$_SESSION['systemLang']) ?></span>
                <?php } ?>
              </div>
            </div>
            <!-- repaired date -->
            <div class="mb-1 row align-items-center">
              <label for="repaired-date" class="col-sm-12 col-form-label text-capitalize">
                <?php if ($mal_info['mal_status'] == 1 && $mal_info['isAccepted'] != 2) {
                  echo language('REPAIRED DATE', @$_SESSION['systemLang']);
                } else {
                  echo language('DELAYED DATE', @$_SESSION['systemLang']);
                } ?>
              </label>
              <div class="col-sm-12 position-relative">
                <?php if ($mal_info['mal_status']) { ?>
                  <span class="text-primary" dir='ltr'><?php echo date_format(date_create($mal_info['repaired_date']), 'd/m/Y') ?></span>
                <?php } else { ?>
                  <span class="pt-2 text-danger"><?php echo language('NOT REPAIRED BY THE TECHNICAL', @$_SESSION['systemLang']) ?></span>
                <?php } ?>
              </div>
            </div>
            <!-- repaired time -->
            <div class="mb-1 row align-items-center">
              <label for="repaired-time" class="col-sm-12 col-form-label text-capitalize">
                <?php if ($mal_info['mal_status'] == 1 && $mal_info['isAccepted'] != 2) {
                  echo language('REPAIRED TIME', @$_SESSION['systemLang']);
                } else {
                  echo language('DELAYED TIME', @$_SESSION['systemLang']);
                } ?>
              </label>
              <div class="col-sm-12 position-relative">
                <?php if ($mal_info['mal_status']) { ?>
                  <span class="text-primary" dir='ltr'><?php echo date_format(date_create($mal_info['repaired_time']), 'h:i:s a') ?></span>
                <?php } else { ?>
                  <span class="text-danger"><?php echo language('NOT REPAIRED BY THE TECHNICAL', @$_SESSION['systemLang']) ?></span>
                <?php } ?>
              </div>
            </div>
            <?php if ($mal_info['mal_status'] == 1) { ?>
              <!-- diff time -->
              <div class="mb-1 row align-items-center">
                <label for="showed-time" class="col-sm-12 col-form-label text-capitalize"><?php echo language('REPAIRED PERIOD', @$_SESSION['systemLang']) ?></label>
                <div class="col-sm-12 position-relative pt-2">
                  <?php
                    $diff= [];
                    if ($mal_info['showed_time'] != '00:00:00' && $mal_info['repaired_time'] != '00:00:00') {
                      $showed_date = date_create($mal_info['showed_date']);        // showed date
                      $repaired_date = date_create($mal_info['repaired_date']);      // repaired date
                      // get the diffrence of days
                      $diff_date = date_diff($showed_date, $repaired_date, true);

                      $showed_time = date_create($mal_info['showed_time']);     // showed time
                      $repaired_time = date_create($mal_info['repaired_time']);   // repaired time
                      // get the diffrence
                      $diff_time = date_diff($repaired_time, $showed_time, true);

                      $days = $diff_date->d;
                      $hours = $diff_time->h;
                      $minutes = $diff_time->i;
                      $seconds = $diff_time->s;
                  ?>
                    <span class="text-primary">
                      <?php echo ($days > 0 ? "$days " . language($days > 1 ? 'DAYS' : 'DAY', @$_SESSION['systemLang']).", " : '') . ($hours > 0 ? " $hours " . language($hours > 1 ? 'HOURS' : 'HOUR', @$_SESSION['systemLang']) . ", " : '') . ($minutes > 0 ? " $minutes " . language($minutes > 1 ? 'MINUTES' : 'MINUTE', @$_SESSION['systemLang']).", " : '') . ($seconds > 0 ? " $seconds " . language($seconds > 1 ? 'SECONDS' : 'SECOND', @$_SESSION['systemLang']).". " : '') ?>
                    </span>
                  <?php } else { ?>
                    <span class="text-danger"><?php echo language('THE TECHNICAL MAN DIDN`T REPAIR THE MALFUNCTION TO CALCULATE THE MALFUNCTION REPAIRED PERIOD', @$_SESSION['systemLang']) ?></span>
                  <?php } ?>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
        <!-- additional info -->
        <div class="col-12">
          <div class="section-block">
            <div class="section-header">
              <h5><?php echo language('ADDITIONAL INFO', @$_SESSION['systemLang']) ?></h5>
              <hr />
            </div>
            <!-- description -->
            <div class="mb-sm-2 mb-md-3 row align-items-center">
              <label for="descreption" class="col-sm-12 col-form-label text-capitalize"><?php echo language('MALFUNCTION DESCRIPTION', @$_SESSION['systemLang']) ?></label>
              <div class="col-sm-12 position-relative">
                <textarea name="descreption" id="descreption" title="describe the malfunction" class="form-control w-100" style="height: 5rem; resize: none; direction: <?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>" placeholder="Describe the malfunction" required <?php if ($_SESSION['isTech'] == 1 || $mal_info['mal_status'] == 1) {echo 'disabled';} ?>><?php echo $mal_info['descreption'] ?></textarea>
              </div>
            </div>
            <!-- technical man comment -->
            <div class="mb-sm-2 mb-md-3 row align-items-center">
              <label for="comment" class="col-sm-12 col-form-label text-capitalize"><?php echo language('TECHNICAL MAN COMMENT', @$_SESSION['systemLang']) ?></label>
              <div class="col-sm-12 position-relative">
                <textarea name="comment" id="comment" class="form-control w-100" style="height: 5rem; resize: none; direction: <?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>" <?php if ($_SESSION['isTech'] == 0 || $mal_info['mal_status'] == 1) {echo 'disabled';} ?>><?php echo empty($mal_info['tech_comment']) && $mal_info['mal_status'] == 1 ? "لا يوجد تعليق من الفني" : $mal_info['tech_comment']; ?></textarea>
              </div>
            </div>
            <!-- technical man comment -->
            <div class="mb-sm-2 mb-md-3 row align-items-center">
              <label for="tech-status-comment" class="col-sm-12 col-form-label text-capitalize"><?php echo language('REASONS FOR REJECTION OR POSTPONEMENT', @$_SESSION['systemLang']) ?></label>
              <div class="col-sm-12 position-relative">
                <textarea name="tech-status-comment" id="tech-status-comment" class="form-control w-100" style="height: 5rem; resize: none; direction: <?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>" <?php if ($_SESSION['isTech'] == 0 || $mal_info['mal_status'] == 1) {echo 'disabled';} ?>><?php echo empty($mal_info['tech_status_comment']) && $mal_info['mal_status'] == 1 ? "لا يوجد تعليق من الفني" : $mal_info['tech_status_comment']; ?></textarea>
              </div>
            </div>
            <!-- cost -->
            <div class="mb-sm-2 mb-md-3 row align-items-center">
              <label for="cost" class="col-sm-12 col-form-label text-capitalize"><?php echo language('MALFUNCTION COST', @$_SESSION['systemLang']) ?></label>
              <div class="col-sm-12 position-relative">
                <div class="row">
                  <div class="col-4">
                    <input name="cost" id="cost" class="form-control"  placeholder="<?php echo language('MALFUNCTION COST', @$_SESSION['systemLang']) ?>" value="<?php echo $mal_info['cost'] ?>" <?php if ($_SESSION['isTech'] == 0 || $mal_info['mal_status'] == 1) {echo 'disabled';} ?> >
                  </div>
                  <div class="mt-2 col">
                    <span><?php echo language('L.E', @$_SESSION['systemLang']) ?></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- malfunction review -->
        <div class="col-12">
          <div class="section-block">
            <div class="section-header">
              <h5><?php echo language('MALFUNCTION REVIEW', @$_SESSION['systemLang']) ?></h5>
              <hr />
            </div>
            <!-- quality of employee -->
            <div class="mb-sm-2 mb-md-3 row align-items-center">
              <label for="technical-qty" class="col-sm-12 col-form-label text-capitalize"><?php echo language('QUALITY OF TECHNICAL MAN', @$_SESSION['systemLang']) ?></label>
              <div class="col-sm-12 position-relative">
                <select name="technical-qty" id="technical-qty" class="form-select" <?php if ($_SESSION['mal_review'] == 0 || ($mal_info['mal_status'] == 0 && $_SESSION['isTech'] == 0) || $mal_info['isAccepted'] == 2 || $mal_info['isReviewed'] == 1) {echo 'disabled';} ?> >
                  <option  value="default" disabled <?php if ($mal_info['isReviewed'] == 0) {echo "selected";} ?>><?php echo language('SELECT', @$_SESSION['systemLang'])." ".language('TYPE', @$_SESSION['systemLang'])." ".language('QUALITY OF TECHNICAL MAN', @$_SESSION['systemLang']) ?></option>
                  <option value="1" <?php if ($mal_info['isReviewed'] == 1 && $mal_info['qty_emp'] == 1) {echo "selected";} ?>><?php echo language('BAD', @$_SESSION['systemLang']) ?></option>
                  <option value="2" <?php if ($mal_info['isReviewed'] == 1 && $mal_info['qty_emp'] == 2) {echo "selected";} ?>><?php echo language('GOOD', @$_SESSION['systemLang']) ?></option>
                  <option value="3" <?php if ($mal_info['isReviewed'] == 1 && $mal_info['qty_emp'] == 3) {echo "selected";} ?>><?php echo language('VERY GOOD', @$_SESSION['systemLang']) ?></option>
                </select>
              </div>
            </div>
            <!-- quality of service -->
            <div class="mb-sm-2 mb-md-3 row align-items-center">
              <label for="service-qty" class="col-sm-12 col-form-label text-capitalize"><?php echo language('QUALITY OF SERVICE', @$_SESSION['systemLang']) ?></label>
              <div class="col-sm-12 position-relative">
                <select name="service-qty" id="service-qty" class="form-select" <?php if ($_SESSION['mal_review'] == 0 || ($mal_info['mal_status'] == 0 && $_SESSION['isTech'] == 0) || $mal_info['isAccepted'] == 2 || $mal_info['isReviewed'] == 1) {echo 'disabled';} ?> >
                  <option  value="default" disabled <?php if ($mal_info['isReviewed'] == 0) {echo "selected";} ?>><?php echo language('SELECT', @$_SESSION['systemLang'])." ".language('TYPE', @$_SESSION['systemLang'])." ".language('QUALITY OF SERVICE', @$_SESSION['systemLang']) ?></option>
                  <option value="1" <?php if ($mal_info['isReviewed'] == 1 && $mal_info['qty_service'] == 1) {echo "selected";} ?>><?php echo language('BAD', @$_SESSION['systemLang']) ?></option>
                  <option value="2" <?php if ($mal_info['isReviewed'] == 1 && $mal_info['qty_service'] == 2) {echo "selected";} ?>><?php echo language('GOOD', @$_SESSION['systemLang']) ?></option>
                  <option value="3" <?php if ($mal_info['isReviewed'] == 1 && $mal_info['qty_service'] == 3) {echo "selected";} ?>><?php echo language('VERY GOOD', @$_SESSION['systemLang']) ?></option>
                </select>
              </div>
            </div>
            <!-- money review -->
            <div class="mb-sm-2 mb-md-3 row align-items-center">
              <label for="money-review" class="col-sm-12 col-form-label text-capitalize"><?php echo language('COST REVIEW', @$_SESSION['systemLang']) ?></label>
              <div class="col-sm-12 position-relative">
                <select name="money-review" id="money-review" class="form-select" <?php if ($_SESSION['mal_review'] == 0 || ($mal_info['mal_status'] == 0 && $_SESSION['isTech'] == 0) || $mal_info['isAccepted'] == 2 || $mal_info['isReviewed'] == 1) {echo 'disabled';} ?> >
                  <option  value="default" disabled <?php if ($mal_info['isReviewed'] == 0) {echo "selected";} ?>><?php echo language('SELECT', @$_SESSION['systemLang'])." ".language('TYPE', @$_SESSION['systemLang'])." ".language('COST REVIEW', @$_SESSION['systemLang']) ?></option>
                  <option value="1" <?php if ($mal_info['isReviewed'] == 1 && $mal_info['money_review'] == 1) {echo "selected";} ?> ><?php echo language('RIGHT', @$_SESSION['systemLang']) ?></option>
                  <option value="2" <?php if ($mal_info['isReviewed'] == 1 && $mal_info['money_review'] == 2) {echo "selected";} ?> ><?php echo language('NOT RIGHT', @$_SESSION['systemLang']) ?></option>
                </select>
              </div>
            </div>
            <!-- employee review comment -->
            <div class="mb-sm-2 mb-md-3 row align-items-center">
              <label for="review-comment" class="col-sm-12 col-form-label text-capitalize"><?php echo language('REVIEW COMMENT', @$_SESSION['systemLang']) ?></label>
              <div class="col-sm-12 position-relative">
                <textarea name="review-comment" id="review-comment" title="review comment" class="form-control w-100" style="height: 5rem; resize: none; direction: <?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>"  <?php if ($_SESSION['mal_review'] == 0 || ($mal_info['mal_status'] == 0 && $_SESSION['isTech'] == 0) || $mal_info['isAccepted'] == 2 || $mal_info['isReviewed'] == 1) {echo 'disabled';} ?> ><?php echo $mal_info['qty_comment'] ?></textarea>
              </div>
            </div>
            <?php if ($mal_info['isReviewed']) { ?>
              <!-- reviewed date -->
              <div class="mb-1 row align-items-center">
                <label for="reviewed-date" class="col-sm-12 col-form-label text-capitalize"><?php echo language('REVIEWED DATE', @$_SESSION['systemLang']) ?></label>
                <div class="col-sm-12 position-relative">
                  <span class="text-primary" dir='ltr'><?php echo date_format(date_create($mal_info['reviewed_date']), 'd/m/Y') ?></span>
                </div>
              </div>
              <!-- reviewed time -->
              <div class="mb-1 row align-items-center">
                <label for="reviewed-time" class="col-sm-12 col-form-label text-capitalize"><?php echo language('REVIEWED TIME', @$_SESSION['systemLang']) ?></label>
                <div class="col-sm-12 position-relative">
                  <span class="text-primary" dir='ltr'><?php echo date_format(date_create($mal_info['reviewed_time']), 'h:i:s a') ?></span>
                </div>
              </div>
            <?php } ?>
            <?php if ($mal_info['isReviewed'] != 0 && $mal_info['mal_status'] == 0 && $_SESSION['isTech'] == 0) { ?> 
              <div class="mb-1 row align-items-center">
                <span class="text-info" dir="<?php echo @$_SESSION['systemLang'] == 0 ? 'rtl' : 'ltr' ?>" style="text-align: <?php echo @$_SESSION['systemLang'] == 0 ? 'right' : 'left' ?>"><?php echo language('THAT IS NOT POSSIBLE TO REVIEW THE MALFUNCTION BERFORE REPAIR IT', @$_SESSION['systemLang']) ?></span>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>

      <!-- the malfunctions media -->
      <div class="mb-3 row row-cols-sm-1 g-3">
        <div class="col-12">
          <div class="section-block">
            <div class="section-header">
              <h5><?php echo language('MALFUNCTION MEDIA', @$_SESSION['systemLang']) ?></h5>
              <!-- add new malfunction -->
              <?php if ($_SESSION['isTech'] == 1) {?>
              <button type="button" role="button" class="btn btn-outline-primary py-1 fs-12 media-button" onclick="add_new_media()">
                <i class="bi bi-card-image"></i>
                <?php echo language('ADD NEW PHOTO', @$_SESSION['systemLang']) ?>
              </button>
              <?php } ?>
              <hr />
            </div>
            <!-- malfunction media -->
            <?php $mal_media = $mal_obj->get_malfunction_media($mal_id); ?>
            <div class="row row-cols-sm-1 row-cols-md-3 justify-content-center align-items-stretched g-3" id="media-container">
            <?php if ($mal_media != null && count($mal_media) > 0) { ?>
              <?php foreach ($mal_media as $key => $media) { ?>
                <?php $media_source = $uploads . "malfunctions/" . $_SESSION['company_id'] ."/". $media['media'] ?>
                <?php if (file_exists($media_source)) { ?>
                  <div class="col-12 col-media">
                    <?php if ($media['type'] == 'img') { ?>
                      <img src="<?php echo $media_source ?>" alt="">
                    <?php } ?>
                    <?php if ($_SESSION['isTech'] == 1) { ?>
                    <div class="control-btn">
                      <button type="button" class="btn btn-danger py-1 ms-1" onclick="delete_media(this)" data-media-id="<?php echo $media['id']; ?>" data-media-name="<?php echo $media['media']; ?>"><i class="bi bi-trash"></i></button>
                    </div>
                    <?php } ?>
                  </div>
                <?php } else { ?>
                  <div class="alert alert-danger">
                    <h6 class="h6 text-danger fw-bold">
                      <i class="bi bi-exclamation-triangle-fill"></i>
                      <?php echo language('THERE IS NO MEDIA TO SHOW', @$_SESSION['systemLang']) ?>
                    </h6>
                  </div>
                <?php } ?>
              <?php } ?>
            <?php } else { ?>
              <div class="alert alert-danger">
                <h6 class="h6 text-danger fw-bold">
                  <i class="bi bi-exclamation-triangle-fill"></i>
                  <?php echo language('THERE IS NO MEDIA TO SHOW', @$_SESSION['systemLang']) ?>
                </h6>
              </div>
            <?php } ?>
            </div>
            <!-- malfunction media file info -->
            <div class="d-none" id="file-inputs"></div>
          </div>
        </div>
      </div>

      <!-- submit -->
      <div class="hstack gap-2">
        <div class="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'me-auto' : 'ms-auto' ?>">
          <button type="submit" form="edit-malfunction-info" class="btn btn-primary text-capitalize form-control bg-gradient fs-12 py-1" id="update-malfunctions" <?php if ($mal_info['mal_status'] == 1 || ($_SESSION['mal_update'] == 0 && ($mal_info['mal_status'] == 1 && $mal_info['isReviewed'] == 1)) || ($_SESSION['UserID'] != $mal_info['tech_id'] && $_SESSION['mal_update'] == 0)) {echo 'disabled';} ?>>
            <i class="bi bi-check-all"></i>&nbsp;<?php echo language('SAVE CHANGES', @$_SESSION['systemLang']) ?>
          </button>
        </div>
        <div>
          <button type="button" class="btn btn-outline-danger text-capitalize form-control bg-gradient fs-12 py-1" data-bs-toggle="modal" data-bs-target="#deleteMalModal" <?php if ($_SESSION['mal_delete'] == 0) {echo 'readonly';} ?> >
            <i class="bi bi-trash"></i>&nbsp;<?php echo language('DELETE', @$_SESSION['systemLang']) ?>
          </button>
        </div>
      </div>
    </form>
    <!-- end form -->
    <!-- Modal -->
    <div class="modal fade" id="deleteMalModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-capitalize " id="exampleModalLabel"><?php echo language('CONFIRM', @$_SESSION['systemLang'])." ".language('DELETE', @$_SESSION['systemLang'])." ".language('THE MALFUNCTION', @$_SESSION['systemLang']) ?></h5>
          </div>
          <div class="modal-body">
            <?php if ($_SESSION['mal_delete'] == 0) { ?>
              <h5 class="h5 text-danger" dir="<?php echo @$_SESSION['systemLang'] == "ar" ? "rtl" : "ltr"; ?>"><?php echo language("YOU DON`T HAVE THE PERMISSION TO DELETE THIS MALFUNCTION", @$_SESSION['systemLang']) ?></h5>
            <?php } else { ?> 
              <h5 class="h5 text-primary " dir="<?php echo @$_SESSION['systemLang'] == "ar" ? "rtl" : "ltr"; ?>"><?php echo language('ARE YOU SURE TO DELETE', @$_SESSION['systemLang'])." ".language('THE MALFUNCTION', @$_SESSION['systemLang'])." ".( @$_SESSION['systemLang'] == "ar" ? "؟" : "?" )?> </h5>
            <?php } ?>
          </div>
          <div class="modal-footer">
            <?php if ($_SESSION['mal_delete'] == 1) { ?>
            <a href="?do=delete-malfunction&mal-id=<?php echo $mal_info['mal_id'] ?>" class="btn btn-danger text-capitalize fs-12" ><i class="bi bi-trash"></i>&nbsp;<?php echo language('DELETE', @$_SESSION['systemLang']) ?></a>
            <?php } ?>
            <button type="button" class="btn btn-secondary fs-12" data-bs-dismiss="modal"><?php echo language('CLOSE', @$_SESSION['systemLang']) ?></button>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php } else { 
  // include no data founded
  include_once $globmod . 'no-data-founded.php';
} ?>