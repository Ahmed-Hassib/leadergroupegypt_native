<?php
// get malfunction id 
$comb_id = isset($_GET['combid']) && !empty($_GET['combid']) ? intval($_GET['combid']) : 0;
// create an object of Combination class
$comb_obj = new Combination();
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
      $updateQ = "UPDATE `combinations` SET `isShowed` = 1, `showed_date` = CURRENT_DATE(), `showed_time` = CURRENT_TIME() WHERE `comb_id` = ?";
      $stmtUp = $con->prepare($updateQ);     // select all directions
      $stmtUp->execute(array($comb_id));               // execute data
    }
  }
?>
  <!-- start add new user page -->
  <div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
    <!-- start form -->
    <form class="py-3 my-5 custom-form needs-validation" action="?do=update-combination-info" method="POST" enctype="multipart/form-data" onchange="form_validation(this.form)">
      <div class="row row-cols-sm-1 row-cols-md-2 g-3">
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
                  <label for="admin-name" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('ADMIN NAME', @$_SESSION['systemLang']) ?></label>
                  <div class="col-sm-12 col-md-8">
                    <!-- admin name -->
                    <?php $admin_name = selectSpecificColumn("`UserName`", "`users`", "WHERE `UserID` = ".$comb_info['addedBy'])[0]['UserName'] ?>
                    <input type="hidden" class="form-control" id="admin-id" name="admin-id" value="<?php echo $comb_info['addedBy'] ?>" autocomplete="off" required data-no-astrisk="true" />
                    <input type="text" class="form-control" id="admin-name" name="admin-name" placeholder="administrator name" value="<?php echo $admin_name ?>" autocomplete="off" required disabled  />
                  </div>
                </div>
                <!-- Technical name -->
                <div class="mb-sm-2 mb-md-3 row">
                  <label for="technical-id" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('TECHNICAL NAME', @$_SESSION['systemLang']) ?></label>
                  <div class="col-sm-12 col-md-8">
                    <select class="form-select" id="technical-id" name="technical-id" required <?php if (($_SESSION['comb_update'] != 1 && $_SESSION['isTech'] != 1) || $comb_info['isFinished'] == 1) {echo 'disabled';} ?>>
                      <option  value="default" disabled selected><?php echo language('SELECT', @$_SESSION['systemLang'])." ".language('TECHNICAL NAME', @$_SESSION['systemLang']) ?></option>
                      <?php $emp_info = $comb_obj->select_specific_column("`UserID`, `UserName`", "users", "WHERE `isTech` = 1 AND `company_id` = " . $_SESSION['company_id']); ?>
                      <?php if (count($emp_info) > 0) { ?>
                        <?php foreach ($emp_info as $userRow) { ?>
                          <option value="<?php echo $userRow['UserID'] ?>" <?php if ($comb_info['UserID'] == $userRow['UserID']) {echo 'selected';} ?> >
                            <?php echo $userRow['UserName']; ?>
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
                <!-- technical status -->
                <div class="mb-sm-2 mb-md-3 row">
                  <label for="tech-comb-status" class="col-sm-12 col-md-4 col-form-label text-capitalize pt-0"><?php echo language('TECH STATUS', @$_SESSION['systemLang']) ?></label>
                  <div class="col-sm-12 col-md-8" id="comb-status">
                    <select class="form-select" name="tech-comb-status" id="tech-comb-status" required <?php if (($_SESSION['comb_update'] != 1 && $_SESSION['isTech'] != 1) || $comb_info['isFinished'] == 1) {echo 'disabled';} ?> <?php if ($_SESSION['isTech'] == 0) {echo 'disabled';} ?>>
                      <option value="default" disabled selected><?php echo language("SELECT YOUR STATUS", @$_SESSION['systemLang']) ?></option>
                      <option value="-1" <?php if ($comb_info['isAccepted'] == -1) { echo 'selected'; } ?>><?php echo language("NO STATUS", @$_SESSION['systemLang']) ?></option>
                      <option value="0"  <?php if ($comb_info['isAccepted'] ==  0) { echo 'selected'; } ?>><?php echo language("NOT ACCEPTED", @$_SESSION['systemLang']) ?></option>
                      <option value="1"  <?php if ($comb_info['isAccepted'] ==  1) { echo 'selected'; } ?>><?php echo language("ACCEPTED", @$_SESSION['systemLang']) ?></option>
                      <option value="2"  <?php if ($comb_info['isAccepted'] ==  2) { echo 'selected'; } ?>><?php echo language("DELAYED", @$_SESSION['systemLang']) ?></option>
                    </select>
                  </div>
                </div>
                <!-- combination status -->
                <div class="mb-sm-2 mb-md-3 row">
                  <label for="mal-status" class="col-sm-12 col-md-4 col-form-label text-capitalize pt-0"><?php echo language('STATUS', @$_SESSION['systemLang']) ?></label>
                  <div class="col-sm-12 col-md-8" id="comb-status">
                    <div class="form-check form-check-inline">
                      <input type="radio" class="form-check-input" id="comb-status-finished" name="comb-status" autocomplete="off" value="1" <?php if ($comb_info['isFinished'] == 1) { echo 'checked'; } ?> <?php if (($_SESSION['comb_update'] != 1 && $_SESSION['isTech'] != 1) || $comb_info['isFinished'] == 1) {echo 'disabled';} ?> />
                      <label for="comb-status-finished" ><?php echo language('FINISHED', @$_SESSION['systemLang']) ?></label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input type="radio" class="form-check-input" id="comb-status-unfinished" name="comb-status" autocomplete="off" value="0" <?php if ($comb_info['isFinished'] == 0) { echo 'checked'; } ?> <?php if (($_SESSION['comb_update'] != 1 && $_SESSION['isTech'] != 1) || $comb_info['isFinished'] == 1) {echo 'disabled';} ?> />
                      <label for="comb-status-unfinished" ><?php echo language('UNFINISHED', @$_SESSION['systemLang']) ?></label>
                    </div>
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
            <!-- client-nameme -->
            <div class="mb-sm-2 mb-md-3 row">
              <label for="client-name" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('CLIENT NAME', @$_SESSION['systemLang']) ?></label>
              <div class="col-sm-12 col-md-8">
                <input type="text" class="form-control" name="client-name" placeholder="<?php echo language('CLIENT NAME', @$_SESSION['systemLang']) ?>" value="<?php echo $comb_info['client_name'] ?>" required <?php if (($_SESSION['comb_update'] != 1 && $_SESSION['isTech'] != 1) || $comb_info['isFinished'] == 1) {echo 'disabled';} ?> >
              </div>
            </div>
            <!-- phone -->
            <div class="mb-sm-2 mb-md-3 row">
              <label for="client-phone" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('PHONE', @$_SESSION['systemLang']) ?></label>
              <div class="col-sm-12 col-md-8 position-relative">
                <input type="text" name="client-phone" id="client-phone" class="form-control w-100" placeholder="<?php echo language('PHONE', @$_SESSION['systemLang']) ?>" value="<?php echo $comb_info['phone'] ?>" required <?php if (($_SESSION['comb_update'] != 1 && $_SESSION['isTech'] != 1) || $comb_info['isFinished'] == 1) {echo 'disabled';} ?> />
              </div>
            </div>
            <!-- address -->
            <div class="mb-sm-2 mb-md-3 row">
              <label for="client-address" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('THE ADDRESS', @$_SESSION['systemLang']) ?></label>
              <div class="col-sm-12 col-md-8 position-relative">
                <input type="text" name="client-address" id="client-address" class="form-control w-100" placeholder="<?php echo language('THE ADDRESS', @$_SESSION['systemLang']) ?>" value="<?php echo $comb_info['address'] ?>" required  <?php if (($_SESSION['comb_update'] != 1 && $_SESSION['isTech'] != 1) || $comb_info['isFinished'] == 1) {echo 'disabled';} ?> />
              </div>
            </div>
            <!-- notes -->
            <div class="mb-sm-2 mb-md-3 row">
              <label for="client-notes" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('THE NOTES', @$_SESSION['systemLang']) ?></label>
              <div class="col-sm-12 col-md-8 position-relative">
                <textarea type="text" name="client-notes" id="client-notes" class="form-control w-100" rows="5" placeholder="<?php echo language('THE NOTES', @$_SESSION['systemLang']) ?>" style="resize: none; direction: <?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>" required  <?php if (($_SESSION['comb_update'] != 1 && $_SESSION['isTech'] != 1) || $comb_info['isFinished'] == 1) {echo 'disabled';} ?> ><?php echo $comb_info['comment'] ?></textarea>
              </div>
            </div>
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
            <div class="mb-sm-2 mb-md-3 row">
              <label for="added-date" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('ADDED DATE', @$_SESSION['systemLang']) ?></label>
              <div class="col-sm-12 col-md-8">
                <input type="date" class="form-control text-center" id="added-date" name="added-date" placeholder="Combination date" value="<?php echo $comb_info['added_date'] ?>" autocomplete="off" required disabled/>
              </div>
            </div>
            <!-- added time -->
            <div class="mb-sm-2 mb-md-3 row">
              <label for="added-time" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('ADDED TIME', @$_SESSION['systemLang']) ?></label>
              <div class="col-sm-12 col-md-8">
                <input type="time" class="form-control text-center" id="added-time" name="added-time" placeholder="Combination time" value="<?php echo $comb_info['added_time'] ?>" autocomplete="off" required disabled/>
              </div>
            </div>
            <!-- showed date -->
            <div class="mb-sm-2 mb-md-3 row">
              <label for="showed-date" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('COMB SHOWED DATE', @$_SESSION['systemLang']) ?></label>
              <div class="col-sm-12 col-md-8">
                <?php if ($comb_info['isShowed']) { ?>
                  <input type="date" class="form-control text-center" id="finished-date" name="finished-date" placeholder="Combination date" value="<?php echo $comb_info['showed_date'] ?>" autocomplete="off" disabled/>
                <?php } else { ?>
                  <input type="text" class="form-control text-center" id="msg-finished-date" name="msg-finished-date" placeholder="Combination date message" value="Combination is not showed" autocomplete="off" disabled/>
                <?php } ?>
              </div>
            </div>
            <!-- showed time -->
            <div class="mb-sm-2 mb-md-3 row">
              <label for="showed-time" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('COMB SHOWED TIME', @$_SESSION['systemLang']) ?></label>
              <div class="col-sm-12 col-md-8">
                <?php if ($comb_info['isShowed']) { ?>
                  <input type="time" class="form-control text-center" id="finished-time" name="finished-time" placeholder="Combination time" value="<?php echo $comb_info['showed_time'] ?>" autocomplete="off" disabled/>
                <?php } else { ?>
                  <input type="text" class="form-control text-center" id="msg-finished-time" name="msg-finished-time" placeholder="Combination time message" value="Combination is not showed" autocomplete="off" disabled/>
                <?php } ?>
              </div>
            </div>
            <!-- finished date -->
            <div class="mb-sm-2 mb-md-3 row">
              <label for="finished-date" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('FINISHED DATE', @$_SESSION['systemLang']) ?></label>
              <div class="col-sm-12 col-md-8">
                <?php if ($comb_info['isFinished']) { ?>
                  <input type="date" class="form-control text-center" id="finished-date" name="finished-date" placeholder="Combination date" value="<?php echo $comb_info['finished_date'] ?>" autocomplete="off" disabled/>
                <?php } else { ?>
                  <input type="text" class="form-control text-center" id="msg-finished-date" name="msg-finished-date" placeholder="Combination date message" value="<?php echo language('NOT ASSIGNED', $_SESSION['systemLang']) ?>" autocomplete="off" disabled/>
                <?php } ?>
              </div>
            </div>
            <!-- finished time -->
            <div class="mb-sm-2 mb-md-3 row">
              <label for="finished-time" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('FINISHED TIME', @$_SESSION['systemLang']) ?></label>
              <div class="col-sm-12 col-md-8">
                <?php if ($comb_info['isFinished']) { ?>
                  <input type="time" class="form-control text-center" id="finished-date" name="finished-date" placeholder="Combination date" value="<?php echo $comb_info['finished_time'] ?>" autocomplete="off" disabled/>
                <?php } else { ?>
                  <input type="text" class="form-control text-center" id="msg-finished-date" name="msg-finished-date" placeholder="Combination date message" value="<?php echo language('NOT ASSIGNED', $_SESSION['systemLang']) ?>" autocomplete="off" disabled/>
                <?php } ?>
              </div>
            </div>
            
            <?php if ($comb_info['isAccepted'] == 1) { ?>
              <!-- diff time -->
              <div class="mb-sm-2 mb-md-3 row">
                <label for="showed-time" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('FINISHED PERIOD', @$_SESSION['systemLang']) ?></label>
                <div class="col-sm-12 col-md-8 pt-2">
                <?php
                  $diff= [];
                  if ($comb_info['showed_time'] != '00:00:00' && $comb_info['finished_time'] != '00:00:00') {
                    $shDate = date_create($comb_info['showed_date']);        // showed date
                    $fiDate = date_create($comb_info['finished_date']);      // finished date
                    // get the diffrence of days
                    $diffDate = date_diff($shDate, $fiDate, true);

                    $shTime = date_create($comb_info['showed_time']);        // showed time
                    $fiTime = date_create($comb_info['finished_time']);      // finished time
                    // get the diffrence of time
                    $diffTime = date_diff($shTime, $fiTime, true);
                  ?>
                  <span class="mt-2" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'ltr' : 'rtl' ?>">
                    <?php
                      echo $diffDate->d . "&nbsp;";
                      echo $diffDate->d > 1 ? "day" : "days";
                      echo " - ";
                      echo $diffTime->h . "&nbsp;";
                      echo $diffTime->h > 1 ? "hour" : "hours";
                      echo " - ";
                      echo $diffTime->i . "&nbsp;";
                      echo $diffTime->i > 1 ? "minute" : "minutes";
                      echo " - ";
                      echo $diffTime->s . "&nbsp;";
                      echo $diffTime->s > 1 ? "second" : "seconds";
                      ?>
                  </span>
                  <?php } else { ?>
                    <span class="text-danger "><?php echo language('THE TECHNICAL MAN DIDN`T FINISH THE COMBINATION TO CALCULATE THE COMBINATION FINISHED PERIOD', @$_SESSION['systemLang']) ?></span>
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
              <label for="comment" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('TECHNICAL MAN COMMENT', @$_SESSION['systemLang']) ?></label>
              <div class="col-sm-12 col-md-8">
                <textarea name="comment" id="comment" title="describe the combination" class="form-control w-100" style="height: 7rem; resize: none; direction: <?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>" <?php if ($_SESSION['isTech'] == 0 || $comb_info['isFinished']) {echo 'disabled';} ?>><?php echo empty($comb_info['tech_comment']) && $comb_info['isFinished'] ? "لا يوجد تعليق من الفني" : $comb_info['tech_comment']; ?></textarea>
              </div>
            </div>
            <!-- cost -->
            <div class="mb-sm-2 mb-md-3 row">
              <label for="cost" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('COMBINATION COST', @$_SESSION['systemLang']) ?></label>
              <div class="col-sm-12 col-md-8">
                <div class="row">
                  <div class="col-3">
                    <input name="cost" id="cost" class="form-control"  placeholder="<?php echo language('COMBINATION COST', @$_SESSION['systemLang']) ?>" value="<?php echo $comb_info['cost'] ?>" <?php if ($_SESSION['isTech'] == 0 || ($_SESSION['comb_update'] != 1 && $_SESSION['isTech'] != 1) || $comb_info['isFinished'] == 1) {echo 'disabled';} ?> >
                  </div>
                  <div class="mt-2 col">
                    <span><?php echo language('L.E', @$_SESSION['systemLang']) ?></span>
                  </div>
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
            <!-- reviewed time -->
            <div class="mb-sm-2 mb-md-3 row">
              <label for="reviewed-time" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('REVIEWED TIME', @$_SESSION['systemLang']) ?></label>
              <div class="col-sm-12 col-md-8">
                <input type="time" class="form-control" id="reviewed-time" name="reviewed-time" placeholder="malfunction time" value="<?php echo $comb_info['reviewed_time'] ?>" autocomplete="off" readonly/>
              </div>
            </div>
            <!-- reviewed date -->
            <div class="mb-sm-2 mb-md-3 row">
              <label for="reviewed-date" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('REVIEWED DATE', @$_SESSION['systemLang']) ?></label>
              <div class="col-sm-12 col-md-8">
                <input type="date" class="form-control" id="reviewed-date" name="reviewed-date" placeholder="malfunction date" value="<?php echo $comb_info['reviewed_date'] ?>" autocomplete="off" readonly/>
              </div>
            </div>
            <?php } ?>
            <?php if ($comb_info['isFinished'] == 0 && $_SESSION['isTech'] == 0) { ?> 
              <div class="mb-sm-2 mb-md-3 row">
                <span class="text-info" dir="<?php echo @$_SESSION['systemLang'] == 0 ? 'rtl' : 'ltr' ?>" style="text-align: <?php echo @$_SESSION['systemLang'] == 0 ? 'right' : 'left' ?>"><?php echo language('THAT IS NOT POSSIBLE TO REVIEW THE COMBINATION BERFORE FINISH IT', @$_SESSION['systemLang']) ?></span>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>

      <!-- submit -->
      <div class="hstack gap-2">
        <div class="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'me-auto' : 'ms-auto' ?>">
          <button type="button" class="btn btn-primary text-capitalize form-control bg-gradient fs-12 <?php if ($_SESSION['comb_update'] == 0) {echo 'disabled';} ?>" id="" onclick="form_validation(this.form, 'submit')">
            <i class="bi bi-check-all"></i>
            <?php echo language('SAVE CHANGES', @$_SESSION['systemLang']) ?>
          </button>
        </div>
        <div>
          <button type="button" class="btn btn-outline-danger text-capitalize form-control bg-gradient fs-12 <?php if ($_SESSION['comb_delete'] == 0) {echo 'disabled';} ?>" data-bs-toggle="modal" data-bs-target="#deleteCombModal" id="delete-comb" data-comb-id="<?php echo $comb_info['comb_id'] ?>">
            <i class="bi bi-trash"></i>
            <?php echo language('DELETE', @$_SESSION['systemLang']) ?>
          </button>
        </div>
      </div>
    </form>
    <!-- end form -->
    <?php include_once 'delete-combination-modal.php' ?>
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