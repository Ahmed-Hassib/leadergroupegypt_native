<!-- navbar -->
<nav class="mb-5 navbar navbar-expand-lg navbar-light bg-white bg-gradient shadow" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?php echo $nav_up_level ?>dashboard/index.php" <?php if (!isset($_SESSION['UserName'])) { echo "style='margin: auto'"; } ?>>
      <img src="<?php echo $assets ?>jsl.jpeg" alt="sys tree logo" width="40">
      <span class="text-uppercase "><?php echo isset($_SESSION['company_name']) ? $_SESSION['company_name'] : language('NOT ASSIGNED') ?></span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#app-navbar" aria-controls="app-navbar" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="app-navbar">
      <ul class="navbar-nav <?php echo @$_SESSION['systemLang'] == 'ar' ? 'ms-auto' : 'me-auto' ?> mb-2 mb-lg-0 text-capitalize">
        <li class="nav-item">
          <a class="nav-link <?php if (strtolower($page_title) == languageEn('DASHBOARD')) {echo 'active';} ?>" aria-current="page" href="<?php echo $nav_up_level ?>dashboard/index.php">
            <i class="bi bi-house-fill"></i>
            <span><?php echo language('DASHBOARD', @$_SESSION['systemLang']) ?></span>
          </a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle <?php if (strtolower($page_title) == languageEn('THE COMPANIES')) {echo 'active';} ?>" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <span><?php echo language('THE COMPANIES', @$_SESSION['systemLang']) ?></span>
          </a>
          <ul class="dropdown-menu <?php echo @$_SESSION['systemLang'] == 'ar' ? 'dropdown-menu-end' : 'dropdown-menu-start' ?> text-capitalize <?php echo @$_SESSION['systemLang'] == 'ar' ? 'text-end' : 'text-start' ?>" aria-labelledby="navbarDropdown">
            <li>
              <a class="dropdown-item <?php if ($_SESSION['user_show'] == 0) {echo 'disabled';} ?>" href="<?php echo $nav_up_level ?>companies/index.php?do=companies-list" >
                <i class="bi bi-list-ul"></i>
                <span><?php echo language('COMPANIES LIST', @$_SESSION['systemLang']) ?></span>
              </a>
            </li>
            <hr class="dropdown-divider">
            <li>
              <a class="dropdown-item <?php if ($_SESSION['user_add'] == 0) {echo 'disabled';} ?>" href="<?php echo $nav_up_level ?>companies/index.php?do=add-new-company">
                <i class="bi bi-plus"></i>
                <span><?php echo language('ADD NEW COMPANY', @$_SESSION['systemLang']) ?></span>
              </a>
            </li>
          </ul>
        </li>
      </ul>
      <ul class="navbar-nav <?php echo $isDeveloping ? "me-auto" : "" ?>">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <span><i class="bi bi-person-circle"></i>&nbsp;<?php echo $_SESSION['UserName'] ?></span>
          </a>
          <ul class="dropdown-menu <?php echo @$_SESSION['systemLang'] == 'ar' ? 'dropdown-menu-start' : 'dropdown-menu-end' ?> text-capitalize <?php echo @$_SESSION['systemLang'] == 'ar' ? 'text-end' : 'text-start' ?>" aria-labelledby="navbarDropdown">
            <?php if (!$isDeveloping) { ?>
            <li>
              <a class="dropdown-item" href="<?php echo $nav_up_level ?>requests/index.php?do=updateSession&user-id=<?php echo $_SESSION['UserID'] ?>">
                <i class="bi bi-arrow-clockwise"></i>
                <span><?php echo language('REFRESH', @$_SESSION['systemLang']) ?></span>
              </a>
            </li>
            <?php if ($_SESSION['isLicenseExpired'] == 0) { ?>
              <li>
                <a class="dropdown-item" href="<?php echo $nav_up_level ?>users/index.php?do=editUser&userid=<?php echo $_SESSION['UserID']; ?>">
                  <i class="bi bi-sliders"></i>
                  <span><?php echo language('PROFILE', @$_SESSION['systemLang']) ?></span>
                </a>
              </li>
            <?php } ?>
            <!-- <hr class="dropdown-divider"> -->
            <li>
              <a class="dropdown-item" href="<?php echo $nav_up_level ?>settings/index.php">
                <i class="bi bi-gear"></i>
                <span><?php echo language('SETTINGS', @$_SESSION['systemLang']) ?></span>
              </a>
            </li>
            <hr class="dropdown-divider">
            <?php } ?>
            <li>
              <a class="dropdown-item" href="<?php echo $sys_tree ?>logout.php">
                <i class="bi bi-box-arrow-right"></i>
                <span><?php echo language('LOG OUT', @$_SESSION['systemLang']) ?></span>
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
<!-- navbar -->