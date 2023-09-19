<!-- start sidebar menu -->
<div class="sidebar-menu sidebar-menu-<?php echo @$_SESSION['website']['lang'] == 'ar' ? 'right' : 'left' ?> close">
  <!-- start sidebar menu brand -->
  <div class="sidebar-menu-brand website" href="<?php echo $up_level ?>index.php" <?php echo !isset($_SESSION['website']['UserName']) ? "style='margin: auto'" : "" ?>>
    <span class="sidebar-menu-logo-name text-uppercase ">
      <?php echo lang('SPONSOR') ?>
    </span>
    <!-- close icon displayed in small screens -->
    <span class="close-btn"><i class="bi bi-x"></i></span>
  </div>
  <!-- end sidebar menu brand -->
  <!-- start sidebar menu content -->
  <ul class="nav-links">
    <!-- start dashboard page link -->
    <li>
      <a href="<?php echo $up_level ?>index.php">
        <i class="bi bi-grid"></i>
        <span class="link-name"><?php echo lang('HOME') ?></span>
      </a>
      <!-- start blank sub menu -->
      <ul class="sub-menu blank">
        <li>
          <a href="<?php echo $up_level ?>index.php">
            <span class="link-name"><?php echo lang('HOME') ?></span>
          </a>
        </li>
      </ul>
      <!-- end blank sub menu -->
    </li>
    <!-- end dashboard page link -->
    <!-- start about page link -->
    <li>
      <div class="icon-link">
        <section>
          <i class="bi bi-journal-text"></i>
          <span class="link-name"><?php echo lang('ABOUT US') ?></span>
        </section>
        <i class="bi bi-arrow-down-short"></i>
      </div>
      <!-- start blank sub menu -->
      <ul class="sub-menu">
        <li>
          <a href="<?php echo $website_root ?>about/index.php">
            <span class="link-name"><?php echo lang('DASHBOARD') ?></span>
          </a>
        </li>
        <li>
          <a href="<?php echo $website_root ?>about/index.php?do=add-new">
            <span class="link-name"><?php echo lang('ADD NEW', 'about') ?></span>
          </a>
        </li>
      </ul>
      <!-- end blank sub menu -->
    </li>
    <!-- end about page link -->
    <!-- start services page link -->
    <li>
      <div class="icon-link">
        <section>
          <i class="bi bi-tools"></i>
          <span class="link-name"><?php echo lang('THE SERVICES') ?></span>
        </section>
        <i class="bi bi-arrow-down-short"></i>
      </div>
      <!-- start blank sub menu -->
      <ul class="sub-menu">
        <li>
          <a href="<?php echo $website_root ?>services/index.php">
            <span class="link-name"><?php echo lang('DASHBOARD') ?></span>
          </a>
        </li>
        <li>
          <a href="<?php echo $website_root ?>services/index.php?do=add-new">
            <span class="link-name"><?php echo lang('ADD NEW', 'services') ?></span>
          </a>
        </li>
      </ul>
      <!-- end blank sub menu -->
    </li>
    <!-- end services page link -->

    <!-- start gallery nav link -->
    <li>
      <!-- start link containing sub menu -->
      <div class="icon-link">
        <section>
          <i class="bi bi-image"></i>
          <span class="link-name"><?php echo lang('GALLERY') ?></span>
        </section>
        <i class="bi bi-arrow-down-short"></i>
      </div>
      <!-- end link containing sub menu -->
      <!-- start sub menu -->
      <ul class="sub-menu">
        <li>
          <a href="<?php echo $website_root ?>gallery/index.php">
            <span class="link-name"><?php echo lang('DASHBOARD') ?></span>
          </a>
        </li>
        <li>
          <a href="<?php echo $website_root ?>gallery/index.php?do=add-new">
            <span class="link-name"><?php echo lang('ADD NEW', 'gallery') ?></span>
          </a>
        </li>
      </ul>
      <!-- end sub menu -->
    </li>
    <!-- end gallery nav link -->

    <!-- start links nav link -->
    <li>
      <!-- start link containing sub menu -->
      <div class="icon-link">
        <section>
          <i class="bi bi-link-45deg"></i>
          <span class="link-name"><?php echo lang('IMPORTANT LINKS') ?></span>
        </section>
        <i class="bi bi-arrow-down-short"></i>
      </div>
      <!-- end link containing sub menu -->
      <!-- start sub menu -->
      <ul class="sub-menu">
        <li>
          <a href="<?php echo $website_root ?>links/index.php">
            <span class="link-name"><?php echo lang('DASHBOARD') ?></span>
          </a>
        </li>
        <li>
          <a href="<?php echo $website_root ?>links/index.php?do=add-new">
            <span class="link-name"><?php echo lang('ADD NEW', 'links') ?></span>
          </a>
        </li>
      </ul>
      <!-- end sub menu -->
    </li>
    <!-- end links nav link -->

    <li>
      <a href="<?php echo $website ?>logout.php">
        <i class="bi bi-box-arrow-right"></i>
        <span class="link-name"><?php echo lang('LOGOUT') ?></span>
      </a>
    </li>
    <!-- start setting nav link -->
    <?php if (isset($_SESSION['website']['user_id'])) { ?>
      <!-- start profile details nav link -->
      <li>
        <!-- start profile details -->
        <div class="profile-details">
          <a href="">
            <div class="profile-content">
              <img src="<?php echo $uploads . "employees-img/male-avatar.svg" ?>" class="profile-img">
            </div>
            <div class="name-job">
              <div class="profile-name"><?php echo $_SESSION['website']['username'] ?></div>
              <div class="profile-job">Admin</div>
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

<div class="top-navbar top-navbar-<?php echo @$_SESSION['website']['lang'] == 'ar' ? 'right' : 'left' ?>">
  <div class="top-navbar-content">
    <i class="bi bi-list sidebar-menubtn"></i>
  </div>
</div>

<div class="main-content" style="margin-top: 45px; padding: 1rem 0 0;">