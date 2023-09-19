<div class="container" dir="<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'rtl' : 'ltr' ?>">
  <!-- start new design -->
  <div class="row">
    <div class="col-12">
      <div class="section-block">
        <div class="mb-3 row g-3 justify-content-start">
          <!-- photo section -->
          <div class="col-sm-12 col-lg-4">
            <div class="text-center" dir="ltr">
              <img src="<?php echo $uploads . 'employees-img/male-avatar.svg' ?>" alt="" class="mb-4 img-fluid employee-avatar shadow">
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
                  <?php echo lang('GENERAL INFO', $lang_file) ?>
                </h5>
              </header>
              <div class="row g-3 justify-content-start align-items-baseline">
                <div class="col-sm-12 col-md-5">
                  <span class="text-muted"><?php echo lang('FULLNAME', $lang_file) ?>:</span>
                  <span class="text-black"><?php echo $user['Fullname'] ?></span>
                </div>
                <div class="col-sm-12 col-md-3">
                  <span class="text-muted"><?php echo lang('GENDER', $lang_file) ?>:</span>
                  <span class="text-black"><?php echo $user['gender'] == 0 ? lang('MALE', $lang_file) : lang('FEMALE', $lang_file) ?></span>
                </div>
                <div class="col-sm-12 col-md-4">
                  <span class="text-muted"><?php echo lang('ADDRESS', $lang_file) ?>:</span>
                  <span class="<?php echo empty($user['address']) ? ' text-danger' : 'text-black' ?>"><?php echo !empty($user['address']) ? $user['address'] : lang('NO DATA') ?></span>
                </div>
              </div>
            </div>
            <!-- virtical rule -->
            <hr>
            <div class="p-2">
              <header class="section-header mb-3">
                <h5 class="h5 text-muted">
                  <?php echo lang('PERSONAL INFO', $lang_file) ?>
                </h5>
              </header>
              <div class="row g-3 justify-content-start align-items-baseline">
                <div class="col-sm-12 col-md-5">
                  <span class="text-muted"><?php echo lang('EMAIL', $lang_file) ?>:</span>
                  <span class="<?php echo empty($user['Email']) ? ' text-danger' : 'text-black' ?>"><?php echo !empty($user['Email']) ? $user['Email'] : lang('NO DATA') ?></span>
                </div>
                <div class="col-sm-12 col-md-3">
                  <span class="text-muted"><?php echo lang('PHONE', $lang_file) ?>:</span>
                  <span class="<?php echo empty($user['phone']) ? ' text-danger' : 'text-black' ?>"><?php echo !empty($user['phone']) ? $user['phone'] : lang('NO DATA') ?></span>
                </div>
                <div class="col-sm-12 col-md-4">
                  <span class="text-muted"><?php echo lang('BIRTH', $lang_file) ?>:</span>
                  <span class="<?php echo $user['date_of_birth'] == '0000-00-00' ? ' text-danger' : 'text-black' ?>"><?php echo $user['date_of_birth'] != '0000-00-00' ? $user['date_of_birth'] : lang('NO DATA') ?></span>
                </div>
              </div>
            </div>
            <!-- virtical rule -->
            <hr>
            <div class="p-2">
              <header class="section-header mb-3">
                <h5 class="h5 text-muted">
                  <?php echo lang('JOB INFO', $lang_file) ?>
                </h5>
              </header>
              <div class="row g-3 justify-content-start align-items-baseline">
                <div class="col-sm-12 col-md-5">
                  <span class="text-muted"><?php echo lang('JOB TITLE', $lang_file) ?>:</span>
                  <span class="<?php echo $user['job_title_id'] == 0 ? ' text-danger' : 'text-black' ?>">
                    <?php if ($user['job_title_id']) {
                      if (!isset($db_obj)) {
                        // create an object of Database class
                        $db_obj = new Database("localhost", "jsl_db", "root", "@hmedH@ssib");
                      }
                      // get job title
                      $job_title = $db_obj->select_specific_column("`job_title_name`", "`users_job_title`", "WHERE `job_title_id` = " . $user['job_title_id'])[0]['job_title_name'];
                    } else {
                      $job_title = "NO DATA";
                    }
                    // display job title
                    echo lang($job_title, $lang_file);
                    ?>
                  </span>
                </div>
                <div class="col-sm-12 col-md-4">
                  <span class="text-muted"><?php echo lang('JOINED') ?>:</span>
                  <span class="<?php echo $user['joinedDate'] == '0000-00-00' ? ' text-danger' : 'text-black' ?>"><?php echo $user['joinedDate'] != '0000-00-00' ? $user['joinedDate'] : lang('NO DATA') ?></span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- hstack for buttons -->
        <div class="hstack gap-2">
          <a href="?do=edit-user-info&userid=<?php echo base64_encode($user_id) ?>" class="p-1 <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'me-auto' : 'ms-auto' ?> btn btn-primary py-1 fs-12 <?php echo $_SESSION['sys']['UserID'] != $user['UserID'] && $_SESSION['sys']['user_update'] == 0 ? 'disabled' : '' ?>" style="width: 120px">
            <i class="bi bi-pencil-square"></i>
            <?php echo lang('EDIT', $lang_file) ?>
          </a>
          <?php if ($user['TrustStatus'] != 1 && $user['job_title_id'] != 1 && $_SESSION['sys']['user_delete'] == 1) { ?>
            <button type="button" data-bs-toggle="modal" data-bs-target="#deleteUserModal" onclick="show_delete_user_modal(this)" data-username="<?php echo $user['UserName'] ?>" data-user-id="<?php echo base64_encode($user_id) ?>" class="btn btn-outline-danger text-capitalize py-1 fs-12"><i class="bi bi-trash"></i>&nbsp;<?php echo lang('DELETE') ?></button>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
  <!-- end new design -->
</div>

<?php if ($_SESSION['sys']['user_delete'] == 1) {
  include_once 'delete-user-modal.php';
} ?>