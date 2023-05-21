<div class="container" dir="<?php echo $_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
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
                <span><?php echo $user['UserName'] ?></span>
                <!-- trusted mark -->
                <?php if ($user['TrustStatus'] == 1) { ?> 
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
                  <span class="text-black"><?php echo $user['Fullname'] ?></span>
                </div>
                <div class="col-sm-12 col-md-3">
                  <span class="text-muted"><?php echo language('GENDER', @$_SESSION['systemLang']) ?>:</span>
                  <span class="text-black"><?php echo $user['gender'] == 0 ? language('MALE', @$_SESSION['systemLang']) : language('FEMALE', @$_SESSION['systemLang']) ?></span>
                </div>
                <div class="col-sm-12 col-md-4">
                  <span class="text-muted"><?php echo language('THE ADDRESS', @$_SESSION['systemLang']) ?>:</span>
                  <span class="<?php echo empty($user['address']) ? ' text-danger' : 'text-black' ?>"><?php echo !empty($user['address']) ? $user['address'] : language('NO DATA ENTERED', @$_SESSION['systemLang']) ?></span>
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
                  <span class="<?php echo empty($user['Email']) ? ' text-danger' : 'text-black' ?>"><?php echo !empty($user['Email']) ? $user['Email'] : language('NO DATA ENTERED', @$_SESSION['systemLang']) ?></span>
                </div>
                <div class="col-sm-12 col-md-3">
                  <span class="text-muted"><?php echo language('PHONE', @$_SESSION['systemLang']) ?>:</span>
                  <span class="<?php echo empty($user['phone']) ? ' text-danger' : 'text-black' ?>"><?php echo !empty($user['phone']) ? $user['phone'] : language('NO DATA ENTERED', @$_SESSION['systemLang']) ?></span>
                </div>
                <div class="col-sm-12 col-md-4">
                  <span class="text-muted"><?php echo language('DATE OF BIRTH', @$_SESSION['systemLang']) ?>:</span>
                  <span class="<?php echo $user['date_of_birth'] == '0000-00-00' ? ' text-danger' : 'text-black' ?>"><?php echo $user['date_of_birth'] != '0000-00-00' ? $user['date_of_birth'] : language('NO DATA ENTERED', @$_SESSION['systemLang']) ?></span>
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
                  <span class="<?php echo $user['job_title_id'] == 0 ? ' text-danger' : 'text-black' ?>">
                    <?php if ($user['job_title_id']) {
                      if (!isset($db_obj)) {
                        // create an object of Database class
                        $db_obj = new Database();
                      }
                      // get job title
                      $job_title = $db_obj->select_specific_column("`job_title_name`", "`users_job_title`", "WHERE `job_title_id` = " . $user['job_title_id'])[0]['job_title_name'];
                    } else {
                      $job_title = "NO DATA ENTERED";
                    }
                    // display job title
                    echo language($job_title, @$_SESSION['systemLang']);
                    ?>
                  </span>
                </div> 
                <div class="col-sm-12 col-md-4">
                  <span class="text-muted"><?php echo language('JOINED', @$_SESSION['systemLang']) ?>:</span>
                  <span class="<?php echo $user['joinedDate'] == '0000-00-00' ? ' text-danger' : 'text-black' ?>"><?php echo $user['joinedDate'] != '0000-00-00' ? $user['joinedDate'] : language('NO DATA ENTERED', @$_SESSION['systemLang']) ?></span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- hstack for buttons -->
        <div class="hstack gap-2">
          <a href="?do=edit-user-info&userid=<?php echo $user_id ?>" class="p-1 <?php echo @$_SESSION['systemLang'] == 'ar' ? 'me-auto' : 'ms-auto' ?> btn btn-primary fs-12 <?php echo $_SESSION['UserID'] != $user['UserID'] && $_SESSION['user_update'] == 0 ? 'disabled' : '' ?>" style="width: 70px">
            <i class="bi bi-pencil-square"></i>
            <?php echo language('EDIT', @$_SESSION['systemLang']) ?>
          </a>
          <?php if ($user['TrustStatus'] != 1 && $user['job_title_id'] != 1) { ?>
            <button type="button" data-bs-toggle="modal" data-bs-target="#deleteUserModal" onclick="show_delete_user_modal(this)" data-username="<?php echo $user['UserName'] ?>" data-user-id="<?php echo $user_id ?>" class="btn btn-outline-danger text-capitalize fs-12 p-1" <?php if ($_SESSION['user_delete'] == 0 && $user['UserID'] != $_SESSION['UserID']) {echo 'disabled';} ?>><i class="bi bi-trash"></i>&nbsp;<?php echo language('DELETE', @$_SESSION['systemLang']) ?></button>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
  <!-- end new design -->
</div>
