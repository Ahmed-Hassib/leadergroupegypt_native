<?php
// check page type
if ($page_category == 'website') {
  // current language
  $lang = isset($_SESSION['website']['lang']) && !empty($_SESSION['website']['lang']) ? $_SESSION['website']['lang'] : 'ar';
} elseif ($page_category == 'sys_tree') {
  // current language
  $lang = isset($_SESSION['sys']['lang']) && !empty($_SESSION['sys']['lang']) ? $_SESSION['sys']['lang'] : 'ar';
}

// all language files
$global_lang = ['global'];

// for sys tree
$sys_tree_lang = ['login', 'dashboard', 'directions', 'pieces', 'sugg_comp', 'employees', 'pcs_conn', 'clients', 'malfunctions', 'combinations', 'settings'];

// for website
$website_lang = ['index', 'login', 'dashboard', 'sections', 'gallery', 'about', 'links', 'services', 'description'];

// check page category
switch ($page_category) {
  case 'sys_tree':
    $lang_files = $sys_tree_lang;
    break;

  case 'website':
    $lang_files = $website_lang;
    break;

  default:
    # code...
    break;
}

// loop on language files
foreach ($global_lang as $file) {
  // include file
  include_once "global/$lang/$file.php";
}

// loop on language files
foreach ($lang_files as $file) {
  // include file
  include_once "$page_category/$lang/$file.php";
}

// language function
function lang($phrase, $file = 'global_', $lang = "ar")
{
  // return the word
  return $file($phrase);
}
