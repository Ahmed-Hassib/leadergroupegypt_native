<?php
if (isset($page_category) && !isset($no_footer)) {
  // switch case to include the specific footer of given page category
  switch ($page_category) {
    case 'website':
      $website_footer = get_page_dependencies("" . $page_category . "_global", 'footer');
      // include footer
      include_once $website_tpl . $website_footer;
      break;

    case 'sys_tree':
      // check session of user
      if (isset($_SESSION['sys']['UserID']) && $_SESSION['sys']['is_root']) {
        $sys_tree_footer = get_page_dependencies("" . $page_category . "_global", 'footer')['root'];
      } else {
        if ($is_developing == false) {
          $sys_tree_footer = get_page_dependencies("" . $page_category . "_global", 'footer')['user'];
        }
      }

      // check if footer set
      if (isset($sys_tree_footer)) {
        // include footer
        include_once $sys_tree_tpl . $sys_tree_footer;
      }
      break;

    case 'blog':
      $blog_footer = get_page_dependencies("" . $page_category . "_global", 'footer');
      // include footer
      include_once $blog_tpl . $blog_footer;
      break;
  }
}
