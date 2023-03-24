<!-- start add new user page -->
<div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
    <!-- add new user page -->
    <?php if ($_SESSION['user_add'] == 1) { ?>
    <!-- first row -->
    <div class="mb-3">
        <a href="?do=addUser" class="btn btn-outline-primary py-1 shadow-sm">
            <h6 class="h6 mb-0 text-center text-capitalize fs-12">
                <?php echo language('ADD NEW EMPLOYEE', @$_SESSION['systemLang']) ?>
                <i class="bi bi-person-plus"></i>
            </h6>
        </a>
    </div>
    <?php } ?>
    <!-- second row -->
    <div class="mb-3">
        <?php
        // create an object of User class
        $user_obj = new User();
        // call get_all_users function
        $data = $user_obj->get_all_users($_SESSION['company_id']);
        $count = $data[0];
        $rows = $data[1];
        // check if empty data
        if (empty($rows) || $count == 0) { ?>
            <h5 class='h5 text-center text-danger '><?php echo language('THERE IS NO EMPLOYEES TO SHOW', @$_SESSION['systemLang']) ?></h5>
        <?php } else { ?>
            <!-- display all employees -->
            <div class="row row-cols-sm-1 row-cols-md-2 row-cols-lg-4 g-4 align-items-stretch justify-content-start">
                <?php foreach ($rows as $index => $row) { ?>
                    <div class="col-12">
                        <div class="card <?php if ($_SESSION['system_theme'] == 2) { echo 'card-effect '; echo @$_SESSION['systemLang'] == "ar" ? "card-effect-right":"card-effect-left"; } ?>">
                            <!-- employee image -->
                            <img src="<?php echo $uploads."/employees-img/male-avatar.svg" ?>" class="card-img-top shadow" alt="">
                            <!-- employee details -->
                            <div class="card-body">
                                <!-- vstack for employee info -->
                                <div class="vstack gap-1">
                                    <!-- card title -->
                                    <h5 class="mb-0 card-title">
                                        <!-- trusted mark -->
                                        <?php if ($row['TrustStatus'] == 1) { ?> 
                                            <i class="bi bi-patch-check-fill text-primary"></i>
                                        <?php } ?>
                                        <!-- username -->
                                        <?php echo $row['UserName'] ?>
                                    </h5>
                                    <!-- job title -->
                                    <p class="card-text text-secondary"><?php echo !empty($row['job_title']) ? $row['job_title'] : language('NO DATA ENTERED', @$_SESSION['systemLang']) ?></p>
                                    <!-- horizontal rule -->
                                    <hr>
                                </div>
                                <!-- vstack for some statistics -->
                                <div class="vstack gap-1 <?php echo @$_SESSION['systemLang'] == 'ar' ? 'text-end' : 'text-start' ?>">
                                    <!-- employee type -->
                                    <p class="mb-0 card-text text-black">
                                        <i class="bi bi-person"></i>
                                        <?php echo $row['isTech'] == 1 ? language("TECHNICAL", @$_SESSION['systemLang']) : ($row['TrustStatus'] == 1 ? language("THE MANAGER", @$_SESSION['systemLang']) : language("NORMAL EMPLOYEE", @$_SESSION['systemLang'])) ?>
                                    </p>
                                    <p class="mb-0 card-text">
                                        <i class="bi bi-whatsapp"></i>
                                        <span class="<?php echo !empty($row['phone']) ? 'text-black' : 'text-secondary' ?>">
                                            <!-- <?php echo !empty($row['phone']) ? $row['phone'] : language('NOT ASSIGNED', @$_SESSION['systemLang']) ?> -->
                                            <?php echo !empty($row['phone']) ? $row['phone'] : language('NO DATA ENTERED', @$_SESSION['systemLang']) ?>
                                        </span>
                                    </p>
                                    <p class="mb-0 card-text text-black"></p>
                                    <!-- horizontal rule -->
                                    <hr>
                                </div>
                                <!-- hstack for buttons -->
                                <div class="row g-1 align-items-center">
                                    <div class="col-sm-12 col-lg-4">
                                        <p class="col-12 card-text text-secondary mb-0 fs-12 fs-10-sm"><?php echo language('JOINED', @$_SESSION['systemLang'])." ".$row['joinedDate'] ?></p>
                                    </div>
                                    <div class="col-sm-12 col-lg-8">
                                        <div class="row g-1 justify-content-center align-items-start <?php echo @$_SESSION['systemLang'] == 'ar' ? 'me-auto' : 'ms-auto' ?>">
                                            <?php if ($_SESSION['UserID'] == $row['UserID'] || $_SESSION['user_update'] == 1) { ?>
                                                <!-- user profile button -->
                                                <div class="col-8">
                                                    <a href='?do=editUser&userid=<?php echo $row['UserID'] ?>' class='w-100 p-1 btn btn-primary text-capitalize fs-12 fs-10-sm'><?php echo language('PROFILE', @$_SESSION['systemLang']) ?> </a>
                                                </div>
                                            <?php } ?>
                                            <?php if ($_SESSION['user_delete'] == 1) { ?>
                                                <!-- user delete button -->
                                                <div class="col-4">
                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#deleteUserModal" class='w-100 p-1 btn btn-outline-danger text-capitalize fs-12 fs-10-sm' onclick="show_delete_user_modal(this)" data-username="<?php echo $row['UserName'] ?>" data-userid="<?php echo $row['UserID'] ?>"><?php echo language('DELETE', @$_SESSION['systemLang']) ?></button>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</div>


<!-- include_once delete user module -->
<?php include_once 'includes/delete-user-modal.php' ?>