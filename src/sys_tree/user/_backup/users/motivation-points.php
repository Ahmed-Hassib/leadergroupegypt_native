<?php
// type
$type = isset($_GET['type']) ? intval($_GET['type']) : -1;
// user id
$userid = isset($_GET['userid']) ? intval($_GET['userid']) : 0;
// check if user exist
$check = checkItem("`UserID`", "`users`", $userid);

$fullname   = $check > 0 && $userid != 0 ? selectSpecificColumn("`FullName`", "`users`", "WHERE `UserID` = $userid")[0]['FullName'] : language("UNKNOWN", @$_SESSION['systemLang']); 
?>
<!-- start delete suggestions and posPoints -->
<div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
    <!-- start header -->
    <header class="mb-5 header">
        <h1 class="text-capitalize "><?php echo language('MOTIVATION POINTS', @$_SESSION['systemLang']) ?></h1>
        <h5 class="h5 text-capitalize <?php echo $check > 0 ? 'text-secondary' : 'text-danger' ?>">`<?php echo $check > 0 ? $fullname : language("THERE IS NO ID LIKE THAT", @$_SESSION['systemLang']); ?>`</h5>
        <!-- <h4 class="h4 <?php echo $type == 0 ? 'text-danger':'text-success'; ?>"><?php echo $type != -1 ? ($type == 0 ? language('NEGATIVE POINTS', @$_SESSION['systemLang']) : language('POSITIVE POINTS', @$_SESSION['systemLang'])) : "" ?></h4> -->
    </header>
    <?php if ($check > 0) { ?>
        <?php if ($type == -1) { ?>
            <!-- first row -->
            <div class="mb-5 row row-cols-sm-1 row-cols-md-4 g-3">
                <div class="col-sm-12">
                    <div class="card card-stat bg-success">
                        <div class="card-body">
                            <i class="bi bi-arrow-up-circle"></i>
                            <!-- <h5 class="card-title text-capitalize"></h5> -->
                            <span>
                                <a href="?do=motivationPoints&type=1&userid=<?php echo $userid ?>" class="stretched-link">
                                    <?php echo language('POSITIVE POINTS', @$_SESSION['systemLang']) ?>
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="card card-stat bg-danger">
                        <div class="card-body">
                            <i class="bi bi-arrow-down-circle"></i>
                            <!-- <h5 class="card-title text-capitalize"></h5> -->
                            <span>
                                <a href="?do=motivationPoints&type=0&userid=<?php echo $userid ?>" class="stretched-link">
                                    <?php echo language('NEGATIVE POINTS', @$_SESSION['systemLang']) ?>
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
                <?php if ($_SESSION['UserID'] != $userid && $_SESSION['points_add'] == 1) { ?>
                    <div class="col-sm-12">
                        <div class="card card-stat bg-add">
                            <div class="card-body">
                                <i class="bi bi-plus"></i>
                                <!-- <h5 class="card-title text-capitalize"></h5> -->
                                <span>
                                    <a href="?do=addNewPoints&userid=<?php echo $userid ?>" class="stretched-link">
                                        <?php echo language('ADD NEW POINTS', @$_SESSION['systemLang']) ?>
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } elseif ($type == 0) { ?>
            <!-- negative points -->
            <!-- first row -->
            <div class="mb-5 row row-cols-sm-1 row-cols-md-5 g-3">
                <div class="col-sm-12">
                    <div class="card card-stat bg-primary">
                        <div class="card-body">
                            <!-- <i class="bi bi-gear"></i> -->
                            <h5 class="card-title text-capitalize"></h5>
                            <span>
                                <a href="?do=motivationPoints&userid=<?php echo $userid ?>" class="stretched-link">
                                    <?php echo language('DASHBOARD', @$_SESSION['systemLang']) ?>
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="card card-stat bg-danger">
                        <div class="card-body">
                            <i class="bi bi-arrow-down-circle"></i>
                            <h5 class="card-title text-capitalize"><?php echo language('TOTAL', @$_SESSION['systemLang'])." ".language('NEGATIVE POINTS', @$_SESSION['systemLang']) ?></h5>
                            <span>
                                <a href="?do=motivationPoints&type=0&order=total&userid=<?php echo $userid ?>" class="stretched-link">
                                    <?php
                                        // sum of negative points
                                        $sumNegPoints = 0;
                                        // get all negPoints of this user
                                        $negPoints = selectSpecificColumn("`points`", "`users_points`", "WHERE `points_type` = 0 AND `UserID` = $userid");
                                        // loop to get the sum
                                        foreach($negPoints as $index => $point) {
                                            // echo get sum
                                            $sumNegPoints += $point['points'];
                                        }
                                        // print the sum
                                        echo $sumNegPoints;
                                    ?>
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="card card-stat bg-danger">
                        <div class="card-body">
                            <i class="bi bi-arrow-down-circle"></i>
                            <h5 class="card-title text-capitalize"><?php echo language('NEGATIVE POINTS', @$_SESSION['systemLang'])." ".language('TODAY', @$_SESSION['systemLang']) ?></h5>
                            <span>
                                <a href="?do=motivationPoints&type=0&order=today&userid=<?php echo $userid ?>" class="stretched-link">
                                    <?php
                                        // date of today
                                        $date = Date('Y-m-d');
                                        // sum of negative points
                                        $sumNegPoints = 0;
                                        // get all negPoints of this user
                                        $negPoints = selectSpecificColumn("`points`", "`users_points`", "WHERE `points_date` = '$date' AND `points_type` = 0 AND `UserID` = $userid");
                                        // loop to get the sum
                                        foreach($negPoints as $index => $point) {
                                            // echo get sum
                                            $sumNegPoints += $point['points'];
                                        }
                                        // print the sum
                                        echo $sumNegPoints;
                                    ?>
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="card card-stat bg-danger">
                        <div class="card-body">
                            <i class="bi bi-arrow-down-circle"></i>
                            <h5 class="card-title text-capitalize"><?php echo language('NEGATIVE POINTS', @$_SESSION['systemLang'])." ".language('OF THIS MONTH', @$_SESSION['systemLang']) ?></h5>
                            <span>
                                <a href="?do=motivationPoints&type=0&order=month&userid=<?php echo $userid ?>" class="stretched-link">
                                    <?php
                                        $startDate  = Date('Y-m-1');
                                        $endDate    = Date('Y-m-30');
                                        // sum of negative points
                                        $sumNegPoints = 0;
                                        // get all negPoints of this user
                                        $negPoints = selectSpecificColumn("`points`", "`users_points`", "WHERE `points_date` BETWEEN '$startDate' AND '$endDate' AND `points_type` = 0 AND `UserID` = $userid");
                                        // loop to get the sum
                                        foreach($negPoints as $index => $point) {
                                            // echo get sum
                                            $sumNegPoints += $point['points'];
                                        }
                                        // print the sum
                                        echo $sumNegPoints;
                                    ?>
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
                <?php if ($_SESSION['UserID'] != $userid && $_SESSION['points_add'] == 1) { ?>
                    <div class="col-sm-12">
                        <div class="card card-stat bg-add">
                            <div class="card-body">
                                <i class="bi bi-plus"></i>
                                <!-- <h5 class="card-title text-capitalize"></h5> -->
                                <span>
                                    <a href="?do=addNewPoints&userid=<?php echo $userid ?>" class="stretched-link">
                                        <?php echo language('ADD NEW POINTS', @$_SESSION['systemLang']) ?>
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <!-- show points -->
            <?php
                // get the order
                $order = isset($_GET['order']) ? $_GET['order'] : "empty";
                // check the order
                if ($order != "empty") {
                    // switch case to get the title
                    switch($order) {
                        case "total":
                            // query
                            $query = "SELECT *FROM `users_points` WHERE `UserID` = $userid AND `points_type` = 0";
                            // page subtitle
                            $subTitle = language('TOTAL', @$_SESSION['systemLang'])." ".language('NEGATIVE POINTS', @$_SESSION['systemLang']);
                            break;
                        case "today":
                            // date of today
                            $date = Date('Y-m-d');
                            // query
                            $query = "SELECT *FROM `users_points` WHERE `UserID` = $userid AND `points_type` = 0 AND `points_date` = '$date'";
                            // page subtitle
                            $subTitle = language('NEGATIVE POINTS', @$_SESSION['systemLang'])." ".language('TODAY', @$_SESSION['systemLang']);
                            break;
                        case "month":
                            $startDate  = Date('Y-m-1');
                            $endDate    = Date('Y-m-30');
                            // query
                            $query = "SELECT *FROM `users_points` WHERE `UserID` = $userid AND `points_type` = 0 AND `points_date` BETWEEN '$startDate' AND '$endDate'";
                            // page subtitle
                            $subTitle = language('NEGATIVE POINTS', @$_SESSION['systemLang'])." ".language('OF THIS MONTH', @$_SESSION['systemLang']);
                            break;
                    }

                    // get user info from database
                    $stmt = $con->prepare($query);
                    $stmt->execute();                     // execute query
                    $rows = $stmt->fetchAll();             // fetch data
                    $count = $stmt->rowCount();           // get row count
                    // check the count
                    if ($count > 0) {
            ?>
                        <!-- display page subtitle -->
                        <div class="mb-3 header">
                            <h5 class="h5 text-capitalize text-secondary "><?php echo $subTitle; ?></h5>
                        </div>
                        <!-- start table container -->
                        <div class="table-responsive-sm">
                            <!-- strst users table -->
                            <table class="table table-bordered  display compact table-style text-center" id="negativePoints">
                                <thead class="primary text-capitalize">
                                    <tr>
                                        <th data-order="asc" data-col-type="number" style="max-width: 25px">#</th>
                                        <th data-order="asc" data-col-type="string" style="max-width: 50px;"><?php echo language('THE DATE', @$_SESSION['systemLang']) ?></th>
                                        <th data-order="asc" data-col-type="string" style="max-width: 50px;"><?php echo language('THE POINTS', @$_SESSION['systemLang']) ?></th>
                                        <th data-order="asc" data-col-type="string" style="max-width: 100px;"><?php echo language('ADDED BY', @$_SESSION['systemLang']) ?></th>
                                        <th data-order="asc" data-col-type="string" style="min-width: 150px;"><?php echo language('THE COMMENT', @$_SESSION['systemLang']) ?></th>
                                        <th style="min-width: 150px;"><?php echo language('CONTROL', @$_SESSION['systemLang']) ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        // loop on data
                                        foreach ($rows as $index => $point) {
                                    ?>
                                        <tr>
                                            <td><?php echo ($index + 1) ?></td>
                                            <td><?php echo $point['points_date'] ?></td>
                                            <td><?php echo $point['points'] ?></td>
                                            <td><?php 
                                                // admin name
                                                $adminName = selectSpecificColumn("`UserName`", "`users`", "WHERE `UserID` = ". $point['added_by'])[0]['UserName'];
                                                echo $adminName 
                                            ?></td>
                                            <td><?php echo $point['comment'] ?></td>
                                            <td>
                                                <!-- <a href='' class='me-1 btn btn-success text-capitalize fs-12 fs-10-sm <?php if ($_SESSION['user_update'] == 0) {echo 'disabled';} ?>'><i class='bi bi-pencil-square'></i><?php echo language('SHOW', @$_SESSION['systemLang'])." ".language('THE DETAILS', @$_SESSION['systemLang']) ?> </a> -->
                                                <button type="button" data-bs-toggle="modal" data-bs-target="#deleteUserPointsModal" class='my-1 me-1 btn btn-danger text-capitalize fs-12 <?php if ($_SESSION['points_delete'] == 0) {echo 'disabled';} ?> fs-10-sm' onclick="show_delete_user_modal(this)" data-points="<?php echo $point['points'] ?>" data-id="<?php echo $point['id'] ?>"><i class='bi bi-trash'></i><!-- <?php echo language('DELETE', @$_SESSION['systemLang']) ?> --></button>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- modal to show -->
                        <div class="modal fade" id="deleteUserPointsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title text-capitalize " id="exampleModalLabel"><?php echo language('CONFIRM', @$_SESSION['systemLang'])." ".language('DELETE', @$_SESSION['systemLang'])." ".language('POINTS', @$_SESSION['systemLang']) ?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <h2 class="h2" <?php echo @$_SESSION['systemLang'] == "ar" ? "dir=rtl" : ""; ?>><?php echo language('ARE YOU SURE TO DELETE', @$_SESSION['systemLang'])." '" ?> <span id="user-points"></span> <?php echo language('POINTS', @$_SESSION['systemLang']). "' ".( @$_SESSION['systemLang'] == "ar" ? "؟" : "?" )?> </h2>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <a id="delete-points" class="btn btn-danger text-capitalize <?php if ($_SESSION['points_delete'] == 0) {echo 'disabled';} ?>"><i class="bi bi-trash"></i>&nbsp;<?php echo language('DELETE', @$_SESSION['systemLang']) ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                    <!-- end of table -->
                    <?php } else { ?>
                        <h5 class="h5 text-center text-danger "><?php echo language("THERE IS NO POINTS TO SHOW",  @$_SESSION['systemLang']) ?></h5>
                    <?php } ?>  
            <?php } ?>
        <?php } elseif ($type == 1) { ?>
            <!-- positive points points -->
            <!-- first row -->
            <div class="mb-5 row row-cols-sm-1 row-cols-md-5 g-3">
                <div class="col-sm-12">
                    <div class="card card-stat bg-primary">
                        <div class="card-body">
                            <!-- <i class="bi bi-gear"></i> -->
                            <h5 class="card-title text-capitalize"></h5>
                            <span>
                                <a href="?do=motivationPoints&userid=<?php echo $userid ?>" class="stretched-link">
                                    <?php echo language('DASHBOARD', @$_SESSION['systemLang']) ?>
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="card card-stat bg-success">
                        <div class="card-body">
                            <i class="bi bi-arrow-up-circle"></i>
                            <h5 class="card-title text-capitalize"><?php echo language('TOTAL', @$_SESSION['systemLang'])." ".language('POSITIVE POINTS', @$_SESSION['systemLang']) ?></h5>
                            <span>
                                <a href="?do=motivationPoints&type=1&order=total&userid=<?php echo $userid ?>" class="stretched-link">
                                    <?php
                                        // sum of negative points
                                        $sumNegPoints = 0;
                                        // get all negPoints of this user
                                        $negPoints = selectSpecificColumn("`points`", "`users_points`", "WHERE `points_type` = 1 AND `UserID` = $userid");
                                        // loop to get the sum
                                        foreach($negPoints as $index => $point) {
                                            // echo get sum
                                            $sumNegPoints += $point['points'];
                                        }
                                        // print the sum
                                        echo $sumNegPoints;
                                    ?>
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="card card-stat bg-success">
                        <div class="card-body">
                            <i class="bi bi-arrow-up-circle"></i>
                            <h5 class="card-title text-capitalize"><?php echo language('POSITIVE POINTS', @$_SESSION['systemLang'])." ".language('TODAY', @$_SESSION['systemLang']) ?></h5>
                            <span>
                                <a href="?do=motivationPoints&type=1&order=today&userid=<?php echo $userid ?>" class="stretched-link">
                                    <?php
                                        // date of today
                                        $date = Date('Y-m-d');
                                        // sum of negative points
                                        $sumNegPoints = 0;
                                        // get all negPoints of this user
                                        $negPoints = selectSpecificColumn("`points`", "`users_points`", "WHERE `points_date` = '$date' AND `points_type` = 1 AND `UserID` = $userid");
                                        // loop to get the sum
                                        foreach($negPoints as $index => $point) {
                                            // echo get sum
                                            $sumNegPoints += $point['points'];
                                        }
                                        // print the sum
                                        echo $sumNegPoints;
                                    ?>
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="card card-stat bg-success">
                        <div class="card-body">
                            <i class="bi bi-arrow-up-circle"></i>
                            <h5 class="card-title text-capitalize"><?php echo language('POSITIVE POINTS', @$_SESSION['systemLang'])." ".language('OF THIS MONTH', @$_SESSION['systemLang']) ?></h5>
                            <span>
                                <a href="?do=motivationPoints&type=1&order=month&userid=<?php echo $userid ?>" class="stretched-link">
                                    <?php
                                        $startDate  = Date('Y-m-1');
                                        $endDate    = Date('Y-m-30');
                                        // sum of negative points
                                        $sumNegPoints = 0;
                                        // get all negPoints of this user
                                        $negPoints = selectSpecificColumn("`points`", "`users_points`", "WHERE `points_date` BETWEEN '$startDate' AND '$endDate' AND `points_type` = 1 AND `UserID` = $userid");
                                        // loop to get the sum
                                        foreach($negPoints as $index => $point) {
                                            // echo get sum
                                            $sumNegPoints += $point['points'];
                                        }
                                        // print the sum
                                        echo $sumNegPoints;
                                    ?>
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
                <?php if ($_SESSION['UserID'] != $userid && $_SESSION['points_add'] == 1) { ?>
                    <div class="col-sm-12">
                        <div class="card card-stat bg-add">
                            <div class="card-body">
                                <i class="bi bi-plus"></i>
                                <!-- <h5 class="card-title text-capitalize"></h5> -->
                                <span>
                                    <a href="?do=addNewPoints&userid=<?php echo $userid ?>" class="stretched-link">
                                        <?php echo language('ADD NEW POINTS', @$_SESSION['systemLang']) ?>
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <!-- show points -->
            <?php
                // get the order
                $order = isset($_GET['order']) ? $_GET['order'] : "empty";
                // check the order
                if ($order != "empty") {
                    // switch case to get the title
                    switch($order) {
                        case "total":
                            // query
                            $query = "SELECT *FROM `users_points` WHERE `UserID` = $userid AND `points_type` = 1";
                            // page subtitle
                            $subTitle = language('TOTAL', @$_SESSION['systemLang'])." ".language('POSITIVE POINTS', @$_SESSION['systemLang']);
                            break;
                        case "today":
                            // date of today
                            $date = Date('Y-m-d');
                            // query
                            $query = "SELECT *FROM `users_points` WHERE `UserID` = $userid AND `points_type` = 1 AND `points_date` = '$date'";
                            // page subtitle
                            $subTitle = language('POSITIVE POINTS', @$_SESSION['systemLang'])." ".language('TODAY', @$_SESSION['systemLang']);
                            break;
                        case "month":
                            $startDate  = Date('Y-m-1');
                            $endDate    = Date('Y-m-30');
                            // query
                            $query = "SELECT *FROM `users_points` WHERE `UserID` = $userid AND `points_type` = 1 AND `points_date` BETWEEN '$startDate' AND '$endDate'";
                            // page subtitle
                            $subTitle = language('POSITIVE POINTS', @$_SESSION['systemLang'])." ".language('OF THIS MONTH', @$_SESSION['systemLang']);
                            break;
                    }

                    // get user info from database
                    $stmt = $con->prepare($query);
                    $stmt->execute();                     // execute query
                    $rows = $stmt->fetchAll();             // fetch data
                    $count = $stmt->rowCount();           // get row count
                    // check the count
                    if ($count > 0) {
            ?>
                        <!-- display page subtitle -->
                        <div class="mb-3 header">
                            <h5 class="h5 text-capitalize text-secondary "><?php echo $subTitle; ?></h5>
                        </div>
                        <!-- start table container -->
                        <div class="table-responsive-sm">
                            <!-- strst users table -->
                            <table class="table table-bordered  display compact table-style text-center"  id="negativePoints">
                                <thead class="primary text-capitalize">
                                    <tr>
                                        <th data-order="asc" data-col-type="number" style="max-width: 25px">#</th>
                                        <th data-order="asc" data-col-type="string" style="max-width: 50px;"><?php echo language('THE DATE', @$_SESSION['systemLang']) ?></th>
                                        <th data-order="asc" data-col-type="string" style="max-width: 50px;"><?php echo language('THE POINTS', @$_SESSION['systemLang']) ?></th>
                                        <th data-order="asc" data-col-type="string" style="max-width: 100px;"><?php echo language('ADDED BY', @$_SESSION['systemLang']) ?></th>
                                        <th data-order="asc" data-col-type="string" style="min-width: 150px;"><?php echo language('THE COMMENT', @$_SESSION['systemLang']) ?></th>
                                        <th style="min-width: 150px;"><?php echo language('CONTROL', @$_SESSION['systemLang']) ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        // loop on data
                                        foreach ($rows as $index => $point) {
                                    ?>
                                        <tr>
                                            <td><?php echo ($index + 1) ?></td>
                                            <td><?php echo $point['points_date'] ?></td>
                                            <td><?php echo $point['points'] ?></td>
                                            <td><?php 
                                                // admin name
                                                $adminName = selectSpecificColumn("`UserName`", "`users`", "WHERE `UserID` = ". $point['added_by'])[0]['UserName'];
                                                echo $adminName 
                                            ?></td>
                                            <td><?php echo $point['comment'] ?></td>
                                            <td>
                                                <!-- <a href='' class='me-1 btn btn-success text-capitalize fs-12 fs-10-sm <?php if ($_SESSION['user_update'] == 0) {echo 'disabled';} ?>'><i class='bi bi-pencil-square'></i><?php echo language('SHOW', @$_SESSION['systemLang'])." ".language('THE DETAILS', @$_SESSION['systemLang']) ?> </a> -->
                                                <button type="button" data-bs-toggle="modal" data-bs-target="#deleteUserPointsModal" class='my-1 me-1 btn btn-danger text-capitalize fs-12 <?php if ($_SESSION['points_delete'] == 0) {echo 'disabled';} ?> fs-10-sm' onclick="show_delete_user_modal(this)" data-points="<?php echo $point['points'] ?>" data-id="<?php echo $point['id'] ?>"><i class='bi bi-trash'></i><!-- <?php echo language('DELETE', @$_SESSION['systemLang']) ?> --></button>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- modal to show -->
                        <div class="modal fade" id="deleteUserPointsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title text-capitalize " id="exampleModalLabel"><?php echo language('CONFIRM', @$_SESSION['systemLang'])." ".language('DELETE', @$_SESSION['systemLang'])." ".language('POINTS', @$_SESSION['systemLang']) ?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <h2 class="h2" <?php echo @$_SESSION['systemLang'] == "ar" ? "dir=rtl" : ""; ?>><?php echo language('ARE YOU SURE TO DELETE', @$_SESSION['systemLang'])." '" ?> <span id="user-points"></span> <?php echo language('POINTS', @$_SESSION['systemLang']). "' ".( @$_SESSION['systemLang'] == "ar" ? "؟" : "?" )?> </h2>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <a id="delete-points" class="btn btn-danger text-capitalize <?php if ($_SESSION['points_delete'] == 0) {echo 'disabled';} ?>"><i class="bi bi-trash"></i>&nbsp;<?php echo language('DELETE', @$_SESSION['systemLang']) ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                    <!-- end of table -->
                    <?php } else { ?>
                        <h5 class="h5 text-center text-danger "><?php echo language("THERE IS NO POINTS TO SHOW",  @$_SESSION['systemLang']) ?></h5>
                    <?php } ?>  
            <?php } ?>
        <?php } ?>
    <?php } else { ?>
        <!-- first row -->
        <div class="text-center">
            <?php redirectHome(""); ?>
        </div>
    <?php } ?>
</div>
<!-- end delete suggestions and complaints -->