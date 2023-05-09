<?php

// Routes
$src        = $up_level  . "src/";                      // root directory

// SYS TREE DIRECTORY
$sys_tree   = $src        . "sys_tree/";
$globmod    = $sys_tree   . "global-modules/";       // Global modules Directory for pages
$requests   = $sys_tree   . "requests/";             // Requests Directory

// INCLUDES DIRECTORY
$includes   = $up_level  . "includes/";                 // Includes Directory
$lan        = $includes  . "languages/";                // Languages Directory
$func       = $includes  . "functions/";                // Functions Directory

// Libraries Directory
$lib        = $includes  . "libraries/";
$vendor     = $lib       . "vendor/";                   // Vendor Directory

// LAYOUT DIRECTORY
$layout     = $up_level  . "layout/";                   // layout directory
$css        = $layout    . "css/";                      // CSS Directory
$js         = $layout    . "js/";                       // JS Directory
$node       = $layout    . "node_modules/";             // node module Directory
$fonts      = $layout    . "fonts/";                    // fonts Directory

// TEMPLATE DIRECTORY
$tpl           = $includes . "templates/";           // Template Directory
$website_tpl   = $tpl      . "website/";             // Template Directory
$sys_tree_tpl  = $tpl      . "sys_tree/";            // Template Directory
$blog_tpl      = $tpl      . "blog/";                // Template Directory


// LANDING PAGE DIRECTORY
$website         = $src      . "website/";

// LANDING PAGE LAYOUT
$website_css          = $css            . "website/";
$website_js           = $js             . "website/";
$website_src          = $website        . "src/";
$website_images       = $website        . "images/";
$website_pages        = $website_src    . "pages/";
$website_pages_desc   = $website_pages  . "desc/";



// BLOG DIRECTORY
$blog         = $src      . "blog/";
$blog_admin   = $blog     . "admin/";
$blog_user    = $blog     . "user/";
$blog_global  = $blog     . "global/";


// SYS TREE LAYOUT
$sys_tree_css    = $css       . "sys_tree/";
$sys_tree_js     = $js        . "sys_tree/";
$sys_tree_user   = $sys_tree  . "user/";
$sys_tree_root   = $sys_tree  . "root/";



// ASSETS DIRECTORY
$assets     = $up_level  . "assets/";                   // Assets Directory

// DATA DIRECTORY
$data       = $up_level  . "data/";                     // Data Directory
$uploads    = $data      . "uploads/";                  // Uploads Directory
$backups    = $data      . "backups/";                  // Backups Directory
$descdata   = $data      . "description/";              // Description Directory for videos
$json       = $data      . "json/";                     // Json Directory
$dirs       = $json      . "dirs/";                     // Dirs Directory
$dev_models = $json      . "devices-models/";           // Devices` Models Directory

?>