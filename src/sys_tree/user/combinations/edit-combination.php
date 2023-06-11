<?php
// get malfunction id 
$comb_id = isset($_GET['combid']) && !empty($_GET['combid']) ? intval($_GET['combid']) : 0;
if (!isset($comb_obj)) {
  // create an object of Combination
  $comb_obj = new Combination();
}
// check if combid exist
$is_exist = $comb_obj->is_exist("`comb_id`", "`combinations`", $comb_id);
// check
if ($is_exist == true) {
  // get combination info
  $combination_q = $comb_obj->get_spec_combination($comb_id, $_SESSION['company_id']);
  // is exist comb
  $is_exist_comb = $combination_q[0];
  // combination data
  $comb_info = $combination_q[1][0];

  // update comb status
  if ($comb_info['isShowed'] == 0) {
    if($_SESSION['UserID'] == $comb_info['UserID']) {
      $updateQ = "UPDATE `combinations` SET `isShowed` = 1, `showed_date` = '".get_date_now()."', `showed_time` = '".get_time_now()."' WHERE `comb_id` = ?";
      $stmtUp = $con->prepare($updateQ);     // select all directions
      $stmtUp->execute(array($comb_id));               // execute data
    }
  }
?>
  <!-- start add new user page -->
  <div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
    <!-- start form -->
    <form class="custom-form" action="?do=update-combination-info" method="POST" enctype="multipart/form-data" id="edit-combination-info">
      <!-- submit -->
      <div class="mb-3 hstack gap-2">
        <?php if ($_SESSION['comb_update'] == 1 || ($_SESSION['UserID'] == $comb_info['UserID'] && $_SESSION['isTech'] == 1)) { ?>
        <div class="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'me-auto' : 'ms-auto' ?>">
          <button type="button" class="btn btn-primary text-capitalize form-control bg-gradient fs-12" id="" onclick="form_validation(this.form, 'submit')">
            <i class="bi bi-check-all"></i>
            <?php echo language('SAVE CHANGES', @$_SESSION['systemLang']) ?>
          </button>
        </div>
        <?php } ?>
        <?php if ($_SESSION['comb_delete'] == 1) { ?>
        <div>
          <button type="button" class="btn btn-outline-danger text-capitalize form-control bg-gradient fs-12" data-bs-toggle="modal" data-bs-target="#deleteCombModal" id="delete-comb" data-comb-id="<?php echo $comb_info['comb_id'] ?>">
            <i class="bi bi-trash"></i>
            <?php echo language('DELETE', @$_SESSION['systemLang']) ?>
          </button>
        </div>
        <?php } ?>
      </div>

      <div class="mb-3 row row-cols-sm-1 row-cols-md-2 g-3">
        <!-- first column -->
        <div class="col-12">
          <div class="row g-3">
            <!-- resbonsible for combination -->
            <div class="col-12">
              <div class="section-block">
                <div class="section-header">
                  <h5><?php echo language('RESPONSIBLE FOR COMB INFO', @$_SESSION['systemLang']) ?></h5>
                  <hr />
                </div>
                <input type="hidden" class="form-control" id="comb-id" name="comb-id" value="<?php echo $comb_info['comb_id'] ?>" autocomplete="off" required data-no-astrisk="true" />
                <!-- Administrator name -->
                <div class="mb-sm-2 mb-md-3 row">
                  <label for="admin-name" class="col-sm-12 col-form-label text-capitalize"><?php echo language('ADMIN NAME', @$_SESSION['systemLang']) ?></label>
                  <div class="col-sm-12">
                    <!-- admin name -->
                    <?php $admin_name = $comb_obj->select_specific_column("`UserName`", "`users`", "WHERE `UserID` = ".$comb_info['addedBy'])[0]['UserName'] ?>
                    <input type="hidden" class="form-control" id="admin-id" name="admin-id" value="<?php echo $comb_info['addedBy'] ?>" autocomplete="off" required data-no-astrisk="true" />
                    <input type="text" class="form-control" id="admin-name" name="admin-name" placeholder="administrator name" value="<?php echo $admin_name ?>" autocomplete="off" required disabled  />
                  </div>
                </div>
                <!-- Technical name -->
                <div class="mb-sm-2 mb-md-3 row">
                  <label for="technical-id" class="col-sm-12 col-form-label text-capitalize"><?php echo language('TECHNICAL NAME', @$_SESSION['systemLang']) ?></label>
                  <div class="col-sm-12">
                    <select class="form-select" id="technical-id" name="technical-id" required <?php if ($_SESSION['isTech'] == 1 || $_SESSION['comb_update'] == 0 || $comb_info['isFinished'] == 1) {echo 'disabled';} ?>>
                      <option value="default" disabled selected><?php echo language('SELECT', @$_SESSION['systemLang'])." ".language('TECHNICAL NAME', @$_SESSION['systemLang']) ?></option>
                      <?php $emp_info = $comb_obj->select_specific_column("`UserID`, `UserName`", "users", "WHERE `isTech` = 1 AND `job_title_id` = 2 AND `company_id` = " . $_SESSION['company_id']); ?>
                      <?php if (count($emp_info) > 0) { ?>
                        <?php foreach ($emp_info as $uer_row) { ?>
                          <option value="<?php echo $uer_row['UserID'] ?>" <?php if ($comb_info['UserID'] == $uer_row['UserID']) {echo 'selected';} ?> >
                            <?php echo $uer_row['UserName']; ?>
                          </option>
                        <?php } ?>
                      <?php } else { ?>
                        <option><?php echo language('NOT AVAILABLE NOW', $_SESSION['systemLang']) ?></option>
                      <?php } ?>
                    </select>
                    <input type="hidden" name="technical-id" id="technical-id-value" value="" required>
                  </div>
                </div>
              </div>
            </div>

            <!-- combination status -->
            <div class="col-12">
              <div class="section-block">
                <div class="section-header">
                  <h5><?php echo language('COMBINATION STATUS', @$_SESSION['systemLang']) ?></h5>
                  <hr />
                </div>

                <!-- combination status -->
                <div class="mb-sm-2 mb-md-3 row">
                  <label for="mal-status" class="col-sm-12 col-form-label text-capitalize pt-0"><?php echo language('STATUS', @$_SESSION['systemLang']) ?></label>
                  <div class="col-sm-12" id="comb-status">
                    <select class="form-select" name="comb-status" id="comb-status" required <?php if (($_SESSION['comb_update'] != 1 && $_SESSION['isTech'] != 1) || $comb_info['isFinished'] == 1) {echo 'disabled';} ?> <?php if ($_SESSION['isTech'] == 0) {echo 'disabled';} ?>>
                      <option value="default" disabled><?php echo language("SELECT YOUR STATUS", @$_SESSION['systemLang']) ?></option>
                      <option value="0" <?php if ($comb_info['isFinished'] ==  0) { echo 'selected'; } ?>><?php echo language("UNFINISHED", @$_SESSION['systemLang']) ?></option>
                      <option value="1" <?php if ($comb_info['isFinished'] ==  1) { echo 'selected'; } ?>><?php echo language("FINISHED", @$_SESSION['systemLang']) ?></option>
                      <option value="2" <?php if ($comb_info['isFinished'] ==  2) { echo 'selected'; } ?>><?php echo language("DELAYED", @$_SESSION['systemLang']) ?></option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- client info -->
        <div class="col-12">
          <div class="section-block">
            <div class="section-header">
              <h5><?php echo language('CLIENT INFO', @$_SESSION['systemLang']) ?></h5>
              <hr />
            </div>
            <?php if ($_SESSION['comb_update'] == 1) {?>
            <!-- client-nameme -->
            <div class="mb-sm-2 mb-md-3 row">
              <label for="client-name" class="col-sm-12 col-form-label text-capitalize"><?php echo language('CLIENT NAME', @$_SESSION['systemLang']) ?></label>
              <div class="col-sm-12">
                <input type="text" class="form-control" name="client-name" placeholder="<?php echo language('CLIENT NAME', @$_SESSION['systemLang']) ?>" value="<?php echo $comb_info['client_name'] ?>" <?php if ($comb_info['isFinished'] == 1) {echo 'disabled';} ?> required />
              </div>
            </div>
            <!-- phone -->
            <div class="mb-sm-2 mb-md-3 row">
              <label for="client-phone" class="col-sm-12 col-form-label text-capitalize"><?php echo language('PHONE', @$_SESSION['systemLang']) ?></label>
              <div class="col-sm-12 position-relative">
                <input type="text" name="client-phone" id="client-phone" class="form-control w-100" placeholder="<?php echo language('PHONE', @$_SESSION['systemLang']) ?>" value="<?php echo $comb_info['phone'] ?>" <?php if ($comb_info['isFinished'] == 1) {echo 'disabled';} ?> required />
              </div>
            </div>
            <!-- address -->
            <div class="mb-sm-2 mb-md-3 row">
              <label for="client-address" class="col-sm-12 col-form-label text-capitalize"><?php echo language('THE ADDRESS', @$_SESSION['systemLang']) ?></label>
              <div class="col-sm-12 position-relative">
                <input type="text" name="client-address" id="client-address" class="form-control w-100" placeholder="<?php echo language('THE ADDRESS', @$_SESSION['systemLang']) ?>" value="<?php echo $comb_info['address'] ?>" <?php if ($comb_info['isFinished'] == 1) {echo 'disabled';} ?> required />
              </div>
            </div>
            <!-- notes -->
            <div class="mb-sm-2 mb-md-3 row">
              <label for="client-notes" class="col-sm-12 col-form-label text-capitalize"><?php echo language('THE NOTES', @$_SESSION['systemLang']) ?></label>
              <div class="col-sm-12 position-relative">
                <textarea type="text" name="client-notes" id="client-notes" class="form-control w-100" rows="5" placeholder="<?php echo language('THE NOTES', @$_SESSION['systemLang']) ?>" style="resize: none; direction: <?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>" <?php if ($comb_info['isFinished'] == 1) {echo 'disabled';} ?> required ><?php echo $comb_info['comment'] ?></textarea>
              </div>
            </div>
            <?php } else { ?>
              <!-- client-nameme -->
            <div class="mb-sm-2 mb-md-3 row">
              <label for="client-name" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('CLIENT NAME', @$_SESSION['systemLang']) ?></label>
              <div class="col-sm-12 col-md-8 position-relative">
                <span class="text-primary"><?php echo $comb_info['client_name'] ?></span>
              </div>
            </div>
            <!-- phone -->
            <div class="mb-sm-2 mb-md-3 row">
              <label for="client-phone" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('PHONE', @$_SESSION['systemLang']) ?></label>
              <div class="col-sm-12 col-md-8 position-relative">
                <span class="text-primary"><?php echo $comb_info['phone'] ?></span>
              </div>
            </div>
            <!-- address -->
            <div class="mb-sm-2 mb-md-3 row">
              <label for="client-address" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('THE ADDRESS', @$_SESSION['systemLang']) ?></label>
              <div class="col-sm-12 col-md-8 position-relative">
                <span class="text-primary"><?php echo $comb_info['address'] ?></span>
              </div>
            </div>
            <!-- notes -->
            <div class="mb-sm-2 mb-md-3 row">
              <label for="client-notes" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('THE NOTES', @$_SESSION['systemLang']) ?></label>
              <div class="col-sm-12 col-md-8 position-relative">
                <span class="text-primary"><?php echo $comb_info['comment'] ?></span>
              </div>
            </div>
            <?php } ?>
          </div>
        </div>

        <!-- Combination date and time -->
        <div class="col-12">
          <div class="section-block">
              <div class="section-header">
              <h5><?php echo language('DATE & TIME INFO', @$_SESSION['systemLang']) ?></h5>
              <hr />
            </div>
            <!-- added date -->
            <div class="mb-1 row align-items-center">
              <label for="added-date" class="col-sm-12 col-md-5 col-form-label text-capitalize"><?php echo language('ADDED DATE', @$_SESSION['systemLang']) ?></label>
              <div class="col-sm-12 col-md-7">
                <span class="text-primary" dir='ltr'><?php echo date_format(date_create($comb_info['added_date']), 'd/m/Y') ?></span>
              </div>
            </div>
            <!-- added time -->
            <div class="mb-1 row align-items-center">
              <label for="added-time" class="col-sm-12 col-md-5 col-form-label text-capitalize"><?php echo language('ADDED TIME', @$_SESSION['systemLang']) ?></label>
              <div class="col-sm-12 col-md-7">
                <span class="text-primary" dir='ltr'><?php echo date_format(date_create($comb_info['added_time']), 'h:i:s a') ?></span>
              </div>
            </div>
            <!-- showed date -->
            <div class="mb-1 row align-items-center">
              <label for="showed-date" class="col-sm-12 col-md-5 col-form-label text-capitalize"><?php echo language('COMB SHOWED DATE', @$_SESSION['systemLang']) ?></label>
              <div class="col-sm-12 col-md-7">
                <?php if ($comb_info['isShowed']) { ?>
                  <span class="text-primary" dir='ltr'><?php echo date_format(date_create($comb_info['showed_date']), 'd/m/Y') ?></span>
                <?php } else { ?>
                  <span class="pt-2 text-danger"><?php echo language('NOT SHOWED BY THE TECHNICAL', @$_SESSION['systemLang']) ?></span>                
                <?php } ?>
              </div>
            </div>
            <!-- showed time -->
            <div class="mb-1 row align-items-center">
              <label for="showed-time" class="col-sm-12 col-md-5 col-form-label text-capitalize"><?php echo language('COMB SHOWED TIME', @$_SESSION['systemLang']) ?></label>
              <div class="col-sm-12 col-md-7">
                <?php if ($comb_info['isShowed']) { ?>
                  <span class="text-primary" dir='ltr'><?php echo date_format(date_create($comb_info['showed_time']), 'h:i:s a') ?></span>
                <?php } else { ?>
                  <span class="pt-2 text-danger"><?php echo language('NOT SHOWED BY THE TECHNICAL', @$_SESSION['systemLang']) ?></span>
                <?php } ?>
              </div>
            </div>
            <!-- finished date -->
            <div class="mb-1 row align-items-center">
              <label for="finished-date" class="col-sm-12 col-md-5 col-form-label text-capitalize">
                <?php if ($comb_info['isFinished'] == 1 && $comb_info['isAccepted'] == 1) {
                  echo language('FINISHED DATE', @$_SESSION['systemLang']);
                } else {
                  echo language('DELAYED OR REFUSED DATE', @$_SESSION['systemLang']);
                }
                ?>
              </label>
              <div class="col-sm-12 col-md-7">
                <?php if ($comb_info['isFinished']) { ?>
                  <span class="text-primary" dir='ltr'><?php echo date_format(date_create($comb_info['finished_date']), 'd/m/Y') ?></span>
                <?php } else { ?>
                  <span class="pt-2 text-danger"><?php echo language('NOT FINISHED BY THE TECHNICAL', @$_SESSION['systemLang']) ?></span>
                <?php } ?>
              </div>
            </div>
            <!-- finished time -->
            <div class="mb-1 row align-items-center">
              <label for="finished-time" class="col-sm-12 col-md-5 col-form-label text-capitalize">
                <?php if ($comb_info['isFinished'] == 1 && $comb_info['isAccepted'] == 1) {
                  echo language('FINISHED TIME', @$_SESSION['systemLang']);
                } else {
                  echo language('DELAYED OR REFUSED TIME', @$_SESSION['systemLang']);
                }
                ?>
              </label>
              <div class="col-sm-12 col-md-7">
                <?php if ($comb_info['isFinished']) { ?>
                  <span class="text-primary" dir='ltr'><?php echo date_format(date_create($comb_info['finished_time']), 'h:i:s a') ?></span>
                <?php } else { ?>
                  <span class="pt-2 text-danger"><?php echo language('NOT FINISHED BY THE TECHNICAL', @$_SESSION['systemLang']) ?></span>
                <?php } ?>
              </div>
            </div>
            
            <?php if ($comb_info['isFinished'] == 1) { ?>
              <!-- diff time -->
              <div class="mb-1 row align-items-center">
                <label for="showed-time" class="col-sm-12 col-md-5 col-form-label text-capitalize"><?php echo language('FINISHED PERIOD', @$_SESSION['systemLang']) ?></label>
                <div class="col-sm-12 col-md-7 pt-2">
                <?php
                  $diff= [];
                    if ($comb_info['isFinished'] == 1 && $comb_info['showed_time'] != '00:00:00' && $comb_info['finished_time'] != '00:00:00') {
                      $showed_date = date_create($comb_info['showed_date']);        // showed date
                      $finished_date = date_create($comb_info['finished_date']);      // finished date
                      // get the diffrence of days
                      $diff_date = date_diff($showed_date, $finished_date, true);

                      $showed_time = date_create($comb_info['showed_time']);     // showed time
                      $finished_time = date_create($comb_info['finished_time']);   // finished time
                      // get the diffrence
                      $diff_time = date_diff($finished_time, $showed_time, true);

                      $days = $diff_date->d;
                      $hours = $diff_time->h;
                      $minutes = $diff_time->i;
                      $seconds = $diff_time->s;
                  ?>
                    <span class="text-primary">
                      <?php echo ($days > 0 ? "$days " . language($days > 1 ? 'DAYS' : 'DAY', @$_SESSION['systemLang']).", " : '') . ($hours > 0 ? " $hours " . language($hours > 1 ? 'HOURS' : 'HOUR', @$_SESSION['systemLang']) . ", " : '') . ($minutes > 0 ? " $minutes " . language($minutes > 1 ? 'MINUTES' : 'MINUTE', @$_SESSION['systemLang']).", " : '') . ($seconds > 0 ? " $seconds " . language($seconds > 1 ? 'SECONDS' : 'SECOND', @$_SESSION['systemLang']).". " : '') ?>
                    </span>
                  <?php } else { ?>
                    <span class="text-danger"><?php echo language('THE TECHNICAL MAN DIDN`T FINISH THE COMBINATION TO CALCULATE THE COMBINATION FINISHED PERIOD', @$_SESSION['systemLang']) ?></span>
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
            <!-- technical man comment -->
            <div class="mb-sm-2 mb-md-3 row">
              <label for="comment" class="col-sm-12 col-form-label text-capitalize"><?php echo language('TECHNICAL MAN COMMENT', @$_SESSION['systemLang']) ?></label>
              <div class="col-sm-12 position-relative">
                <textarea name="comment" id="comment" title="describe the combination" class="form-control w-100" style="height: 7rem; resize: none; direction: <?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>" <?php if ($_SESSION['isTech'] == 0 || $comb_info['isFinished'] == 1) {echo 'disabled';} ?>><?php echo empty($comb_info['tech_comment']) && $comb_info['isFinished'] ? "لا يوجد تعليق من الفني" : $comb_info['tech_comment']; ?></textarea>
              </div>
            </div>
            <!-- cost -->
            <div class="mb-sm-2 mb-md-3 row">
              <label for="cost" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('COMBINATION COST', @$_SESSION['systemLang']) ?></label>
              <div class="col-sm-12 col-md-8 position-relative">
                <div class="input-group" dir="ltr">
                  <span class="input-group-text"><?php echo language('L.E', @$_SESSION['systemLang']) ?></span>
                  <input type="text" name="cost" id="cost" class="form-control" placeholder="<?php echo language('COMBINATION COST', @$_SESSION['systemLang']) ?>" value="<?php echo $comb_info['cost'] ?>" <?php if ($_SESSION['isTech'] == 0 || $comb_info['isFinished'] == 1) {echo 'disabled';} ?> onblur="arabic_to_english_nums(this)" >
                </div>
                <div id="costHelp" class="form-text text-info">
                  <i class="bi bi-exclamation-triangle-fill"></i>&nbsp;
                  <?php echo language('THE NUMBERS MUST BE IN ENGLISH', @$_SESSION['systemLang']) ?>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- combination review -->
        <div class="col-12">
          <div class="section-block">
              <div class="section-header">
              <h5><?php echo language('COMBINATION REVIEW', @$_SESSION['systemLang']) ?></h5>
              <hr />
            </div>
            <!-- quality of employee -->
            <div class="mb-sm-2 mb-md-3 row">
              <label for="technical-qty" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('QUALITY OF TECHNICAL MAN', @$_SESSION['systemLang']) ?></label>
              <div class="col-sm-12 col-md-8">
                <select name="technical-qty" id="technical-qty" class="form-select" <?php if ($_SESSION['comb_review'] == 0 || ($comb_info['isFinished'] == 0 && $_SESSION['isTech'] == 0) || $comb_info['isReviewed'] == 1) {echo 'disabled';} ?> >
                  <option value="default" disabled <?php if ($comb_info['isReviewed'] == 0) {echo "selected";} ?>><?php echo language('SELECT', @$_SESSION['systemLang'])." ".language('TYPE', @$_SESSION['systemLang'])." ".language('QUALITY OF TECHNICAL MAN', @$_SESSION['systemLang']) ?></option>
                  <option value="1" <?php if ($comb_info['isReviewed'] == 1 && $comb_info['qty_emp'] == 1) {echo "selected";} ?>><?php echo language('BAD', @$_SESSION['systemLang']) ?></option>
                  <option value="2" <?php if ($comb_info['isReviewed'] == 1 && $comb_info['qty_emp'] == 2) {echo "selected";} ?>><?php echo language('GOOD', @$_SESSION['systemLang']) ?></option>
                  <option value="3" <?php if ($comb_info['isReviewed'] == 1 && $comb_info['qty_emp'] == 3) {echo "selected";} ?>><?php echo language('VERY GOOD', @$_SESSION['systemLang']) ?></option>
                </select>
              </div>
            </div>
            <!-- quality of service -->
            <div class="mb-sm-2 mb-md-3 row">
              <label for="service-qty" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('QUALITY OF SERVICE', @$_SESSION['systemLang']) ?></label>
              <div class="col-sm-12 col-md-8">
                <select name="service-qty" id="service-qty" class="form-select" <?php if ($_SESSION['comb_review'] == 0 || ($comb_info['isFinished'] == 0 && $_SESSION['isTech'] == 0) || $comb_info['isReviewed'] == 1) {echo 'disabled';} ?> >
                  <option value="default" disabled <?php if ($comb_info['isReviewed'] == 0) {echo "selected";} ?>><?php echo language('SELECT', @$_SESSION['systemLang'])." ".language('TYPE', @$_SESSION['systemLang'])." ".language('QUALITY OF SERVICE', @$_SESSION['systemLang']) ?></option>
                  <option value="1" <?php if ($comb_info['isReviewed'] == 1 && $comb_info['qty_service'] == 1) {echo "selected";} ?>><?php echo language('BAD', @$_SESSION['systemLang']) ?></option>
                  <option value="2" <?php if ($comb_info['isReviewed'] == 1 && $comb_info['qty_service'] == 2) {echo "selected";} ?>><?php echo language('GOOD', @$_SESSION['systemLang']) ?></option>
                  <option value="3" <?php if ($comb_info['isReviewed'] == 1 && $comb_info['qty_service'] == 3) {echo "selected";} ?>><?php echo language('VERY GOOD', @$_SESSION['systemLang']) ?></option>
                </select>
              </div>
            </div>
            <!-- money review -->
            <div class="mb-sm-2 mb-md-3 row">
              <label for="money-review" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('COST REVIEW', @$_SESSION['systemLang']) ?></label>
              <div class="col-sm-12 col-md-8">
                <select name="money-review" id="money-review" class="form-select" <?php if ($_SESSION['comb_review'] == 0 || ($comb_info['isFinished'] == 0 && $_SESSION['isTech'] == 0) || $comb_info['isReviewed'] == 1) {echo 'disabled';} ?> >
                  <option value="default" disabled <?php if ($comb_info['isReviewed'] == 0) {echo "selected";} ?>><?php echo language('SELECT', @$_SESSION['systemLang'])." ".language('TYPE', @$_SESSION['systemLang'])." ".language('COST REVIEW', @$_SESSION['systemLang']) ?></option>
                  <option value="1" <?php if ($comb_info['isReviewed'] == 1 && $comb_info['money_review'] == 1) {echo "selected";} ?> ><?php echo language('RIGHT', @$_SESSION['systemLang']) ?></option>
                  <option value="2" <?php if ($comb_info['isReviewed'] == 1 && $comb_info['money_review'] == 2) {echo "selected";} ?> ><?php echo language('NOT RIGHT', @$_SESSION['systemLang']) ?></option>
                </select>
              </div>
            </div>
            <!-- employee review comment -->
            <div class="mb-sm-2 mb-md-3 row">
              <label for="review-comment" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('REVIEW COMMENT', @$_SESSION['systemLang']) ?></label>
              <div class="col-sm-12 col-md-8">
                <textarea name="review-comment" id="review-comment" title="review comment" class="form-control w-100" style="height: 5rem; resize: none; direction: <?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>" required  <?php if ($_SESSION['comb_review'] == 0 || ($comb_info['isFinished'] == 0 && $_SESSION['isTech'] == 0) || $comb_info['isReviewed'] == 1) {echo 'disabled';} ?> ><?php echo $comb_info['qty_comment'] ?></textarea>
              </div>
            </div>
            <?php if ($comb_info['isReviewed']) { ?>
            <!-- reviewed date -->
            <div class="mb-1 row align-items-center">
              <label for="reviewed-date" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('REVIEWED DATE', @$_SESSION['systemLang']) ?></label>
              <div class="col-sm-12 col-md-8">
                <span class="text-primary" dir='ltr'><?php echo date_format(date_create($comb_info['reviewed_date']), 'd/m/Y') ?></span>
              </div>
            </div>
            <!-- reviewed time -->
            <div class="mb-1 row align-items-center">
              <label for="reviewed-time" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('REVIEWED TIME', @$_SESSION['systemLang']) ?></label>
              <div class="col-sm-12 col-md-8">
                <span class="text-primary" dir='ltr'><?php echo date_format(date_create($comb_info['reviewed_time']), 'h:i:s a') ?></span>
              </div>
            </div>
            <?php } ?>
            <?php if ($comb_info['isFinished'] == 0 && $_SESSION['isTech'] == 0) { ?> 
              <div class="mb-1 row align-items-center">
                <span class="text-info" dir="<?php echo @$_SESSION['systemLang'] == 0 ? 'rtl' : 'ltr' ?>" style="text-align: <?php echo @$_SESSION['systemLang'] == 0 ? 'right' : 'left' ?>">
                  <i class="bi bi-exclamation-triangle-fill"></i>&nbsp;
                  <?php echo language('THAT IS NOT POSSIBLE TO REVIEW THE COMBINATION BERFORE FINISH IT', @$_SESSION['systemLang']) ?>
                </span>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>

      <!-- the malfunctions media -->
      <div class="mb-3 row row-cols-sm-1 g-3">
        <div class="col-12">
          <div class="section-block">
            <div class="section-header media-section">
              <h5 style="<?php echo $_SESSION['isTech'] == 0 ? 'padding-bottom: 0!important':''; ?>"><?php echo language('MALFUNCTION MEDIA', @$_SESSION['systemLang']) ?></h5>
              <!-- add new malfunction -->
              <?php if ($_SESSION['isTech'] == 1 && ($_SESSION['comb_update'] == 1 || $_SESSION['UserID'] == $comb_info['UserID'])) {?>
              <button type="button" role="button" class="btn btn-outline-primary py-1 fs-12 media-button" onclick="add_new_media()">
                <i class="bi bi-card-image"></i>
                <?php echo language('ADD NEW PHOTO', @$_SESSION['systemLang']) ?>
              </button>
              <?php } ?>
              <hr />
            </div>
            <!-- combination media -->
            <?php $comb_media = $comb_obj->get_combination_media($comb_id); ?>
            <div class="row row-cols-sm-1 <?php echo $comb_media != null && count($comb_media) > 0 ? 'row-cols-md-3' : 'row-cols-md-2' ?> justify-content-center align-items-stretched g-3" id="media-container">
            <?php if ($comb_media != null && count($comb_media) > 0) { ?>
              <?php foreach ($comb_media as $key => $media) { ?>
                <?php $media_source = $uploads . "combinations/" . $_SESSION['company_id'] ."/". $media['media'] ?>
                <?php if (file_exists($media_source)) { ?>
                  <div class="col-12 col-media">
                    <?php if ($media['type'] == 'img') { ?>
                      <img src="<?php echo $media_source ?>" alt="">
                    <?php } else { ?>
                      <video src="<?php echo $media_source ?>" controls>
                        <source src="<?php echo $media_source ?>" type="video/*">
                      </video>
                    <?php } ?>
                    <div class="control-btn">
                      <?php if ($_SESSION['comb_media_download'] == 1) { ?>
                        <button type="button" class="btn btn-primary py-1 ms-1" onclick="download_media('<?php echo $media_source ?>', '<?php echo $media['type'] == 'img' ? 'jpg' : 'mp4' ?>')" src="<?php echo $media_source ?>"><i class='bi bi-download'></i></a>
                      <?php } ?>
                      <?php if ($_SESSION['comb_media_delete'] == 1) { ?>
                        <button type="button" class="btn btn-danger py-1 ms-1" onclick="delete_media(this)" data-media-id="<?php echo $media['id']; ?>" data-media-name="<?php echo $media['media']; ?>"><i class="bi bi-trash"></i></button>
                      <?php } ?>
                      <button type="button" class="btn btn-primary" onclick="open_media('<?php echo $media_source ?>', '<?php echo $media['type'] == 'img' ? 'jpg' : 'mp4' ?>')"><i class="bi bi-eye"></i></button>
                    </div>
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
        <?php if ($_SESSION['comb_update'] == 1 || ($_SESSION['UserID'] == $comb_info['UserID'] && $_SESSION['isTech'] == 1)) { ?>
        <div class="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'me-auto' : 'ms-auto' ?>">
          <button type="button" class="btn btn-primary text-capitalize form-control bg-gradient fs-12" id="" onclick="form_validation(this.form, 'submit')">
            <i class="bi bi-check-all"></i>
            <?php echo language('SAVE CHANGES', @$_SESSION['systemLang']) ?>
          </button>
        </div>
        <?php } ?>
        <?php if ($_SESSION['comb_delete'] == 1) { ?>
        <div>
          <button type="button" class="btn btn-outline-danger text-capitalize form-control bg-gradient fs-12" data-bs-toggle="modal" data-bs-target="#deleteCombModal" id="delete-comb" data-comb-id="<?php echo $comb_info['comb_id'] ?>">
            <i class="bi bi-trash"></i>
            <?php echo language('DELETE', @$_SESSION['systemLang']) ?>
          </button>
        </div>
        <?php } ?>
      </div>
    </form>
    <!-- end form -->
    <?php include_once 'delete-combination-modal.php' ?>

    <!-- media modal -->
    <div id="media-modal" class="media-modal">
      <span class="close" id="media-modal-close">&times;</span>
      <div id="media-modal-content"></div>
    </div>
  </div>
<?php } else { ?>
  <!-- start edit profile page -->
  <div class="container">
    <!-- start header -->
    <header class="header">
      <h1 class="text-capitalize"><?php echo language('SHOW COMBINATION DETAILS', @$_SESSION['systemLang']) ?></h1>
      <?php
        $msg = "<div class='alert alert-warning'>there is no combinations</div>";
        redirectHome($msg, 'back');
      ?>
    </header>
  </div>
<?php } ?>