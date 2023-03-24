<?php
// start output buffering
ob_start();
// start session
session_start();
// regenerate session id
session_regenerate_id();
// title page
$page_title = "Settings";
// is admin == true
$is_admin = true;
// page category
$page_category = "sys_tree";
// page role
$page_role = "sys_tree_root";
// folder name of dependendies
$dependencies_folder = "sys_tree/";
// level
$level = 4;
// nav level
$nav_level = 1;
// initial configration of system
include_once str_repeat("../", $level) . "etc/init.php";
// check username in SESSION variable
if (isset($_SESSION['UserName']))  {

    // start dashboard page
    // check if Get request do is set or not
    $query = isset($_GET['do']) ? $_GET['do'] : 'manage';
    // start manage page
    if ($query == 'manage') {
?>
    <!-- start home stats container -->
    <div class="container"  >
        <!-- start header -->
        <div class="mb-3 header">
            <h1 class="h1 text-capitalize"><?php echo language('SETTINGS', @$_SESSION['systemLang']) ?></h1>
            <!-- <?php print_r($_SESSION) ?> -->
        </div>
        <!-- end header -->
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
                                default:
                                    $type = language('TRIAL', @$_SESSION['systemLang']);
                            }
                        ?>
                            <p>
                                <span class="text-capitalize"><?php echo language('COMPANY NAME', @$_SESSION['systemLang']) . ": " . $_SESSION['company_name'] ?></span><br>
                                <span class="text-capitalize"><?php echo language('APP VERSION', @$_SESSION['systemLang']) . ": " . $curr_version ?></span><br>
                                <span class="text-capitalize"><?php echo language('TYPE OF LICENSE', @$_SESSION['systemLang']) . ": " . $type ?></span><br>
                                <span class="text-capitalize"><?php echo language('LICENSE EXPIRY DATE', @$_SESSION['systemLang']) . ": " . $row['expire_date'] ?></span><br>
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
                                            <button type="button" id="renewLicenseBtn" data-bs-toggle="modal" data-bs-target="#warningMsg" class='my-1 me-1 btn btn-success text-capitalize fs-12 <?php if ($_SESSION['isRoot'] == 0) {echo 'disabled';} ?>'><i class='bi bi-arrow-clockwise me-1'></i>&nbsp;<?php echo language('RENEW LICENSE', @$_SESSION['systemLang']) ?></button>
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
                                                <button type="button" class="btn-close ms-0 fs12" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <h5 class="h5" <?php echo @$_SESSION['systemLang'] == "ar" ? "dir=rtl" : ""; ?>><?php echo language('PLEASE, REENTER THE OWNER OF SYSTEM PASSWORD', @$_SESSION['systemLang']) ?> </h5>
                                                <div class="mb-3 position-relative">
                                                    <input type="password" form="renewLicenseForm" class="form-control" id="password" name="pass" placeholder="Password" dir="ltr" required>
                                                    <i class="bi bi-eye-slash show-pass text-dark" id="show-pass" onclick="showPass(this)"></i>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary fs-12" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" form="renewLicenseForm" class="btn btn-success text-capitalize fs-12 <?php if ($_SESSION['isRoot'] == 0) {echo 'disabled';} ?>"><i class="bi bi-check-all"></i>&nbsp;<?php echo language('CONFIRM', @$_SESSION['systemLang']) ?></button>
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
                                                <button type="button" class="btn-close ms-0 fs-12" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <h5 class="h5 text-danger " <?php echo @$_SESSION['systemLang'] == "ar" ? "dir=rtl" : ""; ?>><?php echo language('YOU MUST SELECT NEW LICENSE TYPE', @$_SESSION['systemLang']) ?> </h5>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary fs-12" data-bs-dismiss="modal">Close</button>
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
                    <form action="requests.php?do=changeLang" method="POST">
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
                                <!-- <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="language" id="languageEn" value="1" <?php echo @$_SESSION['systemLang'] == "en" ? "checked" : "" ?>>
                                    <label class="form-check-label text-capitalize" for="languageEn">
                                        <?php echo language('ENGLISH', @$_SESSION['systemLang']) ?>
                                    </label>
                                </div> -->
                            </div>
                        </div>
                        <!-- end language field -->
                        <!-- strat submit -->
                        <div class="hstack gap-3">
                            <button type="submit" class="me-auto btn btn-primary text-capitalize fs-12"><i class="bi bi-check-all me-1"></i>&nbsp;<?php echo language('SAVE CHANGES', @$_SESSION['systemLang']) ?></button>
                        </div>
                        <!-- end submit -->
                    </form>
                </div>
            </div>

            <?php if ($_SESSION['restore_backup'] == 1 && $_SESSION['isLicenseExpired'] == 0) { ?>
            <!-- restore tha backups -->
            <div class="col-12">
                <div class="section-block">
                    <!-- section header -->
                    <div class="section-header" >
                        <h5 class="text-capitalize "><?php echo language('RESTORE BACKUP', @$_SESSION['systemLang']) ?></h5>
                        <hr />
                    </div>
                    <!-- backup form -->
                    <form action="settings.php?do=restoreBackup" method="POST" enctype="multipart/form-data">
                        <!-- strat backup field -->
                        <div class="mb-3 row">
                            <label for="backup" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('CHOOSE BACKUP', @$_SESSION['systemLang']) ?></label>
                            <div class="col-sm-12 col-md-8">
                                <input type="file" name="backup" id="backup">
                            </div>
                        </div>
                        <!-- end backup field -->
                        <!-- strat submit -->
                        <div class="hstack gap-3">
                            <button type="submit" class="me-auto btn btn-primary text-capitalize fs-12"><i class="bi bi-upload me-1"></i>&nbsp;<?php echo language('RESTORE', @$_SESSION['systemLang']) ?></button>
                        </div>
                        <!-- end submit -->
                    </form>
                </div>
            </div>
            <?php } ?>
            
            <?php if ($_SESSION['restore_backup'] == 1) { ?>
            <!-- backup duration -->
            <div class="col-12">
                <div class="section-block">
                    <!-- section header -->
                    <div class="section-header" >
                        <h5 class="text-capitalize "><?php echo language('BACKUP MANAGEMENT', @$_SESSION['systemLang']) ?></h5>
                        <hr />
                    </div>
                    <!-- backup form -->
                    <form action="requests.php?do=updateBackupInfo" method="POST" name="backup_duration_form">
                        <!-- strat backup field -->
                        <div class="mb-2 row">
                            <label for="backup_duration" class="col-sm-12 col-md-6 col-form-label text-capitalize"><?php echo language('CHOOSE DURATION', @$_SESSION['systemLang']) ?></label>
                            <div class="col-sm-12 col-md-6">
                                <select class="form-select" name="backup_duration" id="backup_duration" required>
                                    <option value="default" selected disabled><?php echo language('CHOOSE DURATION', @$_SESSION['systemLang']) ?></option>
                                    <option value="1" <?php echo $_SESSION['backup_duration'] == 1 ? 'selected' : '' ?>><?php echo language('HALF AN HOUR', @$_SESSION['systemLang']) ?></option>
                                    <option value="2" <?php echo $_SESSION['backup_duration'] == 2 ? 'selected' : '' ?>><?php echo language('HOUR', @$_SESSION['systemLang']) ?></option>
                                    <option value="3" <?php echo $_SESSION['backup_duration'] == 3 ? 'selected' : '' ?>><?php echo language('6 HOURS', @$_SESSION['systemLang']) ?></option>
                                </select>
                            </div>
                        </div>
                        <!-- end backup field -->
                        <!-- start last backup time -->
                        <div class="mb-2 row">
                            <label for="last_backup_time" class="col-sm-12 col-md-6 col-fom-label text-capitalize"><?php echo language('LAST BACKUP TIME', @$_SESSION['systemLang']) ?></label>
                            <div class="col-sm-12 col-md-6">
                                <input type="time" class="form-control" name="last_backup_time" id="last_backup_time" value="<?php echo $_SESSION['last_backup_time'] ?>" disabled>
                            </div>
                        </div>
                        <!-- end last backup time -->
                        <!-- start next backup time -->
                        <div class="mb-2 row">
                            <label for="next_backup_time" class="col-sm-12 col-md-6 col-fom-label text-capitalize"><?php echo language('NEXT BACKUP TIME', @$_SESSION['systemLang']) ?></label>
                            <div class="col-sm-12 col-md-6">
                                <input type="time" class="form-control" name="next_backup_time" id="next_backup_time" value="<?php echo $_SESSION['next_backup_time'] ?>" disabled>
                            </div>
                        </div>
                        <!-- end next backup time -->
                        <!-- strat submit -->
                        <div class="hstack gap-3">
                            <button type="submit" class="me-auto btn btn-primary text-capitalize fs-12"><i class="bi bi-check-all me-1"></i>&nbsp;<?php echo language('SAVE CHANGES', @$_SESSION['systemLang']) ?></button>
                        </div>
                        <!-- end submit -->
                    </form>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>

    <?php } elseif ($query == "restoreBackup" && $_SESSION['restore_backup'] == 1) { 
        // get backup id
        $backupFileInfo = isset($_FILES['backup']) ? $_FILES['backup'] : 0;
    ?>
        <!-- start home stats container -->
        <div class="container ">
            <!-- start header -->
            <div class="mb-3 header">
                <h1 class="h1 text-capitalize"><?php echo language('SETTINGS', @$_SESSION['systemLang']) ?></h1>
                <h4 class="h4 text-info "><?php echo language('RESTORE BACKUP', @$_SESSION['systemLang']) ?></h4>
                <?php 

                    // // print_r($backupFileInfo);
                    // // backup dir
                    // $backupFilePath = $_SERVER['DOCUMENT_ROOT'] . "/jsl-network/data/backups/".$backupFileName;
                    // flag
                    $flag = '';
                    // check if the file path is exest..
                    if (file_exists($backupFileInfo['tmp_name'])) {
                        // call restoreBackup function
                        $flag = restoreBackup($backupFileInfo['tmp_name']);

                        // check the flag
                        if ($flag == true) {
                            // success message
                            $msg = '<div class="alert alert-success text-capitalize"><i class="bi bi-check-circle-fill"></i>&nbsp;' . language("BACKUP RESTORED SUCCESSFULY", @$_SESSION['systemLang']) . '</div>';
                        } else {
                            // error message
                            $msg = '<div class="alert alert-danger text-capitalize"><i class="bi bi-exclamation-triangle-fill"></i>&nbsp;' . language("FAILED TO RESTORE BACKUP", @$_SESSION['systemLang']) . '</div>';
                            $msg .= '<div class="alert alert-danger text-capitalize"><i class="bi bi-exclamation-triangle-fill"></i>&nbsp;' . $flag . '</div>';
                        }
                        // redirect to home page
                        redirectHome($msg, 'backup');
                    } else {
                        // error message
                        $msg = '<div class="alert alert-danger text-capitalize"><i class="bi bi-exclamation-triangle-fill"></i>&nbsp;' . language("FAILED TO RESTORE BACKUP", @$_SESSION['systemLang']) . '</div>';
                        // redirect to home page
                        redirectHome($msg, 'backup');
                    }
                ?>
            </div>
        </div>
    <?php } elseif ($query == "renewLicense" && $_SESSION['isRoot'] == 1) { ?>
        <!-- start home stats container -->
        <div class="container ">
            <!-- start header -->
            <div class="mb-3 header">
                <h1 class="h1 text-capitalize"><?php echo language('SETTINGS', @$_SESSION['systemLang']) ?></h1>
                <h4 class="h4 text-info "><?php echo language('RENEW LICENSE', @$_SESSION['systemLang']) ?></h4>
                <?php
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        if (isset($_POST['pass']) || isset($_POST['license'])) {
                            $pass = sha1($_POST['pass']);
                            $licenseType = intval($_POST['license']);
                            // get root password
                            $rootPass = selectSpecificColumn("`Pass`", "`users`", "WHERE `UserID` = 1")[0]['Pass'];
                            // check if the same password
                            if ($pass == $rootPass) {
                                switch ($licenseType) {
                                    case 1:
                                        $months = 1;
                                        break;
                                    case 2:
                                        $months = 3;
                                        break;
                                    case 3:
                                        $months = 6;
                                        break;
                                    case 4:
                                        $months = 12;
                                        break;
                                }
                                // date of today
                                $today = Date("Y-m-d");
                                // license period
                                $period = ' + ' . $months . ' months';
                                $expireDate = Date("Y-m-d", strtotime($today. $period));

                                // update the previous license
                                $q = "UPDATE `license` SET `isEnded` = 1 WHERE `ID` = ?;";
                                $q .= "INSERT INTO `license` (`type`, `expire_date`) VALUES (?, ?);";
                                
                                // update the database with this info
                                $stmt = $con->prepare($q);
                                $stmt->execute(array($_SESSION['licenseID'], $licenseType, $expireDate));
                                
                                // success message
                                $msg = '<div class="alert alert-success text-capitalize fw-bolder">' . language("LICENSE UPDATED SUCCESSFULLY", @$_SESSION['systemLang']) . '</div>';
                                // redirect to home page
                                redirectHome($msg, 'back');
                            }else {
                                // error message
                                $msg = '<div class="alert alert-danger text-capitalize fw-bolder">' . language("SORRY, USERNAME OR PASSWORD IS WRONG PLEASE TRY LATER", @$_SESSION['systemLang']) . '</div>';
                                $msg .= '<div class="alert alert-danger text-capitalize fw-bolder">' . language("YOU CANNOT ACCESS THIS PAGE DIRECTLY", @$_SESSION['systemLang']) . '</div>';
                                // redirect to home page
                                redirectHome($msg, 'back', 5);
                            }
                        } else {
                            // error message
                            $msg = '<div class="alert alert-danger text-capitalize"><i class="bi bi-exclamation-triangle-fill"></i>&nbsp;' . language("YOU CANNOT ACCESS THIS PAGE DIRECTLY", @$_SESSION['systemLang']) . '</div>';
                            // redirect to home page
                            redirectHome($msg, 'back');
                        }
                    } else {
                        // error message
                        $msg = '<div class="alert alert-danger text-capitalize"><i class="bi bi-exclamation-triangle-fill"></i>&nbsp;' . language("YOU CANNOT ACCESS THIS PAGE DIRECTLY", @$_SESSION['systemLang']) . '</div>';
                        // redirect to home page
                        redirectHome($msg);
                    }
                ?>
            </div>
        </div>

    <?php } else {
        // include page not found module
        include $globmod . "page-error.php";
    }
} else { 
    // include permission error module
    include_once $globmod . "permission-error.php";
}
include_once $tpl . "footer.php"; 
include_once $tpl . "js-includes.php";
ob_end_flush();
?>