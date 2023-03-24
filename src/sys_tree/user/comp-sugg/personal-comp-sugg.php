<?php
$is_contain_table = true;
// get the type
$type = isset($_GET['type']) ? $_GET['type'] : -1;
// get status
$status = isset($_GET['status']) ? $_GET['status'] : -1;
// get userid
$userid = isset($_GET['userid']) ? $_GET['userid'] : -1;
// check if userid is exist in database
$check = checkItem("`UserID`", "`users`", $userid);

?>
<!-- start home stats container -->
<div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
    <!-- start header -->
    <div class="mb-3 header">
        <h1 class="h1 text-capitalize"><?php echo language('MANAGE', @$_SESSION['systemLang']) . " " . language('COMPLAINTS & SUGGESTIONS', @$_SESSION['systemLang']) ?></h1>
        <h4 class="h4 text-capitalize text-secondary "><?php echo language('PERSONAL COMP/SUGG', @$_SESSION['systemLang']) ?></h4>
    </div>
    <?php if ($check > 0) { ?>
        <?php if ($type == -1) { ?>
            <!-- first row -->
            <div class="mb-5 row row-cols-sm-1 row-cols-md-4 g-3">
                <div class="col-sm-12">
                    <div class="card card-stat bg-primary">
                        <div class="card-body">
                            <!-- <i class="bi bi-file-person"></i> -->
                            <!-- <h5 class="card-title text-capitalize"></h5> -->
                            <span>
                                <a href="index.php" class="stretched-link text-capitalize">
                                    <?php echo language('DASHBOARD', @$_SESSION['systemLang']) ?>
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="card card-stat bg-success">
                        <div class="card-body">
                            <i class="bi bi-mailbox"></i>
                            <!-- <h5 class="card-title text-capitalize"></h5> -->
                            <span>
                                <a href="?do=personalCompSugg&type=0&userid=<?php echo $_SESSION['UserID'] ?>" class="stretched-link text-capitalize">
                                    <?php echo language('THE SUGGESTIONS', @$_SESSION['systemLang']) ?>
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="col-sm-12">
                    <div class="card card-stat bg-danger">
                        <div class="card-body">
                            <i class="bi bi-journal-x"></i>
                            <!-- <h5 class="card-title text-capitalize"></h5> -->
                            <span>
                                <a href="?do=personalCompSugg&type=1&userid=<?php echo $_SESSION['UserID'] ?>" class="stretched-link text-capitalize">
                                    <?php echo language('THE COMPLAINTS', @$_SESSION['systemLang']) ?>
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="col-sm-12">
                    <div class="card card-stat bg-add">
                        <div class="card-body">
                            <!-- <h5 class="card-title text-capitalize"></h5> -->
                            <span>
                                <a href="?do=addNewComSugg" class="stretched-link text-capitalize">
                                    <i class="bi bi-plus"></i>
                                    <?php echo language('ADD NEW SUGG/COMP', @$_SESSION['systemLang']) ?>
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        <?php } elseif ($type == 0) { ?>
            <!-- first row -->
            <div class="mb-5 row row-cols-sm-1 row-cols-md-4 g-3">
                <div class="col-sm-12">
                    <div class="card card-stat bg-primary">
                        <div class="card-body">
                            <i class="bi bi-arrow-left-circle"></i>
                            <!-- <h5 class="card-title text-capitalize"></h5> -->
                            <span>
                                <a href="index.php?do=personalCompSugg&userid=<?php echo $_SESSION['UserID'] ?>" class="stretched-link text-capitalize">
                                    <?php echo language('BACK', @$_SESSION['systemLang']) ?>
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="card card-stat bg-success">
                        <div class="card-body">
                            <i class="bi bi-mailbox"></i>
                            <h5 class="card-title text-capitalize"><?php echo language('THE SUGGESTIONS', @$_SESSION['systemLang']) ?></h5>
                            <span>
                                <a href="?do=personalCompSugg&type=0&status=2&userid=<?php echo $_SESSION['UserID'] ?>" class="stretched-link text-capitalize">
                                    <?php echo countRecords("`id`", "`comp_sugg`", "WHERE `type` = 0 AND `UserID` = ".$_SESSION['UserID']) ?>
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="card card-stat bg-success">
                        <div class="card-body">
                            <i class="bi bi-mailbox"></i>
                            <h5 class="card-title text-capitalize"><?php echo language('READED SUGGESTIONS', @$_SESSION['systemLang']) ?></h5>
                            <span>
                                <a href="?do=personalCompSugg&type=0&status=1&userid=<?php echo $_SESSION['UserID'] ?>" class="stretched-link text-capitalize">
                                    <?php echo countRecords("`id`", "`comp_sugg`", "WHERE `type` = 0 AND `activate_status` = 1 AND `UserID` = ".$_SESSION['UserID']) ?>
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="card card-stat bg-success">
                        <div class="card-body">
                            <i class="bi bi-mailbox"></i>
                            <h5 class="card-title text-capitalize"><?php echo language('UNREADED SUGGESTIONS', @$_SESSION['systemLang']) ?></h5>
                            <span>
                                <a href="?do=personalCompSugg&type=0&status=0&userid=<?php echo $_SESSION['UserID'] ?>" class="stretched-link text-capitalize">
                                    <?php echo countRecords("`id`", "`comp_sugg`", "WHERE `type` = 0 AND `activate_status` = 0 AND `UserID` = ".$_SESSION['UserID']) ?>
                                </a>
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
                        $query = "SELECT *FROM `comp_sugg` WHERE `type` = $type AND `activate_status` = 0 AND `UserID` = $userid";
                        $subTitle = "UNREADED SUGGESTIONS";
                        break;
                        
                    case 1:
                        $query = "SELECT *FROM `comp_sugg` WHERE `type` = $type AND `activate_status` = 1 AND `UserID` = $userid";
                        $subTitle = "READED SUGGESTIONS";
                        break;
                        
                    case 2:
                        $query = "SELECT *FROM `comp_sugg` WHERE `type` = $type AND `UserID` = $userid";
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
                            <table class="table table-bordered  display compact table-style text-center" id="compSugg">
                                <thead class="primary text-capitalize">
                                    <tr>
                                        <th data-order="asc" data-col-type="number" style="max-width: 25px">#</th>
                                        <th data-order="asc" data-col-type="string" style="min-width: 150px;"><?php echo language('THE SUGGESTION', @$_SESSION['systemLang']) ?></th>
                                        <th data-order="asc" data-col-type="string" style="max-width: 50px;"><?php echo language('THE DATE', @$_SESSION['systemLang']) ?></th>
                                        <th data-order="asc" data-col-type="string" style="min-width: 150px;"><?php echo language('ADMIN COMMENT', @$_SESSION['systemLang']) ?></th>
                                        <?php if ($status == 2) { ?>
                                            <th style="max-width: 50px;"><?php echo language('STATUS', @$_SESSION['systemLang']) ?></th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($rows as $index => $row) { ?>
                                    <tr>
                                        <td><?php echo ($index + 1) ?></td>
                                        <td><?php echo $row['sugg'] ?></td>
                                        <td><?php echo $row['added_date'] ?></td>
                                        <td><?php echo !empty($row['admin_comment']) ? $row['admin_comment'] : language("THERE IS NO COMMENT FROM ADMIN TO SHOW", @$_SESSION['systemLang']) ?></td>
                                        <?php if ($status == 2) { ?>
                                            <td style="max-width: 50px;"><i class="bi <?php echo $row['activate_status'] == 0 ? "bi-circle" : "bi-check2-circle" ?>" title="<?php echo $row['activate_status'] == 0 ? language("UNREADED SUGGESTION", @$_SESSION['systemLang']) : language("READED SUGGESTION", @$_SESSION['systemLang']) ?>"></i></td>
                                        <?php } ?>
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
                                <a href="index.php?do=personalCompSugg&userid=<?php echo $_SESSION['UserID'] ?>" class="stretched-link text-capitalize">
                                    <?php echo language('BACK', @$_SESSION['systemLang']) ?>
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="card card-stat bg-danger">
                        <div class="card-body">
                            <i class="bi bi-mailbox"></i>
                            <h5 class="card-title text-capitalize"><?php echo language('THE COMPLAINTS', @$_SESSION['systemLang']) ?></h5>
                            <span>
                                <a href="?do=personalCompSugg&type=1&status=2&userid=<?php echo $_SESSION['UserID'] ?>" class="stretched-link text-capitalize">
                                    <?php echo countRecords("`id`", "`comp_sugg`", "WHERE `type` = 1 AND `UserID` = ".$_SESSION['UserID']) ?>
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="card card-stat bg-danger">
                        <div class="card-body">
                            <i class="bi bi-mailbox"></i>
                            <h5 class="card-title text-capitalize"><?php echo language('READED COMPLAINTS', @$_SESSION['systemLang']) ?></h5>
                            <span>
                                <a href="?do=personalCompSugg&type=1&status=1&userid=<?php echo $_SESSION['UserID'] ?>" class="stretched-link text-capitalize">
                                    <?php echo countRecords("`id`", "`comp_sugg`", "WHERE `type` = 1 AND `activate_status` = 1 AND `UserID` = ".$_SESSION['UserID']) ?>
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="card card-stat bg-danger">
                        <div class="card-body">
                            <i class="bi bi-mailbox"></i>
                            <h5 class="card-title text-capitalize"><?php echo language('UNREADED COMPLAINTS', @$_SESSION['systemLang']) ?></h5>
                            <span>
                                <a href="?do=personalCompSugg&type=1&status=0&userid=<?php echo $_SESSION['UserID'] ?>" class="stretched-link text-capitalize">
                                    <?php echo countRecords("`id`", "`comp_sugg`", "WHERE `type` = 1 AND `activate_status` = 0 AND `UserID` = ".$_SESSION['UserID']) ?>
                                </a>
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
                        $query = "SELECT *FROM `comp_sugg` WHERE `type` = $type AND `activate_status` = 0 AND `UserID` = $userid";
                        $subTitle = "UNREADED COMPLAINTS";
                        break;
                        
                    case 1:
                        $query = "SELECT *FROM `comp_sugg` WHERE `type` = $type AND `activate_status` = 1 AND `UserID` = $userid";
                        $subTitle = "READED COMPLAINTS";
                        break;
                        
                    case 2:
                        $query = "SELECT *FROM `comp_sugg` WHERE `type` = $type AND `UserID` = $userid";
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
                            <table class="table table-bordered  display compact table-style text-center" id="compSugg2">
                                <thead class="primary text-capitalize">
                                    <tr>
                                        <th data-order="asc" data-col-type="number" style="max-width: 25px">#</th>
                                        <th data-order="asc" data-col-type="string" style="min-width: 150px;"><?php echo language('THE SUGGESTION', @$_SESSION['systemLang']) ?></th>
                                        <th data-order="asc" data-col-type="string" style="max-width: 50px;"><?php echo language('THE DATE', @$_SESSION['systemLang']) ?></th>
                                        <th data-order="asc" data-col-type="string" style="min-width: 150px;"><?php echo language('ADMIN COMMENT', @$_SESSION['systemLang']) ?></th>
                                        <?php if ($status == 2) { ?>
                                            <th style="max-width: 50px;"><?php echo language('STATUS', @$_SESSION['systemLang']) ?></th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($rows as $index => $row) { ?>
                                    <tr>
                                        <td><?php echo ($index + 1) ?></td>
                                        <td><?php echo $row['sugg'] ?></td>
                                        <td><?php echo $row['added_date'] ?></td>
                                        <td><?php echo !empty($row['admin_comment']) ? $row['admin_comment'] : language("THERE IS NO COMMENT FROM ADMIN TO SHOW", @$_SESSION['systemLang']) ?></td>
                                        <?php if ($status == 2) { ?>
                                            <td style="max-width: 50px;"><i class="bi <?php echo $row['activate_status'] == 0 ? "bi-circle" : "bi-check2-circle" ?>" title="<?php echo $row['activate_status'] == 0 ? language("UNREADED SUGGESTION", @$_SESSION['systemLang']) : language("READED SUGGESTION", @$_SESSION['systemLang']) ?>"></i></td>
                                        <?php } ?>
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
        
    <?php } else { ?>
        <!-- start edit profile page -->
        <div class="container">
            <!-- start header -->
            <header class="header">
                <?php
                    $msg = '<h3 class="alert alert-danger  text-capitalize">'. language('THERE IS NO ID LIKE THAT',  @$_SESSION['systemLang']) .'</h3>';
                    redirectHome($msg, "back");
                ?>
            </header>
        </div>
    <?php } ?> 
</div>