<!-- start sidebar menu -->
<div class="sidebar-menu sidebar-menu-<?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?> close">
  <!-- start sidebar menu brand -->
  <div class="sidebar-menu-brand" href="dashboard.php" <?php echo !isset($_SESSION['sys']['UserName']) ? "style='margin: auto'" : "" ?>>
    <div class="brand-container" style="align-self: center;">
      <?php
      $db_obj = !isset($db_obj) ? new Database() : $db_obj;

      $company_img_name_db = $db_obj->select_specific_column("`company_img`", "`companies`", "WHERE `company_id` = " . base64_decode($_SESSION['sys']['company_id']));
      $company_img_name_db = count($company_img_name_db) > 0 ? $company_img_name_db[0]['company_img'] : null;
      $company_img_name = empty($company_img_name_db) || $company_img_name_db == null ? 'systree.jpg' : $company_img_name_db;
      $company_img_path = empty($company_img_name_db) || $company_img_name_db == null ? $systree_assets : $uploads . "companies-img/" . base64_decode($_SESSION['sys']['company_id']);
      // check if image exists
      $img_file = file_exists("$company_img_path/$company_img_name") ? "$company_img_path/$company_img_name" : $systree_assets . "systree.jpg";
      // resize company image
      $is_resized = resize_img($company_img_path . "/", $company_img_name);
      ?>
      <img
        src="<?php echo $is_resized ? "$company_img_path/resized/$company_img_name" : "$company_img_path/$company_img_name" ?>"
        class="sidebar-menu-logo-img" <?php if (empty($company_img_name_db) || $company_img_name_db == null) { ?> style=""
        <?php } ?>
        alt="<?php echo isset($_SESSION['sys']['company_name']) ? $_SESSION['sys']['company_name'] : lang('NOT ASSIGNED') ?>"
        id="company-img-brand">
      <span class="sidebar-menu-logo-name text-uppercase ">
        <?php echo isset($_SESSION['sys']['company_name']) ? $_SESSION['sys']['company_name'] : lang('NOT ASSIGNED') ?>
      </span>
    </div>
    <!-- close icon displayed in small screens -->
    <span class="close-btn"><i class="bi bi-x"></i></span>
  </div>
  <!-- end sidebar menu brand -->
  <!-- start sidebar menu content -->
  <ul class="nav-links">
    <!-- start dashboard page link -->
    <li>
      <a href="<?php echo $nav_up_level ?>dashboard/index.php">
        <i class="bi bi-grid"></i>
        <span class="link-name">
          <?php echo lang('DASHBOARD') ?>
        </span>
      </a>
      <!-- start blank sub menu -->
      <ul class="sub-menu blank">
        <li>
          <a href="<?php echo $nav_up_level ?>dashboard/index.php">
            <span class="link-name">
              <?php echo lang('DASHBOARD') ?>
            </span>
          </a>
        </li>
      </ul>
      <!-- end blank sub menu -->
    </li>
    <!-- end dashboard page link -->

    <!-- start employee nav link -->
    <li>
      <!-- start link containing sub menu -->
      <div class="icon-link">
        <section>
          <i class="bi bi-building"></i>
          <span class="link-name">
            <?php echo lang('COMPANIES') ?>
          </span>
        </section>
        <i class="bi bi-arrow-down-short"></i>
      </div>
      <!-- end link containing sub menu -->
      <!-- start sub menu -->
      <ul class="sub-menu">
        <li>
          <a href="<?php echo $nav_up_level ?>companies/index.php?do=list">
            <span class="link-name">
              <?php echo lang('LIST') ?>
            </span>
          </a>
        </li>
      </ul>
      <!-- end sub menu -->
    </li>
    <!-- end employee nav link -->

    <!-- start setting nav link -->
    <li>
      <!-- <a href="<?php echo $nav_up_level ?>settings/index.php">
        <i class="bi bi-gear"></i>
        <span class="link-name">
          <?php echo lang('SETTINGS') ?>
        </span>
      </a> -->
      <!-- start blank sub menu -->
      <!-- <ul class="sub-menu blank">
        <li>
          <a href="<?php echo $nav_up_level ?>settings/index.php">
            <span class="link-name">
              <?php echo lang('SETTINGS') ?>
            </span>
          </a>
        </li>
      </ul> -->
      <!-- end blank sub menu -->
    </li>
    <li>
      <a href="<?php echo $sys_tree ?>logout.php">
        <i class="bi bi-box-arrow-right"></i>
        <span class="link-name">
          <?php echo lang('LOGOUT') ?>
        </span>
      </a>
    </li>
    <!-- start setting nav link -->
    <?php if (isset($_SESSION['sys']['UserName'])) { ?>
      <!-- start profile details nav link -->
      <li>
        <!-- start profile details -->
        <div class="profile-details">
          <a href="">
            <!-- href="<?php echo $nav_up_level ?>users/index.php?do=edit-user-info&userid=<?php echo $_SESSION['sys']['UserID']; ?>"> -->
            <div class="profile-content">
              <?php $profile_img_name = empty($_SESSION['sys']['profile_img']) || !file_exists($uploads . "employees-img/" . base64_decode($_SESSION['sys']['company_id']) . "/" . $_SESSION['sys']['profile_img']) ? "male-avatar.svg" : base64_decode($_SESSION['sys']['company_id']) . "/" . $_SESSION['sys']['profile_img']; ?>
              <?php $profile_img_path = $uploads . "employees-img/" . $profile_img_name; ?>
              <img src="<?php echo $profile_img_path ?>" class="profile-img">
            </div>
            <div class="name-job">
              <div class="profile-name">
                <?php echo $_SESSION['sys']['UserName'] ?>
              </div>
              <?php if (!empty($_SESSION['sys']['job_title_id'])) { ?>
                <div class="profile-job">
                  <?php
                  $db_obj = !isset($db_obj) ? new Database() : $db_obj;
                  // get job title
                  $job_title = $db_obj->select_specific_column("`job_title_name`", "`users_job_title`", "WHERE `job_title_id` = " . base64_decode($_SESSION['sys']['job_title_id']))[0]['job_title_name'];
                  // display job title
                  echo lang($job_title);
                  ?>
                </div>
              <?php } ?>
            </div>
          </a>
        </div>
        <!-- end profile details -->
      </li>
      <!-- start profile details nav link -->
    <?php } ?>
  </ul>
  <!-- end sidebar menu content -->
</div>
<!-- end sidebar menu -->

<div class="top-navbar top-navbar-<?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
  <div class="top-navbar-content">
    <i class="bi bi-list sidebar-menubtn"></i>

    <?php if (isset($possible_back) && $possible_back == true) { ?>
      <a href="<?php echo $nav_up_level ?>requests/index.php?do=update-session&user-id=<?php echo $_SESSION['sys']['UserID'] ?>"
        class="btn btn-outline-light py-1 fs-12 <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'me-auto' : 'ms-auto' ?> mx-3">
        <span>
          <?php echo lang('REFRESH SESSION') ?>
        </span>
      </a>
      <button
        class="btn btn-outline-light text-capitalize py-1 fs-12 <?php echo $_SESSION['sys']['lang'] == 'ar' ? 'me-auto' : 'ms-auto' ?>"
        onclick="history_control()">
        <i class="bi bi-arrow-return-left"></i>
      </button>
    <?php } ?>
  </div>
</div>

<div class="main-content">