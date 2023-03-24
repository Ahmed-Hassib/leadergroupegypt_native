
<?php include_once $tpl . "footer.php" ?>

<!-- GET GLOBAL JS FILES -->
<?php $global_js_files = get_page_dependencies('global', 'js'); ?>

<!-- INCLUDE GLOBAL JS FILES -->
<?php foreach ($global_js_files as $global_js_file) { ?>
  <script src="<?php echo $js . $global_js_file; ?>"></script>
<?php } ?>

<!-- CHECK IF PAGE CONTAIIN TABLES -->
<?php if (isset($is_contain_table) && $is_contain_table == true) { ?>
  <!-- GET ALL TABLE CUSTOM JS FILES -->
  <?php $table_js_files = get_page_dependencies('tables', 'js'); ?>
  <!-- GET ALL TABLES NODE JS FILES -->
  <?php $tables_node_js_files = get_page_dependencies('tables', 'node')['js']; ?>
  
  <!-- INCLUDE ALL TABLES NODE JS FILES -->
  <?php foreach ($tables_node_js_files as $tables_node_js_file) { ?>
    <script src="<?php echo $node . $tables_node_js_file; ?>"></script>
  <?php } ?>

  <!-- INCLUDE ALL TABLE CUSTOM JS FILES -->
  <?php foreach ($table_js_files as $table_js_file) { ?>
    <script src="<?php echo $js . $table_js_file; ?>"></script>
  <?php } ?>
<?php } ?>


<!-- GET ALL GLOBAL CSS FILES DEPENDING ON PAGE CATEGORY -->
<?php if (isset($page_category)) { ?>
  <?php $global_web_js_files = get_page_dependencies("".$page_category."_global", 'js'); ?>

  <?php foreach ($global_web_js_files as $js_file) { ?>
    <script src="<?php echo $js . $dependencies_folder . $js_file; ?>"></script>
  <?php } ?>
<?php } ?>
  
<?php $page_role_js_files = get_page_dependencies($page_role, 'js'); ?>

<?php foreach ($page_role_js_files as $js_file) { ?>
  <script src="<?php echo $js . $dependencies_folder . $js_file; ?>"></script>
<?php } ?>


<?php 
// CHECK PAGE CATEGORY IF EQUAL 'sys_tree'
if ($page_category == 'sys_tree' && $page_role != 'sys_tree_login' && $page_role != 'sys_tree_signup' && isset($_SESSION['UserID']) && $_SESSION['isRoot'] == 0) {
  // INCLUDE ADD DIERCTION MODAL
  include_once $nav_up_level . 'directions/add-direction-modal.php';
  echo "<script>localStorage.removeItem('sidebarMenuClosed');</script>";
}
?>


<!-- save system language to local storage -->
<?php if (isset($is_website_pages) && $is_website_pages == true) { ?>
  <script>
    // assign systemLang to local storage
    localStorage['systemLang']  = '<?php echo @$_SESSION['systemLang'] ?>';
    // check current language
    document.body.style.direction = localStorage['systemLang'] == 'ar' ? 'rtl' : 'ltr';
  </script>

<?php } ?>

<?php if (isset($preloader) && $preloader == true) {?>
  <script>
    $(document).ready(function() {
      $(".spinner").fadeOut(1000, function() {
        $(this).parent().fadeOut(1200, function() {
          $("body").css('overflow-x', 'visible');
        });
      });
    })
  </script>
<?php } else { ?>
  <script>
    $(document).ready(function() {
      $("body").css('overflow-x', 'visible');
    })
  </script>
<?php } ?>

</body>
</html>

