<!-- start sidebar menu -->
<div class="sidebar-menu sidebar-menu-<?php echo @$_SESSION['systemLang'] == 'ar' ? 'right' : 'left' ?> close">
  <!-- start sidebar menu brand -->
  <div class="sidebar-menu-brand" href="dashboard.php" <?php if (!isset($_SESSION['UserName'])) { echo "style='margin: auto'"; } ?>>
    <?php 
    if (!isset($db_obj)) {
      $db_obj = new Database();
    }

    $company_img_name_db = $db_obj->select_specific_column("`company_img`", "`companies`", "WHERE `company_id` = ".$_SESSION['company_id'])[0]['company_img'];
    $company_img_name = empty($company_img_name_db) ? 'leadergroupegypt.jpg' : $company_img_name_db;
    $company_img_path = empty($company_img_name_db) ? $uploads . "companies-img" : $uploads . "companies-img/".$_SESSION['company_id']; 
    ?>
    <img src="<?php echo "$company_img_path/$company_img_name" ?>" class="sidebar-menu-logo-img" alt="<?php echo isset($_SESSION['company_name']) ? $_SESSION['company_name'] : language('NOT ASSIGNED') ?>" id="company-img-brand" >
    <!-- <img  src="<?php echo $assets ?>jsl.jpeg" > -->
    <span class="sidebar-menu-logo-name text-uppercase "><?php echo isset($_SESSION['company_name']) ? $_SESSION['company_name'] : language('NOT ASSIGNED') ?></span>
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
        <span class="link-name"><?php echo language('DASHBOARD', @$_SESSION['systemLang']) ?></span>
      </a>
      <!-- start blank sub menu -->
      <ul class="sub-menu blank">
        <li>
          <a href="<?php echo $nav_up_level ?>dashboard/index.php">
            <span class="link-name"><?php echo language('DASHBOARD', @$_SESSION['systemLang']) ?></span>
          </a>
        </li>
      </ul>
      <!-- end blank sub menu -->
    </li>
    <!-- end dashboard page link -->

    <?php if ($_SESSION['user_show'] == 1) { ?>
    <!-- start employee nav link -->
    <li>
      <!-- start link containing sub menu -->
      <div class="icon-link">
        <section>
          <i class="bi bi-people"></i>
          <span class="link-name"><?php echo language('THE EMPLOYEES', @$_SESSION['systemLang']) ?></span>
        </section>
        <i class="bi bi-arrow-down-short"></i>
      </div>
      <!-- end link containing sub menu -->
      <!-- start sub menu -->
      <ul class="sub-menu">
        <?php if ($_SESSION['user_show'] == 1) { ?>
        <li>
          <a href="<?php echo $nav_up_level ?>users/index.php">
            <span class="link-name"><?php echo language('EMPLOYEES LIST', @$_SESSION['systemLang']) ?></span>
          </a>
        </li>
        <?php } ?>
        <?php if ($_SESSION['user_add'] == 1) { ?>
        <li>
          <a href="<?php echo $nav_up_level ?>users/index.php?do=add-new-user">
            <span class="link-name"><?php echo language('ADD NEW EMPLOYEE', @$_SESSION['systemLang']) ?></span>
          </a>
        </li>
        <?php } ?>
      </ul>
      <!-- end sub menu -->
    </li>
    <!-- end employee nav link -->
    <?php } ?>

    <?php if ($_SESSION['dir_show'] == 1) { ?>
    <!-- start directions nav link -->
    <li>
      <div class="icon-link">
        <section>
          <i class="bi bi-diagram-3"></i>
          <span class="link-name"><?php echo language('THE DIRECTIONS', @$_SESSION['systemLang']) ?></span>
        </section>
        <i class="bi bi-arrow-down-short"></i>
      </div>
      <!-- start sub menu -->
      <ul class="sub-menu">
        <?php if ($_SESSION['dir_show'] == 1) { ?>
        <li>
          <a href="<?php echo $nav_up_level ?>directions/index.php">
            <span class="link-name"><?php echo language('DIRECTIONS LIST', @$_SESSION['systemLang']) ?></span>
          </a>
        </li>
        <?php } ?>
        <?php if ($_SESSION['dir_add'] == 1) { ?>
        <li>
          <a href="#" data-bs-toggle="modal" data-bs-target="#addNewDirectionModal">
            <span class="link-name"><?php echo language('ADD NEW DIRECTION', @$_SESSION['systemLang']) ?></span>
          </a>
        </li>
        <?php } ?>
      </ul>
      <!-- end sub menu -->
    </li>
    <!-- end directions nav link -->
    <?php } ?>

    <?php if ($_SESSION['pcs_show'] == 1 || $_SESSION['pcs_add'] == 1) { ?>
    <!-- start pieces nav link -->
    <li>
      <div class="icon-link">
        <section>
          <i class="bi bi-router"></i>
          <span class="link-name"><?php echo language('PIECES', @$_SESSION['systemLang']) ?></span>
        </section>
        <i class="bi bi-arrow-down-short"></i>
      </div>
      <!-- start sub menu -->
      <ul class="sub-menu">
        <?php if ($_SESSION['pcs_show'] == 1) { ?>
        <li>
          <a href="<?php echo $nav_up_level ?>pieces/index.php?name=pieces">
              <span class="link-name"><?php echo language('DASHBOARD', @$_SESSION['systemLang']) ?></span>
          </a>
        </li>
        <li>
          <a href="<?php echo $nav_up_level ?>pieces/index.php?name=pieces&do=show-all-pieces">
              <span class="link-name"><?php echo language('PIECES LIST', @$_SESSION['systemLang']) ?></span>
          </a>
        </li>
        <li>
          <a href="<?php echo $nav_up_level ?>pieces/index.php?name=pieces&do=devices-companies">
              <span class="link-name"><?php echo language('MANAGE', @$_SESSION['systemLang'])." ".language('PIECES TYPES', @$_SESSION['systemLang']) ?></span>
          </a>
        </li>
        <?php } ?>
        <?php if ($_SESSION['pcs_add'] == 1) { ?>
        <li>
          <a href="<?php echo $nav_up_level ?>pieces/index.php?name=pieces&do=add-new-piece">
              <span class="link-name"><?php echo language('ADD NEW PIECE', @$_SESSION['systemLang']) ?></span>
          </a>
        </li>
        <?php } ?>
      </ul>
      <!-- end sub menu -->
    </li>
    <!-- end pieces nav link -->
    <?php } ?>
    
    <?php if ($_SESSION['connection_add'] == 1 || $_SESSION['connection_show'] == 1) { ?>
    <!-- start dashboard page link -->
    <li>
      <div class="icon-link">
        <section>
          <i class="bi bi-hdd-network"></i>
          <span class="link-name"><?php echo language('CONNECTION TYPES', @$_SESSION['systemLang']) ?></span>
        </section>
        <i class="bi bi-arrow-down-short"></i>
      </div>
      <!-- start blank sub menu -->
      <ul class="sub-menu">
        <li>
          <a href="<?php echo $nav_up_level ?>pieces-connection/index.php">
            <span class="link-name"><?php echo language('DASHBOARD', @$_SESSION['systemLang']) ?></span>
          </a>
        </li>
        <?php if ($_SESSION['connection_add'] == 1) { ?>
        <li>
          <a href="#" data-bs-toggle="modal" data-bs-target="#addNewPieceConnTypeModal">
            <span class="link-name"><?php echo language('ADD NEW CONNECTION TYPE', @$_SESSION['systemLang']) ?></span>
          </a>
        </li>
        <?php } ?>
        <?php
        if (!isset($pcs_conn_obj)) {
          // create an object of PiecesConn class
          $pcs_conn_obj = new PiecesConn();
        }
        // get all connections 
        $conn_data_types = $pcs_conn_obj->count_records("`id`", "`connection_types`", "WHERE `company_id` = ". $_SESSION['company_id']);
        ?>
        <?php if ($_SESSION['connection_update'] == 1 && $conn_data_types > 0) { ?>
        <li>
          <a href="#" data-bs-toggle="modal" data-bs-target="#editPieceConnTypeModal">
            <span class="link-name"><?php echo language('EDIT CONNECTION TYPES', @$_SESSION['systemLang']) ?></span>
          </a>
        </li>
        <?php } ?>
        <?php if ($_SESSION['connection_delete'] == 1 && $conn_data_types > 0) { ?>
        <li>
          <a href="#" data-bs-toggle="modal" data-bs-target="#deletePieceConnTypeModal">
            <span class="link-name"><?php echo language('DELETE CONNECTION TYPE', @$_SESSION['systemLang']) ?></span>
          </a>
        </li>
        <?php } ?>
      </ul>
      <!-- end blank sub menu -->
    </li>
    <!-- end dashboard page link -->
    <?php } ?>

    <?php if ($_SESSION['pcs_show'] == 1 || $_SESSION['pcs_add'] == 1) { ?>
    <!-- start clients nav link -->
    <li>
      <div class="icon-link">
        <section>
          <i class="bi bi-people"></i>
          <span class="link-name"><?php echo language('CLIENTS', @$_SESSION['systemLang']) ?></span>
        </section>
        <i class="bi bi-arrow-down-short"></i>
      </div>
      <!-- start sub menu -->
      <ul class="sub-menu">
        <?php if ($_SESSION['pcs_show'] == 1) { ?>
        <li>
          <a href="<?php echo $nav_up_level ?>pieces/index.php?name=clients">
            <span class="link-name"><?php echo language('DASHBOARD', @$_SESSION['systemLang']) ?></span>
          </a>
        </li>
        <li>
          <a href="<?php echo $nav_up_level ?>pieces/index.php?name=clients&do=show-all-clients">
            <span class="link-name"><?php echo language('CLIENTS LIST', @$_SESSION['systemLang']) ?></span>
          </a>
        </li>
        <?php } ?>
        <?php if ($_SESSION['pcs_add'] == 1) { ?>
        <li>
          <a href="<?php echo $nav_up_level ?>pieces/index.php?name=clients&do=add-new-piece">
            <span class="link-name"><?php echo language('ADD NEW CLIENT', @$_SESSION['systemLang']) ?></span>
          </a>
        </li>
        <?php } ?>
      </ul>
      <!-- end sub menu -->
    </li>
    <!-- end clients nav link -->
    <?php } ?>

    <?php if ($_SESSION['mal_show'] == 1 || $_SESSION['mal_add'] == 1) { ?>
    <!-- start malfunctions nav link -->
    <li>
      <div class="icon-link">
        <section>
          <i class="bi bi-lightning-charge"></i>
          <span class="link-name"><?php echo language('THE MALFUNCTIONS', @$_SESSION['systemLang']) ?></span>
        </section>
        <i class="bi bi-arrow-down-short"></i>
      </div>
      <!-- start sub menu -->
      <ul class="sub-menu">
        <?php if ($_SESSION['mal_show'] == 1) { ?>
        <li>
          <a href="<?php echo $nav_up_level ?>malfunctions/index.php">
            <span class="link-name"><?php echo language('DASHBOARD', @$_SESSION['systemLang']) ?></span>
          </a>
        </li>
        <?php } ?>
        <?php if ($_SESSION['mal_add'] == 1) { ?>
        <li>
          <a href="<?php echo $nav_up_level ?>malfunctions/index.php?do=add-new-malfunction">
            <span class="link-name"><?php echo language('ADD NEW MALFUNCTION', @$_SESSION['systemLang']) ?></span>
          </a>
        </li>
        <?php } ?>
      </ul>
      <!-- end sub menu -->
      <?php } ?>
    </li>
    <!-- end malfunctions nav link -->

    <?php if ($_SESSION['comb_show'] == 1 || $_SESSION['comb_add'] == 1) { ?>
    <!-- start combinations nav link -->
    <li>
      <div class="icon-link">
        <section>
          <i class="bi bi-braces-asterisk"></i>
          <span class="link-name"><?php echo language('THE COMBINATIONS', @$_SESSION['systemLang']) ?></span>
        </section>
        <i class="bi bi-arrow-down-short"></i>
      </div>
      <!-- start sub menu -->
      <ul class="sub-menu">
        <?php if ($_SESSION['comb_show'] == 1) { ?>
        <li>
          <a href="<?php echo $nav_up_level ?>combinations/index.php">
            <span class="link-name"><?php echo language('DASHBOARD', @$_SESSION['systemLang']) ?></span>
          </a>
        </li>
        <?php } ?>
        <?php if ($_SESSION['comb_add'] == 1) { ?>
        <li>
          <a href="<?php echo $nav_up_level ?>combinations/index.php?do=addCombinations">
            <span class="link-name"><?php echo language('ADD NEW COMBINATION', @$_SESSION['systemLang']) ?></span>
          </a>
        </li>
        <?php } ?>
      </ul>
      <!-- end sub menu -->
    </li>
    <!-- end combinations nav link -->
    <?php } ?>
    <!-- start setting nav link -->
    <li>
      <a href="<?php echo $nav_up_level ?>settings/index.php">
        <i class="bi bi-gear"></i>
        <span class="link-name"><?php echo language('SETTINGS', @$_SESSION['systemLang']) ?></span>
      </a>
      <!-- start blank sub menu -->
      <ul class="sub-menu blank">
        <li>
          <a href="<?php echo $nav_up_level ?>settings/index.php">
            <span class="link-name"><?php echo language('SETTINGS', @$_SESSION['systemLang']) ?></span>
          </a>
        </li>
      </ul>
      <!-- end blank sub menu -->
    </li>
    <li>
      <a href="<?php echo $sys_tree ?>logout.php" class="logout-btn">
        <i class="bi bi-box-arrow-right"></i>
        <span class="link-name"><?php echo language('LOG OUT', @$_SESSION['systemLang']) ?></span>
      </a>
    </li>
    <!-- start setting nav link -->
    <?php if (isset($_SESSION['UserName'])) { ?>
    <!-- start profile details nav link -->
    <li>
      <!-- start profile details -->
      <div class="profile-details">
        <a href="<?php echo $nav_up_level ?>users/index.php?do=edit-user-info&userid=<?php echo $_SESSION['UserID']; ?>">
        <div class="profile-content">
          <?php $profile_img_name = empty($_SESSION['profile_img']) ? "male-avatar.svg" : $_SESSION['company_id']."/". $_SESSION['profile_img']; ?>
          <?php $profile_img_path = $uploads . "employees-img/" . $profile_img_name ;?>
          <img src="<?php echo $profile_img_path ?>" class="profile-img">
        </div>
          <div class="name-job">
            <div class="profile-name"><?php echo $_SESSION['UserName'] ?></div>
            <?php if (!empty($_SESSION['job_title_id'])) { ?>
              <div class="profile-job">
                <?php 
                  if (!isset($db_obj)) {
                    // create an object of Database class
                    $db_obj = new Database();
                  }
                  // get job title
                  echo $db_obj->select_specific_column("`job_title_name`", "`users_job_title`", "WHERE `job_title_id` = " . $_SESSION['job_title_id'])[0]['job_title_name'] ?>
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

<div class="top-navbar top-navbar-<?php echo @$_SESSION['systemLang'] == 'ar' ? 'right' : 'left' ?>">
  <div class="top-navbar-content">
    <i class="bi bi-list sidebar-menubtn"></i>  
    <?php if (isset($_SESSION['isTrial']) && $_SESSION['isTrial'] == 1) {?>
      <span class="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'me-auto' : 'ms-auto' ?> mx-3">
        <span class="badge bg-danger"><?php echo language("TRIAL", @$_SESSION['systemLang']) ?></span>
      </span>
    <?php } ?>
    
    <?php if ($possible_back == true) { ?>
      <a href="<?php echo $nav_up_level ?>requests/index.php?do=update-session&user-id=<?php echo $_SESSION['UserID'] ?>" class="btn btn-outline-light py-1 fs-12 <?php echo @$_SESSION['systemLang'] == 'ar' ? 'me-auto' : 'ms-auto' ?> mx-3">
        <span><?php echo language('REFRESH SESSION', @$_SESSION['systemLang']) ?></span>
      </a>
      <button class="btn btn-outline-light text-capitalize py-1 fs-12 <?php echo $_SESSION['systemLang'] == 'ar' ? 'me-auto' : 'ms-auto' ?>" onclick="history_control()">
        <i class="bi bi-arrow-return-left"></i>
      </button>
    <?php } ?>
  </div>
</div>

<div class="main-content">

  <?php # if ($preloader == true && !empty($_SESSION['phone']) && isset($_SESSION['is_activated_phone']) && $_SESSION['is_activated_phone'] == 0) { ?>
  <!-- <div class="m-auto container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
    <div class="alert alert-warning" role="alert">
      <i class="bi bi-exclamation-triangle-fill"></i>
      <span><?php echo language('HI', @$_SESSION['systemLang']) . ' ' . $_SESSION['UserName'] ?>,&nbsp;</span>
      <span><?php echo language('YOUR PHONE NUMBER IS NOT ACTIVATED!', @$_SESSION['systemLang']) ?></span> -->
      <!-- <a class="alert-link" href="<?php echo $nav_up_level ?>requests/index.php?do=activate-phone-number"><?php # echo language('SEND ACTIVATION CODE', @$_SESSION['systemLang']) ?>&nbsp;<i class="bi bi-arrow-up-left-square"></i></a> -->
      <!-- <button type="button" class="btn-close btn-close-<?php echo @$_SESSION['systemLang'] == 'ar' ? 'left' : 'right' ?>" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  </div> -->
  <?php # } ?>
