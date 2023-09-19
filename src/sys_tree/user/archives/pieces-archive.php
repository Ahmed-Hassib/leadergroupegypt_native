<?php $type = isset($_GET['type']) && !empty($_GET['type']) ? $_GET['type'] : "manage" ?>
<!-- start home stats container -->
<div class="container" dir="<?php echo $page_dir ?>">
  <?php if ($type == "manage") { ?>
    <!-- start header -->
    <header class="mb-3 header">
      <h1 class="h1 text-capitalize"><?php echo lang('ARCHIVE', @$_SESSION['sys']['lang']) ?></h1>
      <h5 class="h5 text-secondary text-capitalize "><?php echo lang('PIECES/CLIENTS ARCHIVE', @$_SESSION['sys']['lang']) ?></h5>
    </header>
    <!-- end header -->
    <div class="mb-3 row row-cols-sm-1 row-cols-md-4 g-3">
      <div class="col-sm-12">
        <div class="card card-stat bg-secondary bg-gradient">
          <div class="card-body">
            <i class="bi bi-arrow-left"></i>
            <span>
              <a href="index.php" class="stretched-link text-capitalize">
                <?php echo lang('BACK', @$_SESSION['sys']['lang']) ?>
              </a>
            </span>
          </div>
        </div>
      </div>
      <div class="col-sm-12">
        <div class="card card-stat bg-primary bg-gradient">
          <div class="card-body">
            <i class="bi bi-dice-5"></i>
            <span>
              <a href="?do=piecesArchive&type=pieces" class="stretched-link text-capitalize">
                <?php echo lang('PIECES ARCHIVE', @$_SESSION['sys']['lang']) ?>
              </a>
            </span>
          </div>
        </div>
      </div>
      <div class="col-sm-12">
        <div class="card card-stat bg-primary bg-gradient">
          <div class="card-body">
            <i class="bi bi-people"></i>
            <span>
              <a href="?do=piecesArchive&type=clients" class="stretched-link text-capitalize">
                <?php echo lang('CLIENTS ARCHIVE', @$_SESSION['sys']['lang']) ?>
              </a>
            </span>
          </div>
        </div>
      </div>
    </div>
  <?php } elseif ($type != "manage") {
    // get added_date value
    $added_date = isset($_GET['added_date']) && !empty($_GET['added_date']) ? $_GET['added_date'] : 0;
    // check the value of added_date
    // if not assigned
    // display all dates in database
    if ($added_date == 0) {
      // check the type of query
      // if type == pieces
      if ($type == "pieces") {
        $q = "SELECT DISTINCT(`added_date`) FROM `pieces` WHERE `type_id` != 4 ORDER BY `added_date` ASC;";
        // prepare statment
        $stmt = $con->prepare($q);
        $stmt->execute(); // execute query
        $rows = $stmt->fetchAll(); // fetch data
        $count = $stmt->rowCount();

      ?>
        <!-- start header -->
        <header class="mb-3 header">
          <h1 class="h1 text-capitalize"><?php echo lang('ARCHIVE', @$_SESSION['sys']['lang']) ?></h1>
          <h5 class="h5 text-secondary text-capitalize "><?php echo lang('PIECES ARCHIVE', @$_SESSION['sys']['lang']) ?></h5>
        </header>
        <!-- end header -->
        <div class="mb-5 row row-cols-sm-2 row-cols-md-4 row-cols-lg-6 g-3">
          <?php if ($count > 0) { ?>
            <?php $counter = 0; ?>
            <?php foreach ($rows as $key => $row) { ?>
              <div class="col-6">
                <div class="card card-stat bg-primary bg-gradient">
                  <div class="card-body">
                    <i class="bi bi-calendar-month"></i>
                    <span class="nums">
                      <a href="?do=piecesArchive&type=pieces&added_date=<?php echo $row['added_date'] ?>" class="stretched-link">
                        <?php $piecesNum = countRecords("`id`", "`pieces`", "WHERE `added_date` = '".$row['added_date']."' AND `pieces`.`type_id` != 4") ?>
                        <span> <?php echo $row['added_date'] ?></span><br>
                        <span class="fs-16" dir="<?php echo $page_dir ?>">
                          <span class="text-capitalize"><?php echo lang("TOTAL", @$_SESSION['sys']['lang']) . " " . lang("PIECES", @$_SESSION['sys']['lang']) ?> = </span>
                          <span class="num" data-goal="<?php echo $piecesNum ?>">0</span>
                        </span>
                      </a>
                    </span>
                  </div>
                </div>
              </div>
            <?php } ?>
          <?php } ?>
        </div>
      <?php } elseif ($type == "clients") {
        $q = "SELECT DISTINCT(`added_date`) FROM `pieces` WHERE `type_id` = 4 ORDER BY `added_date` ASC;";
        // prepare statment
        $stmt = $con->prepare($q);
        $stmt->execute(); // execute query
        $rows = $stmt->fetchAll(); // fetch data
        $count = $stmt->rowCount();

      ?>
        <!-- start header -->
        <header class="mb-3 header">
          <h1 class="h1 text-capitalize"><?php echo lang('ARCHIVE', @$_SESSION['sys']['lang']) ?></h1>
          <h5 class="h5 text-secondary text-capitalize "><?php echo lang('CLIENTS ARCHIVE', @$_SESSION['sys']['lang']) ?></h5>
        </header>
        <!-- end header -->
        <div class="mb-5 row row-cols-sm-2 row-cols-md-4 row-cols-lg-6 g-3">
          <?php if ($count > 0) { ?>
            <?php #$counter = 0; ?>
            <?php foreach ($rows as $key => $row) { ?>
              <div class="col-6">
                <div class="card card-stat bg-primary bg-gradient">
                  <div class="card-body">
                    <i class="bi bi-calendar-month"></i>
                    <span class="nums">
                      <a href="?do=piecesArchive&type=clients&added_date=<?php echo $row['added_date'] ?>" class="stretched-link">
                        <?php $clientsNum = countRecords("`id`", "`pieces`", "WHERE `added_date` = '".$row['added_date']."' AND `pieces`.`type_id` = 4") ?>
                        <span> <?php echo $row['added_date'] ?></span><br>
                        <span class="fs-16" dir="<?php echo $page_dir ?>">
                          <span class="text-capitalize"><?php echo lang("TOTAL", @$_SESSION['sys']['lang']) . " " . lang("CLIENTS", @$_SESSION['sys']['lang']) ?> = </span>
                          <span class="num" data-goal="<?php echo $clientsNum ?>">0</span>
                        </span>
                      </a>
                    </span>
                  </div>
                </div>
              </div>
              <?php #$counter += $clientsNum ?>
            <?php } ?>
            <?php #echo $counter ?>
          <?php } ?>
        </div>
      <?php } else { ?>
        <!-- start edit profile page -->
        <div class="my-5 container">
          <!-- start header -->
          <header class="header">
            <h1 class="h1 text-capitalize"><?php echo lang('ARCHIVE', @$_SESSION['sys']['lang']) ?></h1>
            <?php
              // error message
              $msg = '<div class="alert alert-danger text-capitalize"><i class="bi bi-exclamation-triangle-fill"></i>&nbsp;'.lang('WRONG CHOISE', @$_SESSION['sys']['lang']).'</div>';
              // redirect to home page
              redirect_home($msg, "back");
            ?>
          </header>
        </div>
      <?php } ?>
    <?php } else {
      // check the type of query
      // if type == pieces
      if ($type == "pieces") {
        // number of page
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        // previous page
        $previousPage = $page - 1;
        // next page
        $nextPage = $page + 1;
        
        //  check if number of rows per page is set
        if (isset($_POST['rowsPerPage'])) {
          $_SESSION['sys']['rowsPerPage'] = $_POST['rowsPerPage'];
        }

        // start from
        $startFrom = ($page - 1) * $_SESSION['sys']['rowsPerPage'];

        // query statement
        $q = "SELECT 
            `pieces`.*, 
            `pieces_addr`.`address`, 
            `pieces_phone`.`phone`,
            `pieces_additional`.`ssid`,
            `pieces_additional`.`pass_connection`,
            `pieces_additional`.`frequency`,
            `pieces_additional`.`device_type`
          FROM 
            `pieces`
          LEFT JOIN `pieces_addr` ON `pieces_addr`.`id` = `pieces`.`id` 
          LEFT JOIN `pieces_phone` ON `pieces_phone`.`id` = `pieces`.`id`
          LEFT JOIN `pieces_additional` ON `pieces_additional`.`id` = `pieces`.`id`
          WHERE 
            `type_id` != 4 AND `added_date` = '".$added_date."'
          ORDER BY 
            `pieces`.`direction_id` ASC, 
            `pieces`.`direct` DESC, 
            `pieces`.`type_id` ASC";

        $limitation = ' LIMIT '.$startFrom.', '.$_SESSION['sys']['rowsPerPage'].';';
        $query = $q . $limitation;

        // prepare statment
        $stmt = $con->prepare($query);
        $stmt->execute(); // execute query
        $rows = $stmt->fetchAll(); // fetch data

        // prepare statment
        $st = $con->prepare($q);
        $st->execute(); // execute query
        $rs = $st->fetchAll(); // fetch data

        // get row count
        $count = $st->rowCount();
        // total pages
        $totalPages = ceil($count / $_SESSION['sys']['rowsPerPage']);

        $columns = array(
          "ip"                => "IP", 
          "mac-add"           => "MAC ADD", 
          "name"              => "CLIENT NAME", 
          "username"          => "USERNAME", 
          "pass"              => "PASSWORD", 
          "dir"               => "THE DIRECTION", 
          "src"               => "THE SOURCE", 
          "ssid"              => "SSID" , 
          "pass-conn"         => "PASSWORD CONNECTION" , 
          "freq"              => "FREQUENCY", 
          "dev-type"          => "DEVICE TYPE", 
          "conn-type"         => "CONNECTION TYPE", 
          "addr"              => "THE ADDRESS", 
          "phone"             => "PHONE", 
          "type"              => "THE TYPE", 
          "notes"             => "THE NOTES",
          "avg-ping"          => "AVG PING",
          "pack-loss"         => "PACKET LOSS",
          "direct"            => "CONNECTION", 
          "adedd-date"        => "ADDED DATE", 
          "adedd-by"          => "ADDED BY",
        );

      ?>
        <!-- start header -->
        <header class="mb-3 header">
          <h1 class="h1 text-capitalize"><?php echo lang('ARCHIVE', @$_SESSION['sys']['lang']) ?></h1>
          <h5 class="h5 text-secondary text-capitalize "><?php echo lang('PIECES ARCHIVE', @$_SESSION['sys']['lang']) ?></h5>
          <h6 class="h6 text-secondary text-capitalize " dir="<?php echo $page_dir ?>"><?php echo lang("ADDED DATE", @$_SESSION['sys']['lang']) . " = " . $added_date ?></h6>
          <div class="search-box row row-cols-sm-1">
            <div class="col">
              <input type="text" class="form-control w-100" name="search" id="search" placeholder="search" onkeyup="tableFiltration(this)">
            </div>
          </div>
          <!-- end users table -->
          <?php if ($count > 50) { ?>
            <!-- pagination navbar -->
            <nav class="m-3" style="<?php echo $totalPages > 10 ? 'overflow-x: scroll' : '' ?>" aria-label="Page navigation example">
              <ul class="pagination pagination-sm <?php echo $totalPages <= 20 ? 'justify-content-center' : '' ?> " data-current="<?php echo $page ?>">
                <li class="page-item <?php echo $previousPage == 0 ? 'disabled' : '' ?>"><a class="page-link" id="previousBtn" href="archives.php?do=piecesArchive&type=pieces&added_date=2021-08-04&page=<?php echo $previousPage; ?>"><i class="bi bi-arrow-left"></i></a></li>
                <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                  <li class="page-item <?php echo $page == $i ? "active" : "" ?>"><a class="page-link" href="archives.php?do=piecesArchive&type=pieces&added_date=2021-08-04&page=<?php echo $i ?>"><?php echo $i ?></a></li>
                <?php } ?>
                <li class="page-item <?php echo $nextPage > $totalPages ? 'disabled' : '' ?>"><a class="page-link" id="previousBtn" href="archives.php?do=piecesArchive&type=pieces&added_date=2021-08-04&page=<?php echo $nextPage; ?>"><i class="bi bi-arrow-right"></i></a></li>
              </ul>
            </nav>

            <div style="width: 200px">
              <form action="?do=piecesArchive&type=pieces&added_date=<?php echo $added_date ?>" method="POST">
                <div class="col-sm-12 col-md-8">
                  <select class="form-select" name="rowsPerPage" id="rowPerPage" onchange="submitForm(this)">
                    <option value="10" <?php echo $_SESSION['sys']['rowsPerPage'] == 10 ? 'selected' : ''; ?>>10</option>
                    <option value="25" <?php echo $_SESSION['sys']['rowsPerPage'] == 25 ? 'selected' : ''; ?>>25</option>
                    <option value="50" <?php echo $_SESSION['sys']['rowsPerPage'] == 50 ? 'selected' : ''; ?>>50 (Recommended)</option>
                    <option value="100" <?php echo $_SESSION['sys']['rowsPerPage'] == 100 ? 'selected' : ''; ?>>100</option>
                    <option value="500" <?php echo $_SESSION['sys']['rowsPerPage'] == 500 ? 'selected' : ''; ?>>500</option>
                  </select>
                </div>
              </form>
            </div>
          <?php } ?>

        </header>
        <!-- start table container -->
        <div class="table-responsive-sm">
          <div class="fixed-scroll-btn">
            <!-- scroll left button -->
            <button type="button" role="button" class="scroll-button scroll-prev scroll-prev-right">
              <i class="carousel-control-prev-icon"></i>
            </button>
            <!-- scroll right button -->
            <button type="button" role="button" class="scroll-button scroll-next <?php echo $_SESSION['sys']['lang'] == 'ar' ? 'scroll-next-left' : 'scroll-next-right' ?>">
              <i class="carousel-control-next-icon"></i>
            </button>
          </div>
          <!-- strst users table -->
          <table class="table table-bordered  display compact table-style" id="all-pieces" >
            <thead class="primary text-capitalize">
              <tr>
                <th class="d-none">ID</th>
                <th style="min-width: 50px" data-order="asc" data-col-type="number">#</th>
                <th style="min-width: 200px" data-col="ip" data-order="asc" data-col-type="ip" class="text-uppercase"><?php echo lang('IP', @$_SESSION['sys']['lang']) ?></th>
                <th style="min-width: 200px" data-col="mac-add" data-order="asc" data-col-type="string" class="text-uppercase"><?php echo lang('MAC ADD', @$_SESSION['sys']['lang']) ?></th>
                <th style="min-width: 200px" data-col="name" data-order="asc" data-col-type="string"><?php echo lang('CLIENT NAME', @$_SESSION['sys']['lang']) ?></th>
                <th style="min-width: 200px" data-col="username" data-order="asc" data-col-type="string"><?php echo lang('USERNAME', @$_SESSION['sys']['lang']) ?></th>
                <th style="min-width: 200px" data-col="pass" data-order="asc" data-col-type="string"><?php echo lang('PASSWORD', @$_SESSION['sys']['lang']) ?></th>
                <th style="min-width: 200px" data-col="dir" data-order="asc" data-col-type="string"><?php echo lang('THE DIRECTION', @$_SESSION['sys']['lang']) ?></th>
                <th style="min-width: 200px" data-col="src" data-order="asc" data-col-type="ip"><?php echo lang('THE SOURCE', @$_SESSION['sys']['lang']) ?></th>
                <th style="min-width: 100px" data-col="ssid"><?php echo lang('SSID', @$_SESSION['sys']['lang']) ?></th>
                <th style="min-width: 200px" data-col="pass-conn"><?php echo lang('PASSWORD CONNECTION', @$_SESSION['sys']['lang']) ?></th>
                <th style="min-width: 100px" data-col="freq"><?php echo lang('FREQUENCY', @$_SESSION['sys']['lang']) ?></th>
                <th style="min-width: 200px" data-col="dev-type" data-order="asc" data-col-type="string"><?php echo lang('DEVICE TYPE', @$_SESSION['sys']['lang']) ?></th>
                <th style="min-width: 100px" data-col="conn-type" data-order="asc" data-col-type="string"><?php echo lang('CONNECTION TYPE', @$_SESSION['sys']['lang']) ?></th>
                <th style="min-width: 200px" data-col="addr"><?php echo lang('THE ADDRESS', @$_SESSION['sys']['lang']) ?></th>
                <th style="min-width: 200px" data-col="phone" data-order="asc" data-col-type="string"><?php echo lang('PHONE', @$_SESSION['sys']['lang']) ?></th>
                <th style="min-width: 100px" data-col="type" data-order="asc" data-col-type="string"><?php echo lang('THE TYPE', @$_SESSION['sys']['lang']) ?></th>
                <th style="min-width: 200px" data-col="notes" data-order="asc" data-col-type="string"><?php echo lang('THE NOTES', @$_SESSION['sys']['lang']) ?></th>
                <th style="min-width: 200px" data-col="avg-ping" >avg ping</th>
                <th style="min-width: 200px" data-col="pack-loss" >packet loss</th>
                <th style="min-width: 100px" data-col="direct" data-order="asc" data-col-type="string"><?php echo lang('CONNECTION', @$_SESSION['sys']['lang']) ?></th>
                <th style="min-width: 200px" data-col="adedd-date" data-order="asc" data-col-type="string"><?php echo lang('ADDED DATE', @$_SESSION['sys']['lang']) ?></th>
                <th style="min-width: 100px" data-col="adedd-by" data-order="asc" data-col-type="string"><?php echo lang('ADDED BY', @$_SESSION['sys']['lang']) ?></th>
                <th style="min-width: 200px"><?php echo lang('CONTROL', @$_SESSION['sys']['lang']) ?></th>
              </tr>
            </thead>
            <tbody id="piecesTbl" name="pieces">
              <?php $index = $startFrom; ?>
              <?php foreach ($rows as $row) { ?>
                <tr>
                  <td class="d-none"><?php echo $row['id']; ?></td>
                  <td><?php echo ++$index; ?></td>
                  <td data-ip="<?php echo convert_ip($row['piece_ip']) ?>"><?php echo $row['piece_ip'] == 1 ? 'لا يوجد' :"<a href='http://" . $row['piece_ip'] . "' target='_blank'>" . $row['piece_ip'] . '</a>'; ?></td>
                  <td class="<?php echo !empty($row['mac_add']) ? "" : "text-danger " ?>"><?php echo !empty($row['mac_add']) ? $row['mac_add'] : lang("NO DATA ENTERED", @$_SESSION['sys']['lang']) ?></td>
                  <td><?php echo $row['piece_name']; ?></td>
                  <td>
                    <a href="pieces.php?do=edit-piece&piece-id=<?php echo $row['id']; ?>">
                      <?php echo $row['username']; ?>
                    </a>
                  </td>
                  <td><?php echo $row['piece_pass']; ?></td>
                  <td>
                    <?php if ($row['direction_id'] != 0) { ?>
                      <a href="directions.php?do=showDir&dirId=<?php echo $row['direction_id']; ?>">
                        <?php echo selectSpecificColumn("`direction_name`", "`direction`", "WHERE `direction_id` = ".$row['direction_id'])[0]['direction_name']; ?>
                      </a>
                    <?php } else { ?>
                      <p class="text-danger "><?php echo lang("NO DATA ENTERED", @$_SESSION['sys']['lang']) ?></p>
                    <?php } ?>
                  </td>
                  <?php $sourceip = $row['source_id'] == 0 ? $row['piece_ip'] : selectSpecificColumn('piece_ip','pieces','WHERE id = ' . $row['source_id'])[0]['piece_ip']; ?>
                  <td data-ip="<?php echo convert_ip($sourceip) ;?>"> 
                    <?php echo '<a href="http://' . $sourceip . '" target="">' . $sourceip . '</a>'; ?>
                  </td>
                  <td><?php echo $row['ssid']; ?></td>
                  <td><?php echo $row['pass_connection']; ?></td>
                  <td><?php echo $row['frequency']; ?></td>
                  <td>
                    <?php if (!empty($row['device_type'])) { ?>
                      <?php echo $row['device_type'] ?></td>
                    <?php } else { ?>
                      <p class="text-danger "><?php echo lang("NO DATA ENTERED", @$_SESSION['sys']['lang']) ?></p>
                    <?php } ?>
                  <td><?php echo $row['conn_type']; ?></td>
                  <td><?php  echo $row['address'] == '' ? 'لا يوجد' : $row['address']; ?></td>
                  <td><?php echo $row['phone'] == '' ? 'لا يوجد' : $row['phone']; ?></td>
                  <td>
                    <?php if ($row['type_id'] != 0) { ?>
                      <?php echo selectSpecificColumn("`type_name`", "`types`", "WHERE `type_id` = ". $row['type_id'])[0]['type_name']; ?></td>
                    <?php } else { ?>
                      <p class="text-danger "><?php echo lang("NO DATA ENTERED", @$_SESSION['sys']['lang']) ?></p>
                    <?php } ?>
                  <td><?php echo $row['notes']; ?></td>
                  <td class="text-capitalize">
                    <?php if ($row['piece_ip'] == 1) {
                      echo 'لا يوجد';
                    } else {
                      echo '-----';
                    } ?>
                  </td>
                  <td class="text-capitalize">
                    <?php if ($row['piece_ip'] == 1) {
                      echo 'لا يوجد';
                    } else {
                      echo '-----';
                    } ?>
                  </td>
                  <td><?php echo $row['direct'] == 0 ? lang('NOT DIRECT', @$_SESSION['sys']['lang']) : lang('DIRECT', @$_SESSION['sys']['lang']); ?></td>
                  <td><?php echo $row['added_date'] == '0000-00-00' ? lang("NO DATA ENTERED", @$_SESSION['sys']['lang']) : $row['added_date'] ?></td>
                  <td><?php echo selectSpecificColumn("`UserName`", "`users`", "WHERE `UserID` = ". $row['added_by'])[0]["UserName"]; ?></td>
                  <td>
                    <a class="btn btn-success text-capitalize fs-12 <?php if ($_SESSION['sys']['pcs_update'] == 0) {echo 'd-none';} ?>" href="pieces.php?do=edit-piece&piece-id=<?php echo $row['id']; ?>" target=""><i class="bi bi-pencil-square"></i><!-- <?php echo lang('EDIT', @$_SESSION['sys']['lang']) ?> --></a>
                    <?php if ($row['type_id'] != 4) { ?>
                      <a class="btn btn-outline-primary text-capitalize fs-12 <?php if ($_SESSION['sys']['pcs_show'] == 0) {echo 'd-none';} ?>" href="?do=show-piece&dir-id=<?php echo $row['direction_id'] ?>&srcId=<?php echo $row['id'] ?>" ><i class="bi bi-eye"></i><!-- <?php echo lang('SHOW', @$_SESSION['sys']['lang']).' '.lang('PIECES', @$_SESSION['sys']['lang']) ?> --></a>
                    <?php } ?>
                    <?php if ($row['piece_ip'] != 1) { ?>
                      <button class="btn btn-outline-secondary text-capitalize fs-12" onclick="ping(this)" value="<?php echo $row['piece_ip']; ?>">ping</button>
                    <?php } ?>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
        <!-- end table container -->
        <div class="cdrop-container">
          <div class="cdrop" data-open="0" onclick="showHideList(this.children[0])"><i class="bi bi-caret-down-square"></i></div>

          <div class="clist">
            <div class="lDiv">
              <?php $i = 0; ?>
              <?php foreach ($columns as $key => $col) { ?>
                <div>
                  <input type="checkbox" id="col-<?php echo $i + 1 ?>" onclick="showHideColumn(this, 'piecesTbl')" data-col="<?php echo $key ?>" >&nbsp;
                  <label for="col-<?php echo $i + 1 ?>"><?php echo lang($col, @$_SESSION['sys']['lang']) ?></label>
                </div>
              <?php $i++; ?>
              <?php } ?>
              <!-- input for show all columns -->
              <div>
                <input type="checkbox" name="show-all" id="show-all" onclick="showHideAllColumns()">&nbsp;
                <label for="show-all"><?php echo lang('SHOW ALL', @$_SESSION['sys']['lang']) ?></label>
              </div>
            </div>
          </div>
        </div>
      <?php } elseif ($type == "clients") {
        // number of page
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        // previous page
        $previousPage = $page - 1;
        // next page
        $nextPage = $page + 1;
        
        //  check if number of rows per page is set
        if (isset($_POST['rowsPerPage'])) {
          $_SESSION['sys']['rowsPerPage'] = $_POST['rowsPerPage'];
        }

        // start from
        $startFrom = ($page - 1) * $_SESSION['sys']['rowsPerPage'];

        // query statement
        $q = "SELECT 
            `pieces`.*, 
            `pieces_addr`.`address`, 
            `pieces_phone`.`phone`,
            `pieces_additional`.`ssid`,
            `pieces_additional`.`pass_connection`,
            `pieces_additional`.`frequency`,
            `pieces_additional`.`device_type`
          FROM 
            `pieces`
          LEFT JOIN `pieces_addr` ON `pieces_addr`.`id` = `pieces`.`id` 
          LEFT JOIN `pieces_phone` ON `pieces_phone`.`id` = `pieces`.`id`
          LEFT JOIN `pieces_additional` ON `pieces_additional`.`id` = `pieces`.`id`
          WHERE 
            `type_id` = 4 AND `added_date` = '".$added_date."'
          ORDER BY 
            `pieces`.`direction_id` ASC, 
            `pieces`.`direct` DESC, 
            `pieces`.`type_id` ASC";

        $limitation = ' LIMIT '.$startFrom.', '.$_SESSION['sys']['rowsPerPage'].';';
        $query = $q . $limitation;

        // prepare statment
        $stmt = $con->prepare($query);
        $stmt->execute(); // execute query
        $rows = $stmt->fetchAll(); // fetch data

        // prepare statment
        $st = $con->prepare($q);
        $st->execute(); // execute query
        $rs = $st->fetchAll(); // fetch data

        // get row count
        $count = $st->rowCount();
        // total pages
        $totalPages = ceil($count / $_SESSION['sys']['rowsPerPage']);

        $columns = array(
          "ip"                => "IP", 
          "mac-add"           => "MAC ADD", 
          "name"              => "CLIENT NAME", 
          "username"          => "USERNAME", 
          "pass"              => "PASSWORD", 
          "dir"               => "THE DIRECTION", 
          "src"               => "THE SOURCE", 
          "ssid"              => "SSID" , 
          "pass-conn"         => "PASSWORD CONNECTION" , 
          "freq"              => "FREQUENCY", 
          "dev-type"          => "DEVICE TYPE", 
          "conn-type"         => "CONNECTION TYPE", 
          "addr"              => "THE ADDRESS", 
          "phone"             => "PHONE", 
          "type"              => "THE TYPE", 
          "notes"             => "THE NOTES",
          "avg-ping"          => "AVG PING",
          "pack-loss"         => "PACKET LOSS",
          "direct"            => "CONNECTION", 
          "adedd-date"        => "ADDED DATE", 
          "adedd-by"          => "ADDED BY",
        );

      ?>
        <!-- start header -->
        <header class="mb-3 header">
          <h1 class="h1 text-capitalize"><?php echo lang('ARCHIVE', @$_SESSION['sys']['lang']) ?></h1>
          <h5 class="h5 text-secondary text-capitalize "><?php echo lang('CLIENTS ARCHIVE', @$_SESSION['sys']['lang']) ?></h5>
          <h6 class="h6 text-secondary text-capitalize " dir="<?php echo $page_dir ?>"><?php echo lang("ADDED DATE", @$_SESSION['sys']['lang']) . " = " . $added_date ?></h6>
          <div class="search-box row row-cols-sm-1">
            <div class="col">
              <input type="text" class="form-control w-100" name="search" id="search" placeholder="search" onkeyup="tableFiltration(this)">
            </div>
          </div>
          <!-- end users table -->
          <?php if ($count > 50) { ?>
            <!-- pagination navbar -->
            <nav class="m-3" style="<?php echo $totalPages > 10 ? 'overflow-x: scroll' : '' ?>" aria-label="Page navigation example">
              <ul class="pagination pagination-sm <?php echo $totalPages <= 20 ? 'justify-content-center' : '' ?> " data-current="<?php echo $page ?>">
                <li class="page-item <?php echo $previousPage == 0 ? 'disabled' : '' ?>"><a class="page-link" id="previousBtn" href="archives.php?do=piecesArchive&type=clients&added_date=2021-08-04&page=<?php echo $previousPage; ?>"><i class="bi bi-arrow-left"></i></a></li>
                <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                  <li class="page-item <?php echo $page == $i ? "active" : "" ?>"><a class="page-link" href="archives.php?do=piecesArchive&type=clients&added_date=2021-08-04&page=<?php echo $i ?>"><?php echo $i ?></a></li>
                <?php } ?>
                <li class="page-item <?php echo $nextPage > $totalPages ? 'disabled' : '' ?>"><a class="page-link" id="previousBtn" href="archives.php?do=piecesArchive&type=clients&added_date=2021-08-04&page=<?php echo $nextPage; ?>"><i class="bi bi-arrow-right"></i></a></li>
              </ul>
            </nav>

            <div style="width: 200px">
              <form action="?do=piecesArchive&type=clients&added_date=<?php echo $added_date ?>" method="POST">
                <div class="col-sm-12 col-md-8">
                  <select class="form-select" name="rowsPerPage" id="rowPerPage" onchange="submitForm(this)">
                    <option value="10" <?php echo $_SESSION['sys']['rowsPerPage'] == 10 ? 'selected' : ''; ?>>10</option>
                    <option value="25" <?php echo $_SESSION['sys']['rowsPerPage'] == 25 ? 'selected' : ''; ?>>25</option>
                    <option value="50" <?php echo $_SESSION['sys']['rowsPerPage'] == 50 ? 'selected' : ''; ?>>50 (Recommended)</option>
                    <option value="100" <?php echo $_SESSION['sys']['rowsPerPage'] == 100 ? 'selected' : ''; ?>>100</option>
                    <option value="500" <?php echo $_SESSION['sys']['rowsPerPage'] == 500 ? 'selected' : ''; ?>>500</option>
                  </select>
                </div>
              </form>
            </div>
          <?php } ?>

        </header>
        <!-- start table container -->
        <div class="table-responsive-sm">
          <div class="fixed-scroll-btn">
            <!-- scroll left button -->
            <button type="button" role="button" class="scroll-button scroll-prev scroll-prev-right">
              <i class="carousel-control-prev-icon"></i>
            </button>
            <!-- scroll right button -->
            <button type="button" role="button" class="scroll-button scroll-next <?php echo $_SESSION['sys']['lang'] == 'ar' ? 'scroll-next-left' : 'scroll-next-right' ?>">
              <i class="carousel-control-next-icon"></i>
            </button>
          </div>
          <!-- strst users table -->
          <table class="table table-bordered  display compact table-style" id="all-pieces" >
            <thead class="primary text-capitalize">
              <tr>
                <th class="d-none">ID</th>
                <th style="min-width: 50px" data-order="asc" data-col-type="number">#</th>
                <th style="min-width: 200px" data-col="ip" data-order="asc" data-col-type="ip" class="text-uppercase"><?php echo lang('IP', @$_SESSION['sys']['lang']) ?></th>
                <th style="min-width: 200px" data-col="mac-add" data-order="asc" data-col-type="string" class="text-uppercase"><?php echo lang('MAC ADD', @$_SESSION['sys']['lang']) ?></th>
                <th style="min-width: 200px" data-col="name" data-order="asc" data-col-type="string"><?php echo lang('CLIENT NAME', @$_SESSION['sys']['lang']) ?></th>
                <th style="min-width: 200px" data-col="username" data-order="asc" data-col-type="string"><?php echo lang('USERNAME', @$_SESSION['sys']['lang']) ?></th>
                <th style="min-width: 200px" data-col="pass" data-order="asc" data-col-type="string"><?php echo lang('PASSWORD', @$_SESSION['sys']['lang']) ?></th>
                <th style="min-width: 200px" data-col="dir" data-order="asc" data-col-type="string"><?php echo lang('THE DIRECTION', @$_SESSION['sys']['lang']) ?></th>
                <th style="min-width: 200px" data-col="src" data-order="asc" data-col-type="ip"><?php echo lang('THE SOURCE', @$_SESSION['sys']['lang']) ?></th>
                <th style="min-width: 100px" data-col="ssid"><?php echo lang('SSID', @$_SESSION['sys']['lang']) ?></th>
                <th style="min-width: 200px" data-col="pass-conn"><?php echo lang('PASSWORD CONNECTION', @$_SESSION['sys']['lang']) ?></th>
                <th style="min-width: 100px" data-col="freq"><?php echo lang('FREQUENCY', @$_SESSION['sys']['lang']) ?></th>
                <th style="min-width: 200px" data-col="dev-type" data-order="asc" data-col-type="string"><?php echo lang('DEVICE TYPE', @$_SESSION['sys']['lang']) ?></th>
                <th style="min-width: 100px" data-col="conn-type" data-order="asc" data-col-type="string"><?php echo lang('CONNECTION TYPE', @$_SESSION['sys']['lang']) ?></th>
                <th style="min-width: 200px" data-col="addr"><?php echo lang('THE ADDRESS', @$_SESSION['sys']['lang']) ?></th>
                <th style="min-width: 200px" data-col="phone" data-order="asc" data-col-type="string"><?php echo lang('PHONE', @$_SESSION['sys']['lang']) ?></th>
                <th style="min-width: 100px" data-col="type" data-order="asc" data-col-type="string"><?php echo lang('THE TYPE', @$_SESSION['sys']['lang']) ?></th>
                <th style="min-width: 200px" data-col="notes" data-order="asc" data-col-type="string"><?php echo lang('THE NOTES', @$_SESSION['sys']['lang']) ?></th>
                <th style="min-width: 200px" data-col="avg-ping" >avg ping</th>
                <th style="min-width: 200px" data-col="pack-loss" >packet loss</th>
                <th style="min-width: 100px" data-col="direct" data-order="asc" data-col-type="string"><?php echo lang('CONNECTION', @$_SESSION['sys']['lang']) ?></th>
                <th style="min-width: 200px" data-col="adedd-date" data-order="asc" data-col-type="string"><?php echo lang('ADDED DATE', @$_SESSION['sys']['lang']) ?></th>
                <th style="min-width: 100px" data-col="adedd-by" data-order="asc" data-col-type="string"><?php echo lang('ADDED BY', @$_SESSION['sys']['lang']) ?></th>
                <th style="min-width: 200px"><?php echo lang('CONTROL', @$_SESSION['sys']['lang']) ?></th>
              </tr>
            </thead>
            <tbody id="piecesTbl" name="pieces">
              <?php $index = $startFrom; ?>
              <?php foreach ($rows as $row) { ?>
                <tr>
                  <td class="d-none"><?php echo $row['id']; ?></td>
                  <td><?php echo ++$index; ?></td>
                  <td data-ip="<?php echo convert_ip($row['piece_ip']) ?>"><?php echo $row['piece_ip'] == 1 ? 'لا يوجد' :"<a href='http://" . $row['piece_ip'] . "' target='_blank'>" . $row['piece_ip'] . '</a>'; ?></td>
                  <td class="<?php echo !empty($row['mac_add']) ? "" : "text-danger " ?>"><?php echo !empty($row['mac_add']) ? $row['mac_add'] : lang("NO DATA ENTERED", @$_SESSION['sys']['lang']) ?></td>
                  <td><?php echo $row['piece_name']; ?></td>
                  <td>
                    <a href="pieces.php?do=edit-piece&piece-id=<?php echo $row['id']; ?>">
                      <?php echo $row['username']; ?>
                    </a>
                  </td>
                  <td><?php echo $row['piece_pass']; ?></td>
                  <td>
                    <?php if ($row['direction_id'] != 0) { ?>
                      <a href="directions.php?do=showDir&dirId=<?php echo $row['direction_id']; ?>">
                        <?php echo selectSpecificColumn("`direction_name`", "`direction`", "WHERE `direction_id` = ".$row['direction_id'])[0]['direction_name']; ?>
                      </a>
                    <?php } else { ?>
                      <p class="text-danger "><?php echo lang("NO DATA ENTERED", @$_SESSION['sys']['lang']) ?></p>
                    <?php } ?>
                  </td>
                  <?php $sourceip = $row['source_id'] == 0 ? $row['piece_ip'] : selectSpecificColumn('piece_ip','pieces','WHERE id = ' . $row['source_id'])[0]['piece_ip']; ?>
                  <td data-ip="<?php echo convert_ip($sourceip) ;?>"> 
                    <?php echo '<a href="http://' . $sourceip . '" target="">' . $sourceip . '</a>'; ?>
                  </td>
                  <td><?php echo $row['ssid']; ?></td>
                  <td><?php echo $row['pass_connection']; ?></td>
                  <td><?php echo $row['frequency']; ?></td>
                  <td>
                    <?php if (!empty($row['device_type'])) { ?>
                      <?php echo $row['device_type'] ?></td>
                    <?php } else { ?>
                      <p class="text-danger "><?php echo lang("NO DATA ENTERED", @$_SESSION['sys']['lang']) ?></p>
                    <?php } ?>
                  <td><?php echo $row['conn_type']; ?></td>
                  <td><?php  echo $row['address'] == '' ? 'لا يوجد' : $row['address']; ?></td>
                  <td><?php echo $row['phone'] == '' ? 'لا يوجد' : $row['phone']; ?></td>
                  <td>
                    <?php if ($row['type_id'] != 0) { ?>
                      <?php echo selectSpecificColumn("`type_name`", "`types`", "WHERE `type_id` = ". $row['type_id'])[0]['type_name']; ?></td>
                    <?php } else { ?>
                      <p class="text-danger "><?php echo lang("NO DATA ENTERED", @$_SESSION['sys']['lang']) ?></p>
                    <?php } ?>
                  <td><?php echo $row['notes']; ?></td>
                  <td class="text-capitalize">
                    <?php if ($row['piece_ip'] == 1) {
                      echo 'لا يوجد';
                    } else {
                      echo '-----';
                    } ?>
                  </td>
                  <td class="text-capitalize">
                    <?php if ($row['piece_ip'] == 1) {
                      echo 'لا يوجد';
                    } else {
                      echo '-----';
                    } ?>
                  </td>
                  <td><?php echo $row['direct'] == 0 ? lang('NOT DIRECT', @$_SESSION['sys']['lang']) : lang('DIRECT', @$_SESSION['sys']['lang']); ?></td>
                  <td><?php echo $row['added_date'] == '0000-00-00' ? lang("NO DATA ENTERED", @$_SESSION['sys']['lang']) : $row['added_date'] ?></td>
                  <td><?php echo selectSpecificColumn("`UserName`", "`users`", "WHERE `UserID` = ". $row['added_by'])[0]["UserName"]; ?></td>
                  <td>
                    <a class="btn btn-success text-capitalize fs-12 <?php if ($_SESSION['sys']['pcs_update'] == 0) {echo 'd-none';} ?>" href="pieces.php?do=edit-piece&piece-id=<?php echo $row['id']; ?>" target=""><i class="bi bi-pencil-square"></i><!-- <?php echo lang('EDIT', @$_SESSION['sys']['lang']) ?> --></a>
                    <?php if ($row['type_id'] != 4) { ?>
                      <a class="btn btn-outline-primary text-capitalize fs-12 <?php if ($_SESSION['sys']['pcs_show'] == 0) {echo 'd-none';} ?>" href="pieces.php?do=show-piece&dir-id=<?php echo $row['direction_id'] ?>&srcId=<?php echo $row['id'] ?>" ><i class="bi bi-eye"></i><!-- <?php echo lang('SHOW', @$_SESSION['sys']['lang']).' '.lang('PIECES', @$_SESSION['sys']['lang']) ?> --></a>
                    <?php } ?>
                    <?php if ($row['piece_ip'] != 1) { ?>
                      <button class="btn btn-outline-secondary text-capitalize fs-12" onclick="ping(this)" value="<?php echo $row['piece_ip']; ?>">ping</button>
                    <?php } ?>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
        <!-- end table container -->
        <div class="cdrop-container">
          <div class="cdrop" data-open="0" onclick="showHideList(this.children[0])"><i class="bi bi-caret-down-square"></i></div>

          <div class="clist">
            <div class="lDiv">
              <?php $i = 0; ?>
              <?php foreach ($columns as $key => $col) { ?>
                <div>
                  <input type="checkbox" id="col-<?php echo $i + 1 ?>" onclick="showHideColumn(this, 'piecesTbl')" data-col="<?php echo $key ?>" >&nbsp;
                  <label for="col-<?php echo $i + 1 ?>"><?php echo lang($col, @$_SESSION['sys']['lang']) ?></label>
                </div>
              <?php $i++; ?>
              <?php } ?>
              <!-- input for show all columns -->
              <div>
                <input type="checkbox" name="show-all" id="show-all" onclick="showHideAllColumns()">&nbsp;
                <label for="show-all"><?php echo lang('SHOW ALL', @$_SESSION['sys']['lang']) ?></label>
              </div>
            </div>
          </div>
        </div>
      <?php } else { ?>
        <!-- start edit profile page -->
        <div class="my-5 container">
          <!-- start header -->
          <header class="header">
            <h1 class="h1 text-capitalize"><?php echo lang('ARCHIVE', @$_SESSION['sys']['lang']) ?></h1>
            <?php
              // error message
              $msg = '<div class="alert alert-danger text-capitalize"><i class="bi bi-exclamation-triangle-fill"></i>&nbsp;'.lang('WRONG CHOISE', @$_SESSION['sys']['lang']).'</div>';
              // redirect to home page
              redirect_home($msg, "back");
            ?>
          </header>
        </div>
      <?php } ?>
    <?php } ?>
  <?php } ?>
</div>