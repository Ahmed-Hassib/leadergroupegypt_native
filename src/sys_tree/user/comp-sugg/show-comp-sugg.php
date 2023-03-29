<?php
$is_contain_table = true;
// get the type
$type = isset($_GET['type']) ? $_GET['type'] : -1;
// check the status
$status = isset($_GET['status']) ? $_GET['status'] : -1;
?>
<!-- start home stats container -->
<div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
    <!-- start header -->
    <div class="header">
        <h1 class="h1 text-capitalize"><?php echo language('MANAGE', @$_SESSION['systemLang']) . " " . language('COMPLAINTS & SUGGESTIONS', @$_SESSION['systemLang']) ?></h1>
        <?php if ($type != -1) { ?>
            <h4 class="h4 text-capitalize  text-secondary"><?php echo $type == 0 ? language('THE SUGGESTIONS', @$_SESSION['systemLang']) : language('THE COMPLAINTS', @$_SESSION['systemLang']) ?></h4>
        <?php } else { 
            // danger message
            $msg = '<div class="alert alert-danger  text-capitalize">'.language('YOU CANNOT ACCESS THIS PAGE DIRECTLY', @$_SESSION['systemLang']).'</div>';
            // create a log message
            // createLogs($_SESSION['UserID'], 'Complaints & Suggestions Dept: You canoot access this page directly', 3);
            // redirect home
            redirectHome($msg);
        } ?>
    </div>
    <?php if ($type == 0) { ?>
        <!-- first row -->
        <div class="mb-5 row row-cols-sm-1 row-cols-md-4 g-3">
            <div class="col-sm-12">
                <div class="card card-stat bg-primary">
                    <div class="card-body">
                        <i class="bi bi-arrow-left-circle"></i>
                        <!-- <h5 class="card-title text-capitalize"></h5> -->
                        <span>
                            <a href="index.php" class="stretched-link text-capitalize">
                                <?php echo language('BACK', @$_SESSION['systemLang']) ?>
                            </a>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="card card-stat bg-success">
                    <?php $sugg = countRecords("`id`", "`comp_sugg`", "WHERE `type` = 0") ?>
                    <div class="card-body">
                        <i class="bi bi-mailbox"></i>
                        <h5 class="card-title text-capitalize"><?php echo language('THE SUGGESTIONS', @$_SESSION['systemLang']) ?></h5>
                        <span class="nums">
                            <a href="?do=showCompSugg&type=0&status=2" class="num stretched-link text-capitalize" data-goal="<?php echo $sugg ?>">0</a>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="card card-stat bg-success">
                    <?php $readedSugg = countRecords("`id`", "`comp_sugg`", "WHERE `type` = 0 AND `activate_status` = 1") ?>
                    <div class="card-body">
                        <i class="bi bi-mailbox"></i>
                        <h5 class="card-title text-capitalize"><?php echo language('READED SUGGESTIONS', @$_SESSION['systemLang']) ?></h5>
                        <span class="nums">
                            <a href="?do=showCompSugg&type=0&status=1" class="num stretched-link text-capitalize" data-goal="<?php echo $readedSugg ?>">0</a>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="card card-stat bg-success">
                    <?php $unreadedSugg = countRecords("`id`", "`comp_sugg`", "WHERE `type` = 0 AND `activate_status` = 0") ?>
                    <div class="card-body">
                        <i class="bi bi-mailbox"></i>
                        <h5 class="card-title text-capitalize"><?php echo language('UNREADED SUGGESTIONS', @$_SESSION['systemLang']) ?></h5>
                        <span class="nums">
                            <a href="?do=showCompSugg&type=0&status=0" class="num stretched-link text-capitalize" data-goal="<?php echo $unreadedSugg ?>">0</a>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <!-- check the status -->
        <?php
            $query = "";
            switch ($status) {
                case 0:
                    $query = "SELECT *FROM `comp_sugg` WHERE `type` = $type AND `activate_status` = 0";
                    $subTitle = "UNREADED SUGGESTIONS";
                    break;
                    
                case 1:
                    $query = "SELECT *FROM `comp_sugg` WHERE `type` = $type AND `activate_status` = 1";
                    $subTitle = "READED SUGGESTIONS";
                    break;
                    
                case 2:
                    $query = "SELECT *FROM `comp_sugg` WHERE `type` = $type";
                    $subTitle = "TOTAL SUGGESTIONS";
                    break;
            }
            
            if (!empty($query)) {
                // prepare the query
                $stmt = $con->prepare($query);
                $stmt->execute();
                $rows = $stmt->fetchAll();
                $count = $stmt->rowCount();           // get row count
                // check the count
                if ($count > 0) { 
            ?>      
                    <!-- start header -->
                    <div class="mb-3 header">
                        <h5 class="h5 text-capitalize text-secondary "><?php echo language($subTitle, @$_SESSION['systemLang']) ?></h5>
                    </div>
                    <!-- start table container -->
                    <div class="table-responsive-sm">
                        <!-- strst users table -->
                        <table class="table table-bordered  display compact table-style text-center" id="compSugg3">
                            <thead class="primary text-capitalize">
                                <tr>
                                    <th data-order="asc" data-col-type="number" style="max-width: 25px">#</th>
                                    <th data-order="asc" data-col-type="string" style="min-width: 150px;"><?php echo language('ADDED BY', @$_SESSION['systemLang']) ?></th>
                                    <th data-order="asc" data-col-type="string" style="min-width: 150px;"><?php echo language('THE SUGGESTION', @$_SESSION['systemLang']) ?></th>
                                    <th data-order="asc" data-col-type="string" style="max-width: 50px;"><?php echo language('THE DATE', @$_SESSION['systemLang']) ?></th>
                                    <th data-order="asc" data-col-type="string" style="min-width: 150px;"><?php echo language('ADMIN COMMENT', @$_SESSION['systemLang']) ?></th>
                                    <?php if ($status == 2) { ?>
                                        <th style="max-width: 50px;"><?php echo language('STATUS', @$_SESSION['systemLang']) ?></th>
                                    <?php } ?>
                                    <th style="max-width: 100px"><?php echo language('CONTROL', @$_SESSION['systemLang']) ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    // loop on data
                                    foreach ($rows as $index => $row) {
                                ?>
                                <tr>
                                    <td><?php echo ($index + 1) ?></td>
                                    <td>
                                        <?php if ($_SESSION['user_show'] == 1) { ?>
                                            <a href="<?php echo $nav_up_level ?>users/index.php?do=edit-user-info&userid=<?php echo $row['UserID'] ?>">
                                                <?php echo selectSpecificColumn("`UserName`", "`users`", "WHERE `UserID` = ".$row['UserID'])[0]['UserName'] ?>
                                            </a>
                                        <?php } else { ?> 
                                            <span><?php echo selectSpecificColumn("`UserName`", "`users`", "WHERE `UserID` = ".$row['UserID'])[0]['UserName'] ?></span>
                                        <?php } ?>
                                    </td>
                                    <td><?php echo $row['sugg'] ?></td>
                                    <td><?php echo $row['added_date'] ?></td>
                                    <td>
                                        <form action="?do=activateSugg" method="POST" id="activateCompSugg-<?php echo $row['id'] ?>">
                                            <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
                                            <textarea name="admin-comment" id="admin-comment" dir="rtl" class="form-control" style="resize: vertical; height: 1rem" placeholder="<?php echo language('THERE IS NO COMMENT FROM ADMIN TO SHOW', @$_SESSION['systemLang']) ?>" <?php if ($_SESSION['sugg_replay'] == 0) {echo 'disabled';} ?>><?php echo !empty($row['admin_comment']) ? $row['admin_comment']: ""; ?></textarea>
                                        </form>
                                    </td>
                                    <?php if ($status == 2) { ?>
                                        <td style="max-width: 50px;"><i class="bi <?php echo $row['activate_status'] == 0 ? "bi-circle" : "bi-check2-circle" ?>" title="<?php echo $row['activate_status'] == 0 ? language("UNREADED SUGGESTION", @$_SESSION['systemLang']) : language("READED SUGGESTION", @$_SESSION['systemLang']) ?>"></i></td>
                                    <?php } ?>
                                    <td>
                                        <button type="submit" class="btn btn-primary fs-12" form="activateCompSugg-<?php echo $row['id'] ?>" <?php if ($_SESSION['sugg_replay'] == 0) {echo 'disabled';} ?>><i class="bi bi-check-all"></i>&nbsp;<?php echo language('SAVE CHANGES', @$_SESSION['systemLang']) ?></button>
                                        <a href="?do=deleteCompSugg&compSuggID=<?php echo $row['id'] ?>" class="btn btn-outline-danger fs-12"><i class="bi bi-trash"></i></a>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
            <?php } else { ?>
                <!-- start edit profile page -->
                <div class="container">
                    <!-- start header -->
                    <header class="header">
                        <h5 class="h5 text-danger "><?php echo language("THERE IS NO SUGGESTIONS OR COMPLAINTS TO SHOW", @$_SESSION['systemLang']) ?></h5>
                    </header>
                </div>
            <?php } ?>
        <?php } ?>
            
    <?php } elseif ($type == 1) { ?>
        <!-- first row -->
        <div class="mb-5 row row-cols-sm-1 row-cols-md-4 g-3">
            <div class="col-sm-12">
                <div class="card card-stat bg-primary">
                    <div class="card-body">
                        <i class="bi bi-arrow-left-circle"></i>
                        <!-- <h5 class="card-title text-capitalize"></h5> -->
                        <span>
                            <a href="index.php" class="stretched-link text-capitalize">
                                <?php echo language('BACK', @$_SESSION['systemLang']) ?>
                            </a>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="card card-stat bg-danger">
                    <?php $comp = countRecords("`id`", "`comp_sugg`", "WHERE `type` = 1") ?>
                    <div class="card-body">
                        <i class="bi bi-mailbox"></i>
                        <h5 class="card-title text-capitalize"><?php echo language('THE COMPLAINTS', @$_SESSION['systemLang']) ?></h5>
                        <span class="nums">
                            <a href="?do=showCompSugg&type=1&status=2" class="num stretched-link text-capitalize" data-goal="<?php echo $comp ?>">0</a>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="card card-stat bg-danger">
                    <?php $readedComp = countRecords("`id`", "`comp_sugg`", "WHERE `type` = 1 AND `activate_status` = 1") ?>
                    <div class="card-body">
                        <i class="bi bi-mailbox"></i>
                        <h5 class="card-title text-capitalize"><?php echo language('READED COMPLAINTS', @$_SESSION['systemLang']) ?></h5>
                        <span class="nums">
                            <a href="?do=showCompSugg&type=1&status=1" class="num stretched-link text-capitalize" data-goal="<?php echo $readedComp ?>">0</a>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="card card-stat bg-danger">
                    <?php $unreadedSugg = countRecords("`id`", "`comp_sugg`", "WHERE `type` = 1 AND `activate_status` = 0") ?>
                    <div class="card-body">
                        <i class="bi bi-mailbox"></i>
                        <h5 class="card-title text-capitalize"><?php echo language('UNREADED COMPLAINTS', @$_SESSION['systemLang']) ?></h5>
                        <span class="nums">
                            <a href="?do=showCompSugg&type=1&status=0" class="num stretched-link text-capitalize" data-goal="<?php echo $unreadedSugg ?>">0</a>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <!-- check the status -->
        <?php
            $query = "";
            switch ($status) {
                case 0:
                    $query = "SELECT *FROM `comp_sugg` WHERE `type` = $type AND `activate_status` = 0";
                    $subTitle = "UNREADED COMPLAINTS";
                    break;
                    
                case 1:
                    $query = "SELECT *FROM `comp_sugg` WHERE `type` = $type AND `activate_status` = 1";
                    $subTitle = "READED COMPLAINTS";
                    break;
                    
                case 2:
                    $query = "SELECT *FROM `comp_sugg` WHERE `type` = $type";
                    $subTitle = "TOTAL COMPLAINTS";
                    break;
            }
            
            if (!empty($query)) {
                // prepare the query
                $stmt = $con->prepare($query);
                $stmt->execute();
                $rows = $stmt->fetchAll();
                $count = $stmt->rowCount();           // get row count
                // check the count
                if ($count > 0) { 
            ?>      
                    <!-- start header -->
                    <div class="mb-3 header">
                        <h5 class="h5 text-capitalize text-secondary "><?php echo language($subTitle, @$_SESSION['systemLang']) ?></h5>
                    </div>
                    <!-- start table container -->
                    <div class="table-responsive-sm">
                        <!-- strst users table -->
                        <table class="table table-bordered  display compact table-style text-center" id="compSugg4">
                            <thead class="primary text-capitalize">
                                <tr>
                                    <th data-order="asc" data-col-type="number" style="max-width: 25px">#</th>
                                    <th data-order="asc" data-col-type="string" style="min-width: 150px;"><?php echo language('ADDED BY', @$_SESSION['systemLang']) ?></th>
                                    <th data-order="asc" data-col-type="string" style="min-width: 150px;"><?php echo language('THE SUGGESTION', @$_SESSION['systemLang']) ?></th>
                                    <th data-order="asc" data-col-type="string" style="max-width: 50px;"><?php echo language('THE DATE', @$_SESSION['systemLang']) ?></th>
                                    <th data-order="asc" data-col-type="string" style="min-width: 150px;"><?php echo language('ADMIN COMMENT', @$_SESSION['systemLang']) ?></th>
                                    <?php if ($status == 2) { ?>
                                        <th style="max-width: 50px;"><?php echo language('STATUS', @$_SESSION['systemLang']) ?></th>
                                    <?php } ?>
                                    <th style="max-width: 100px"><?php echo language('CONTROL', @$_SESSION['systemLang']) ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($rows as $index => $row) { ?>
                                <tr>
                                    <td><?php echo ($index + 1) ?></td>
                                    <td>
                                        <?php if ($_SESSION['user_show'] == 1) { ?>
                                            <a href="users.php?do=edit-user-info&userid=<?php echo $row['UserID'] ?>">
                                                <?php echo selectSpecificColumn("`UserName`", "`users`", "WHERE `UserID` = ".$row['UserID'])[0]['UserName'] ?>
                                            </a>
                                        <?php } else { ?> 
                                            <span><?php echo selectSpecificColumn("`UserName`", "`users`", "WHERE `UserID` = ".$row['UserID'])[0]['UserName'] ?></span>
                                        <?php } ?>
                                    </td>
                                    <td><?php echo $row['sugg'] ?></td>
                                    <td><?php echo $row['added_date'] ?></td>
                                    <td>
                                        <form action="?do=activateSugg" method="POST" id="activateCompSugg-<?php echo $row['id'] ?>">
                                            <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
                                            <textarea name="admin-comment" id="admin-comment" dir="rtl" class="form-control" style="resize: vertical; height: 1rem" placeholder="<?php echo language('THERE IS NO COMMENT FROM ADMIN TO SHOW', @$_SESSION['systemLang']) ?>"  <?php if ($_SESSION['sugg_replay'] == 0) {echo 'disabled';} ?>><?php echo !empty($row['admin_comment']) ? $row['admin_comment']: ""; ?></textarea>
                                        </form>
                                    </td>
                                    <?php if ($status == 2) { ?>
                                        <td style="max-width: 50px;"><i class="bi <?php echo $row['activate_status'] == 0 ? "bi-circle" : "bi-check2-circle" ?>" title="<?php echo $row['activate_status'] == 0 ? language("UNREADED SUGGESTION", @$_SESSION['systemLang']) : language("READED SUGGESTION", @$_SESSION['systemLang']) ?>"></i></td>
                                    <?php } ?>
                                    <td>
                                        <button type="submit" class="btn btn-primary fs-12" form="activateCompSugg-<?php echo $row['id'] ?>" <?php if ($_SESSION['sugg_replay'] == 0) {echo 'disabled';} ?>><i class="bi bi-check-all"></i>&nbsp;<?php echo language('SAVE CHANGES', @$_SESSION['systemLang']) ?></button>
                                        <a href="?do=deleteCompSugg&compSuggID=<?php echo $row['id'] ?>" class="btn btn-outline-danger fs-12"><i class="bi bi-trash"></i>&nbsp;<?php echo language("DELETE", @$_SESSION['systemLang']) ?></a>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
            <?php } else { ?>
                <!-- start edit profile page -->
                <div class="container">
                    <!-- start header -->
                    <header class="header">
                        <h5 class="h5 text-danger "><?php echo language("THERE IS NO SUGGESTIONS OR COMPLAINTS TO SHOW", @$_SESSION['systemLang']) ?></h5>
                    </header>
                </div>
            <?php } ?>
        <?php } ?>
        
    <?php } ?>
</div>