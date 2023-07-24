<?php
if (isset($_SESSION['UserID'])) {
  if (!isset($db_obj)) {
    // create an object of Database class
    $db_obj = new Database();
  }
  // check if the current version is up to date or not
  $latest_version = $db_obj->get_latest_records("*", "`versions`", "WHERE `is_working` = 1 AND `is_developing` = 0", "`v_id`", 1)[0];
  // check the count
  if (count($latest_version) > 0) {
    // get latest version id
    $latest_version_id = $latest_version['v_id'];
    $latest_version_name = $latest_version['v_name'];
    // check the value of latest version with the current version of the system
    if ($latest_version_id > $_SESSION['curr_version_id']) {
  ?>
      <div class="my-1 text-center" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
        <span><?php echo language('THERE IS A NEW VERSION OF THE SYSTEM', @$_SESSION['systemLang']) ?>.&nbsp;</span>
        <a href="dashboard.php?do=version-info"><?php echo language('SHOW FEATURES', @$_SESSION['systemLang']) ?></a>
        <span>&nbsp;|&nbsp;</span>
        <a href="requests.php?do=upgrade-version&new-version-id=<?php echo $latest_version_id ?>"><?php echo language('UPGRADE NOW', @$_SESSION['systemLang']) ?>&nbsp;<?php echo $latest_version_name ?></a>
      </div>
    <?php } ?>
  <?php } ?>
<?php } ?>