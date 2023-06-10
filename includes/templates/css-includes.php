<!-- GET ALL GLOBAL FILES -->
<?php $global_fonts_files       = get_page_dependencies('global', 'fonts'); ?>
<?php $global_css_files         = get_page_dependencies('global', 'css'); ?>
<?php $global_css_node_files    = get_page_dependencies('global', 'node')['css']; ?>

<!-- GLOBAL FONTS FILES -->
<?php foreach ($global_fonts_files as $fonts_files) { ?>
  <link rel="stylesheet" href="<?php echo $fonts . $fonts_files; ?>">
<?php } ?>

<!-- GLOBAL CSS FILES -->
<?php foreach ($global_css_files as $global_css_file) { ?>
  <link rel="stylesheet" href="<?php echo $css . $global_css_file; ?>">
<?php } ?>

<!-- GLOBAL NODE CSS FILES -->
<?php foreach ($global_css_node_files as $global_node_css_file) { ?>
  <link rel="stylesheet" href="<?php echo $node . $global_node_css_file; ?>">
<?php } ?>

<?php if (isset($is_contain_table) && $is_contain_table == true) { ?>
  <!-- GET ALL CSS TABLES STYLE -->
  <?php $tables_css_files = get_page_dependencies('tables', 'css') ?>
  <?php foreach ($tables_css_files as $css_file) { ?>
    <link rel="stylesheet" href="<?php echo $css . $css_file; ?>">
  <?php } ?>

  <!-- GET ALL CSS TABLES STYLE -->
  <?php $tables_css_node_files = get_page_dependencies('tables', 'node')['css'] ?>
  <?php foreach ($tables_css_node_files as $css_file) { ?>
    <link rel="stylesheet" href="<?php echo $node . $css_file; ?>">
  <?php } ?>
<?php } ?>


<!-- GET ALL GLOBAL CSS FILES DEPENDING ON PAGE CATEGORY -->
<?php if (isset($page_category)) { ?>
  <?php $global_web_css_files = get_page_dependencies("".$page_category."_global", 'css'); ?>

  <?php foreach ($global_web_css_files as $css_file) { ?>
    <link rel="stylesheet" href="<?php echo $css . $dependencies_folder . $css_file; ?>">
  <?php } ?>
<?php } ?>

<?php if (isset($page_role)) { ?>
  <!-- GET ALL CSS FILES DEPENDING ON PAGE ROLE IN CURRENT CATEGORY -->
  <?php $page_role_css_file = get_page_dependencies($page_role, 'css'); ?>

  <?php foreach ($page_role_css_file as $css_file) { ?>
    <link rel="stylesheet" href="<?php echo $css . $dependencies_folder . $css_file; ?>">
  <?php } ?>
<?php } ?>


<!-- PAGE ICON -->
<link rel="icon" href="<?php echo $assets ?>leadergroupegypt.ico">
