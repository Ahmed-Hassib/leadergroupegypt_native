<!-- start new design -->
<div class="row">
    <div class="col-12">
        <div class="section-block">
            <div class="mb-3 row g-3 justify-content-start">
                <!-- photo section -->
                <div class="col-sm-12 col-lg-4">
                    <div class="text-center" dir="ltr">
                        <img src="<?php echo $uploads.'employees-img/male-avatar.svg' ?>" alt="" class="mb-4 img-fluid employee-avatar shadow">
                        <h3 class="h3 text-black">
                            <span><?php echo $row['UserName'] ?></span>
                            <!-- trusted mark -->
                            <?php if ($row['TrustStatus'] == 1) { ?> 
                                <i class="bi bi-patch-check-fill text-primary"></i>
                            <?php } ?>
                        </h3>
                    </div>
                </div>
                <!-- info section -->
                <div class="col-sm-12 col-lg-8">
                    <div class="p-2">
                        <header class="section-header mb-3">
                            <h5 class="h5 text-muted">
                                <?php echo language('GENERAL INFO', @$_SESSION['systemLang']) ?>
                            </h5>
                        </header>
                        <div class="row g-3 justify-content-start align-items-baseline">
                            <div class="col-sm-12 col-md-5">
                                <span class="text-muted"><?php echo language('FULLNAME', @$_SESSION['systemLang']) ?>:</span>
                                <span class="text-black"><?php echo $row['Fullname'] ?></span>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <span class="text-muted"><?php echo language('GENDER', @$_SESSION['systemLang']) ?>:</span>
                                <span class="text-black"><?php echo $row['gender'] == 0 ? language('MALE', @$_SESSION['systemLang']) : language('FEMALE', @$_SESSION['systemLang']) ?></span>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <span class="text-muted"><?php echo language('THE ADDRESS', @$_SESSION['systemLang']) ?>:</span>
                                <span class="<?php echo empty($row['address']) ? ' text-danger' : 'text-black' ?>"><?php echo !empty($row['address']) ? $row['address'] : language('NO DATA ENTERED', @$_SESSION['systemLang']) ?></span>
                            </div>
                        </div>
                    </div>
                    <!-- virtical rule -->
                    <hr>
                    <div class="p-2">
                        <header class="section-header mb-3">
                            <h5 class="h5 text-muted">
                                <?php echo language('PERSONAL INFO', @$_SESSION['systemLang']) ?>
                            </h5>
                        </header>
                        <div class="row g-3 justify-content-start align-items-baseline">
                            <div class="col-sm-12 col-md-5">
                                <span class="text-muted"><?php echo language('EMAIL', @$_SESSION['systemLang']) ?>:</span>
                                <span class="<?php echo empty($row['Email']) ? ' text-danger' : 'text-black' ?>"><?php echo !empty($row['Email']) ? $row['Email'] : language('NO DATA ENTERED', @$_SESSION['systemLang']) ?></span>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <span class="text-muted"><?php echo language('PHONE', @$_SESSION['systemLang']) ?>:</span>
                                <span class="<?php echo empty($row['phone']) ? ' text-danger' : 'text-black' ?>"><?php echo !empty($row['phone']) ? $row['phone'] : language('NO DATA ENTERED', @$_SESSION['systemLang']) ?></span>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <span class="text-muted"><?php echo language('DATE OF BIRTH', @$_SESSION['systemLang']) ?>:</span>
                                <span class="<?php echo $row['date_of_birth'] == '0000-00-00' ? ' text-danger' : 'text-black' ?>"><?php echo $row['date_of_birth'] != '0000-00-00' ? $row['date_of_birth'] : language('NO DATA ENTERED', @$_SESSION['systemLang']) ?></span>
                            </div>
                        </div>
                    </div>
                    <!-- virtical rule -->
                    <hr>
                    <div class="p-2">
                        <header class="section-header mb-3">
                            <h5 class="h5 text-muted">
                                <?php echo language('JOB INFO', @$_SESSION['systemLang']) ?>
                            </h5>
                        </header>
                        <div class="row g-3 justify-content-start align-items-baseline">
                            <div class="col-sm-12 col-md-5">
                                <span class="text-muted"><?php echo language('JOB TITLE', @$_SESSION['systemLang']) ?>:</span>
                                <span class="<?php echo empty($row['job_title']) ? ' text-danger' : 'text-black' ?>"><?php echo !empty($row['job_title']) ? $row['job_title'] : language('NO DATA ENTERED', @$_SESSION['systemLang']) ?></span>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <span class="text-muted"><?php echo language('IS A TECH?', @$_SESSION['systemLang']) ?>:</span>
                                <span><?php echo $row['isTech'] == 0 ? language('NO', @$_SESSION['systemLang']) : language('YES', @$_SESSION['systemLang']) ?></span>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <span class="text-muted"><?php echo language('JOINED', @$_SESSION['systemLang']) ?>:</span>
                                <span class="<?php echo $row['joinedDate'] == '0000-00-00' ? ' text-danger' : 'text-black' ?>"><?php echo $row['joinedDate'] != '0000-00-00' ? $row['joinedDate'] : language('NO DATA ENTERED', @$_SESSION['systemLang']) ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- hstack for buttons -->
            <div class="hstack gap-3">
                <a href="?do=editUser&action=1&userid=<?php echo $userid ?>" class="p-1 <?php echo @$_SESSION['systemLang'] == 'ar' ? 'me-auto' : 'ms-auto' ?> btn btn-primary fs-12 <?php echo $_SESSION['UserID'] != $row['UserID'] && $_SESSION['user_update'] == 0 ? 'disabled' : '' ?>" style="width: 70px">
                    <?php echo language('EDIT', @$_SESSION['systemLang']) ?>
                </a>
            </div>
        </div>
    </div>
</div>
<!-- end new design -->
