<?php

// global functions
$global_func = ['functions'];

// website functions
$website_func = [];

// systre functions
$systree_func = ['send-whatsapp-msg', 'next_ip', 'location'];

// get db info depending on page category
switch ($page_category) {
  case 'website':
    $func_conf = $website_func;
    break;

  case 'sys_tree':
    $func_conf = $systree_func;
    break;

  default:
    $func_conf = null;
    break;
}

// loop on global function to include
foreach ($global_func as $key => $func_file) {
  include_once $func . "global/{$func_file}.php";
}

// loop on page category functions
foreach ($func_conf as $key => $func_file) {
  include_once $func . "{$page_category}/{$func_file}.php";
}

