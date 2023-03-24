<?php
// edit piece page
// check if Get request pieceid is numeric and get the integer value
$pieceid = isset($_GET['pieceid']) && is_numeric($_GET['pieceid']) ? intval($_GET['pieceid']) : 0;
// create an object of Pieces class
$pcs_obj = new Pieces();
// get a specific piece to diplay its data and update it 
$pcs = $pcs_obj->get_spec_piece($pieceid);
// counter
$count = $pcs[0];
// piece`s data
$pcs_data = $pcs[1];
// check the row count
if ($count == true) { ?>
    <!-- start add new user page -->
    <div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
        <!-- start header -->
        <header class="header">
            <h5 class="h5 text-capitalize text-secondary "><?php if ($pcs_data['is_client'] == 0) { echo language('PIECE NAME', @$_SESSION['systemLang']); } else { echo language('CLIENT NAME', @$_SESSION['systemLang']); } ?>: <?php echo $pcs_data['piece_name']; ?></h5>
        </header>
        <!-- end header -->
        <?php $name = $pcs_data['is_client'] == 0 ? 'pieces' : 'clients' ?>
        <!-- start new design -->
        <form class="custom-form need-validation" action="?name=<?php echo $name ?>&do=updatePieceInfo" method="POST" id="editPiece">
            <!-- horzontal stack -->
            <div class="hstack gap-3">
                <h6 class="h6  text-decoration-underline text-capitalize text-danger">
                    <span><?php echo language('NOTE', @$_SESSION['systemLang']) ?>:</span>&nbsp;
                    <span><?php echo language('THIS SIGN * IS REFERE TO REQUIRED FIELDS', @$_SESSION['systemLang']) ?></span>
                </h6>
            </div>
            <!-- start piece info -->
            <div class="mb-3 row row-cols-sm-1 row-cols-md-2 g-3 align-items-stretch justify-content-start">
                <!-- first column -->
                <div class="col-12">
                    <div class="section-block">
                        <div class="section-header">
                            <h5><?php echo language('PERSONAL INFO', @$_SESSION['systemLang']) ?></h5>
                            <hr />
                        </div>
                        <!-- Id -->
                        <input type="hidden" class="form-control" id="piece-id" name="piece-id" placeholder="ID" readonly value="<?php echo $pcs_data['piece_id']; ?>"/>
                        <!-- piece name -->
                        <div class="mb-sm-2 mb-md-3 row">
                            <label for="piece-name" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('FULLNAME', @$_SESSION['systemLang']) ?></label>
                            <div class="col-sm-12 col-md-8">
                                <input type="text" class="form-control" id="piece-name" name="piece-name" placeholder="<?php echo language('FULLNAME', @$_SESSION['systemLang']) ?>" value="<?php echo $pcs_data['piece_name']; ?>" required />
                            </div>
                        </div>
                        <!-- address -->
                        <div class="mb-sm-2 mb-md-3 row">
                            <label for="address" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('THE ADDRESS', @$_SESSION['systemLang']) ?></label>
                            <div class="col-sm-12 col-md-8">
                                <input type="text" name="address" id="address" class="form-control w-100" placeholder="<?php echo language('THE ADDRESS', @$_SESSION['systemLang']) ?>" value="<?php echo $pcs_data['address']; ?>" />
                            </div>
                        </div>
                        <!-- phone -->
                        <div class="mb-sm-2 mb-md-3 row">
                            <label for="phone-number" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('PHONE', @$_SESSION['systemLang']) ?></label>
                            <div class="col-sm-12 col-md-8">
                                <input type="text" name="phone-number" id="phone-number" class="form-control w-100" placeholder="<?php echo language('PHONE', @$_SESSION['systemLang']) ?>" value="<?php echo $pcs_data['phone']; ?>" />
                            </div>
                        </div>
                        <!-- is client -->
                        <div class="mb-sm-2 mb-md-3 row">
                            <label for="is-client" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('PIECE/CLIENT', @$_SESSION['systemLang']) ?></label>
                            <div class="mt-2 col-sm-12 col-md-8">
                                <!-- SUGGESTION -->
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="is-client" id="piece" value="0" onclick="document.getElementById('types').removeAttribute('disabled');document.getElementById('types').setAttribute('required', 'required');" <?php if ($pcs_data['is_client'] == 0)  {echo 'checked';} ?>>
                                    <label class="form-check-label text-capitalize" for="piece"><?php echo language('PIECE', @$_SESSION['systemLang']) ?></label>
                                </div>
                                <!-- COMPLAINT -->
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="is-client" id="client" value="1" onclick="document.getElementById('types').setAttribute('disabled', 'disabled'); document.getElementById('types').removeAttribute('required');" <?php if ($pcs_data['is_client'] == 1)  {echo 'checked';} ?>>
                                    <label class="form-check-label text-capitalize" for="client"><?php echo language('CLIENT', @$_SESSION['systemLang']) ?></label>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="section-block">
                        <div class="section-header">
                            <h5><?php echo language('ADDITIONAL INFO', @$_SESSION['systemLang']) ?></h5>
                            <hr />
                        </div>
                        <!-- notes -->
                        <div class="mb-sm-2 mb-md-3 row">
                            <label for="notes" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('THE NOTES', @$_SESSION['systemLang']) ?></label>
                            <div class="col-sm-12 col-md-8">
                                <textarea name="notes" id="notes" title="put some notes hete if exist" class="form-control w-100" style="height: 10rem; resize: none; direction: <?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>" placeholder="<?php echo language('PUT YOUR NOTES HERE', @$_SESSION['systemLang']) ?>" ><?php echo $pcs_data['notes']; ?></textarea>
                            </div>
                        </div>
                        <!-- malfunctions -->
                        <?php $malCounter = $pcs_obj->count_records("`mal_id`", "`malfunctions`", "WHERE `client_id` = ".$pcs_data['piece_id']) ?>
                        <?php if ($malCounter > 0) { ?>
                            <!-- malfunctions counter -->
                            <div class="mb-sm-2 mb-md-3 row">
                                <label for="malfunction-counter" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('MALFUNCTIONS COUNTER', @$_SESSION['systemLang']) ?></label>
                                <div class="col-sm-12 col-md-8">
                                    <label class="col-form-label text-capitalize">
                                        <span class="m-3 me-3 text-start" dir="<?php echo @$_SESSION['systemLang'] == "ar" ? "rtl" : "ltr" ?>"><?php echo $malCounter . " " . ($malCounter > 2 ? language("MALFUNCTIONS", @$_SESSION['systemLang']) : language("MALFUNCTION", @$_SESSION['systemLang'])) ?></span>
                                        <a href="<?php echo $nav_up_level ?>malfunctions/index.php?do=showPiecesMal&pieceid=<?php echo $pcs_data['piece_id'] ?>" class="mt-2 text-start" dir="<?php echo @$_SESSION['systemLang'] == "ar" ? "rtl" : "ltr" ?>"><?php echo language("SHOW DETAILS", @$_SESSION['systemLang']) ?></a>
                                    </label>
                                </div>
                            </div>
                            <!-- malfunctions counter -->
                            <div class="mb-sm-2 mb-md-3 row">
                                <label for="malfunction-counter" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('LATEST MALFUNCTION DATE', @$_SESSION['systemLang']) ?></label>
                                <div class="col-sm-12 col-md-8">
                                    <?php $latestMalDate = $pcs_obj->get_latest_records("`added_date`", "`malfunctions`", "WHERE `client_id` = ".$pcs_data['piece_id'], "added_date", 1)[0]['added_date'] ?>
                                    <input type="text" class="form-control"  value="<?php echo $latestMalDate ?>" readonly /> 
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            
            <div class="mb-3 row row-cols-sm-1 g-3 align-items-stretch justify-content-start">
                <!-- second column -->
                <div class="col-12">
                    <div class="section-block">
                        <div class="section-header">
                            <h5><?php echo language('CONNECTION INFO', @$_SESSION['systemLang']) ?></h5>
                            <?php if ($pcs_data['is_client'] == 0)  { ?>
                                <p class="text-muted"><span><?php echo language('IF YOU WANT TO CHANGE THE DIRECTION OF THIS PIECE, THE DIRECTION OF ALL CHILDREN OF THIS PIECE -IF EXIST- WILL BE CHANGE TOO', @$_SESSION['systemLang']) ?></span></p>
                            <?php } ?>
                            <hr />
                        </div>
                        <div class="row row-cols-sm-1 row-cols-md-2 alignitems-stretch justify-content-start flex-row">
                            <div class="col-12">
                                <div class="row row-cols-sm-1">
                                    <!-- direction -->
                                    <div class="col-12">
                                        <!-- direction -->
                                        <div class="mb-sm-2 mb-md-3 row">
                                            <label for="direction" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('THE DIRECTION', @$_SESSION['systemLang']) ?></label>
                                            <div class="col-sm-12 col-md-8">
                                                <select class="form-select" id="direction" name="direction" onchange="get_sources(this, ['sources', 'alternative-sources'], <?php echo $_SESSION['company_id'] ?>, '<?php echo $dirs . $_SESSION['company_name'] ?>');" required>
                                                    <option value="default" disabled><?php echo language('SELECT', @$_SESSION['systemLang'])." ". language('THE DIRECTION', @$_SESSION['systemLang']) ?></option>
                                                    <?php
                                                    // create an object of Direction class
                                                    $dir_obj = new Direction();
                                                    // get all directions
                                                    $dirs = $dir_obj->get_all_directions($_SESSION['company_id']);
                                                    // counter
                                                    $count = $dirs[0];
                                                    // directions data
                                                    $dir_data = $dirs[1];
                                                    // check the row count
                                                    if ($count > 0) { ?>
                                                        <?php foreach ($dir_data as $dirrow) { ?>
                                                            <option value="<?php echo $dirrow['direction_id'] ?>" data-dir-ip="<?php echo $dirrow['direction_ip'] ?>" data-dir-company="<?php echo $_SESSION['company_id'] ?>" <?php echo $pcs_data['direction_id'] == $dirrow['direction_id'] ? 'selected' : '' ?> >
                                                                <?php echo  $dirrow['direction_name'] ?>
                                                            </option>
                                                        <?php } ?>
                                                    <?php } else { ?>
                                                        <option value="default" disabled selected><?php echo language('NOT AVAILABLE NOW', @$_SESSION['systemLang']) ?></option>';
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <!-- source -->
                                        <div class="mb-3 row">
                                            <label for="sources" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('THE SOURCE', @$_SESSION['systemLang']) ?></label>
                                            <div class="col-sm-12 col-md-8">
                                                <select class="form-select" id="sources" name="sourceid" required>
                                                    <option value="default" selected disabled><?php echo language('SELECT', @$_SESSION['systemLang']) ." ". language('THE SOURCE', @$_SESSION['systemLang']) ?></option>
                                                    <?php
                                                    // condition
                                                    $pcs_condition = "WHERE `is_client` = 0 AND `direction_id` = ".$pcs_data['direction_id']." AND `company_id` = ".$_SESSION['company_id']." ORDER BY `direction_id` ASC, `piece_id` ASC";
                                                    // get specific columns from pieces table
                                                    $data = $pcs_obj->select_specific_column("`piece_id`, `piece_ip`, `piece_name`", "`pieces`", $pcs_condition);
                                                    // check the result of the query
                                                    if (count($data) > 0) { ?>
                                                        <?php foreach ($data as $srcrow) { ?>
                                                            <option value="<?php echo $srcrow['piece_id'] ?>" <?php echo $pcs_data['source_id'] == $srcrow['piece_id'] ? 'selected' : '' ?> <?php echo $pcs_data['source_id'] == 0 && $pcs_data['piece_ip'] == $srcrow['piece_ip'] ? 'selected' : '' ?>>
                                                                <?php echo $srcrow['piece_ip'] . ' - ' . $srcrow['piece_name'] ?>
                                                            </option>
                                                        <?php } ?>
                                                    <?php } else { ?>
                                                        <option value="default" disabled selected><?php echo language('NOT AVAILABLE NOW', @$_SESSION['systemLang']) ?></option>';
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <!-- source -->
                                        <div class="mb-3 row">
                                            <label for="alternative-sources" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('ALTERNATIVE SOURCE', @$_SESSION['systemLang']) ?></label>
                                            <div class="col-sm-12 col-md-8">
                                                <select class="form-select" id="alternative-sources" name="alt-sourceid">
                                                    <option value="default" selected disabled><?php echo language('SELECT', @$_SESSION['systemLang']) ." ". language('ALTERNATIVE SOURCE', @$_SESSION['systemLang']) ?></option>
                                                    <?php
                                                    // check the result of the query
                                                    if (count($data) > 0) { ?>
                                                        <?php foreach ($data as $srcrow) { ?>
                                                            <option value="<?php echo $srcrow['piece_id'] ?>" <?php echo $pcs_data['alt_source_id'] == $srcrow['piece_id'] ? 'selected' : '' ?> <?php echo $pcs_data['alt_source_id'] == 0 && $pcs_data['piece_ip'] == $srcrow['piece_ip'] ? 'selected' : '' ?>>
                                                                <?php echo $srcrow['piece_ip'] . ' - ' . $srcrow['piece_name'] ?>
                                                            </option>
                                                        <?php } ?>
                                                    <?php } else { ?>
                                                        <option value="default" disabled selected><?php echo language('NOT AVAILABLE NOW', @$_SESSION['systemLang']) ?></option>';
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row row-cols-sm-1">
                                    <!-- type -->
                                    <div class="col-12">
                                        <div class="mb-sm-2 mb-md-3 row">
                                            <label for="types" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('THE TYPE', @$_SESSION['systemLang']) ?></label>
                                            <div class="col-sm-12 col-md-8">
                                                <?php $types_data = $pcs_obj->select_specific_column("*", "`types`", "WHERE `company_id` = ".$_SESSION['company_id']); ?>
                                                <select class="form-select" id="types" name="type" <?php echo $pcs_data['is_client'] == 1 ? 'disabled' : 'required'; ?>>
                                                    <option value="default" disabled selected><?php echo language('SELECT', @$_SESSION['systemLang'])." ". language('THE TYPE', @$_SESSION['systemLang']) ?></option>
                                                    <?php if (count($types_data) > 0) { ?>
                                                        <?php foreach ($types_data as $type_row) { ?>
                                                            <option value="<?php echo $type_row['type_id'] ?>" <?php echo $pcs_data['type_id'] == $type_row['type_id'] ? 'selected' : '' ?>>
                                                                <?php echo $type_row['type_name'] ?>
                                                            </option>
                                                        <?php } ?>
                                                    <?php } else { ?>
                                                        <option value="default" disabled selected><?php echo language('NOT AVAILABLE NOW', @$_SESSION['systemLang']) ?></option>';
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <!-- direct -->
                                        <div class="mb-3 row">
                                            <label for="direct" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('CONNECTION', @$_SESSION['systemLang']) ?></label>
                                            <div class="mt-1 col-sm-12 col-md-8">
                                                <select class="form-select" name="direct" id="direct">
                                                    <option value="default" selected disabled><?php echo language('SELECT', @$_SESSION['systemLang'])." ". language('CONNECTION', @$_SESSION['systemLang']) ?></option>
                                                    <option value="1" <?php if ( $pcs_data['direct'] == 1) { echo 'selected';} ?>><?php echo language('DIRECT', @$_SESSION['systemLang']) ?></option>
                                                    <option value="0" <?php if ( $pcs_data['direct'] == 0) { echo 'selected';} ?>><?php echo language('NOT DIRECT', @$_SESSION['systemLang']) ?></option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- connection type -->
                                    <div class="col-12">
                                        <div class="mb-sm-2 mb-md-3 row">
                                            <label for="conn-type" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('CONNECTION TYPE', @$_SESSION['systemLang']) ?></label>
                                            <div class="col-sm-12 col-md-8">
                                                <?php $conn_type_data = $pcs_obj->select_specific_column("*", "`conn_types`", "WHERE `company_id` = ".$_SESSION['company_id']); ?>
                                                <select class="form-select text-uppercase" name="conn-type" id="conn-type">
                                                    <option value="default" selected disabled><?php echo language('SELECT', @$_SESSION['systemLang'])." ". language('CONNECTION TYPE', @$_SESSION['systemLang']) ?></option>
                                                    <?php if (count($conn_type_data) > 0) { ?>
                                                        <?php foreach ($conn_type_data as $conn_type_row) { ?>
                                                            <option value='<?php echo $conn_type_row['id'] ?>' <?php echo $pcs_data['conn_type'] == $conn_type_row['id'] ? 'selected' : '' ?>>
                                                                <?php echo $conn_type_row['conn_name'] ?>
                                                            </option>
                                                        <?php } ?>
                                                    <?php } else { ?>
                                                        <option value="default" disabled selected><?php echo language('NOT AVAILABLE NOW', @$_SESSION['systemLang']) ?></option>';
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3 row row-cols-sm-1 g-3 align-items-stretch justify-content-start">
                <!-- third column -->
                <div class="col-12">
                    <div class="section-block">
                        <div class="section-header">
                            <h5><?php echo language('PIECE INFO', @$_SESSION['systemLang']) ?></h5>
                            <hr />
                        </div>
                        <div class="mb-3 row row-cols-sm-1 row-cols-md-2 g-3 align-items-stretch justify-content-start">
                            <div class="col-12">
                                <div class="row row-cols-sm-1">
                                    <div class="col-12">
                                        <!-- IP -->
                                        <div class="mb-sm-2 mb-md-3 row">
                                            <label for="ip" class="col-sm-12 col-md-4 col-form-label"><span class="text-uppercase"><?php echo language('IP', @$_SESSION['systemLang']) ?></span></label>
                                            <div class="col-sm-12 col-md-8">
                                                <input type="text" class="form-control" id="ip" name="ip" placeholder="xxx.xxx.xxx.xxx" onfocus="validateIPaddress(this)" onkeyup="validateIPaddress(this)" required value="<?php echo $pcs_data['piece_ip']; ?>" />
                                                <?php if ($pcs_data['piece_ip'] == "0.0.0.0") {
                                                    echo '<div id="ipHelp" class="form-text text-info">'. language('THIS DEVICE/CLIENT DOESN`T HAVE AN IP', @$_SESSION['systemLang']) .'</div>';
                                                } ?>
                                                <div id="ipHelp" class="form-text text-warning"><?php echo language('IF PIECE/CLIENT NOT HAVE AN IP PRESS 0.0.0.0', @$_SESSION['systemLang']) ?></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <!-- MAC ADD -->
                                        <div class="mb-sm-2 mb-md-3 row">
                                            <label for="mac-add" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('MAC ADD', @$_SESSION['systemLang']) ?></label>
                                            <div class="col-sm-12 col-md-8">
                                                <input type="text" class="form-control" id="mac-add" name="mac-add" onfocus="validateMacAddress(this)" onkeyup="validateMacAddress(this)"  placeholder="<?php echo language('MAC ADD', @$_SESSION['systemLang']) ?>" value="<?php echo $pcs_data['mac_add'] ?>" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <!-- user name -->
                                        <div class="mb-sm-2 mb-md-3 row">
                                            <label for="user-name" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('USERNAME', @$_SESSION['systemLang']) ?></label>
                                            <div class="col-sm-12 col-md-8">
                                                <input type="text" class="form-control" id="user-name" name="user-name" placeholder="<?php echo language('USERNAME', @$_SESSION['systemLang']) ?>" value="<?php echo $pcs_data['username']; ?>" required />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <!-- password -->
                                        <div class="mb-sm-2 mb-md-3 row">
                                            <label for="password" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('PASSWORD', @$_SESSION['systemLang']) ?></label>
                                            <div class="col-sm-12 col-md-8">
                                                <input type="password" class="form-control" id="password" name="password" placeholder="<?php echo language('PASSWORD', @$_SESSION['systemLang']) ?>" required value="<?php echo $pcs_data['piece_pass']; ?>" />
                                                <i class="bi bi-eye-slash show-pass <?php echo @$_SESSION['systemLang'] == 'ar' ? 'show-pass-left' : 'show-pass-right' ?>" onclick="showPass(this)"></i>
                                                <div id="passHelp" class="form-text text-warning"><?php echo language('DON`T SHARE THIS PASSWORD WITH ANYONE', @$_SESSION['systemLang']) ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row row-cols-sm-1">
                                    <div class="col-12">
                                        <!-- password-connection -->
                                        <div class="mb-sm-2 mb-md-3 row">
                                            <label for="password-connection" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('PASSWORD CONNECTION', @$_SESSION['systemLang']) ?></label>
                                            <div class="col-sm-12 col-md-8">
                                                <input type="password" class="form-control" id="password-connection" name="password-connection" placeholder="<?php echo language('PASSWORD CONNECTION', @$_SESSION['systemLang']) ?>" value="<?php echo $pcs_data['pass_connection'] ?>" />
                                                <i class="bi bi-eye-slash show-pass <?php echo @$_SESSION['systemLang'] == 'ar' ? 'show-pass-left' : 'show-pass-right' ?>" onclick="showPass(this)" ></i>
                                                <div id="passHelp" class="form-text text-warning"><?php echo language('DON`T SHARE THIS PASSWORD WITH ANYONE', @$_SESSION['systemLang']) ?></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <!-- ssid -->
                                        <div class="mb-sm-2 mb-md-3 row">
                                            <label for="ssid" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('SSID', @$_SESSION['systemLang']) ?></label>
                                            <div class="col-sm-12 col-md-8">
                                                <input type="text" class="form-control" id="ssid" name="ssid" placeholder="<?php echo language('SSID', @$_SESSION['systemLang']) ?>" value="<?php echo $pcs_data['ssid'] ?>" />
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-12">
                                        <!-- frequency -->
                                        <div class="mb-sm-2 mb-md-3 row">
                                            <label for="frequency" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('FREQUENCY', @$_SESSION['systemLang']) ?></label>
                                            <div class="col-sm-12 col-md-8">
                                                <input type="text" class="form-control" id="frequency" name="frequency" placeholder="<?php echo language('FREQUENCY', @$_SESSION['systemLang']) ?>" value="<?php echo $pcs_data['frequency'] ?>" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <!-- device-type -->
                                        <div class="mb-sm-2 mb-md-3 row">
                                            <label for="device-type" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('DEVICE TYPE', @$_SESSION['systemLang']) ?></label>
                                            <div class="col-sm-12 col-md-8">
                                                <input type="text" class="form-control" id="device-type" name="device-type" placeholder="<?php echo language('DEVICE TYPE', @$_SESSION['systemLang']) ?>" value="<?php echo $pcs_data['device_type'] ?>" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>        
                    </div>
                </div>
            </div>

            <!-- submit -->
            <div class="hstack gap-3">
                <div class="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'me-auto' : 'ms-auto' ?>">
                    <button type="button" form="editPiece" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'ltr' : 'rtl' ?>" class="btn btn-primary text-capitalize" <?php if ($_SESSION['pcs_update'] == 0 && $pcs_data['UserID'] != $_SESSION['UserID']) {echo 'disabled';} ?> onclick="form_validation(this.form, 'submit')"><i class="bi bi-check-all"></i>&nbsp;<?php echo language('SAVE CHANGES', @$_SESSION['systemLang']) ?></button>
                    <button type="button" data-bs-toggle="modal" data-bs-target="#deletePieceModal" class="btn btn-outline-danger text-capitalize bg-gradient <?php if ($_SESSION['pcs_delete'] == 0) {echo 'd-none';} ?>" id="delete-piece">
                        <i class="bi bi-trash"></i>&nbsp;<?php echo language('DELETE', @$_SESSION['systemLang']) ?>
                    </button>
                </div>
            </div>
        </form>

        <!-- include delete piece modal -->
        <?php if ($_SESSION['pcs_delete'] == 1) { include_once 'includes/delete-piece-modal.php'; } ?>

    </div>
<?php } else { 

    // include no data founded module
    include_once $globmod . 'no-data-founded.php';

} ?>