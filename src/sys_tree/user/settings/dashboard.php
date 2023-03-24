<!-- start home stats container -->
<div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
    <div class="mb-3 row row-cols-sm-1 row-cols-md-2 row-cols-lg-3 align-items-stretch g-3 ">
        <!-- system info -->
        <div class="col-12">
            <div class="section-block">
                    <!-- section header -->
                <div class="section-header">
                    <h5 class="text-capitalize "><?php echo language('SYSTEM INFO', @$_SESSION['systemLang']) ?></h5>
                    <hr />
                </div>
                <?php
                // get user info from database
                $stmt = $con->prepare("SELECT *FROM `license` WHERE `company_id` = " . $_SESSION['company_id'] . " ORDER BY `ID` DESC LIMIT 1");
                $stmt->execute();                     // execute query
                $row = $stmt->fetch();                        // fetch data
                $rowsCount = $stmt->rowCount();                   // get row count
                // check the row count
                if ($rowsCount > 0) { 
                    // get license expire date
                    $licenseDate = date_create($row['expire_date']);
                    // date of today
                    $today = date_create(Date('Y-m-d'));
                    // get diffrence
                    $diff = date_diff($today, $licenseDate);
                    // check the license with the current date
                    if ($licenseDate >= $today) {
                        if ($row['isTrial'] == 0) {
                            switch($row['type']) {
                                case 0:
                                    $type = language('FOREVER', @$_SESSION['systemLang']);
                                    break;
                                case 1:
                                    $type = language('MONTHLY', @$_SESSION['systemLang']);
                                    break;
                                case 2:
                                    $type = language('3 MONTHS', @$_SESSION['systemLang']);
                                    break;
                                case 3:
                                    $type = language('6 MONTHS', @$_SESSION['systemLang']);
                                    break;
                                case 4:
                                    $type = language('YEARLY', @$_SESSION['systemLang']);
                                    break;
                            }
                        } else {
                            $type = language('TRIAL', @$_SESSION['systemLang']);
                        }
                    ?>
                        <p>
                            <span class="text-capitalize"><?php echo language('COMPANY NAME', @$_SESSION['systemLang']) . ": " . $_SESSION['company_name'] ?></span><br>
                            <span class="text-capitalize"><?php echo language('APP VERSION', @$_SESSION['systemLang']) . ": " . $_SESSION['curr_version_name'] ?></span><br>
                            <span class="text-capitalize"><?php echo language('TYPE OF LICENSE', @$_SESSION['systemLang']) . ": " ?><span class="<?php echo $row['isTrial'] == 1 ? 'badge bg-danger' : '' ?>"><?php echo $type ?></span></span><br>
                            <span class="text-capitalize"><?php echo language('LICENSE EXPIRY DATE', @$_SESSION['systemLang']) . ": " . $row['expire_date'] ?></span><br>
                            <?php 
                                $start_date = date_create($row['start_date']);
                                $expire_date = date_create($row['expire_date']);
                                // get total days
                                $total_days = date_diff($start_date, $expire_date);
                                // get date of today
                                $to_day = date_create(date("Y-m-d"));
                                // get diffrence between today and expire date
                                $diffrence = date_diff($to_day, $expire_date); 
                                // get the rest
                                $rest = round(($diffrence->days / $total_days->days) * 100, 2);
                            ?>
                            <div class="progress">
                                <?php if ($rest < 15) { ?>
                                    <div class="progress-bar <?php echo bg_progress($rest) ?>" role="progressbar" style="width: <?php echo $rest ?>%" aria-valuenow="<?php echo $diffrence->days ?>" aria-valuemin="10" aria-valuemax="<?php echo $total_days->days ?>"></div>
                                    <div class="progress-value"><?php echo $rest ?>%</div>
                                <?php } else { ?>
                                    <div class="progress-bar <?php echo bg_progress($rest) ?>" role="progressbar" style="width: <?php echo $rest ?>%" aria-valuenow="<?php echo $diffrence->days ?>" aria-valuemin="10" aria-valuemax="<?php echo $total_days->days ?>"><?php echo $rest ?>%</div>
                                <?php }?>
                            </div>
                            <!-- <span></span>  -->
                        </p>
                    <?php } else { ?>
                        <?php if (!$_SESSION['isRoot']) { ?>
                            <h5 class="h5 text-danger"><?php echo language("LICENSE EXPIRED SINCE", @$_SESSION['systemLang']) . " " . $diff->days . " " . language("DAY", @$_SESSION['systemLang']) ?></h5>
                            <h5 class="h5 text-danger"><?php echo language("PLEASE, TRY TO CALL TECHNICAL SUPPORT", @$_SESSION['systemLang']) ?></h5>
                            <h5 class="h5 text-secondary"><i class="bi bi-telephone"></i> => 01028680375</h5>
                        <?php } else { ?>
                            <!-- license form -->
                            <form action="settings.php?do=renewLicense" method="POST" id="renewLicenseForm">
                                <!-- strat license field -->
                                <div class="mb-4 row">
                                    <label for="license" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('CHOOSE LICENSE', @$_SESSION['systemLang']) ?></label>
                                    <div class="col-sm-12 col-md-8">
                                        <select name="license" id="license" class="form-select" onchange="checkLicenseType()">
                                            <option value="default"  disabled selected><?php echo language('CHOOSE LICENSE', @$_SESSION['systemLang']) ?></option>
                                            <option value="1"><?php echo language('MONTHLY', @$_SESSION['systemLang']); ?></option>
                                            <option value="2"><?php echo language('3 MONTHS', @$_SESSION['systemLang']); ?></option>
                                            <option value="3"><?php echo language('6 MONTHS', @$_SESSION['systemLang']); ?></option>
                                            <option value="4"><?php echo language('YEARLY', @$_SESSION['systemLang']); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <!-- end backup field -->
                                <!-- strat submit -->
                                <div class="mb-4 row">
                                    <div class="col-sm-10">
                                        <button type="button" id="renewLicenseBtn" data-bs-toggle="modal" data-bs-target="#warningMsg" class='my-1 me-1 btn btn-success text-capitalize <?php if ($_SESSION['isRoot'] == 0) {echo 'disabled';} ?>'><i class='bi bi-arrow-clockwise me-1'></i>&nbsp;<?php echo language('RENEW LICENSE', @$_SESSION['systemLang']) ?></button>
                                    </div>
                                </div>
                                <!-- end submit -->
                            </form>

                            <!-- modal to show -->
                            <div class="modal fade" id="renewLicense" tabindex="-1" aria-labelledby="renewLicenseModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title text-capitalize " id="renewLicenseModalLabel"><?php echo language('CONFIRM', @$_SESSION['systemLang'])." ".language('RENEW LICENSE', @$_SESSION['systemLang']) ?></h5>
                                            <button type="button" class="btn-close ms-0" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <h5 class="h5" <?php echo @$_SESSION['systemLang'] == "ar" ? "dir=rtl" : ""; ?>><?php echo language('PLEASE, REENTER THE OWNER OF SYSTEM PASSWORD', @$_SESSION['systemLang']) ?> </h5>
                                            <div class="mb-3 position-relative">
                                                <input type="password" form="renewLicenseForm" class="form-control" id="password" name="pass" placeholder="Password" dir="ltr" required>
                                                <i class="bi bi-eye-slash show-pass text-dark" id="show-pass" onclick="showPass(this)"></i>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" form="renewLicenseForm" class="btn btn-success text-capitalize <?php if ($_SESSION['isRoot'] == 0) {echo 'disabled';} ?>"><i class="bi bi-check-all"></i>&nbsp;<?php echo language('CONFIRM', @$_SESSION['systemLang']) ?></button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- modal to show -->
                            <div class="modal fade" id="warningMsg" tabindex="-1" aria-labelledby="modalLabel2" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title text-capitalize " id="modalLabel2"><?php echo language('WARNING', @$_SESSION['systemLang']) ?></h5>
                                            <button type="button" class="btn-close ms-0" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <h5 class="h5 text-danger " <?php echo @$_SESSION['systemLang'] == "ar" ? "dir=rtl" : ""; ?>><?php echo language('YOU MUST SELECT NEW LICENSE TYPE', @$_SESSION['systemLang']) ?> </h5>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php 
                                if ($_SESSION['isLicenseExpired'] == 1) {
                                    echo '<h6 class="h6 mb-3  text-danger"><i class="bi bi-exclamation-triangle-fill"></i>&nbsp;' . language("LICENSE EXPIRED SINCE", @$_SESSION['systemLang']) . " " . $diff->days . " " . language("DAY", @$_SESSION['systemLang']) . '</h6>';
                                }
                            ?>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
        
        <!-- system language setting -->
        <div class="col-12">
            <div class="section-block">
                <!-- section header -->
                <div class="section-header" >
                    <h5 class="text-capitalize "><?php echo language('SYSTEM LANGUAGE', @$_SESSION['systemLang']) ?></h5>
                    <hr />
                </div>
                <!-- language form -->
                <form action="?do=change-lang" method="POST">
                    <!-- hidden input for employee id -->
                    <input type="hidden" name="id" value="<?php echo $_SESSION['UserID'] ?>">
                    <!-- strat language field -->
                    <div class="mb-3 row">
                        <div class="col-sm-12 col-md-8">
                            <!-- arabic language -->
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="language" id="languageAr" value="0" <?php echo @$_SESSION['systemLang'] == "ar" ? "checked" : "" ?>>
                                <label class="form-check-label text-capitalize" for="languageAr">
                                    <?php echo language('ARABIC', @$_SESSION['systemLang']) ?>
                                </label>
                            </div>
                            <!-- english language -->
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="language" id="languageEn" value="1" <?php echo @$_SESSION['systemLang'] == "en" ? "checked" : "" ?> disabled>
                                <label class="form-check-label text-capitalize" for="languageEn">
                                    <span><?php echo language('ENGLISH', @$_SESSION['systemLang']) ?>&nbsp;</span>
                                    <span class="badge bg-secondary"><?php echo language("UNDER DEVELOPING", @$_SESSION['systemLang']) ?></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <!-- end language field -->
                    <!-- strat submit -->
                    <div class="hstack gap-3">
                        <button type="submit" class="me-auto btn btn-primary text-capitalize"><i class="bi bi-check-all me-1"></i>&nbsp;<?php echo language('SAVE CHANGES', @$_SESSION['systemLang']) ?></button>
                    </div>
                    <!-- end submit -->
                </form>
            </div>
        </div>
    </div>
</div>
