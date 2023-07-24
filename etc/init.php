<?php

// include_once header in all pages expect pages include_once noHeader
if (!isset($noHeader)) {
  include_once $tpl . "header.php";
}


// include_once navbar in all pages expect pages include_once noNavBar
if (isset($page_category)) {
  // switch case for page category
  switch($page_category) {
    case 'website':
      // get navbar
      $navbar = get_page_dependencies("".$page_category."_global", 'navbar');
      // include navbar
      include_once $website_tpl . $navbar;
      break;

    case 'sys_tree':
      // include_once check version script
      include_once 'check-version.php';
      // check if root
      if (isset($_SESSION['isRoot'])) {
        if ($_SESSION['isRoot'] == 1) {  
          $navbar = get_page_dependencies("".$page_category."_global", 'navbar')['root'];
        } else {
          $navbar = get_page_dependencies("".$page_category."_global", 'navbar')['user'];
        }
        // include navbar
        include_once $sys_tree_tpl . $navbar;
      }
      break;

    case 'blog':
      // get navbar
      $navbar = get_page_dependencies("".$page_category."_global", 'navbar');
      // include navbar
      include_once $blog_tpl . $navbar;
      break;
  }
}

// echo isset($is_contain_table) ? 'this page is containing tables' : 'this page is not containing tables';