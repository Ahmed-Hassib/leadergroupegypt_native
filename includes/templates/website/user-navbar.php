<?php $db_obj = new Database() ?>
<!-- START NAVBAR -->
<nav class="navbar navbar-expand-lg bg-white" id="website-navbar" role="navigation">
  <div class="container-fluid">
    <a href="<?php echo $up_level ?>index.php" class="navbar-brand">
      <?php echo lang('SPONSOR') ?>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
      aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a href="<?php echo $up_level ?>index.php" class="nav-link active" aria-current="page" href="#">
            <i class="bi bi-house-fill"></i>
            <span class="me-1">
              <?php echo lang('HOME') ?>
            </span>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo $up_level ?>index.php#about-us" class="nav-link">
            <i class="bi bi-journals"></i>&nbsp;
            <?php echo lang('ABOUT US', 'index') ?>
          </a>
        </li>
        <?php $num_services = $db_obj->count_records("`id`", "`services`", "WHERE `is_active` = 1"); ?>
        <?php if ($num_services > 0) { ?>
          <li class="nav-item">
            <a href="<?php echo $up_level ?>index.php#services" class="nav-link">
              <i class="bi bi-tools"></i>
              <span class="me-1">
                <?php echo lang('OUR SERVICES') ?>
              </span>
            </a>
          </li>
        <?php } ?>
        <?php $num_imgs = $db_obj->count_records("`id`", "`gallery`", "WHERE `is_active` = 1"); ?>
        <?php if ($num_imgs > 0) { ?>
          <li class="nav-item">
            <a href="<?php echo $up_level ?>index.php#gallery" class="nav-link">
              <i class="bi bi-images"></i>&nbsp;
              <?php echo lang('GALLERY', 'index') ?>
            </a>
          </li>
        <?php } ?>
        <?php $num_features = $db_obj->count_records("`id`", "`features`", "WHERE `is_active` = 1"); ?>
        <?php if ($num_features > 0) { ?>
          <li class="nav-item">
            <a href="<?php echo $up_level ?>index.php#features" class="nav-link">
              <i class="bi bi-pie-chart"></i>&nbsp;
              <?php echo lang('FEATURES', 'index') ?>
            </a>
          </li>
        <?php } ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?php echo lang('OTHER') ?>
          </a>
          <ul class="dropdown-menu dropdown-menu-start">
            <li class="<?php echo $page_dir == 'rtl' ? 'text-end' : 'text-start' ?>">
              <a href="<?php echo $up_level ?>index.php#team-members" class="dropdown-item">
                <i class="bi bi-people"></i>&nbsp;
                <span>
                  <?php echo lang('TEAM MEMBERS') ?>
                </span>
              </a>
            </li>
            <li class="<?php echo $page_dir == 'rtl' ? 'text-end' : 'text-start' ?>">
              <a href="<?php echo $up_level ?>index.php#testimonials" class="dropdown-item">
                <i class="bi bi-chat"></i>&nbsp;
                <span>
                  <?php echo lang('TESTIMONIALS') ?>
                </span>
              </a>
            </li>
          </ul>
        </li>
        <?php if (!isset($_SESSION['website']['user_id'])) { ?>
          <li class="nav-item">
            <a href="<?php echo $website ?>login.php" class="nav-link">
              <i class="bi bi-box-arrow-in-right"></i>
              <?php echo lang('LOGIN') ?>
            </a>
          </li>
        <?php } else { ?>
          <li class="nav-item">
            <a href="<?php echo $website ?>logout.php" class="nav-link">
              <i class="bi bi-box-arrow-right"></i>&nbsp;
              <?php echo lang('LOGOUT') ?>
            </a>
          </li>
        <?php } ?>
      </ul>
    </div>
  </div>
</nav>
<!-- END HEADER -->