<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') { ?>
    <!-- start edit profile page -->
    <div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
        <!-- start header -->
        <header class="header">
            <?php
            // get piece info from the form
            $id         = isset($_POST['next-id'])    && !empty($_POST['next-id'])   ? trim($_POST['next-id'], ' ')    : '';
            $pieceName  = isset($_POST['piece-name']) && !empty($_POST['piece-name'])? trim($_POST['piece-name'], ' ') : '';
            $ip         = isset($_POST['ip'])         && !empty($_POST['ip'])        ? trim($_POST['ip'], ' ')         : '';
            $username   = isset($_POST['user-name'])  && !empty($_POST['user-name']) ? trim($_POST['user-name'], ' ')  : '';
            $pass       = isset($_POST['password'])   && !empty($_POST['password'])  ? trim($_POST['password'], ' ')   : '';
            $dirid      = isset($_POST['direction'])  && !empty($_POST['direction']) ? trim($_POST['direction'], ' ')  : '';
            $typeid     = isset($_POST['type'])       && !empty($_POST['type'])      ? trim($_POST['type'], ' ')       : 0;
            $isClient   = trim($_POST['is-client']);
            
            // get source id
            $sourceid    = isset($_POST['sourceid']) ? trim($_POST['sourceid'], ' ')   : -1;
            $altsourceid = isset($_POST['alt-sourceid']) ? trim($_POST['alt-sourceid'], ' ')   : -1;

            $phone      = trim($_POST['phone-number'], ' ');
            $address    = trim($_POST['address'], ' ');
            $connType   = isset($_POST['conn-type'])  && !empty($_POST['conn-type']) ? trim($_POST['conn-type'], ' ')  : '';
            $direct     = isset($_POST['direct'])     && !empty($_POST['direct'])    ? trim($_POST['direct'], ' ')     : '';
            $notes      = empty(trim($_POST['notes'], ' ')) ? 'لا توجد ملاحظات' : trim($_POST['notes'], ' ');
            $ssid       = trim($_POST['ssid'], ' ');
            $passConn   = trim($_POST['password-connection'], ' ');
            $frequency  = trim($_POST['frequency'], ' ');
            $devType    = trim($_POST['device-type'], ' ');
            $macAdd     = trim($_POST['mac-add'], ' ');

            // validate the form
            $formErorr = []; // error array

            // validate piece id
            if (empty($id)) {
                $formErorr[] = 'piece name cannot be less than <strong>4 characters.</strong>';
            }

            // validate piece name
            if (empty($pieceName)) {
                $formErorr[] = 'piece name cannot be <strong>empty</strong>';
            }
            // validate ip
            if (empty($ip)) {
                $formErorr[] = '<span class="text-uppercase">IP</span> cannot be <strong>empty.</strong>';
            }
            // validate username
            if (empty($username)) {
                $formErorr[] = 'username cannot be <strong>empty.</strong>';
            }
            // validate password
            if (empty($pass)) {
                $formErorr[] = 'password cannot be <strong>empty.</strong>';
            }
            // validate direction
            if (empty($dirid) || $dirid == 0) {
                $formErorr[] = 'direction cannot be <strong>empty.</strong>';
            }
            // validate source ip
            if ($sourceid < 0) {
                $formErorr[] = 'source <span class="text-uppercase">ip</span> cannot be <strong>empty.</strong>';
            }

            // // validate connection type
            // if (empty($connType) || $connType < 0) {
            //     $formErorr[] = 'connection type cannot be <strong>empty.</strong>';
            // }

            // loop on form error array
            foreach ($formErorr as $error) {
                echo '<div class="alert alert-danger text-capitalize w-50 mx-auto align-left">' . $error . '</div>';
            }

            if ($sourceid == $id) {
                $sourceid = 0;
            }

            if ($altsourceid == $id) {
                $altsourceid = 0;
            }

            // check if empty form error
            if (empty($formErorr)) {
                // create an object of Pieces class
                $pcs_obj = new Pieces();
                // check if user is exist in database or not
                $checkPcs       = $pcs_obj->is_exist("`piece_name`", "`pieces`", $pieceName);
                $checkMacAdd    = !empty($macAdd) ? $pcs_obj->is_exist("`mac_add`", "`pieces`", $macAdd) : 0;
                $checkIPAdd     = $ip == '0.0.0.0' ? 0 : $pcs_obj->count_records("`piece_id`", "`pieces`", "WHERE `piece_ip` = '$ip' AND `direction_id` = $dirid");
                // check piece name
                if ($checkPcs > 0) {
                    // show erroe message
                    $msg = '<div class="alert alert-warning text-capitalize"><i class="bi bi-exclamation-triangle-fill"></i>&nbsp;'.language('THIS USERNAME IS ALREADY EXIST', @$_SESSION['systemLang']).'</div>';
                } elseif ($checkMacAdd > 0) {
                    $msg = '<div class="alert alert-warning text-capitalize"><i class="bi bi-exclamation-triangle-fill"></i>&nbsp;'.language('THIS MAC ADD IS ALREADY EXIST', @$_SESSION['systemLang']).'</div>';
                } elseif ($checkIPAdd > 0) {
                    $msg = '<div class="alert alert-warning text-capitalize"><i class="bi bi-exclamation-triangle-fill"></i>&nbsp;'.language('THIS IP ADD IS ALREADY EXIST', @$_SESSION['systemLang']).'</div>';
                } else {
                    // create an array of piece info
                    $pcs_info = array();
                    // push piece info into an array
                    array_push($pcs_info, $id, $pieceName, $macAdd, $ip, $username, $pass, $dirid, $sourceid, $altsourceid, $typeid, $direct, $connType, $_SESSION['UserID'], $notes, $ssid, $passConn, $frequency, $devType, $_SESSION['company_id'], $isClient, $id, $address, $id, $phone, $id, $ssid, $passConn, $frequency, $devType);
                    // call insert function
                    $is_inserted = $pcs_obj->inser_new_piece($pcs_info);

                    // check if piece/client is inserted
                    if ($is_inserted == true) {
                        // log message
                        $logMsg = "Added a new piece or client with name " . $pieceName . "..";
                        createLogs($_SESSION['UserName'], $logMsg);
                        // echo success message
                        $msg = '<div class="alert alert-success text-capitalize" dir="' . (@$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr') . '"><i class="bi bi-check-circle-fill"></i>&nbsp;' . language('PIECE/CLIENT ADDED SUCCESSFULLY', @$_SESSION['systemLang']) . '</div>';
                    } else {
                        // echo success message
                        $msg = '<div class="alert alert-danger text-capitalize" dir="' . (@$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr') . '"><i class="bi bi-check-circle-fill"></i>&nbsp;' . language('A PROPLEM HAS BEEN HAPPEND WHILE INSERTING A PIECE/CLIENT', @$_SESSION['systemLang']) . '</div>';
                    }
                }
                // redirect to add new user
                redirectHome($msg, 'back');
            } else {
        ?>
                <div class="my-3">
                    <a class="btn btn-outline-primary text-capitalize" href="?do=addPiece">return back</a>
                </div>
        <?php } ?>
    </header>
</div>
<?php } else {
    // include permission error module
    include_once $globmod . 'permission-error.php';
} ?>