<?php
if ($is_developing == false && isset($page_category) && !isset($no_footer)) {
  // switch case to include the specific footer of given page category
  switch ($page_category) {
    case 'website':
      $website_footer = get_page_dependencies("" . $page_category . "_global", 'footer');
      // include footer
      include_once $website_tpl . $website_footer;
      break;

    case 'sys_tree':
      // check session of user
      if (isset($_SESSION['sys']['UserID']) && $_SESSION['sys']['isRoot']) {
        $sys_tree_footer = get_page_dependencies("" . $page_category . "_global", 'footer')['root'];
      } else {
        $sys_tree_footer = get_page_dependencies("" . $page_category . "_global", 'footer')['user'];
      }
      // include footer
      include_once $sys_tree_tpl . $sys_tree_footer;
      break;

    case 'blog':
      $blog_footer = get_page_dependencies("" . $page_category . "_global", 'footer');
      // include footer
      include_once $blog_tpl . $blog_footer;
      break;
  }
}
