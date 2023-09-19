<?php
// get malfunction id 
$comb_id = isset($_GET['combid']) && !empty($_GET['combid']) ? base64_decode($_GET['combid']) : 0;
// create an object of Combination
$comb_obj = !isset($comb_obj) ? new Combination() : $comb_obj;
// check if combid exist
$is_exist = $comb_obj->is_exist("`comb_id`", "`combinations`", $comb_id);
// check
if ($is_exist == true) {
  // get combination info
  $combination_q = $comb_obj->get_spec_combination($comb_id, base64_decode($_SESSION['sys']['company_id']));
  // is exist comb
  $is_exist_comb = $combination_q[0];
  // combination data
  $comb_info = $combination_q[1][0];

  // update comb status
  if ($comb_info['isShowed'] == 0) {
    if (base64_decode($_SESSION['sys']['UserID']) == $comb_info['UserID']) {
      $updateQ = "UPDATE `combinations` SET `isShowed` = 1, `showed_date` = '" . get_date_now() . "', `showed_time` = '" . get_time_now() . "' WHERE `comb_id` = ?";
      $stmtUp = $con->prepare($updateQ);     // select all directions
      $stmtUp->execute(array($comb_id));               // execute data
    }
  }
?>
  <!-- start add new user page -->
  <div class="container" dir="<?php echo $page_dir ?>">
    <!-- start form -->
    <form class="custom-form" action="?do=update-combination-info" method="POST" enctype="multipart/form-data" id="edit-combination-info">
      <!-- submit -->
      <div class="mb-3 hstack gap-2">
        <?php if ($_SESSION['sys']['comb_update'] == 1 || (base64_decode($_SESSION['sys']['UserID']) == $comb_info['UserID'] && $_SESSION['sys']['isTech'] == 1)) { ?>
          <div class="<?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'me-auto' : 'ms-auto' ?>">
            <button type="button" class="btn btn-primary text-capitalize form-control bg-gradient py-1 fs-12" id="" onclick="form_validation(this.form, 'submit')">
              <i class="bi bi-check-all"></i>
              <?php echo lang('SAVE') ?>
            </button>
          </div>
        <?php } ?>
        <?php if ($_SESSION['sys']['comb_delete'] == 1) { ?>
          <div>
            <button type="button" class="btn btn-outline-danger text-capitalize form-control bg-gradient py-1 fs-12" data-bs-toggle="modal" data-bs-target="#deleteCombModal" id="delete-comb" data-comb-id="<?php echo base64_encode($comb_info['comb_id']) ?>" onclick="put_comb_data_into_modal(this)">
              <i class="bi bi-trash"></i>
              <?php echo lang('DELETE') ?>
            </button>
          </div>
        <?php } ?>
      </div>

      <div class="combination-info-container">
        <!-- resbonsible for combination -->
        <div class="combination-info-container__row">
          <div class="section-block">
            <div class="section-header">
              <h5><?php echo lang('RESP COMB', $lang_file) ?></h5>
              <hr />
            </div>
            <input type="hidden" class="form-control" id="comb-id" name="comb-id" value="<?php echo base64_encode($comb_info['comb_id']) ?>" autocomplete="off" required data-no-astrisk="true" />
            <!-- Administrator name -->
            <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
              <!-- admin name -->
              <?php $admin_name = $comb_obj->select_specific_column("`UserName`", "`users`", "WHERE `UserID` = " . $comb_info['addedBy'])[0]['UserName'] ?>
              <input type="hidden" class="form-control" id="admin-id" name="admin-id" value="<?php echo base64_encode($comb_info['addedBy']) ?>" autocomplete="off" required data-no-astrisk="true" />
              <input type="text" class="form-control" id="admin-name" name="admin-name" placeholder="administrator name" value="<?php echo $admin_name ?>" autocomplete="off" required disabled />
              <label for="admin-name"><?php echo lang('ADMIN NAME', $lang_file) ?></label>
            </div>
            <!-- Technical name -->
            <div class="mb-3">
              <div class="form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                <select class="form-select" id="technical-id" name="technical-id" required <?php echo $_SESSION['sys']['isTech'] == 1 || $_SESSION['sys']['comb_update'] == 0 || $comb_info['isFinished'] == 1 ? 'disabled' : '' ?>>
                  <option value="default" disabled selected><?php echo lang('SELECT TECH NAME', $lang_file) ?></option>
                  <?php $emp_info = $comb_obj->select_specific_column("`UserID`, `UserName`", "users", "WHERE `isTech` = 1 AND `job_title_id` = 2 AND `company_id` = " . base64_decode($_SESSION['sys']['company_id'])); ?>
                  <?php if (count($emp_info) > 0) { ?>
                    <?php foreach ($emp_info as $uer_row) { ?>
                      <option value="<?php echo base64_encode($uer_row['UserID']) ?>" <?php echo $comb_info['UserID'] == $uer_row['UserID'] ? 'selected' : '' ?>>
                        <?php echo $uer_row['UserName']; ?>
                      </option>
                    <?php } ?>
                  <?php } ?>
                  <?php if (count($emp_info) <= 0) { ?>
                    <div class="text-danger fw-bold">
                      <i class="bi bi-exclamation-triangle-fill"></i>
                      <?php echo lang("NO DATA") ?>
                    </div> <?php } ?>
                </select>
                <label for="technical-id"><?php echo lang('TECH NAME', $lang_file) ?></label>
                <input type="hidden" name="technical-id" id="technical-id-value" value="" required>
              </div>
            </div>
          </div>

          <!-- combination status -->
          <div class="section-block">
            <div class="section-header">
              <h5><?php echo lang('STATUS', $lang_file) ?></h5>
              <hr />
            </div>

            <!-- combination status -->
            <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
              <select class="form-select" name="comb-status" id="comb-status" required <?php echo ($_SESSION['sys']['comb_update'] != 1 && $_SESSION['sys']['isTech'] != 1) || $comb_info['isFinished'] == 1 ? 'disabled' : ''; ?> <?php echo $_SESSION['sys']['isTech'] == 0 ? 'disabled' : ''; ?>>
                <option value="default" disabled><?php echo lang("SELECT STATUS", $lang_file) ?></option>
                <option value="<?php echo base64_encode(0) ?>" <?php echo $comb_info['isFinished'] ==  0 ? 'selected' : '' ?>><?php echo lang("UNFINISHED", $lang_file) ?></option>
                <option value="<?php echo base64_encode(1) ?>" <?php echo $comb_info['isFinished'] ==  1 ? 'selected' : '' ?>><?php echo lang("FINISHED", $lang_file) ?></option>
                <option value="<?php echo base64_encode(2) ?>" <?php echo $comb_info['isFinished'] ==  2 ? 'selected' : '' ?>><?php echo lang("DELAYED", $lang_file) ?></option>
              </select>
              <label for="comb-status" class="col-sm-12 col-form-label text-capitalize pt-0"><?php echo lang('STATUS', $lang_file) ?></label>
            </div>
          </div>
        </div>

        <!-- client info -->
        <div class="combination-info-container__row section-block">
          <div class="section-header">
            <h5><?php echo lang('BENEFICIARY INFO', $lang_file) ?></h5>
            <hr />
          </div>
          <?php if ($_SESSION['sys']['comb_update'] == 1) { ?>
            <!-- client-nameme -->
            <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
              <input type="text" class="form-control" name="client-name" placeholder="<?php echo lang('BENEFICIARY NAME', $lang_file) ?>" value="<?php echo $comb_info['client_name'] ?>" <?php echo $comb_info['isFinished'] == 1 ? 'disabled' : ''; ?> required />
              <label for="client-name"><?php echo lang('BENEFICIARY NAME', $lang_file) ?></label>
            </div>
            <!-- phone -->
            <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
              <input type="text" name="client-phone" id="client-phone" class="form-control w-100" placeholder="<?php echo lang('PHONE', $lang_file) ?>" value="<?php echo $comb_info['phone'] ?>" <?php echo $comb_info['isFinished'] == 1 ? 'disabled' : ''; ?> required />
              <label for="client-phone"><?php echo lang('PHONE', $lang_file) ?></label>
            </div>
            <!-- address -->
            <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
              <input type="text" name="client-address" id="client-address" class="form-control w-100" placeholder="<?php echo lang('ADDR', $lang_file) ?>" value="<?php echo $comb_info['address'] ?>" <?php echo $comb_info['isFinished'] == 1 ? 'disabled' : '' ?> required />
              <label for="client-address"><?php echo lang('ADDR', $lang_file) ?></label>
            </div>
            <!-- notes -->
            <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
              <textarea type="text" name="client-notes" id="client-notes" class="form-control w-100" style="resize: none; height: 120px;" placeholder="<?php echo lang('NOTE') ?>" style="resize: none; direction: <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'rtl' : 'ltr' ?>" <?php echo $comb_info['isFinished'] == 1 ? 'disabled' : '' ?> required><?php echo $comb_info['comment'] ?></textarea>
              <label for="client-notes"><?php echo lang('NOTE') ?></label>
            </div>
          <?php } else { ?>
            <div class="benef-info-container">
              <!-- client-nameme -->
              <div class="benef-info__row">
                <span><?php echo lang('BENEFICIARY NAME', $lang_file) ?></span>
                <span class="text-primary"><?php echo $comb_info['client_name'] ?></span>
              </div>
              <!-- phone -->
              <div class="benef-info__row">
                <span><?php echo lang('PHONE', $lang_file) ?></span>
                <span class="text-primary"><?php echo $comb_info['phone'] ?></span>
              </div>
              <!-- address -->
              <div class="benef-info__row">
                <span><?php echo lang('ADDR', $lang_file) ?></span>
                <span class="text-primary"><?php echo $comb_info['address'] ?></span>
              </div>
              <!-- notes -->
              <div class="benef-info__row">
                <span><?php echo lang('NOTE') ?></span>
                <span class="text-primary"><?php echo $comb_info['comment'] ?></span>
              </div>
            </div>
          <?php } ?>
        </div>

        <!-- Combination date and time -->
        <div class="combination-info-container__row section-block">
          <div class="section-header">
            <h5><?php echo lang('DATE & TIME INFO', $lang_file) ?></h5>
            <hr />
          </div>
          <div class="date-time-content">
            <!-- added date -->
            <div class="date-time-content__row">
              <label for="added-date"><?php echo lang('ADDED DATE') ?></label>
              <div class="position-relative">
                <span class="text-primary" dir='ltr'><?php echo date_format(date_create($comb_info['added_date']), 'd/m/Y') ?></span>
              </div>
            </div>
            <!-- added time -->
            <div class="date-time-content__row">
              <label for="added-time"><?php echo lang('ADDED TIME') ?></label>
              <div class="position-relative">
                <span class="text-primary" dir='ltr'><?php echo date_format(date_create($comb_info['added_time']), 'h:i:s a') ?></span>
              </div>
            </div>
            <!-- showed date -->
            <div class="date-time-content__row">
              <label for="showed-date"><?php echo lang('SHOWED DATE') ?></label>
              <div class="position-relative">
                <?php if ($comb_info['isShowed']) { ?>
                  <span class="text-primary" dir='ltr'><?php echo date_format(date_create($comb_info['showed_date']), 'd/m/Y') ?></span>
                <?php } else { ?>
                  <span class="text-danger fw-bold"><?php echo lang('NOT SHOWED', $lang_file) ?></span>
                <?php } ?>
              </div>
            </div>
            <!-- showed time -->
            <div class="date-time-content__row">
              <label for="showed-time"><?php echo lang('SHOWED TIME') ?></label>
              <div class="position-relative">
                <?php if ($comb_info['isShowed']) { ?>
                  <span class="text-primary" dir='ltr'><?php echo date_format(date_create($comb_info['showed_time']), 'h:i:s a') ?></span>
                <?php } else { ?>
                  <span class="text-danger fw-bold"><?php echo lang('NOT SHOWED', $lang_file) ?></span>
                <?php } ?>
              </div>
            </div>
            <!-- repaired date -->
            <div class="date-time-content__row">
              <label for="repaired-date">
                <?php echo $comb_info['isFinished'] == 1 && $comb_info['isAccepted'] != 2 ? lang('FINISHED DATE') : lang('DELAYED DATE'); ?>
              </label>
              <div class="position-relative">
                <?php if ($comb_info['isFinished']) { ?>
                  <span class="text-primary" dir='ltr'><?php echo date_format(date_create($comb_info['finished_date']), 'd/m/Y') ?></span>
                <?php } else { ?>
                  <span class="text-danger fw-bold"><?php echo lang('NOT ASSIGNED') ?></span>
                <?php } ?>
              </div>
            </div>
            <!-- repaired time -->
            <div class="date-time-content__row">
              <label for="repaired-time">
                <?php echo $comb_info['isFinished'] == 1 && $comb_info['isAccepted'] != 2 ? lang('FINISHED TIME') : lang('DELAYED TIME'); ?>
              </label>
              <div class="position-relative">
                <?php if ($comb_info['isFinished'] == 1) { ?>
                  <span class="text-primary" dir='ltr'><?php echo date_format(date_create($comb_info['finished_time']), 'h:i:s a') ?></span>
                <?php } else { ?>
                  <span class="text-danger fw-bold"><?php echo lang('NOT ASSIGNED') ?></span>
                <?php } ?>
              </div>
            </div>
            <?php if ($comb_info['isFinished'] == 1) { ?>
              <!-- diff time -->
              <div class="date-time-content__row period">
                <label for="showed-time"><?php echo lang('FINISHED PERIOD') ?></label>
                <div class="position-relative">
                  <?php
                  $diff = [];
                  if ($comb_info['showed_time'] != '00:00:00' && $comb_info['finished_time'] != '00:00:00') {
                    $showed_date = date_create($comb_info['showed_date']);        // showed date
                    $finished_date = date_create($comb_info['finished_date']);      // repaired date
                    // get the diffrence of days
                    $diff_date = date_diff($showed_date, $finished_date, true);

                    $showed_time = date_create($comb_info['showed_time']);     // showed time
                    $finished_time = date_create($comb_info['finished_time']);   // repaired time
                    // get the diffrence
                    $diff_time = date_diff($finished_time, $showed_time, true);

                    $days = $diff_date->d;
                    $hours = $diff_time->h;
                    $minutes = $diff_time->i;
                    $seconds = $diff_time->s;
                  ?>
                    <span class="text-primary">
                      <?php echo ($days > 0 ? "$days " . lang($days > 1 ? 'DAYS' : 'DAY') . ", " : '') . ($hours > 0 ? " $hours " . lang($hours > 1 ? 'HOURS' : 'HOUR') . ", " : '') . ($minutes > 0 ? " $minutes " . lang($minutes > 1 ? 'MINUTES' : 'MINUTE') . ", " : '') . ($seconds > 0 ? " $seconds " . lang($seconds > 1 ? 'SECONDS' : 'SECOND') . ". " : '') ?>
                    </span>
                  <?php } else { ?>
                    <span class="text-danger"><?php echo lang('PERIOD NOTE', $lang_file) ?></span>
                  <?php } ?>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>

        <!-- additional info -->
        <div class="combination-info-container__row section-block">
          <div class="section-header">
            <h5><?php echo lang('ADD INFO', 'pieces') ?></h5>
            <hr />
          </div>
          <!-- technical man comment -->
          <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
            <textarea name="comment" id="comment" title="describe the combination" class="form-control w-100" style="height: 7rem; resize: none; direction: <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'rtl' : 'ltr' ?>" <?php echo $_SESSION['sys']['isTech'] == 0 || $comb_info['isFinished'] == 1 ? 'disabled' : '' ?>><?php echo empty($comb_info['tech_comment']) && $comb_info['isFinished'] ? "لا يوجد تعليق من الفني" : $comb_info['tech_comment']; ?></textarea>
            <label for="comment"><?php echo lang('TECH COMMENT', $lang_file) ?></label>
          </div>
          <!-- cost -->
          <div class="mb-3">
            <div class="input-group" dir="ltr">
              <span class=" input-group-text"><?php echo lang('L.E') ?></span>
              <div class="form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                <input type="text" name="cost" id="cost" class="form-control" placeholder="<?php echo lang('COMB COST', $lang_file) ?>" value="<?php echo $comb_info['cost'] ?>" <?php echo $_SESSION['sys']['isTech'] == 0 || $comb_info['isFinished'] == 1 ? 'disabled' : '' ?> onblur="arabic_to_english_nums(this)">
                <label for="cost"><?php echo lang('COMB COST', $lang_file) ?></label>
              </div>
            </div>
            <div id="costHelp" class="form-text text-info">
              <i class="bi bi-exclamation-triangle-fill"></i>&nbsp;
              <?php echo lang('ENG NUM') ?>
            </div>
          </div>
        </div>

        <?php if ($comb_info['isFinished'] == 1) { ?>
          <!-- combination review -->
          <div class="combination-info-container__row section-block">
            <div class="section-header">
              <h5><?php echo lang('COMB REVIEW', $lang_file) ?></h5>
              <hr />
            </div>
            <!-- quality of employee -->
            <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
              <select name="technical-qty" id="technical-qty" class="form-select" <?php echo $_SESSION['sys']['comb_review'] == 0 || ($comb_info['isFinished'] == 0 && $_SESSION['sys']['isTech'] == 0) || $comb_info['isReviewed'] == 1 ? 'disabled' : '' ?>>
                <option value="default" disabled <?php echo $comb_info['isReviewed'] == 0 ? "selected" : '' ?>><?php echo lang('SELECT QTY', $lang_file) ?></option>
                <option value="<?php echo base64_encode(1) ?>" <?php echo $comb_info['isReviewed'] == 1 && $comb_info['qty_emp'] == 1 ? "selected" : '' ?>><?php echo lang('BAD') ?></option>
                <option value="<?php echo base64_encode(2) ?>" <?php echo $comb_info['isReviewed'] == 1 && $comb_info['qty_emp'] == 2 ? "selected" : '' ?>><?php echo lang('GOOD') ?></option>
                <option value="<?php echo base64_encode(3) ?>" <?php echo $comb_info['isReviewed'] == 1 && $comb_info['qty_emp'] == 3 ? "selected" : '' ?>><?php echo lang('VERY GOOD') ?></option>
              </select>
              <label for="technical-qty"><?php echo lang('TECH QTY', $lang_file) ?></label>
            </div>
            <!-- quality of service -->
            <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
              <select name="service-qty" id="service-qty" class="form-select" <?php echo $_SESSION['sys']['comb_review'] == 0 || ($comb_info['isFinished'] == 0 && $_SESSION['sys']['isTech'] == 0) || $comb_info['isReviewed'] == 1 ? 'disabled' : '' ?>>
                <option value="default" disabled <?php echo $comb_info['isReviewed'] == 0 ? "selected" : '' ?>><?php echo lang('SELECT QTY', $lang_file) ?></option>
                <option value="<?php echo base64_encode(1) ?>" <?php echo $comb_info['isReviewed'] == 1 && $comb_info['qty_service'] == 1 ? "selected" : '' ?>><?php echo lang('BAD') ?></option>
                <option value="<?php echo base64_encode(2) ?>" <?php echo $comb_info['isReviewed'] == 1 && $comb_info['qty_service'] == 2 ? "selected" : '' ?>><?php echo lang('GOOD') ?></option>
                <option value="<?php echo base64_encode(3) ?>" <?php echo $comb_info['isReviewed'] == 1 && $comb_info['qty_service'] == 3 ? "selected" : '' ?>><?php echo lang('VERY GOOD') ?></option>
              </select>
              <label for="service-qty"><?php echo lang('SERVICE QTY', $lang_file) ?></label>
            </div>
            <!-- money review -->
            <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
              <select name="money-review" id="money-review" class="form-select" <?php echo $_SESSION['sys']['comb_review'] == 0 || ($comb_info['isFinished'] == 0 && $_SESSION['sys']['isTech'] == 0) || $comb_info['isReviewed'] == 1 ? 'disabled' : '' ?>>
                <option value="default" disabled <?php echo $comb_info['isReviewed'] == 0 ? "selected" : '' ?>><?php echo lang('SELECT QTY', $lang_file) ?></option>
                <option value="<?php echo base64_encode(1) ?>" <?php echo $comb_info['isReviewed'] == 1 && $comb_info['money_review'] == 1 ? "selected" : '' ?>><?php echo lang('RIGHT') ?></option>
                <option value="<?php echo base64_encode(2) ?>" <?php echo $comb_info['isReviewed'] == 1 && $comb_info['money_review'] == 2 ? "selected" : '' ?>><?php echo lang('WRONG') ?></option>
              </select>
              <label for="money-review"><?php echo lang('COST REVIEW', $lang_file) ?></label>
            </div>
            <!-- employee review comment -->
            <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
              <label for="review-comment"><?php echo lang('NOTE') ?></label>
              <textarea name="review-comment" id="review-comment" title="review comment" class="form-control w-100" style="height: 5rem; resize: none; direction: <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'rtl' : 'ltr' ?>" placeholder="<?php echo lang('NOTE') ?>" required <?php echo $_SESSION['sys']['comb_review'] == 0 || ($comb_info['isFinished'] == 0 && $_SESSION['sys']['isTech'] == 0) || $comb_info['isReviewed'] == 1 ? 'disabled' : '' ?>><?php echo $comb_info['qty_comment'] ?></textarea>
            </div>
            <?php if ($comb_info['isReviewed'] == 1) { ?>
              <!-- reviewed date -->
              <div class="mb-1 row align-items-center">
                <label for="reviewed-date"><?php echo lang('REVIEWED DATE') ?></label>
                <div class="col-sm-12 col-md-8">
                  <span class="text-primary" dir='ltr'><?php echo date_format(date_create($comb_info['reviewed_date']), 'd/m/Y') ?></span>
                </div>
              </div>
              <!-- reviewed time -->
              <div class="mb-1 row align-items-center">
                <label for="reviewed-time"><?php echo lang('REVIEWED TIME') ?></label>
                <div class="col-sm-12 col-md-8">
                  <span class="text-primary" dir='ltr'><?php echo date_format(date_create($comb_info['reviewed_time']), 'h:i:s a') ?></span>
                </div>
              </div>
            <?php } ?>
            <?php if ($comb_info['isFinished'] == 0 && $_SESSION['sys']['isTech'] == 0) { ?>
              <div class="mb-1 row align-items-center">
                <span class="text-warning" dir="<?php echo @$_SESSION['sys']['lang'] == 0 ? 'rtl' : 'ltr' ?>" style="text-align: <?php echo @$_SESSION['sys']['lang'] == 0 ? 'right' : 'left' ?>">
                  <i class="bi bi-exclamation-triangle-fill"></i>&nbsp;
                  <span><?php echo lang('REVIEW ERROR', $lang_file) ?></span>
                </span>
              </div>
            <?php } ?>
          </div>
        <?php } ?>

        <!-- the malfunctions media -->
        <div class="combination-info-container__row section-block">
          <div class="section-header media-section">
            <h5 style="<?php echo $_SESSION['sys']['isTech'] == 0 ? 'padding-bottom: 0!important' : ''; ?>"><?php echo lang('MEDIA', $lang_file) ?></h5>
            <!-- add new malfunction -->
            <?php if ($_SESSION['sys']['isTech'] == 1 && ($_SESSION['sys']['comb_update'] == 1 || base64_decode($_SESSION['sys']['UserID']) == $comb_info['UserID'])) { ?>
              <button type="button" role="button" class="btn btn-outline-primary py-1 fs-12 media-button" onclick="add_new_media()">
                <i class="bi bi-card-image"></i>
                <?php echo lang('ADD MEDIA', $lang_file) ?>
              </button>
            <?php } ?>
            <hr />
          </div>
          <!-- combination media -->
          <?php $comb_media = $comb_obj->get_combination_media($comb_id); ?>
          <div class="media-container" id="media-container">
            <?php if ($comb_media != null && count($comb_media) > 0) { ?>
              <?php foreach ($comb_media as $key => $media) { ?>
                <?php $media_source = $uploads . "combinations/" . base64_decode($_SESSION['sys']['company_id']) . "/" . $media['media'] ?>
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
                      <?php if ($_SESSION['sys']['comb_media_download'] == 1) { ?>
                        <button type="button" class="btn btn-primary py-1 ms-1" onclick="download_media('<?php echo $media_source ?>', '<?php echo $media['type'] == 'img' ? 'jpg' : 'mp4' ?>')" src="<?php echo $media_source ?>"><i class='bi bi-download'></i></a>
                        <?php } ?>
                        <?php if ($_SESSION['sys']['comb_media_delete'] == 1) { ?>
                          <button type="button" class="btn btn-danger py-1 ms-1" onclick="delete_media(this)" data-media-id="<?php echo base64_encode($media['id']); ?>" data-media-name="<?php echo $media['media']; ?>"><i class="bi bi-trash"></i></button>
                        <?php } ?>
                        <button type="button" class="btn btn-primary" onclick="open_media('<?php echo $media_source ?>', '<?php echo $media['type'] == 'img' ? 'jpg' : 'mp4' ?>')"><i class="bi bi-eye"></i></button>
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
      </div>

      <!-- submit -->
      <div class="hstack gap-2">
        <?php if ($_SESSION['sys']['comb_update'] == 1 || (base64_decode($_SESSION['sys']['UserID']) == $comb_info['UserID'] && $_SESSION['sys']['isTech'] == 1)) { ?>
          <div class="<?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'me-auto' : 'ms-auto' ?>">
            <button type="button" class="btn btn-primary text-capitalize form-control bg-gradient py-1 fs-12" id="" onclick="form_validation(this.form, 'submit')">
              <i class="bi bi-check-all"></i>
              <?php echo lang('SAVE') ?>
            </button>
          </div>
        <?php } ?>
        <?php if ($_SESSION['sys']['comb_delete'] == 1) { ?>
          <div>
            <button type="button" class="btn btn-outline-danger text-capitalize form-control bg-gradient py-1 fs-12" data-bs-toggle="modal" data-bs-target="#deleteCombModal" id="delete-comb" data-comb-id="<?php echo base64_encode($comb_info['comb_id']) ?>" onclick="put_comb_data_into_modal(this)">
              <i class="bi bi-trash"></i>
              <?php echo lang('DELETE') ?>
            </button>
          </div>
        <?php } ?>
      </div>
    </form>
    <!-- end form -->
    <?php if ($_SESSION['sys']['comb_delete'] == 1) {
      include_once 'delete-combination-modal.php';
    } ?>

    <!-- media modal -->
    <div id="media-modal" class="media-modal">
      <span class="close" id="media-modal-close">&times;</span>
      <div id="media-modal-content"></div>
    </div>
  </div>
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
