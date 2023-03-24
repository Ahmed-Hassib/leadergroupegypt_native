<!-- start edit profile page -->
<div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
    <!-- start header -->
    <header class="header">
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $updateOwner    = $_SESSION['isTech'];  // the owner of the update
            $combID         = $_POST['comb-id'];
            // check if combination is exist or not
            $checkComb = checkItem("`comb_id`", "`combinations`", $combID);

            if ($checkComb > 0) {
                // print_r($_POST);
                // check if the technical changed for this mal or not
                $comb = selectSpecificColumn("`isReviewed`, `isFinished`", "`combinations`", "WHERE `comb_id` = ".$combID);
                $isFinishedComb = $comb[0]['isFinished'];
                $isReviewedComb = $comb[0]['isReviewed'];

                if ($isReviewedComb != 1 || $isFinishedComb != 1) {
                    // validate the form
                    $formErorr = array();   // error array 
                    // check the type of the owner of the update
                    if ($updateOwner == 0) {
                        // for normal employees
                        $techID = $_POST['technical-id'];
                        // check if the technical changed for this mal or not
                        $combInfo = selectSpecificColumn("`UserID`, `isFinished`", "`combinations`", "WHERE `comb_id` = " . $combID);

                        $oldTechID = $combInfo[0]['UserID'];
                        $combStatus = $combInfo[0]['isFinished'];

                        // if technical man changed
                        if ($oldTechID != $techID) {
                            // update some info of this malfunction 
                            $stmt = $con->prepare("UPDATE `combinations` SET `UserID` = ?, `added_date` = CURRENT_DATE, `added_time` = CURRENT_TIME, `isFinished` = 0, `cost` = 0, `finished_date` = '0000-00-00', `finished_time` = '00:00:00', `isShowed` = 0, `showed_date` = '0000-00-00', `showed_time` = '00:00:00', `isAccepted` = -1,  `isReviewed` = 0, `reviewed_date` = '0000-00-00', `reviewed_time` = '00:00:00', `money_review` = 0, `qty_service` = 0, `qty_emp` = 0, `qty_comment` = ''  WHERE `comb_id` = ?");
                            $stmt->execute(array($techID, $combID));
                        } else {
                            // if the combination is not reviewed
                            if ($isFinishedComb == 1 && $isReviewedComb == 0) {
                                // get review data
                                $technicalQty   = $_POST['technical-qty'];
                                $serviceQty     = $_POST['service-qty'];
                                $moneyReview    = $_POST['money-review'];
                                $reviewComment  = $_POST['review-comment'];
                                // check review 
                                
                                $isReviewed = $technicalQty && $serviceQty && $moneyReview ? 1 : 0;
                                $reviewComment = $technicalQty && $serviceQty && $moneyReview ? $_POST['review-comment'] : "";

                                // update the database with this info
                                $stmt = $con->prepare("UPDATE `combinations` SET `isReviewed` = ?, `reviewed_date` = CURRENT_DATE(), `reviewed_time` = CURRENT_TIME(), `money_review` = ?, `qty_service` = ?, `qty_emp` = ?, `qty_comment` = ?  WHERE `comb_id` = ?");
                                $stmt->execute(array($isReviewed, $moneyReview, $serviceQty, $technicalQty, $reviewComment, $combID));       
                            } else {
                                $comment = $_POST['client-notes'];
                                // update the database with this info
                                $stmt = $con->prepare("UPDATE `combinations` SET `comment` = ?  WHERE `comb_id` = ?");
                                $stmt->execute(array($comment, $combID));       
                            }
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
                        $oldValues = selectSpecificColumn("`tech_comment`, `isFinished`, `cost`, `isAccepted`", "`combinations`", "WHERE `comb_id` = ".$combID)[0];
                        $haveMedia = countRecords("`comb_id`", "`combinations_media`", "WHERE `comb_id` = ".$combID);

                        // for technical employees
                        $techComment    = isset($_POST['comment'])          ? $_POST['comment']             : $oldValues['tech_comment'];
                        $cost           = isset($_POST['cost'])             ? $_POST['cost']                : $oldValues['cost'];
                        $combStatus     = isset($_POST['comb-status'])      ? $_POST['comb-status']         : $oldValues['isFinished'];

                        if ($combStatus == 1) {
                            $techStatus = 1;
                        } else {
                            $techStatus = isset($_POST['tech-comb-status']) ? $_POST['tech-comb-status']    : $oldValues['isAccepted'];
                        }

                        $query          = "";

                        if ($techComment == $oldValues['tech_comment'] && $cost == $oldValues['cost'] && $combStatus == $oldValues['isFinished'] && $techStatus == $oldValues['isAccepted']) {
                            // for normal employees
                            $techID         = $_POST['technical-id'];
                            // check if the technical changed for this mal or not
                            $combInfo = selectSpecificColumn("`UserID`, `isFinished`", "`combinations`", "WHERE `comb_id` = " . $combID);

                            $oldTechID = $combInfo[0]['UserID'];
                            $combStatus = $combInfo[0]['isFinished'];

                            // if technical man changed
                            if ($oldTechID != $techID) {
                                // update some info of this malfunction 
                                $stmt = $con->prepare("UPDATE `combinations` SET `UserID` = ?, `added_date` = CURRENT_DATE, `added_time` = CURRENT_TIME, `isFinished` = 0, `cost` = 0, `finished_date` = '0000-00-00', `finished_time` = '00:00:00', `isShowed` = 0, `showed_date` = '0000-00-00', `showed_time` = '00:00:00', `isAccepted` = -1,  `isReviewed` = 0, `reviewed_date` = '0000-00-00', `reviewed_time` = '00:00:00', `money_review` = 0, `qty_service` = 0, `qty_emp` = 0, `qty_comment` = ''  WHERE `comb_id` = ?");
                                $stmt->execute(array($techID, $combID));
                            } 
                        } 
                        
                        // get comb photo
                        $photoInfo  = !empty($_FILES['comb-photos']) ? $_FILES['comb-photos'] : array();
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
                            

                            // validate combID
                            if (empty($combID)) {
                                $formErorr[] = 'combination ID cannot be <strong>empty.</strong>';
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
                                        // add the date of day and combination id to the photo name
                                        $phName = strtoupper($photoExtension) . "_". Date('Ymd') . "_" . $combID . "_" . rand() . "." . $photoExtension;
                                        // move photo into upload directory
                                        move_uploaded_file($photoTmp[$key], $uploads."//combinations//".$phName);
                                        // check the uploaded type
                                        $type = in_array($photoExtension, $imageTypes) ? "img" : "video";
                                        // append photos values
                                        $updatePhoto .= "(".$combID.", '".$phName."', '".$type."')";
                                        // if not last photo add ',' at the end of the values query
                                        $updatePhoto .= ($key + 1) == count($photoName) ? "" : ", ";
                                    }
                                    $query .= "INSERT INTO `combinations_media` (`comb_id`, `media`,`type`) VALUES " . $updatePhoto . ";";
                                }
                            }
                        }
                        // query to update the combination
                        $query .= "UPDATE `combinations` SET `isFinished` = ?, `isAccepted` = ?, `cost` = ?, `finished_date` = CURRENT_DATE, `finished_time` = CURRENT_TIME, `tech_comment` = ? WHERE `comb_id` = ?;";
                        // update the database with this info
                        $stmt = $con->prepare($query);
                        $stmt->execute(array($combStatus, $techStatus, $cost, $techComment, $combID));
                        // log message
                        $logMsg = "Combinations dept: combination updated successfully";
                        createLogs($_SESSION['UserName'], $logMsg);
                    }
                    // echo success message
                    $msg = '<div class="alert alert-success text-capitalize"><i class="bi bi-check-circle-fill"></i>&nbsp;'.language("COMBINATION UPDATED SUCCESSFULLY", @$_SESSION['systemLang']).'</div>';
                    // redirect to home page
                    redirectHome($msg, 'back');
                }
            } else {
                // log message
                $logMsg = "Combination dept: there is no combination like ".$combID."!.";
                createLogs($_SESSION['UserName'], $logMsg);
                
                // include missing data module
                include_once $globmod . 'data-error.php';
            }
        } else {
            // include permission error module
            include_once $globmod . 'permission-error.php';
        } ?>
    </header>
</div>