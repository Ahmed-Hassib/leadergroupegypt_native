<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') { ?>
    <!-- start edit profile page -->
    <div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
        <div class="text-center">

        <?php
            $updateOwner    = $_SESSION['isTech'];  // the owner of the update
            $malID          = $_POST['mal-id'];
            // check if malfunction is exist or not
            $checkMal = checkItem("`mal_id`", "`malfunctions`", $malID);
            
            if ($checkMal > 0) {
                // check if the technical changed for this mal or not
                $mal = selectSpecificColumn("`isReviewed`, `mal_status`", "`malfunctions`", "WHERE `mal_id` = ".$malID);
                $isRepairedMal = $mal[0]['mal_status'];
                $isReviewedMal = $mal[0]['isReviewed'];
                
                // check
                if ($isReviewedMal != 1 || $isRepairedMal != 1) {    
                    // validate the form
                    $formErorr = array();   // error array 
                    // check the type of the owner of the update
                    if ($updateOwner == 0) {
                        // print_r($_POST);
                        // for normal employees
                        $techID    = $_POST['technical-id'];
                        // check if the technical changed for this mal or not
                        $malInfo = selectSpecificColumn("`tech_id`", "`malfunctions`", "WHERE `mal_id` = ".$malID);
                        $oldTechID = $malInfo[0]['tech_id'];
                        
                        // if technical man changed
                        if ($techID != $oldTechID) {
                            // update some info of this malfunction 
                            $stmt = $con->prepare("UPDATE `malfunctions` SET `tech_id` = ?, `added_date` = CURRENT_DATE, `added_time` = CURRENT_TIME, `mal_status` = 0, `cost` = 0, `repaired_date` = '0000-00-00', `repaired_time` = '00:00:00', `isShowed` = 0, `showed_date` = '0000-00-00', `showed_time` = '00:00:00', `isAccepted` = -1,  `isReviewed` = 0, `reviewed_date` = '0000-00-00', `reviewed_time` = '00:00:00', `money_review` = 0, `qty_service` = 0, `qty_emp` = 0, `qty_comment` = ''  WHERE `mal_id` = ?");
                            $stmt->execute(array($techID, $malID));
                        }
                        
                        // if the malfunction is not reviewed
                        if ($isReviewedMal == 0 && $isRepairedMal) {
                            $technicalQty   = $_POST['technical-qty'];
                            $serviceQty     = $_POST['service-qty'];
                            $moneyReview    = $_POST['money-review'];
                            $reviewComment  = $_POST['review-comment'];
                            // check review 
                            $isReviewed = $technicalQty && $serviceQty && $moneyReview ? 1 : 0;
                            $reviewComment = $technicalQty && $serviceQty && $moneyReview ? $_POST['review-comment'] : "";
                            // update the database with this info
                            $stmt = $con->prepare("UPDATE `malfunctions` SET `isReviewed` = ?, `reviewed_date` = CURRENT_DATE, `reviewed_time` = CURRENT_TIME, `money_review` = ?, `qty_service` = ?, `qty_emp` = ?, `qty_comment` = ?  WHERE `mal_id` = ?");
                            $stmt->execute(array($isReviewed, $moneyReview, $serviceQty, $technicalQty, $reviewComment, $malID));
                        } else {
                            $descreption = $_POST['descreption'];
                            // update the database with this info
                            $stmt = $con->prepare("UPDATE `malfunctions` SET `descreption` = ?  WHERE `mal_id` = ?");
                            $stmt->execute(array($descreption , $malID));
                        }

                    } else {
                        /** 
                         * get the old values from malfunction table of
                         *  [1] technical comment
                         *  [2] malfunction cost
                         *  [3] malfunction status 
                         *  [4] technical status
                         * and get if this mal have a media or not
                         */ 
                        $oldValues = selectSpecificColumn("`tech_comment`, `mal_status`, `cost`, `isAccepted`", "`malfunctions`", "WHERE `mal_id` = ".$malID)[0];
                        $haveMedia = countRecords("`mal_id`", "`malfunctions_media`", "WHERE `mal_id` = ".$malID);
                        
                        // print_r($oldValues);
                        
                        // for technical employees
                        $techComment    = isset($_POST['comment'])      ? $_POST['comment']     : $oldValues['tech_comment'];
                        $cost           = isset($_POST['cost'])         ? $_POST['cost']        : $oldValues['cost'];
                        $malStatus      = isset($_POST['mal-status'])   ? $_POST['mal-status']  : $oldValues['mal_status'];

                        if ($malStatus == 1) {
                            $techStatus = 1;
                        } else {
                            $techStatus = isset($_POST['tech-status'])  ? $_POST['tech-status'] : $oldValues['isAccepted'];
                        }

                        $query = "";
                        
                        if ($techComment == $oldValues['tech_comment'] && $cost == $oldValues['cost'] && $malStatus == $oldValues['mal_status'] && $techStatus == $oldValues['isAccepted']) {
                            // for normal employees
                            $techID    = $_POST['technical-id'];
                            // check if the technical changed for this mal or not
                            $malInfo = selectSpecificColumn("`tech_id`", "`malfunctions`", "WHERE `mal_id` = ".$malID);
                            $oldTechID = $malInfo[0]['tech_id'];
                            
                            // if technical man changed
                            if ($oldTechID != $techID) {
                                // update some info of this malfunction 
                                $stmt = $con->prepare("UPDATE `malfunctions` SET `tech_id` = ?, `added_date` = CURRENT_DATE, `added_time` = CURRENT_TIME, `mal_status` = 0, `cost` = 0, `repaired_date` = '0000-00-00', `repaired_time` = '00:00:00', `isShowed` = 0, `showed_date` = '0000-00-00', `showed_time` = '00:00:00', `isAccepted` = -1,  `isReviewed` = 0, `reviewed_date` = '0000-00-00', `reviewed_time` = '00:00:00', `money_review` = 0, `qty_service` = 0, `qty_emp` = 0, `qty_comment` = ''  WHERE `mal_id` = ?");
                                $stmt->execute(array($techID, $malID));
                            }
                        } 
                        
                        // get mal photo
                        $photoInfo  = !empty($_FILES['mal-photos']) ? $_FILES['mal-photos'] : array();
                        // check if photos/videos are upladed or not
                        $isUploaded = count($photoInfo['name']) > 1 && !empty($photoInfo['name'][1]) ? true : false;
                        // check if photos/videos are uploaded or not
                        if ($isUploaded) {

                            // get photo info
                            $photoName  = $photoInfo['name'];
                            $photoType  = $photoInfo['type'];
                            $photoTmp   = $photoInfo['tmp_name'];
                            $photoError = $photoInfo['error'];
                            $photoSize  = $photoInfo['size'];
                        
                            // allowed photos extensions
                            $allowedExtensions  = array("jpg", "jpeg", "png", "gif", "mp4", "mov", "wmv", "flv");
                            $imageTypes         = array("jpg", "jpeg", "png", "gif");
                            $videoTypes         = array("mp4", "mov", "wmv", "flv");

                            
                            // get photo extension
                            foreach ($photoName as $key => $value) {
                                # code...
                                $arrName = explode('.', $value);
                                $photoExtension = strtolower(end($arrName));
                                // check the photo name and extension
                                if (!empty($value)) {
                                    // check if photo extension in allowed extension or not
                                    if (!in_array($photoExtension, $allowedExtensions)) {
                                        $formErorr[] = 'the extension of photo number ' . ($key + 1) . ' is <strong>not allowed</strong>';
                                    }
                                }
                            }
                                
                            // validate malID
                            if (empty($malID)) {
                                $formErorr[] = 'malfunction ID cannot be <strong>empty.</strong>';
                            }
                                    
                            // loop on form error array
                            foreach ($formErorr as $error) {
                                echo '<div class="alert alert-danger text-capitalize w-50 mx-auto align-left">' . $error . '</div>';
                            }

                            // check if empty form error
                            if (empty($formErorr)) {
                                // values of photos to insert
                                $updatePhoto = "";
                                // check photo array
                                if ($isUploaded) {
                                    // loop on photos
                                    foreach ($photoName as $key => $photo) {
                                        # code...
                                        $arrName = explode('.', $photo);
                                        $photoExtension = strtolower(end($arrName));
                                        // add the date of day and malfunction id to the photo name
                                        $phName = strtoupper($photoExtension) . "_". Date('Ymd') . "_" . $malID . "_" . rand() . "." . $photoExtension;
                                        // move photo into upload directory
                                        move_uploaded_file($photoTmp[$key], $uploads."//malfunctions//".$phName);
                                        // check the uploaded type
                                        $type = in_array($photoExtension, $imageTypes) ? "img" : "video";
                                        // append photos values
                                        $updatePhoto .= "(".$malID.", '".$phName."', '".$type."')";
                                        // if not last photo add ',' at the end of the values query
                                        $updatePhoto .= ($key + 1) == count($photoName) ? "" : ", ";
                                    }
                                    // 
                                    $query .= "INSERT INTO `malfunctions_media` (`mal_id`, `media`,`type`) VALUES " . $updatePhoto . ";";
                                }
                            }
                        }
                        // query to update the malfunction
                        $query .= "UPDATE `malfunctions` SET `mal_status` = ?, `isAccepted` = ?, `cost` = ?, `repaired_date` = CURRENT_DATE, `repaired_time` = CURRENT_TIME, `tech_comment` = ? WHERE `mal_id` = ?;";
                        
                        // update the database with this info
                        $stmt = $con->prepare($query);
                        $stmt->execute(array($malStatus, $techStatus, $cost, $techComment, $malID));
                        // log message
                        $logMsg = "Malfunction dept: malfunction updated successfully";
                        createLogs($_SESSION['UserName'], $logMsg);
                    }
                    // echo success message
                    $msg = '<div class="alert alert-success text-capitalize"><i class="bi bi-check-circle-fill"></i>&nbsp;'.language("MALFUNCTION UPDATED SUCCESSFULLY", @$_SESSION['systemLang']).'</div>';
                    // redirect to home page
                    redirectHome($msg, 'back');
                }
            } else {
                // log message
                $logMsg = "Combination dept: there is no combination ID!.";
                createLogs($_SESSION['UserName'], $logMsg);
                
                // show the warning messgae
                $msg  = '<div class="alert alert-success text-capitalize"><i class="bi bi-check-circle-fill"></i>&nbsp;'.language("THERE IS NO MALFUNCTIONS TO SHOW", @$_SESSION['systemLang']).'</div>';
                redirectHome($msg);
            }
            
            ?>
        </div>
    </div>
<?php } else {
    
    // include permission error
    include_once $globmod . 'permission-error.php';

} ?>