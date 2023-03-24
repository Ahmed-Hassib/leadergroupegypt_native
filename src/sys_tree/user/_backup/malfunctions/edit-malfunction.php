<?php 
// get malfunction id 
$malID = isset($_GET['malid']) && !empty($_GET['malid']) ? intval($_GET['malid']) : 0;
// check if malid exist
$count = checkItem("`mal_id`", "`malfunctions`", $malID);
// check
if ($count > 0) {
    $q = "SELECT *FROM `malfunctions` WHERE `mal_id` = ?";
    $stmt = $con->prepare($q);     // select all directions
    $stmt->execute(array($malID));               // execute data
    $malrows = $stmt->fetch();      // assign all data to variable

    // check if malfunction is showed or not
    if ($malrows['isShowed'] == 0) {
        if ($_SESSION['UserID'] == $malrows['tech_id']) {
            // update some info of this malfunction
            $q = "UPDATE `malfunctions` SET `isShowed` = 1, `showed_date` = CURRENT_DATE, `showed_time` = CURRENT_TIME WHERE `mal_id` = ? AND `company_id` = ?";
            $stmt = $con->prepare($q, $_SESSION['company_id']);     
            $stmt->execute(array($malID));               // execute data 
        }
    }
?>
    <!-- start add new user page -->
    <div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
        <!-- start form -->
        <form class="py-3 my-5 custom-form needs-validation" action="?do=updateMalfunction" method="POST" enctype="multipart/form-data">
            <div class="mb-5 row row-cols-sm-1 row-cols-md-2 g-3">
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
                                    <input type="hidden" name="mal-id" id="mal-id" value="<?php echo $malrows['mal_id'] ?>">
                                    <!-- Administrator name -->
                                    <div class="mb-sm-2 mb-md-3 row">
                                        <label for="admin-name" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('ADMIN NAME', @$_SESSION['systemLang']) ?></label>
                                        <div class="col-sm-12 col-md-8">
                                            <?php
                                            $adminName = selectSpecificColumn("`UserName`", "`users`", "WHERE `UserID` = '" . $malrows['mng_id'] . "' LIMIT 1")[0]['UserName'];
                                            ?>
                                            <input type="hidden" class="form-control" id="admin-id" name="admin-id" value="<?php echo $malrows['mng_id'] ?>" autocomplete="off" required />
                                            <input type="text" class="form-control" id="admin-name" name="admin-name" placeholder="<?php echo language('ADMIN NAME', @$_SESSION['systemLang']) ?>" value="<?php echo $adminName ?>" autocomplete="off" required readonly />
                                        </div>
                                    </div>
                                    <!-- Technical name -->
                                    <div class="mb-sm-2 mb-md-3 row">
                                        <label for="technical-id" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('TECHNICAL NAME', @$_SESSION['systemLang']) ?></label>
                                        <div class="col-sm-12 col-md-8">
                                            <!-- select tag for technical -->
                                            <select class="form-select" id="technical-id" name="tech-id" <?php if ($_SESSION['isTech'] == 1 && $_SESSION['mal_update'] == 0) {echo 'disabled';} ?>>
                                                <option  value="default" disabled selected><?php echo language('SELECT', @$_SESSION['systemLang'])." ".language('THE TECHNICAL', @$_SESSION['systemLang']) ?></option>
                                                <?php
                                                // get all technical men
                                                $usersRows = selectSpecificColumn("`UserID`, `UserName`", "`users`", "WHERE `isTech` = 1");

                                                if (count($usersRows) > 0) {
                                                    // loop on result ..
                                                    foreach ($usersRows as $userRow) {
                                                        // get all information of users..
                                                ?>
                                                        <option value="<?php echo $userRow['UserID'] ?>" <?php if ($userRow['UserID'] == $malrows['tech_id']) { echo 'selected'; } ?>>
                                                            <?php echo $userRow['UserName']; ?>
                                                        </option>";
                                                <?php
                                                    }
                                                } else {
                                                    echo "<option>Not available now</option>";
                                                }
                                                ?>
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
                                <div class="mb-sm-2 mb-md-3 row">
                                    <label for="mal-status" class="col-sm-12 col-md-4 col-form-label text-capitalize pt-0"><?php echo language('STATUS', @$_SESSION['systemLang']) ?></label>
                                    <div class="col-sm-12 col-md-8" id="mal-status">
                                        <select name="mal-status" id="mal-status" class="form-select" <?php if ($_SESSION['isTech'] == 0 ) {echo 'disabled';} ?>>
                                            <option value="default" disabled selected><?php echo language("SELECT", @$_SESSION['systemLang']).' '.language("STATUS", @$_SESSION['systemLang']) ?></option>
                                            <option value="0" <?php if ($malrows['mal_status'] == 0) { echo 'selected'; } ?>><?php echo language('UNREPAIRED', @$_SESSION['systemLang']) ?></option>
                                            <option value="1" <?php if ($malrows['mal_status'] == 1) { echo 'selected'; } ?>><?php echo language('REPAIRED', @$_SESSION['systemLang']) ?></option>
                                            <option value="2" <?php if ($malrows['mal_status'] == 2) { echo 'selected'; } ?>><?php echo language('DELAYED', @$_SESSION['systemLang']) ?></option>
                                        </select>
                                    </div>
                                </div>
                                <!-- tech_status -->
                                <div class="mb-sm-2 mb-md-3 row">
                                    <label for="tech-status" class="col-sm-12 col-md-4 col-form-label text-capitalize pt-0"><?php echo language('TECH STATUS', @$_SESSION['systemLang']) ?></label>
                                    <div class="col-sm-12 col-md-8" id="tech-status">
                                        <select name="tech-status" id="tech-status" class="form-select" <?php if ($_SESSION['isTech'] == 0 ) {echo 'disabled';} ?>>
                                            <option value="default" disabled selected><?php echo language("SELECT", @$_SESSION['systemLang']).' '.language("TECH STATUS", @$_SESSION['systemLang']) ?></option>
                                            <option value="0" <?php if ($malrows['isAccepted'] == -1) { echo 'selected'; } ?>><?php echo language('NO STATUS', @$_SESSION['systemLang']) ?></option>
                                            <option value="0" <?php if ($malrows['isAccepted'] == 0) { echo 'selected'; } ?>><?php echo language('NOT ACCEPTED', @$_SESSION['systemLang']) ?></option>
                                            <option value="1" <?php if ($malrows['isAccepted'] == 1) { echo 'selected'; } ?>><?php echo language('ACCEPTED', @$_SESSION['systemLang']) ?></option>
                                            <option value="2" <?php if ($malrows['isAccepted'] == 2) { echo 'selected'; } ?>><?php echo language('DELAYED', @$_SESSION['systemLang']) ?></option>
                                        </select>
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
                        <div class="mb-sm-2 mb-md-3 row">
                            <label for="client-name" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('CLIENT NAME', @$_SESSION['systemLang']) ?></label>
                            <div class="col-sm-12 col-md-8 position-relative">
                                <?php
                                    $clientDetails = selectSpecificColumn("`piece_id`, `piece_name`, `piece_ip`", "`pieces`", "WHERE `piece_id` = '" . $malrows['client_id'] . "' LIMIT 1");
                                ?>
                                <input type="hidden" name="client-id" id="client-id" class="form-control w-100" placeholder="Client ID" value="<?php echo $malrows['client_id'] ?>" />
                                <input type="text" name="client-name" id="client-name" class="form-control w-100" placeholder="<?php echo language('CLIENT NAME', @$_SESSION['systemLang']) ?>" value="<?php echo $clientDetails[0]['piece_name'] ?>" required readonly onkeyup="search(this)"  />
                                <div class="result w-100">
                                    <ul class="clients-names" id="clients-names"></ul>
                                </div>
                            </div>
                        </div>
                        <!-- client address -->
                        <div class="mb-sm-2 mb-md-3 row">
                            <label for="client-addr" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('THE ADDRESS', @$_SESSION['systemLang']) ?></label>
                            <div class="col-sm-12 col-md-8 position-relative">
                                <?php
                                    $clientAddr = selectSpecificColumn("`address`", "`pieces_addr`", "WHERE `piece_id` = '" . $malrows['client_id'] . "' LIMIT 1");
                                ?>
                                <input type="text" name="client-addr" id="client-addr" class="form-control w-100" placeholder="No address" value="<?php if (!empty($clientAddr)) { echo $clientAddr[0]['address'];} ?>" required readonly />
                            </div>
                        </div>
                        <!-- client address -->
                        <div class="mb-sm-2 mb-md-3 row">
                            <label for="client-addr" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('PHONE', @$_SESSION['systemLang']) ?></label>
                            <div class="col-sm-12 col-md-8 position-relative">
                                <?php
                                    $clientPhone = selectSpecificColumn("`phone`", "`pieces_phone`", "WHERE `piece_id` = '" . $malrows['client_id'] . "' LIMIT 1");
                                ?>
                                <input type="text" name="client-addr" id="client-addr" class="form-control w-100" placeholder="No phone" value="<?php if (!empty($clientPhone)) {echo $clientPhone[0]['phone'];} ?>" required readonly />
                            </div>
                        </div>
                        <!-- client ip -->
                        <div class="mb-sm-2 mb-md-3 row">
                            <label for="client-ip" class="col-sm-12 col-md-4 col-form-label text-capitalize"><span class="text-uppercase"><?php echo language('IP', @$_SESSION['systemLang']) ?></span></label>
                            <div class="col-sm-12 col-md-8 position-relative">
                                <input type="text" name="client-ip" id="client-ip" class="form-control w-100" placeholder="Client IP" value="<?php echo $clientDetails[0]['piece_ip'] != 1 ? $clientDetails[0]['piece_ip'] : "No IP" ?>" required readonly />
                            </div>
                        </div>
                        <!-- malfunctions counter -->
                        <?php $malCounter = countRecords("`mal_id`", "`malfunctions`", "WHERE `client_id` = ".$malrows['client_id']) ?>
                        <div class="mb-sm-2 mb-md-3 row">
                            <label for="malfunction-counter" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('MALFUNCTIONS COUNTER', @$_SESSION['systemLang']) ?></label>
                            <div class="col-sm-12 col-md-8">
                                <span class="mt-2 me-5 text-start" dir="<?php echo @$_SESSION['systemLang'] == "ar" ? "rtl" : "ltr" ?>"><?php echo $malCounter . " " . ($malCounter > 2 ? language("MALFUNCTIONS", @$_SESSION['systemLang']) : language("MALFUNCTION", @$_SESSION['systemLang'])) ?></span>
                                <a href="?do=showPiecesMal&pieceid=<?php echo $malrows['client_id'] ?>" class="mt-2 text-start" dir="<?php echo @$_SESSION['systemLang'] == "ar" ? "rtl" : "ltr" ?>"><?php echo language("SHOW DETAILS", @$_SESSION['systemLang']) ?></a>
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
                        <div class="mb-sm-2 mb-md-3 row">
                            <label for="added-date" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('ADDED DATE', @$_SESSION['systemLang']) ?></label>
                            <div class="col-sm-12 col-md-8">
                                <input type="date" class="form-control" id="added-date" name="added-date" placeholder="malfunction date" value="<?php echo $malrows['added_date'] ?>" autocomplete="off" required readonly/>
                            </div>
                        </div>
                        <!-- added time -->
                        <div class="mb-sm-2 mb-md-3 row">
                            <label for="added-time" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('ADDED TIME', @$_SESSION['systemLang']) ?></label>
                            <div class="col-sm-12 col-md-8">
                                <input type="time" class="form-control" id="added-time" name="added-time" placeholder="malfunction time" value="<?php echo $malrows['added_time'] ?>" autocomplete="off" required readonly/>
                            </div>
                        </div>
                        <!-- showed date -->
                        <div class="mb-sm-2 mb-md-3 row">
                            <label for="showed-date" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('SHOWED DATE', @$_SESSION['systemLang']) ?></label>
                            <div class="col-sm-12 col-md-8">
                                <?php if ($malrows['isShowed']) { ?>
                                    <input type="date" class="form-control" id="repaired-date" name="repaired-date" placeholder="malfunction date" value="<?php echo $malrows['showed_date'] ?>" autocomplete="off" readonly/>
                                <?php } else { ?>
                                    <input type="text" class="form-control" id="msg-repaired-date" name="msg-repaired-date" placeholder="malfunction date message" value="Malfunction is not showed" autocomplete="off" disabled/>
                                <?php } ?>
                            </div>
                        </div>
                        <!-- showed time -->
                        <div class="mb-sm-2 mb-md-3 row">
                            <label for="showed-time" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('SHOWED TIME', @$_SESSION['systemLang']) ?></label>
                            <div class="col-sm-12 col-md-8">
                                <?php if ($malrows['isShowed']) { ?>
                                    <input type="time" class="form-control" id="repaired-time" name="repaired-time" placeholder="malfunction time" value="<?php echo $malrows['showed_time'] ?>" autocomplete="off" readonly/>
                                <?php } else { ?>
                                    <input type="text" class="form-control" id="msg-repaired-time" name="msg-repaired-time" placeholder="malfunction time message" value="Malfunction is not showed" autocomplete="off" disabled/>
                                <?php } ?>
                            </div>
                        </div>
                        <!-- repaired date -->
                        <div class="mb-sm-2 mb-md-3 row">
                            <label for="repaired-date" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('REPAIRED DATE', @$_SESSION['systemLang']) ?></label>
                            <div class="col-sm-12 col-md-8">
                                <?php if ($malrows['mal_status']) { ?>
                                    <input type="date" class="form-control" id="repaired-date" name="repaired-date" placeholder="malfunction date" value="<?php echo $malrows['repaired_date'] ?>" autocomplete="off" readonly/>
                                <?php } else { ?>
                                    <input type="text" class="form-control" id="msg-repaired-date" name="msg-repaired-date" placeholder="malfunction date message" value="Not assigned" autocomplete="off" disabled/>
                                <?php } ?>
                            </div>
                        </div>
                        <!-- repaired time -->
                        <div class="mb-sm-2 mb-md-3 row">
                            <label for="repaired-time" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('REPAIRED TIME', @$_SESSION['systemLang']) ?></label>
                            <div class="col-sm-12 col-md-8">
                                <?php if ($malrows['mal_status']) { ?>
                                    <input type="time" class="form-control" id="repaired-date" name="repaired-date" placeholder="malfunction date" value="<?php echo $malrows['repaired_time'] ?>" autocomplete="off" readonly/>
                                <?php } else { ?>
                                    <input type="text" class="form-control" id="msg-repaired-date" name="msg-repaired-date" placeholder="malfunction date message" value="Not assigned" autocomplete="off" disabled/>
                                <?php } ?>
                            </div>
                        </div>
                        <?php if ($malrows['mal_status'] == 1) { ?>
                            <!-- diff time -->
                            <div class="mb-sm-2 mb-md-3 row">
                                <label for="showed-time" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('REPAIRED PERIOD', @$_SESSION['systemLang']) ?></label>
                                <div class="col-sm-12 col-md-8 pt-2">
                                    <?php
                                        $diff= [];
                                        if ($malrows['showed_time'] != '00:00:00' && $malrows['repaired_time'] != '00:00:00') {
                                            $shDate = date_create($malrows['showed_date']);        // showed date
                                            $fiDate = date_create($malrows['repaired_date']);      // finished date
                                            // get the diffrence of days
                                            $diffDate = date_diff($shDate, $fiDate, true);

                                            $shTime = date_create($malrows['showed_time']);     // showed time
                                            $reTime = date_create($malrows['repaired_time']);   // repaired time
                                            // get the diffrence
                                            $diffTime = date_diff($reTime, $shTime, true);
                                    ?>
                                        <span class="mt-2">
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
                                        <span class="text-info"><?php echo language('THE TECHNICAL MAN DIDN`T REPAIR THE MALFUNCTION TO CALCULATE THE MALFUNCTION REPAIRED PERIOD', @$_SESSION['systemLang']) ?></span>
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
                        <div class="mb-sm-2 mb-md-3 row">
                            <label for="descreption" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('MALFUNCTION DESCRIPTION', @$_SESSION['systemLang']) ?></label>
                            <div class="col-sm-12 col-md-8">
                                <textarea name="descreption" id="descreption" title="describe the malfunction" class="form-control w-100" style="height: 7rem; resize: none; direction: <?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>" placeholder="Describe the malfunction" required <?php if ($_SESSION['isTech'] == 1 || $malrows['mal_status']) {echo 'disabled';} ?>><?php echo $malrows['descreption'] ?></textarea>
                            </div>
                        </div>
                        <!-- technical man comment -->
                        <div class="mb-sm-2 mb-md-3 row">
                            <label for="comment" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('TECHNICAL MAN COMMENT', @$_SESSION['systemLang']) ?></label>
                            <div class="col-sm-12 col-md-8">
                                <textarea name="comment" id="comment" title="describe the malfunction" class="form-control w-100" style="height: 7rem; resize: none; direction: <?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>" <?php if ($_SESSION['isTech'] == 0 || $malrows['mal_status']) {echo 'disabled';} ?>><?php echo empty($malrows['tech_comment']) && $malrows['mal_status'] ? "لا يوجد تعليق من الفني" : $malrows['tech_comment']; ?></textarea>
                            </div>
                        </div>
                        <!-- cost -->
                        <div class="mb-sm-2 mb-md-3 row">
                            <label for="cost" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('MALFUNCTION COST', @$_SESSION['systemLang']) ?></label>
                            <div class="col-sm-12 col-md-8">
                                <div class="row">
                                    <div class="col-3">
                                        <input name="cost" id="cost" class="form-control"  placeholder="<?php echo language('MALFUNCTION COST', @$_SESSION['systemLang']) ?>" value="<?php echo $malrows['cost'] ?>" <?php if ($_SESSION['isTech'] == 0) {echo 'disabled';} ?> >
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
                        <div class="mb-sm-2 mb-md-3 row">
                            <label for="technical-qty" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('QUALITY OF TECHNICAL MAN', @$_SESSION['systemLang']) ?></label>
                            <div class="col-sm-12 col-md-8">
                                <select name="technical-qty" id="technical-qty" class="form-select" <?php if ($_SESSION['mal_review'] == 0 || ($malrows['mal_status'] == 0 && $_SESSION['isTech'] == 0) || $malrows['isReviewed'] == 1) {echo 'disabled';} ?> >
                                    <option  value="default" disabled <?php if ($malrows['isReviewed'] == 0) {echo "selected";} ?>><?php echo language('SELECT', @$_SESSION['systemLang'])." ".language('TYPE', @$_SESSION['systemLang'])." ".language('QUALITY OF TECHNICAL MAN', @$_SESSION['systemLang']) ?></option>
                                    <option value="1" <?php if ($malrows['isReviewed'] == 1 && $malrows['qty_emp'] == 1) {echo "selected";} ?>><?php echo language('BAD', @$_SESSION['systemLang']) ?></option>
                                    <option value="2" <?php if ($malrows['isReviewed'] == 1 && $malrows['qty_emp'] == 2) {echo "selected";} ?>><?php echo language('GOOD', @$_SESSION['systemLang']) ?></option>
                                    <option value="3" <?php if ($malrows['isReviewed'] == 1 && $malrows['qty_emp'] == 3) {echo "selected";} ?>><?php echo language('VERY GOOD', @$_SESSION['systemLang']) ?></option>
                                </select>
                            </div>
                        </div>
                        <!-- quality of service -->
                        <div class="mb-sm-2 mb-md-3 row">
                            <label for="service-qty" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('QUALITY OF SERVICE', @$_SESSION['systemLang']) ?></label>
                            <div class="col-sm-12 col-md-8">
                                <select name="service-qty" id="service-qty" class="form-select" <?php if ($_SESSION['mal_review'] == 0 || ($malrows['mal_status'] == 0 && $_SESSION['isTech'] == 0) || $malrows['isReviewed'] == 1) {echo 'disabled';} ?> >
                                    <option  value="default" disabled <?php if ($malrows['isReviewed'] == 0) {echo "selected";} ?>><?php echo language('SELECT', @$_SESSION['systemLang'])." ".language('TYPE', @$_SESSION['systemLang'])." ".language('QUALITY OF SERVICE', @$_SESSION['systemLang']) ?></option>
                                    <option value="1" <?php if ($malrows['isReviewed'] == 1 && $malrows['qty_service'] == 1) {echo "selected";} ?>><?php echo language('BAD', @$_SESSION['systemLang']) ?></option>
                                    <option value="2" <?php if ($malrows['isReviewed'] == 1 && $malrows['qty_service'] == 2) {echo "selected";} ?>><?php echo language('GOOD', @$_SESSION['systemLang']) ?></option>
                                    <option value="3" <?php if ($malrows['isReviewed'] == 1 && $malrows['qty_service'] == 3) {echo "selected";} ?>><?php echo language('VERY GOOD', @$_SESSION['systemLang']) ?></option>
                                </select>
                            </div>
                        </div>
                        <!-- money review -->
                        <div class="mb-sm-2 mb-md-3 row">
                            <label for="money-review" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('COST REVIEW', @$_SESSION['systemLang']) ?></label>
                            <div class="col-sm-12 col-md-8">
                                <select name="money-review" id="money-review" class="form-select" <?php if ($_SESSION['mal_review'] == 0 || ($malrows['mal_status'] == 0 && $_SESSION['isTech'] == 0) || $malrows['isReviewed'] == 1) {echo 'disabled';} ?> >
                                    <option  value="default" disabled <?php if ($malrows['isReviewed'] == 0) {echo "selected";} ?>><?php echo language('SELECT', @$_SESSION['systemLang'])." ".language('TYPE', @$_SESSION['systemLang'])." ".language('COST REVIEW', @$_SESSION['systemLang']) ?></option>
                                    <option value="1" <?php if ($malrows['isReviewed'] == 1 && $malrows['money_review'] == 1) {echo "selected";} ?> ><?php echo language('RIGHT', @$_SESSION['systemLang']) ?></option>
                                    <option value="2" <?php if ($malrows['isReviewed'] == 1 && $malrows['money_review'] == 2) {echo "selected";} ?> ><?php echo language('NOT RIGHT', @$_SESSION['systemLang']) ?></option>
                                </select>
                            </div>
                        </div>
                        <!-- employee review comment -->
                        <div class="mb-sm-2 mb-md-3 row">
                            <label for="review-comment" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('REVIEW COMMENT', @$_SESSION['systemLang']) ?></label>
                            <div class="col-sm-12 col-md-8">
                                <textarea name="review-comment" id="review-comment" title="review comment" class="form-control w-100" style="height: 5rem; resize: none; direction: <?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>" required  <?php if ($_SESSION['mal_review'] == 0 || ($malrows['mal_status'] == 0 && $_SESSION['isTech'] == 0) || $malrows['isReviewed'] == 1) {echo 'disabled';} ?> ><?php echo $malrows['qty_comment'] ?></textarea>
                            </div>
                        </div>
                        <?php if ($malrows['isReviewed']) { ?>
                        <!-- reviewed time -->
                        <div class="mb-sm-2 mb-md-3 row">
                            <label for="reviewed-time" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('REVIEWED TIME', @$_SESSION['systemLang']) ?></label>
                            <div class="col-sm-12 col-md-8">
                                <input type="time" class="form-control" id="repaired-time" name="repaired-time" placeholder="malfunction time" value="<?php echo $malrows['reviewed_time'] ?>" autocomplete="off" readonly/>
                            </div>
                        </div>
                        <!-- reviewed date -->
                        <div class="mb-sm-2 mb-md-3 row">
                            <label for="reviewed-date" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('REVIEWED DATE', @$_SESSION['systemLang']) ?></label>
                            <div class="col-sm-12 col-md-8">
                                <input type="date" class="form-control" id="repaired-date" name="repaired-date" placeholder="malfunction date" value="<?php echo $malrows['reviewed_date'] ?>" autocomplete="off" readonly/>
                            </div>
                        </div>
                        <?php } ?>
                        <?php if ($malrows['isReviewed'] != 0 && $malrows['mal_status'] == 0 && $_SESSION['isTech'] == 0) { ?> 
                            <div class="mb-sm-2 mb-md-3 row">
                                <span class="text-info" dir="<?php echo @$_SESSION['systemLang'] == 0 ? 'rtl' : 'ltr' ?>" style="text-align: <?php echo @$_SESSION['systemLang'] == 0 ? 'right' : 'left' ?>"><?php echo language('THAT IS NOT POSSIBLE TO REVIEW THE MALFUNCTION BERFORE REPAIR IT', @$_SESSION['systemLang']) ?></span>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <!-- slider for images -->
            <div class="my-3 row">
                <div class="mb-0 section-header">
                    <h5><?php echo language('MALFUNCTION MEDIA', @$_SESSION['systemLang']) ?></h5>
                    <hr />
                </div>
                <div class="mt-0 row row-cols-sm-1 row-cols-md-3 g-4">
                    <?php 
                        // get malfunction photos and videos
                        $malMedia = selectSpecificColumn("*", "`malfunctions_media`", "WHERE `mal_id` = ".$malrows['mal_id']);
                        // check teh result
                        if (!empty($malMedia) ) { ?>
                        <?php foreach ($malMedia as $key => $mal) { ?>
                            <div class="col-12">
                                <?php if ($mal['type'] == "img") { ?>
                                    <img src="<?php echo $uploads."//malfunctions/".$mal['media'] ?>" class="w-100 h-100" alt="<?php echo $mal['media'] ?>">
                                <?php } else { ?>
                                    <video class="w-100 h-100" controls autoplay muted>
                                        <source src="<?php echo $uploads."//malfunctions/".$mal['media'] ?>" type="video/mp4">
                                        <source src="<?php echo $uploads."//malfunctions/".$mal['media'] ?>" type="video/mov">
                                        <source src="<?php echo $uploads."//malfunctions/".$mal['media'] ?>" type="video/webm">
                                        <source src="<?php echo $uploads."//malfunctions/".$mal['media'] ?>" type="video/ogg">
                                        <?php echo language('YOUR BROWSER IS NOT SUPPORT THIS TYPE OF VIDEO', @$_SESSION['systemLang']) ?>
                                    </video>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    <?php } elseif (empty($malMedia) && $_SESSION['isTech'] == 1) { ?>
                        <!-- malfunction photo -->
                        <div class="col-12 w-100">
                            <div class="mb-sm-2 mb-md-3 row">
                                <label for="photo" class="col-sm-12 col-md-4 col-form-label text-capitalize btn btn-outline-primary">choose malfunction photo</label>
                                <div class="col-sm-12 col-md-8">
                                    <input type="file" class="form-control invisible" id="photo" name="mal-photos[]" placeholder="malfunction photo" onchange="showPreview(this)" multiple/>
                                </div>
                            </div>
                            <!-- show media -->
                            <div class="mt-3 row row-cols-sm-1 row-cols-md-2 row-cols-lg-3 g-3" id="showPreviewPhoto"></div>
                        </div>
                    <!-- box to preview the photos -->
                    <?php } elseif (empty($malMedia) && $_SESSION['isTech'] == 0) { ?>
                        <!-- malfunction photo -->
                        <div class="col-12 w-100">
                            <h4 class="h4 text-danger "><?php echo language("THERE IS NO MEDIA TO SHOW", @$_SESSION['systemLang']) ?></h4>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <!-- submit -->
            <div class="hstack gap-2">
                <div class="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'me-auto' : 'ms-auto' ?>">
                    <button type="submit" class="btn btn-primary text-capitalize form-control bg-gradient fs-12" id="update-malfunctions" <?php if ($_SESSION['mal_update'] == 0 && $malrows['isReviewed'] == 1) {echo 'disabled';} ?>>
                        <i class="bi bi-check-all"></i>&nbsp;<?php echo language('SAVE CHANGES', @$_SESSION['systemLang']) ?>
                    </button>
                </div>
                <div>
                    <button type="button" class="btn btn-outline-danger text-capitalize form-control bg-gradient fs-12" data-bs-toggle="modal" data-bs-target="#deleteMalModal" <?php if ($_SESSION['mal_delete'] == 0) {echo 'readonly';} ?> >
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
                            <h4 class="h4 text-danger " dir="<?php echo @$_SESSION['systemLang'] == "ar" ? "rtl" : "ltr"; ?>"><?php echo language("YOU DON`T HAVE THE PERMISSION TO DELETE THIS MALFUNCTION", @$_SESSION['systemLang']) ?></h4>
                        <?php } else { ?> 
                            <h4 class="h4 text-warning " dir="<?php echo @$_SESSION['systemLang'] == "ar" ? "rtl" : "ltr"; ?>"><?php echo language('ARE YOU SURE TO DELETE', @$_SESSION['systemLang'])." ".language('THE MALFUNCTION', @$_SESSION['systemLang'])." ".( @$_SESSION['systemLang'] == "ar" ? "؟" : "?" )?> </h4>
                        <?php } ?>
                    </div>
                    <div class="modal-footer">
                        <a href="?do=deleteMal&malid=<?php echo $malrows['mal_id'] ?>" class="btn btn-danger text-capitalize fs-12 <?php if ($_SESSION['mal_delete'] == 0) {echo 'disabled';} ?>" ><i class="bi bi-trash"></i>&nbsp;<?php echo language('DELETE', @$_SESSION['systemLang']) ?></a>
                        <button type="button" class="btn btn-secondary fs-12" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } else { 
    
    // include no data founded
    include_once $globmod . 'no-data-founded.php';

} ?>