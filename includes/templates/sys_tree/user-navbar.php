<!-- start sidebar menu -->
<div class="sidebar-menu sidebar-menu-<?php echo @$_SESSION['systemLang'] == 'ar' ? 'right' : 'left' ?> close">
  <!-- start sidebar menu brand -->
  <div class="sidebar-menu-brand" href="dashboard.php" <?php if (!isset($_SESSION['UserName'])) { echo "style='margin: auto'"; } ?>>
    <img class="sidebar-menu-logo-img" src="<?php echo $assets ?>jsl.jpeg" alt="<?php echo isset($_SESSION['company_name']) ? $_SESSION['company_name'] : language('NOT ASSIGNED') ?>">
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
        <?php if ($_SESSION['user_add'] == 0) { ?>
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
          <a href="<?php echo $nav_up_level ?>pieces/index.php?name=pieces&do=show-connections-types">
              <span class="link-name"><?php echo language('MANAGE', @$_SESSION['systemLang'])." ".language('CONNECTION TYPES', @$_SESSION['systemLang']) ?></span>
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
          <?php $profile_img = $uploads . "employees-img/" . (empty($_SESSION['profile_img']) ? "male-avatar.svg" : "/".$_SESSION['company_id']."/".$_SESSION['profile_img']) ;?>
          <img src="<?php echo $profile_img ?>" class="profile-img">
        </div>
          <div class="name-job">
            <div class="profile-name"><?php echo $_SESSION['UserName'] ?></div>
            <?php if (!empty($_SESSION['job_title_id'])) { ?>
              <div class="profile-job">
                <?php 
                  // create an object of Database class
                  $db_obj = new Database();
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
  <!-- <img src="<?php echo $assets ?>eid-mobarak-2.png" class="bg-event-img" alt=""> -->