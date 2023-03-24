<!-- start home stats container -->
<div class="container ">
    <!-- start header -->
    <div class="mb-3 header">
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