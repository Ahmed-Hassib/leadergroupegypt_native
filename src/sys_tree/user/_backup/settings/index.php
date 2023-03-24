<?php
// start output buffering
ob_start();
// start session
session_start();
// regenerate session id
session_regenerate_id();
// title page
$page_title = "Settings";
// level
$level = 5;
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
        // include dashboard
        include_once "dashboard.php";

    } elseif ($query == "restoreBackup" && $_SESSION['restore_backup'] == 1) { 
        // get backup id
        $backupFileInfo = isset($_FILES['backup']) ? $_FILES['backup'] : 0;
        // include restore nackup
        include_once "restore-backup.php";
        
    } elseif ($query == "renewLicense" && $_SESSION['isRoot'] == 1) { ?>
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
                                $q .= "INSERT INTO `license` (`type`, `start_date`, `expire_date`) VALUES (?, CURRENT_DATE(), ?);";
                                
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
        // include page not founded module
        include_once $globmod . 'page-error';
    }
} else { 
    // include permission error module
    include_once $globmod . 'permission-error';
}

include_once $tpl . "footer.php"; 
include_once $tpl . "js-includes.php";
ob_end_flush();
?>