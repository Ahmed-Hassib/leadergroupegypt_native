<!-- start edit profile page -->
<div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
    <!-- start header -->
    <header class="header">        
        <?php if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // get piece info from the form
            $id             = isset($_POST['piece-id'])   && !empty($_POST['piece-id'])   ? trim($_POST['piece-id'], ' ') : 0;
            $pieceName      = isset($_POST['piece-name']) && !empty($_POST['piece-name'])? trim($_POST['piece-name'], ' ') : '';
            $ip             = isset($_POST['ip'])         && !empty($_POST['ip'])        ? trim($_POST['ip'], ' ')         : '';
            $username       = isset($_POST['user-name'])  && !empty($_POST['user-name']) ? trim($_POST['user-name'], ' ')  : '';
            $password       = isset($_POST['password'])   && !empty($_POST['password'])  ? trim($_POST['password'], ' ')   : '';
            $directionid    = isset($_POST['direction'])  && !empty($_POST['direction']) ? trim($_POST['direction'], ' ')  : '';
            $typeid         = isset($_POST['type'])       && !empty($_POST['type'])      ? trim($_POST['type'], ' ')       : '';

            // get source id
            $sourceid       = isset($_POST['sourceid']) ? trim($_POST['sourceid'], ' ') : -1;
            $altsourceid    = isset($_POST['alt-sourceid']) ? trim($_POST['alt-sourceid'], ' ') : -1;

            $phone          = trim($_POST['phone-number'], ' ');
            $address        = trim($_POST['address'], ' ');
            $connType       = isset($_POST['conn-type'])  && !empty($_POST['conn-type']) ? trim($_POST['conn-type'], ' ')  : -1;
            $direct         = isset($_POST['direct'])     && !empty($_POST['direct'])    ? trim($_POST['direct'], ' ')     : '';
            $notes          = empty(trim($_POST['notes'], ' ')) ? 'لا توجد ملاحظات' : trim($_POST['notes'], ' ');
            $ssid           = trim($_POST['ssid'], ' ');
            $passConn       = trim($_POST['password-connection'], ' ');
            $frequency      = trim($_POST['frequency'], ' ');
            $deviceType     = trim($_POST['device-type'], ' ');
            $macAdd         = trim($_POST['mac-add'], ' ');
            
            $validIP    = !empty($ip) ? preg_match('/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\z/', $ip) : 1;
            $validMac   = !empty($macAdd) ? preg_match('/^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$/', $macAdd) : 1;

            // validate the form
            $formErorr = []; // error array

            // validate piece id
            if (empty($id) || $id <= 0) {
                $formErorr[] = 'piece id cannot be <strong>empty</strong>';
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
            if (empty($password)) {
                $formErorr[] = 'password cannot be <strong>empty.</strong>';
            }
            // validate direction
            if (empty($directionid) || $directionid == 0) {
                $formErorr[] = 'direction cannot be <strong>empty.</strong>';
            }
            // validate type
            if ((empty($typeid) || $typeid == 0) && $is_client = 0) {
                $formErorr[] = 'type cannot be <strong>empty.</strong>';
            }
            // validate source ip
            if (empty($sourceid) || $sourceid < 0) {
                $formErorr[] = 'source <span class="text-uppercase">ip</span> cannot be <strong>empty.</strong>';
            }
            
            // validate connection type
            // if (empty($connType) || $connType < 0) {
            //     $formErorr[] = 'connection type cannot be <strong>empty.</strong>';
            // }

            // 
            if (!$validIP) {
                $formErorr[] = language('THIS IS NOT A VALID IP', @$_SESSION['systemLang']);
            }

            if (!$validMac) {
                $formErorr[] = language('THIS IS NOT A VALID MAC ADD', @$_SESSION['systemLang']);
            }

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
            
            // create an object of Piece class
            $pcs_obj = new Pieces();

            // check if empty form error
            if (empty($formErorr)) { 
                // check if piece or client name is exist or not 
                if ($pcs_obj->is_exist('`piece_id`', '`pieces`', $id)) {
                    // prepare query
                    // UPDATE QUERY STATEMENTS ..
                    $update_query  = "UPDATE `pieces` SET `pieces`.`piece_ip` = '$ip', `pieces`.`piece_pass` = '$password', `pieces`.`piece_name` = '$pieceName', `pieces`.`conn_type`='$connType', `pieces`.`direct`='$direct', `pieces`.`source_id`='$sourceid', `pieces`.`alt_source_id`='$altsourceid', `pieces`.`username`='$username', `pieces`.`type_id`='$typeid', `pieces`.`direction_id`='$directionid', `pieces`.`mac_add`='$macAdd', `pieces`.`notes` = '$notes', `ssid` = '$ssid', `pass_connection` = '$passConn', `frequency` = '$frequency', `device_type` = '$deviceType'  WHERE `pieces`.`piece_id` = '$id';";

                    // check if this piece has address or not
                    if ($pcs_obj->is_exist('piece_id', 'pieces_addr', $id)) {
                        $update_query .= "UPDATE `pieces_addr` SET `pieces_addr`.`address` = '$address' WHERE `pieces_addr`.`piece_id` = '$id';";
                    } else {
                        $update_query .= "INSERT INTO `pieces_addr` VALUES ('$id', '$address');";
                    }

                    // check if this piece has phone or not
                    if ($pcs_obj->is_exist('piece_id', 'pieces_phone', $id)) {
                        $update_query .= "UPDATE `pieces_phone` SET `pieces_phone`.`phone` = '$phone' WHERE `pieces_phone`.`piece_id` = '$id';";
                    } else {
                        $update_query .= "INSERT INTO `pieces_phone` VALUES ('$id', '$phone');";
                    }

                    //  check if this piece is added in the pieces_additional
                    if ($pcs_obj->is_exist("`piece_id`", "`pieces_additional`", $id)) {
                        $update_query .= "UPDATE `pieces_additional` SET `ssid` = '$ssid', `pass_connection` = '$passConn', `frequency` = '$frequency', `device_type` = '$deviceType' WHERE `piece_id` = '$id';";
                    } else {
                        $update_query .= "INSERT INTO `pieces_additional` (`piece_id`, `ssid`, `pass_connection`, `frequency`, `device_type` ) VALUES ('$id', '$ssid', '$passConn', '$frequency', '$deviceType');";
                    }

                    // prepare the query of the children
                    $update_query .= updateChildDirection($id, $directionid);

                    // update the database with this info
                    $stmt = $con->prepare($update_query);
                    $stmt->execute();
                    // log message
                    $logMsg = "Update piece or client info with name `$pieceName`";
                    createLogs($_SESSION['UserName'], $logMsg);
                    // echo success message
                    $msg = '<div class="alert alert-success text-capitalize"><i class="bi bi-check-circle-fill"></i>&nbsp;'.language("PIECE/CLIENT UPDATED SUCCESSFULLY", @$_SESSION['systemLang']).'</div>';
                    // redirect to home page
                    redirectHome($msg, 'back');
                } else {
                    // include no data founded module
                    include_once $globmod . 'no-data-founded.php';
                }
            } else {
                // redirect to home page
                redirectHome("", 'back');
            }
        } else {
            // include permission error module
            include_once $globmod . 'permission-error.php';
        } ?>
    </header>
</div>