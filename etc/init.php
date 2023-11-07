<?php
// include_once navbar in all pages expect pages include_once noNavBar
if (isset($page_category) && !isset($no_navbar)) {
  // check backup
  include_once 'auto-backup.php';
  // switch case for page category
  switch ($page_category) {
    case 'website':
      // check if root
      if (isset($_SESSION['website']['user_id']) && $_SESSION['website']['is_root'] == 1) {
        // get root navbar
        $navbar = get_page_dependencies("" . $page_category . "_global", 'navbar')['root'];
      } else {
        // get user navbar
        $navbar = get_page_dependencies("" . $page_category . "_global", 'navbar')['user'];
      }
      // include navbar
      include_once $website_tpl . $navbar;
      break;

    case 'sys_tree':
      // check developing
      if ($is_developing == false) {
        // include_once check version script
        include_once 'check-version.php';
        // check session
        if (isset($_SESSION['sys']['UserID'])) {
          // check if root
          if ($_SESSION['sys']['isRoot'] == 1) {
            // get root navbar
            $navbar = get_page_dependencies("" . $page_category . "_global", 'navbar')['root'];
          } else {
            // get user navbar
            $navbar = get_page_dependencies("" . $page_category . "_global", 'navbar')['user'];
          }
          // include navbar
          include_once $sys_tree_tpl . $navbar;
        }
      }
      break;

    case 'blog':
      // get navbar
      $navbar = get_page_dependencies("" . $page_category . "_global", 'navbar');
      // include navbar
      include_once $blog_tpl . $navbar;
      break;
  }
}
?>

<?php if ($is_developing == false) { ?>
  <?php if (isset($_SESSION['flash_message']) && isset($_SESSION['flash_message_icon']) && isset($_SESSION['flash_message_class']) && isset($_SESSION['flash_message_status'])) { ?>
    <div class="m-0 container">
      <div class="alert-flash-container alert-flash-<?php echo $page_category != 'sys_tree' ? 'web' : 'sys' ?>"
        dir="<?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'rtl' : 'ltr' ?>">
        <?php if (is_array($_SESSION['flash_message'])) { ?>
          <?php foreach ($_SESSION['flash_message'] as $key => $message) { ?>
            <div class="alert alert-<?php echo $_SESSION['flash_message_class'][$key]; ?> alert-flash-status" dir="rtl">
              <i class="bi <?php echo $_SESSION['flash_message_icon'][$key] ?>"></i>
              <?php echo lang($message, $_SESSION['flash_message_lang_file'][$key]) ?>
              <button type="button" class="btn-close btn-close-left" data-bs-dismiss="alert" aria-label="Close"></button>
              <span class="alert-progress"></span>
            </div>
          <?php } ?>
        <?php } else { ?>
          <div class="alert alert-<?php echo $_SESSION['flash_message_class']; ?> alert-flash-status" dir="rtl">
            <i class="bi <?php echo $_SESSION['flash_message_icon'] ?>"></i>
            <?php echo lang($_SESSION['flash_message'], $_SESSION['flash_message_lang_file']) ?>
            <button type="button" class="btn-close btn-close-left" data-bs-dismiss="alert" aria-label="Close"></button>
            <span class="alert-progress"></span>
          </div>
        <?php } ?>
      </div>
    </div>

    <script>
      let wait = 1000;
      let progress = 100;
      let flash_alert = document.querySelectorAll('.alert-flash-status');
      var alert_progress_el = document.querySelectorAll('.alert-progress');

      let alert_progress = setInterval(() => {
        // decrease progress
        progress--;
        // decrease width depending on progress
        alert_progress_el.forEach(prog => {
          prog.style.width = `${progress}%`;
        });
        // check progress
        if (progress == 0) clearInterval(alert_progress);
      }, 100);


      setTimeout(() => {
        flash_alert.forEach(alert => {
          alert.remove();
        });
      }, 10300);
    </script>

    <?php unset($_SESSION['flash_message']); ?>
    <?php unset($_SESSION['flash_message_icon']); ?>
    <?php unset($_SESSION['flash_message_class']); ?>
    <?php unset($_SESSION['flash_message_status']); ?>
    <?php unset($_SESSION['flash_message_lang_file']); ?>
  <?php } ?>
<?php } ?>