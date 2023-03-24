<?php
// user id
$userid = isset($_GET['userid']) ? intval($_GET['userid']) : 0;
// check if user id is set or not
if ($userid != 0) {
    // check if user exist
    $check = checkItem("`UserID`", "`users`", $userid);
    // get full name of the employee
    $fullname = $check > 0 ? selectSpecificColumn("`FullName`", "`users`", "WHERE `UserID` = $userid")[0]['FullName'] : language("UNKNOWN", @$_SESSION['systemLang']); 
?>
<!-- start delete suggestions and posPoints -->
<div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
    <div class="row row-cols-sm-1 row-cols-md-2 justify-content-center">
        <!-- add new points section -->
        <div class="col-6">
            <div class="section-header">
                <h5 class="text-capitalize "><?php echo language('ADD NEW POINTS', @$_SESSION['systemLang']) ?></h5>
                <hr />
            </div>
            <!-- start add new points form -->
            <!-- start edit profile form -->
            <form class="profile-form" action="?do=addPoints" method="POST">

                <!-- start userid field -->
                <input type="hidden" class="form-control" name="userid" id="userid" value="<?php echo $userid ?>">
                <!-- end userid field -->
                <!-- start full name field -->
                <div class="mb-4 row">
                    <label for="points" class="col-sm-12 col-md-3 col-form-label text-capitalize" autocomplete="off"><?php echo language('NUMBER OF POINTS', @$_SESSION['systemLang']) ?></label>
                    <div class="col-sm-12 col-md-9">
                        <input type="number" class="form-control" name="points" id="points" placeholder="<?php echo language('ADD', @$_SESSION['systemLang'])." ".language('POSITIVE', @$_SESSION['systemLang'])." ".language('NUMBERS', @$_SESSION['systemLang']) ?>" min="0" required>
                    </div>
                </div>
                <!-- end full name field -->
                <!-- start points type field -->
                <div class="mb-4 row">
                    <label for="points-type" class="col-sm-12 col-md-3 col-form-label text-capitalize"><?php echo language('POINTS TYPE', @$_SESSION['systemLang']) ?></label>
                    <div class="col-sm-12 col-md-9">
                        <!-- <select class="form-select" name="points-type" id="points-type" required <?php if ($_SESSION['points_add'] == 0) {echo 'disabled';} ?>>
                            <option value="default" selected disabled><?php echo language('SELECT', @$_SESSION['systemLang'])." ".language('TYPE', @$_SESSION['systemLang']) ?></option>
                            <option value="0"><?php echo language('NEGATIVE', @$_SESSION['systemLang']) ?></option>
                            <option value="1"><?php echo language('POSITIVE', @$_SESSION['systemLang']) ?></option>
                        </select> -->

                        <!-- NEGATIVE -->
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="points-type" id="points-type-neg" value="0">
                            <label class="form-check-label text-capitalize" for="points-type-neg">
                                <?php echo language('NEGATIVE', @$_SESSION['systemLang']) ?>
                            </label>
                        </div>
                        <!-- POSITIVE -->
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="points-type" id="points-type-pos" value="1">
                            <label class="form-check-label text-capitalize" for="points-type-pos">
                                <?php echo language('POSITIVE', @$_SESSION['systemLang']) ?>
                            </label>
                        </div>
                    </div>
                </div>
                <!-- end points type field -->
                <!-- strat comment field -->
                <div class="mb-4 row">
                    <label for="comment" class="col-sm-12 col-md-3 col-form-label text-capitalize"><?php echo language('COMMENT', @$_SESSION['systemLang']) ?></label>
                    <div class="col-sm-12 col-md-9">
                        <textarea name="comment" id="comment" class="form-control" cols="30" rows="10" style="resize: none;direction:<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>" required <?php if ($_SESSION['points_add'] == 0) {echo 'disabled';} ?>></textarea>
                    </div>
                </div>
                <!-- end comment field -->
                
                <!-- strat submit -->
                <div class="mb-4 row">
                    <div class="col-sm-12">
                        <button type="submit" class="ms-auto btn btn-outline-primary text-capitalize" <?php if ($_SESSION['points_add'] == 0 || $_SESSION['UserID'] == $userid) {echo 'disabled';} ?>><i class="bi bi-check-all"></i>&nbsp;<?php echo language('ADD NEW POINTS', @$_SESSION['systemLang']) ?></button>
                    </div>
                </div>
                <!-- end submit -->
            </form>
            <!-- end add new points form -->
        </div>
        <!-- motivation points section -->
    </div>
</div>
<?php } else { ?>
    <!-- start delete suggestions and posPoints -->
        <div class="container ">
            <!-- start header -->
            <header class="mb-5 header">
                <h1 class="text-capitalize "><?php echo language('MOTIVATION POINTS', @$_SESSION['systemLang']) ?></h1>
            </header>

            <div class="row row-cols-sm-1 row-cols-md-2 justify-content-center">
                <!-- add new points section -->
                <div class="col-6">
                    <div class="section-header">
                        <h5 class="text-capitalize "><?php echo language('ADD NEW POINTS', @$_SESSION['systemLang']) ?></h5>
                        <hr />
                    </div>
                    <!-- start add new points form -->
                    <!-- start edit profile form -->
                    <form class="profile-form" action="?do=addPoints" method="POST">

                        <!-- start userid field -->
                        <input type="hidden" class="form-control" name="userid" id="userid" value="<?php echo $userid ?>">
                        <!-- end userid field -->
                        <!-- Technical name -->
                        <div class="mb-4 row">
                            <label for="userid" class="col-sm-12 col-md-3 col-form-label text-capitalize"><?php echo language('EMPLOYEE NAME', @$_SESSION['systemLang']) ?></label>
                            <div class="col-sm-12 col-md-9">
                                <select class="form-select" id="userid" name="userid">
                                    <option value="default" disabled selected><?php echo language('SELECT', @$_SESSION['systemLang'])." ".language('EMPLOYEE NAME', @$_SESSION['systemLang']) ?></option>
                                    <?php 

                                    $usersRows = selectSpecificColumn("`UserID`, `UserName`", "users", "WHERE `UserID` != 1");

                                    if (count($usersRows) > 0) {
                                        // loop on result ..
                                        foreach ($usersRows as $userRow) {
                                            // get all information of pieces..
                                            echo "<option value='" . $userRow['UserID'] . "'>";
                                            echo $userRow['UserName'];
                                            echo "</option>";
                                        }
                                    } else {
                                        echo "<option>Not available now</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- start full name field -->
                        <div class="mb-4 row">
                            <label for="points" class="col-sm-12 col-md-3 col-form-label text-capitalize" autocomplete="off"><?php echo language('NUMBER OF POINTS', @$_SESSION['systemLang']) ?></label>
                            <div class="col-sm-12 col-md-9">
                                <input type="number" class="form-control" name="points" id="points" placeholder="<?php echo language('ADD', @$_SESSION['systemLang'])." ".language('POSITIVE', @$_SESSION['systemLang'])." ".language('NUMBERS', @$_SESSION['systemLang']) ?>" min="0" required>
                            </div>
                        </div>
                        <!-- end full name field -->
                        <!-- start points type field -->
                        <div class="mb-4 row">
                            <label for="points-type" class="col-sm-12 col-md-3 col-form-label text-capitalize"><?php echo language('POINTS TYPE', @$_SESSION['systemLang']) ?></label>
                            <div class="col-sm-12 col-md-9">
                                <!-- NEGATIVE -->
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="points-type" id="points-type-neg" value="0">
                                    <label class="form-check-label text-capitalize" for="points-type-neg">
                                        <?php echo language('NEGATIVE', @$_SESSION['systemLang']) ?>
                                    </label>
                                </div>
                                <!-- POSITIVE -->
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="points-type" id="points-type-pos" value="1">
                                    <label class="form-check-label text-capitalize" for="points-type-pos">
                                        <?php echo language('POSITIVE', @$_SESSION['systemLang']) ?>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <!-- end points type field -->
                        <!-- strat comment field -->
                        <div class="mb-4 row">
                            <label for="comment" class="col-sm-12 col-md-3 col-form-label text-capitalize"><?php echo language('COMMENT', @$_SESSION['systemLang']) ?></label>
                            <div class="col-sm-12 col-md-9">
                                <textarea name="comment" id="comment" class="form-control" cols="30" rows="10" style="resize: none;direction:<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>" required <?php if ($_SESSION['points_add'] == 0) {echo 'disabled';} ?>></textarea>
                            </div>
                        </div>
                        <!-- end comment field -->
                        
                        <!-- strat submit -->
                        <div class="mb-4 row">
                            <div class="col-sm-12">
                                <button type="submit" class="ms-auto btn btn-outline-primary text-capitalize" <?php if ($_SESSION['points_add'] == 0 || $_SESSION['UserID'] == $userid) {echo 'disabled';} ?>><i class="bi bi-check-all"></i>&nbsp;<?php echo language('ADD NEW POINTS', @$_SESSION['systemLang']) ?></button>
                            </div>
                        </div>
                        <!-- end submit -->
                    </form>
                    <!-- end add new points form -->
                </div>
                <!-- motivation points section -->
            </div>
        </div>
<?php } ?>