<!-- start sidebar menu -->
<div class="sidebar-menu sidebar-menu-<?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?> close">
  <!-- start sidebar menu brand -->
  <div class="sidebar-menu-brand" href="dashboard.php" <?php echo !isset($_SESSION['sys']['UserName']) ? "style='margin: auto'" : "" ?>>
    <div class="brand-container" style="align-self: center;">
      <?php
      $db_obj = !isset($db_obj) ? new Database() : $db_obj;

      $company_img_name_db = $db_obj->select_specific_column("`company_img`", "`companies`", "WHERE `company_id` = " . base64_decode($_SESSION['sys']['company_id']));
      $company_img_name_db = count($company_img_name_db) > 0 ? $company_img_name_db[0]['company_img'] : null;
      $company_img_name = empty($company_img_name_db) || $company_img_name_db == null ? 'systree.png' : $company_img_name_db;
      $company_img_path = empty($company_img_name_db) || $company_img_name_db == null ? $systree_assets : $uploads . "companies-img/" . base64_decode($_SESSION['sys']['company_id']);
      // check if image exists
      $img_file = file_exists("$company_img_path/$company_img_name") ? "$company_img_path/$company_img_name" : $systree_assets . "systree.png";
      // resize company image
      $is_resized = resize_img($company_img_path."/", $company_img_name);
      ?>
      <img src="<?php echo $is_resized ? "$company_img_path/resized/$company_img_name" : "$company_img_path/$company_img_name" ?>" class="sidebar-menu-logo-img" <?php if (empty($company_img_name_db) || $company_img_name_db == null) { ?> style="" <?php } ?>
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

    <?php if ($_SESSION['sys']['user_show'] == 1) { ?>
      <!-- start employee nav link -->
      <li>
        <!-- start link containing sub menu -->
        <div class="icon-link">
          <section>
            <i class="bi bi-people"></i>
            <span class="link-name">
              <?php echo lang('EMPLOYEES') ?>
            </span>
          </section>
          <i class="bi bi-arrow-down-short"></i>
        </div>
        <!-- end link containing sub menu -->
        <!-- start sub menu -->
        <ul class="sub-menu">
          <?php if ($_SESSION['sys']['user_show'] == 1) { ?>
            <li>
              <a href="<?php echo $nav_up_level ?>users/index.php">
                <span class="link-name">
                  <?php echo lang('LIST', 'employees') ?>
                </span>
              </a>
            </li>
          <?php } ?>
          <?php if ($_SESSION['sys']['user_add'] == 1) { ?>
            <li>
              <a href="<?php echo $nav_up_level ?>users/index.php?do=add-new-user">
                <span class="link-name">
                  <?php echo lang('ADD NEW', 'employees') ?>
                </span>
              </a>
            </li>
          <?php } ?>
        </ul>
        <!-- end sub menu -->
      </li>
      <!-- end employee nav link -->
    <?php } ?>

    <?php if ($_SESSION['sys']['dir_show'] == 1) { ?>
      <!-- start directions nav link -->
      <li>
        <div class="icon-link">
          <section>
            <i class="bi bi-diagram-3"></i>
            <span class="link-name">
              <?php echo lang('DIRECTIONS') ?>
            </span>
          </section>
          <i class="bi bi-arrow-down-short"></i>
        </div>
        <!-- start sub menu -->
        <ul class="sub-menu">
          <?php if ($_SESSION['sys']['dir_show'] == 1) { ?>
            <li>
              <a href="<?php echo $nav_up_level ?>directions/index.php">
                <span class="link-name">
                  <?php echo lang('LIST', "directions") ?>
                </span>
              </a>
            </li>
          <?php } ?>
          <?php if ($_SESSION['sys']['dir_add'] == 1) { ?>
            <li>
              <a href="#" data-bs-toggle="modal" data-bs-target="#addNewDirectionModal">
                <span class="link-name">
                  <?php echo lang('ADD NEW', "directions") ?>
                </span>
              </a>
            </li>
          <?php } ?>
        </ul>
        <!-- end sub menu -->
      </li>
      <!-- end directions nav link -->
    <?php } ?>

    <?php if ($_SESSION['sys']['pcs_show'] == 1 || $_SESSION['sys']['pcs_add'] == 1) { ?>
      <!-- start pieces nav link -->
      <li>
        <div class="icon-link">
          <section>
            <i class="bi bi-router"></i>
            <span class="link-name">
              <?php echo lang('PIECES') ?>
            </span>
          </section>
          <i class="bi bi-arrow-down-short"></i>
        </div>
        <!-- start sub menu -->
        <ul class="sub-menu">
          <?php if ($_SESSION['sys']['pcs_show'] == 1) { ?>
            <li>
              <a href="<?php echo $nav_up_level ?>pieces/index.php">
                <span class="link-name">
                  <?php echo lang('DASHBOARD') ?>
                </span>
              </a>
            </li>
            <li>
              <a href="<?php echo $nav_up_level ?>pieces/index.php?do=show-all-pieces">
                <span class="link-name">
                  <?php echo lang('LIST', 'pieces') ?>
                </span>
              </a>
            </li>
            <li>
              <a href="<?php echo $nav_up_level ?>pieces/index.php?do=devices-companies">
                <span class="link-name">
                  <?php echo lang('PCS TYPES', 'pieces') ?>
                </span>
              </a>
            </li>
          <?php } ?>
          <?php if ($_SESSION['sys']['pcs_add'] == 1) { ?>
            <li>
              <a href="<?php echo $nav_up_level ?>pieces/index.php?do=add-new-piece">
                <span class="link-name">
                  <?php echo lang('ADD NEW', 'pieces') ?>
                </span>
              </a>
            </li>
          <?php } ?>
        </ul>
        <!-- end sub menu -->
      </li>
      <!-- end pieces nav link -->
    <?php } ?>

    <?php if ($_SESSION['sys']['connection_add'] == 1 || $_SESSION['sys']['connection_show'] == 1) { ?>
      <!-- start dashboard page link -->
      <li>
        <div class="icon-link">
          <section>
            <i class="bi bi-hdd-network"></i>
            <span class="link-name">
              <?php echo lang('CONNECTION TYPES') ?>
            </span>
          </section>
          <i class="bi bi-arrow-down-short"></i>
        </div>
        <!-- start blank sub menu -->
        <ul class="sub-menu">
          <li>
            <a href="<?php echo $nav_up_level ?>pieces-connection/index.php">
              <span class="link-name">
                <?php echo lang('DASHBOARD') ?>
              </span>
            </a>
          </li>
          <?php if ($_SESSION['sys']['connection_add'] == 1) { ?>
            <li>
              <a href="#" data-bs-toggle="modal" data-bs-target="#addNewPieceConnTypeModal">
                <span class="link-name">
                  <?php echo lang('ADD NEW', 'pcs_conn') ?>
                </span>
              </a>
            </li>
          <?php } ?>
          <?php
          // create an object of PiecesConn class
          $pcs_conn_obj = !isset($pcs_conn_obj) ? new PiecesConn() : $pcs_conn_obj;
          // get all connections 
          $conn_data_types = $pcs_conn_obj->count_records("`id`", "`connection_types`", "WHERE `company_id` = " . base64_decode($_SESSION['sys']['company_id']));
          ?>
          <?php if ($_SESSION['sys']['connection_update'] == 1 && $conn_data_types > 0) { ?>
            <li>
              <a href="#" data-bs-toggle="modal" data-bs-target="#editPieceConnTypeModal">
                <span class="link-name">
                  <?php echo lang('EDIT CONN', 'pcs_conn') ?>
                </span>
              </a>
            </li>
          <?php } ?>
          <?php if ($_SESSION['sys']['connection_delete'] == 1 && $conn_data_types > 0) { ?>
            <li>
              <a href="#" data-bs-toggle="modal" data-bs-target="#deletePieceConnTypeModal">
                <span class="link-name">
                  <?php echo lang('DELETE CONN', 'pcs_conn') ?>
                </span>
              </a>
            </li>
          <?php } ?>
        </ul>
        <!-- end blank sub menu -->
      </li>
      <!-- end dashboard page link -->
    <?php } ?>

    <?php if ($_SESSION['sys']['clients_show'] == 1 || $_SESSION['sys']['clients_add'] == 1) { ?>
      <!-- start clients nav link -->
      <li>
        <div class="icon-link">
          <section>
            <i class="bi bi-people"></i>
            <span class="link-name">
              <?php echo lang('CLIENTS') ?>
            </span>
          </section>
          <i class="bi bi-arrow-down-short"></i>
        </div>
        <!-- start sub menu -->
        <ul class="sub-menu">
          <?php if ($_SESSION['sys']['clients_show'] == 1) { ?>
            <li>
              <a href="<?php echo $nav_up_level ?>clients/index.php">
                <span class="link-name">
                  <?php echo lang('DASHBOARD') ?>
                </span>
              </a>
            </li>
            <li>
              <a href="<?php echo $nav_up_level ?>clients/index.php?do=show-all-clients">
                <span class="link-name">
                  <?php echo lang('LIST', 'clients') ?>
                </span>
              </a>
            </li>
          <?php } ?>
          <?php if ($_SESSION['sys']['clients_add'] == 1) { ?>
            <li>
              <a href="<?php echo $nav_up_level ?>clients/index.php?do=add-new-client">
                <span class="link-name">
                  <?php echo lang('ADD NEW', 'clients') ?>
                </span>
              </a>
            </li>
          <?php } ?>
        </ul>
        <!-- end sub menu -->
      </li>
      <!-- end clients nav link -->
    <?php } ?>

    <?php if ($_SESSION['sys']['mal_show'] == 1 || $_SESSION['sys']['mal_add'] == 1) { ?>
      <!-- start malfunctions nav link -->
      <li>
        <div class="icon-link">
          <section>
            <i class="bi bi-lightning-charge"></i>
            <span class="link-name">
              <?php echo lang('MALS') ?>
            </span>
          </section>
          <i class="bi bi-arrow-down-short"></i>
        </div>
        <!-- start sub menu -->
        <ul class="sub-menu">
          <?php if ($_SESSION['sys']['mal_show'] == 1) { ?>
            <li>
              <a href="<?php echo $nav_up_level ?>malfunctions/index.php">
                <span class="link-name">
                  <?php echo lang('DASHBOARD') ?>
                </span>
              </a>
            </li>
          <?php } ?>
          <?php if ($_SESSION['sys']['mal_add'] == 1) { ?>
            <li>
              <a href="<?php echo $nav_up_level ?>malfunctions/index.php?do=add-new-malfunction">
                <span class="link-name">
                  <?php echo lang('ADD NEW', 'malfunctions') ?>
                </span>
              </a>
            </li>
          <?php } ?>
        </ul>
        <!-- end sub menu -->
      <?php } ?>
    </li>
    <!-- end malfunctions nav link -->

    <?php if ($_SESSION['sys']['comb_show'] == 1 || $_SESSION['sys']['comb_add'] == 1) { ?>
      <!-- start combinations nav link -->
      <li>
        <div class="icon-link">
          <section>
            <i class="bi bi-braces-asterisk"></i>
            <span class="link-name">
              <?php echo lang('COMBS') ?>
            </span>
          </section>
          <i class="bi bi-arrow-down-short"></i>
        </div>
        <!-- start sub menu -->
        <ul class="sub-menu">
          <?php if ($_SESSION['sys']['comb_show'] == 1) { ?>
            <li>
              <a href="<?php echo $nav_up_level ?>combinations/index.php">
                <span class="link-name">
                  <?php echo lang('DASHBOARD') ?>
                </span>
              </a>
            </li>
          <?php } ?>
          <?php if ($_SESSION['sys']['comb_add'] == 1) { ?>
            <li>
              <a href="<?php echo $nav_up_level ?>combinations/index.php?do=add-new-combination">
                <span class="link-name">
                  <?php echo lang('ADD NEW', 'combinations') ?>
                </span>
              </a>
            </li>
          <?php } ?>
        </ul>
        <!-- end sub menu -->
      </li>
      <!-- end combinations nav link -->
    <?php } ?>
    <!-- <li>
      <div class="icon-link">
        <section>
          <i class="bi bi-lightbulb"></i>
          <span class="link-name" style="font-size: 12px!important;"><?php echo lang('COMPLAINTS & SUGGESTIONS') ?></span>
        </section>
      </div>
      <ul class="sub-menu">
        <li>
          <a href="<?php echo $nav_up_level ?>comp-sugg/index.php">
            <span class="link-name"><?php echo lang('DASHBOARD') ?></span>
          </a>
        </li>
        <li>
          <a href="<?php echo $nav_up_level ?>comp-sugg/index.php?do=add-comp-sugg">
            <span class="link-name"><?php echo lang('ADD COMPLAINT OR SUGGESTION') ?></span>
          </a>
        </li>
      </ul>
    </li> -->
    <!-- start setting nav link -->
    <li>
      <a href="<?php echo $nav_up_level ?>settings/index.php">
        <i class="bi bi-gear"></i>
        <span class="link-name">
          <?php echo lang('SETTINGS') ?>
        </span>
      </a>
      <!-- start blank sub menu -->
      <ul class="sub-menu blank">
        <li>
          <a href="<?php echo $nav_up_level ?>settings/index.php">
            <span class="link-name">
              <?php echo lang('SETTINGS') ?>
            </span>
          </a>
        </li>
      </ul>
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
          <a
            href="<?php echo $nav_up_level ?>users/index.php?do=edit-user-info&userid=<?php echo $_SESSION['sys']['UserID']; ?>">
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
                  echo lang($job_title, 'employees');
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
    <?php if (isset($_SESSION['sys']['isTrial']) && $_SESSION['sys']['isTrial'] == 1) { ?>
      <span class="<?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'me-auto' : 'ms-auto' ?> mx-3">
        <span class="badge bg-danger">
          <?php echo lang("TRIAL") ?>
        </span>
      </span>
    <?php } ?>

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