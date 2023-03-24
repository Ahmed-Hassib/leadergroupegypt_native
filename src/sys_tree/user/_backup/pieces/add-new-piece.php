<!-- start add new user page -->
<div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
    <!-- start form -->
    <form class="custom-form need-validation" action="?do=insertPiece" method="POST" id="addPiece">
        <!-- horzontal stack -->
        <div class="hstack gap-3">
            <h6 class="h6 text-decoration-underline text-capitalize text-danger fw-bold">
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
                    <?php
                    // create an object of Database class 
                    $db_obj = new Database();
                    // get latest id in pieces table
                    $latest_id = intval($db_obj->get_latest_records("`piece_id`", "`pieces`", "", "`piece_id`", 1)[0]['piece_id']);
                    // get next id
                    $next_id = $latest_id + 1;
                    ?>
                    <!-- Id -->
                    <input type="hidden" class="form-control" id="next-id" name="next-id" value="<?php echo $next_id; ?>" placeholder="ID" autocomplete="off" readonly />
                    <!-- piece name -->
                    <div class="mb-sm-2 mb-md-3 row">
                        <label for="piece-name" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('FULLNAME', @$_SESSION['systemLang']) ?></label>
                        <div class="col-sm-12 col-md-8">
                            <input type="text" class="form-control" id="piece-name" name="piece-name" placeholder="<?php echo language('FULLNAME', @$_SESSION['systemLang']) ?>" autocomplete="off" required />
                        </div>
                    </div>
                    <!-- address -->
                    <div class="mb-sm-2 mb-md-3 row">
                        <label for="address" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('THE ADDRESS', @$_SESSION['systemLang']) ?></label>
                        <div class="col-sm-12 col-md-8">
                            <input type="text" name="address" id="address" class="form-control w-100" placeholder="<?php echo language('THE ADDRESS', @$_SESSION['systemLang']) ?>" />
                        </div>
                    </div>
                    <!-- phone -->
                    <div class="mb-sm-2 mb-md-3 row">
                        <label for="phone-number" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('PHONE', @$_SESSION['systemLang']) ?></label>
                        <div class="col-sm-12 col-md-8">
                            <input type="text" name="phone-number" id="phone-number" class="form-control w-100" placeholder="<?php echo language('PHONE', @$_SESSION['systemLang']) ?>" />
                        </div>
                    </div>
                    <!-- is client -->
                    <div class="mb-sm-2 mb-md-3 row">
                        <label for="is-client" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('PIECE/CLIENT', @$_SESSION['systemLang']) ?></label>
                        <div class="mt-2 col-sm-12 col-md-8">
                            <!-- SUGGESTION -->
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="is-client" id="piece" value="0" onclick="document.getElementById('types').removeAttribute('disabled');document.getElementById('types').setAttribute('required', 'required');">
                                <label class="form-check-label text-capitalize" for="piece"><?php echo language('PIECE', @$_SESSION['systemLang']) ?></label>
                            </div>
                            <!-- COMPLAINT -->
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="is-client" id="client" value="1" onclick="document.getElementById('types').setAttribute('disabled', 'disabled'); document.getElementById('types').removeAttribute('required');">
                                <label class="form-check-label text-capitalize" for="client"><?php echo language('CLIENT', @$_SESSION['systemLang']) ?></label>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- additional info -->
            <div class="col-12">
                <div class="section-block">
                    <div class="section-header">
                        <h5><?php echo language('ADDITIONAL INFO', @$_SESSION['systemLang']) ?></h5>
                        <hr />
                    </div>
                    <!-- notes -->
                    <div class="row">
                        <label for="notes" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('THE NOTES', @$_SESSION['systemLang']) ?></label>
                        <div class="col-sm-12 col-md-8">
                            <textarea name="notes" id="notes" title="put some notes hete if exist" class="form-control w-100" style="height: 10rem; resize: none; direction: <?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>" placeholder="<?php echo language('PUT YOUR NOTES HERE', @$_SESSION['systemLang']) ?>"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- connection info -->
        <div class="mb-3 row row-cols-sm-1 g-3 align-items-stretch justify-content-start">
            <div class="col-12">
                <div class="section-block">
                    <div class="section-header">
                        <h5><?php echo language('CONNECTION INFO', @$_SESSION['systemLang']) ?></h5>
                        <hr />
                    </div>
                    <div class="row row-cols-sm-1 row-cols-md-2 alignitems-stretch justify-content-start flex-row">
                        <div class="col-12">
                            <div class="row row-cols-sm-1">
                                <!-- direction -->
                                <div class="col-12">
                                    <div class="mb-sm-2 mb-md-3 row">
                                        <label for="direction" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('THE DIRECTION', @$_SESSION['systemLang']) ?></label>
                                        <div class="col-sm-12 col-md-8">
                                            <select class="form-select" id="direction" name="direction" required onchange="get_sources(this, ['sources', 'alternative-sources'], <?php echo $_SESSION['company_id'] ?>, '<?php echo $dirs . $_SESSION['company_name'] ?>');">
                                                <?php
                                                // create an object of Direction class
                                                $dir_obj = new Direction();
                                                // get all directions
                                                $dirs = $dir_obj->get_all_directions($_SESSION['company_id']);
                                                // counter
                                                $dirs_count = $dirs[0];
                                                // directions data
                                                $dir_data = $dirs[1];
                                                // check the row dirs_count
                                                if ($dirs_count > 0) { ?>
                                                    <option value="default" disabled selected><?php echo language('SELECT', @$_SESSION['systemLang'])." ". language('THE DIRECTION', @$_SESSION['systemLang']) ?></option>
                                                    <?php foreach ($dir_data as $dir) { ?>
                                                        <option value="<?php echo $dir['direction_id'] ?>" data-dir-company="<?php echo $_SESSION['company_id'] ?>">
                                                            <?php echo  $dir['direction_name'] ?>
                                                        </option>
                                                    <?php } ?>
                                                <?php } else { ?>
                                                    <option value="default" disabled selected><?php echo language('NOT AVAILABLE NOW', @$_SESSION['systemLang']) ?></option>';
                                                <?php } ?>
                                            </select>
                                            
                                        </div>
                                    </div>
                                </div>
                                <!-- source -->
                                <div class="col-12">
                                    <div class="mb-3 row">
                                        <label for="sources" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('THE SOURCE', @$_SESSION['systemLang']) ?></label>
                                        <div class="col-sm-12 col-md-8">
                                            <select class="form-select" id="sources" name="sourceid" required>
                                                <option  value="default" selected disabled><?php echo language('SELECT', @$_SESSION['systemLang'])." ". language('THE SOURCE', @$_SESSION['systemLang']) ?></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- alternative source -->
                                <div class="col-12">
                                    <div class="mb-3 row">
                                        <label for="alternative-sources" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('ALTERNATIVE SOURCE', @$_SESSION['systemLang']) ?></label>
                                        <div class="col-sm-12 col-md-8">
                                            <select class="form-select" id="alternative-sources" name="alt-sourceid">
                                                <option value="default" selected disabled><?php echo language('SELECT', @$_SESSION['systemLang'])." ". language('ALTERNATIVE SOURCE', @$_SESSION['systemLang']) ?></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- direct -->
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row row-cols-sm-1">
                                <!-- type -->
                                <div class="col-12">
                                    <div class="mb-sm-2 mb-md-3 row">
                                        <label for="types" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('THE TYPE', @$_SESSION['systemLang']) ?></label>
                                        <div class="col-sm-12 col-md-8">
                                            <select class="form-select" id="types" name="type" required>
                                                <?php
                                                // create an object of PiecesTypes class
                                                $types_obj = new PiecesTypes();
                                                // get all types
                                                $types = $types_obj->get_all_types($_SESSION['company_id']);
                                                // counter
                                                $type_count = $types[0];
                                                // types data
                                                $types_data = $types[1];
                                                // check the row type_count
                                                if ($type_count > 0) { ?>
                                                    <option value="default" disabled selected><?php echo language('SELECT', @$_SESSION['systemLang'])." ". language('THE TYPE', @$_SESSION['systemLang']) ?></option>
                                                    <?php foreach ($types_data as $type_row) { ?>
                                                        <option value="<?php echo $type_row['type_id'] ?>">
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
                                    <div class="mb-3 row">
                                        <label for="direct" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('CONNECTION', @$_SESSION['systemLang']) ?></label>
                                        <div class="mt-1 col-sm-12 col-md-8">
                                            <select class="form-select" name="direct" id="direct">
                                                <option value="default" selected disabled><?php echo language('SELECT', @$_SESSION['systemLang'])." ". language('CONNECTION', @$_SESSION['systemLang']) ?></option>
                                                <option value="1"><?php echo language('DIRECT', @$_SESSION['systemLang']) ?></option>
                                                <option value="0"><?php echo language('NOT DIRECT', @$_SESSION['systemLang']) ?></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- connection type -->
                                <div class="col-12">
                                    <div class="mb-sm-2 mb-md-3 row">
                                        <label for="conn-type" class="col-sm-12 col-md-4 col-form-label text-capitalize">
                                            <?php echo language('CONNECTION TYPE', @$_SESSION['systemLang']) ?>
                                        </label>
                                        <div class="col-sm-12 col-md-8">
                                            <!-- <span class="bg-secondary text-light form-control"><?php echo language('UNDER DEVELOPING', @$_SESSION['systemLang']) ?></span> -->
                                            <?php $conn_type_data = $db_obj->select_specific_column("*", "`conn_types`", "WHERE `company_id` = ".$_SESSION['company_id']); ?>
                                            <select class="form-select text-uppercase" name="conn-type" id="conn-type">
                                                <option value="default" selected disabled><?php echo language('SELECT', @$_SESSION['systemLang'])." ". language('CONNECTION TYPE', @$_SESSION['systemLang']) ?></option>
                                                <?php if (count($conn_type_data) > 0) { ?>
                                                    <?php foreach ($conn_type_data as $conn_type_row) { ?>
                                                        <option value='<?php echo $conn_type_row['id'] ?>'>
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

            <!-- third column -->
            <div class="col-12">
                <div class="section-block">
                    <div class="section-header">
                        <h5><?php echo language('PIECE INFO', @$_SESSION['systemLang']) ?></h5>
                        <hr />
                    </div>
                    <div class="row row-cols-sm-1 row-cols-md-2 align-items-stretch justify-content-start">
                        <div class="col-12">
                            <div class="row row-cols-sm-1 align-items-stretch justify-content-start">
                                <!-- IP -->
                                <div class="col-12">
                                    <div class="mb-sm-2 mb-md-3 row">
                                        <label for="ip" class="col-sm-12 col-md-4 col-form-label"><span class="text-uppercase"><?php echo language('IP', @$_SESSION['systemLang']) ?></span></label>
                                        <div class="col-sm-12 col-md-8">
                                            <input type="text" class="form-control" id="ip" name="ip" placeholder="xxx.xxx.xxx.xxx" onkeyup="validateIPaddress(this)" autocomplete="off" required />
                                            <div id="ipHelp" class="form-text text-warning"><?php echo language('IF PIECE/CLIENT NOT HAVE AN IP PRESS 0.0.0.0', @$_SESSION['systemLang']) ?></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- MAC ADD -->
                                <div class="col-12">
                                    <div class="mb-sm-2 mb-md-3 row">
                                        <label for="mac-add" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('MAC ADD', @$_SESSION['systemLang']) ?></label>
                                        <div class="col-sm-12 col-md-8">
                                            <input type="text" class="form-control" id="mac-add" name="mac-add" onkeyup="validateMacAddress(this)" placeholder="<?php echo language('MAC ADD', @$_SESSION['systemLang']) ?>" />
                                        </div>
                                    </div>
                                </div>
                                <!-- user name -->
                                <div class="col-12">
                                    <div class="mb-sm-2 mb-md-3 row">
                                        <label for="user-name" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('USERNAME', @$_SESSION['systemLang']) ?></label>
                                        <div class="col-sm-12 col-md-8">
                                            <input type="text" class="form-control" id="user-name" name="user-name" placeholder="<?php echo language('USERNAME', @$_SESSION['systemLang']) ?>" autocomplete="off" required />
                                        </div>
                                    </div>
                                </div>
                                <!-- password -->
                                <div class="col-12">
                                    <div class="mb-sm-2 mb-md-3 row">
                                        <label for="password" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('PASSWORD', @$_SESSION['systemLang']) ?></label>
                                        <div class="col-sm-12 col-md-8">
                                            <input type="text" class="form-control" id="password" name="password" placeholder="<?php echo language('PASSWORD', @$_SESSION['systemLang']) ?>" autocomplete="off" required />
                                            <div id="passHelp" class="form-text text-warning "><?php echo language('DON`T SHARE THIS PASSWORD WITH ANYONE', @$_SESSION['systemLang']) ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row row-cols-sm-1">
                                <!-- password-connection -->
                                <div class="col-12">
                                    <div class="mb-sm-2 mb-md-3 row">
                                        <label for="password-connection" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('PASSWORD CONNECTION', @$_SESSION['systemLang']) ?></label>
                                        <div class="col-sm-12 col-md-8">
                                            <input type="password" class="form-control" id="password-connection" name="password-connection" placeholder="<?php echo language('PASSWORD CONNECTION', @$_SESSION['systemLang']) ?>"  />
                                            <i class="bi bi-eye-slash show-pass <?php echo @$_SESSION['systemLang'] == 'ar' ? 'show-pass-left' : 'show-pass-right' ?>" onclick="showPass(this)"></i>
                                            <div id="passHelp" class="form-text text-warning "><?php echo language('DON`T SHARE THIS PASSWORD WITH ANYONE', @$_SESSION['systemLang']) ?></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- ssid -->
                                <div class="col-12">
                                    <div class="mb-sm-2 mb-md-3 row">
                                        <label for="ssid" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('SSID', @$_SESSION['systemLang']) ?></label>
                                        <div class="col-sm-12 col-md-8">
                                            <input type="text" class="form-control" id="ssid" name="ssid" placeholder="<?php echo language('SSID', @$_SESSION['systemLang']) ?>" />
                                        </div>
                                    </div>
                                </div>
                                <!-- frequency -->
                                <div class="col-12">
                                    <div class="mb-sm-2 mb-md-3 row">
                                        <label for="frequency" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('FREQUENCY', @$_SESSION['systemLang']) ?></label>
                                        <div class="col-sm-12 col-md-8">
                                            <input type="text" class="form-control" id="frequency" name="frequency" placeholder="<?php echo language('FREQUENCY', @$_SESSION['systemLang']) ?>"  />
                                        </div>
                                    </div>
                                </div>
                                <!-- device-type -->
                                <div class="col-12">
                                    <div class="mb-sm-2 mb-md-3 row">
                                        <label for="device-type" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo language('DEVICE TYPE', @$_SESSION['systemLang']) ?></label>
                                        <div class="col-sm-12 col-md-8">
                                            <input type="text" class="form-control" id="device-type" name="device-type" placeholder="<?php echo language('DEVICE TYPE', @$_SESSION['systemLang']) ?>" />
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
            <button type="button" form="addPiece" class="btn btn-primary text-capitalize bg-gradient fs-12 p-1 <?php echo @$_SESSION['systemLang'] == 'ar' ? 'me-auto' : 'ms-auto' ?>" id="add-piece" <?php if ($_SESSION['pcs_add'] == 0) {echo 'disabled';} ?> onclick="form_validation(this.form, 'submit')">
                <i class="bi bi-plus"></i>

                <?php
                    if ($page_title == "pieces") {
                        echo language('ADD NEW PIECE', @$_SESSION['systemLang']);
                    } else {
                        echo language('ADD NEW CLIENT', @$_SESSION['systemLang']);
                    }
                ?>
            </button>
        </div>
    </form>
    <!-- end form -->
</div>
