<?php
// start output buffering
ob_start();
// start session
session_start();
// regenerate session id
session_regenerate_id();
// check if session is set
// check username in SESSION variable
if (isset($_SESSION['sys']['UserName'])) {
  // update version name in coockies
  // setcookie('v_name', $_SESSION['sys']['curr_version_name'], time() + (365 * 24 * 60 * 60), "/");
  setcookie('v_name', "", time() - (365 * 24 * 60 * 60), "/");

  // title page
  $page_title = "Dashboard";
  // is admin == true
  $is_admin = true;
  // page category
  $page_category = "sys_tree";
  // page role
  $page_role = "sys_tree_root";
  // folder name of dependendies
  $dependencies_folder = "sys_tree/";
  // level
  $level = 4;
  // nav level
  $nav_level = 1;
  // pre-configration of system
  include_once str_repeat("../", $level) . "etc/pre-conf.php";
  // initial configration of system
  include_once str_repeat("../", $level) . "etc/init.php";
  // check if system write a log for login into system
  if ($_SESSION['sys']['log'] == 0) {
    // log message
    $msg = "loginning to system";
    create_logs($_SESSION['sys']['UserName'], $msg);
    $_SESSION['sys']['log'] = 1;
  }
?>
  <!-- start home stats container -->
  <div class="container" dir="<?php echo $page_dir ?>">
    <!-- start stats -->
    <div class="stats">
      <!-- start new design -->
      <div class="mb-3 row row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3 justify-content-sm-center align-items-center">
        <div class="col-6 <?php if ($_SESSION['sys']['user_show'] == 0) {echo 'd-none';} ?>">
          <div class="card card-stat <?php if ($_SESSION['sys']['system_theme'] == 2) { echo 'card-effect '; echo @$_SESSION['sys']['lang'] == "ar" ? "card-effect-right":"card-effect-left"; } else { echo 'bg-primary';} ?> bg-gradient">
            <div class="card-body">
              <i class="bi bi-building"></i>
              <a href="<?php echo $nav_up_level ?>companies/index.php?do=companies-list" class="stretched-link text-capitalize">
                <?php echo lang('THE COMPANIES', @$_SESSION['sys']['lang']) ?>
              </a>
            </div>
            <?php $newEmpCounter = countRecords("`company_id`", "`companies`", "WHERE `joined_date` = 'CURRENT_DATE' AND `company_id` <> 1"); ?>
            <?php if ($newEmpCounter > 0) { ?>
              <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill border border-light bg-danger">
                <span><?php echo $newEmpCounter ?></span>
              </span>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
    <!-- end stats -->
  </div>
  <!-- end dashboard page -->
<?php
  // footer
  include_once $tpl . "footer.php";
  include_once $tpl . "js-includes.php";
} else {
  header("Location: ../../logout.php");
  exit();
}

ob_end_flush();
?>