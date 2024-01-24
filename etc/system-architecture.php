<?php

/**
 * 
 */
function get_page_dependencies($page_role, $file_type)
{
  // include_once "app-routes.php";
  // website files
  $project_files_archeticture = [
    // global files
    'global' => [
      'css' => [
        '1' => 'normalize.css',
        '2' => 'animation.css',
        '3' => 'global.css',
        '4' => 'sidebar-menu.css',
      ],
      'js' => [
        '1' => 'global.js',
        '2' => 'lang.js',
        '3' => 'validation.js',
        '4' => 'sidebar-menu.js',
      ],
      'node' => [
        'css' => [
          '1' => 'bootstrap/dist/css/bootstrap.min.css',
          '2' => 'bootstrap-icons/font/bootstrap-icons.css',
        ],
        'js' => [
          '1' => 'jquery/dist/jquery.min.js',
          '2' => 'bootstrap/dist/js/bootstrap.bundle.min.js',
          '3' => 'progresspiesvg/js/min/jquery-progresspiesvg-min.js',
          '4' => 'progresspiesvg/js/min/progresspiesvgAppl-min.js',
        ]
      ],
      'fonts' => [
        '1' => 'cairo.css'
      ]
    ],

    // for tables files
    'tables' => [
      'css' => [
        '1' => 'table-style.css',
      ],
      'js' => [
        '1' => 'table-behaviour.js',
      ],
      'node' => [
        'css' => [
          '1' => "datatables.net-bs5/css/dataTables.bootstrap5.min.css",
          '2' => 'datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css',
          '3' => 'datatables.net-colresize-unofficial/jquery.dataTables.colResize.css'
        ],
        'js' => [
          '1' => 'jszip/dist/jszip.min.js',
          '2' => 'pdfmake/build/pdfmake.min.js',
          '3' => 'pdfmake/build/vfs_fonts.js',
          '4' => 'datatables.net/js/jquery.dataTables.min.js',
          '5' => 'datatables.net-bs5/js/dataTables.bootstrap5.min.js',
          '6' => 'datatables.net-buttons/js/dataTables.buttons.min.js',
          '7' => 'datatables.net-buttons/js/buttons.colVis.js',
          '8' => 'datatables.net-buttons/js/buttons.html5.min.js',
          '9' => 'datatables.net-buttons/js/buttons.print.min.js',
          '10' => 'datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js',
          '11' => 'datatables.net-colresize-unofficial/jquery.dataTables.colResize.js'
        ]
      ],
      'fonts' => []
    ],

    // for charts files
    'charts' => [
      'css' => [
        '1' => 'charts.css',
      ],
      'js' => [
        '1' => 'charts.js',
      ],
      'node' => [
        'css' => [],
        'js' => [
          '1' => 'chart.js/dist/chart.umd.js'
        ]
      ],
      'fonts' => []
    ],

    // for webite global files
    'website_global' => [
      'css' => [
        '1' => 'global.css',
        '2' => "index.css",
      ],
      'js' => [
        '1' => 'index.js'
      ],
      'node' => [
        'css' => [],
        'js' => []
      ],
      'fonts' => [
        '1' => 'cairo.css'
      ],
      'navbar' => [
        'root' => 'root-navbar.php',
        'user' => 'user-navbar.php'
      ],
      'footer' => 'website-footer.php',
    ],


    // for website login
    'website_login' => [
      'css' => [
        '1' => 'login.css'
      ],
      'js' => [],
      'node' => [
        'css' => [],
        'js' => []
      ],
      'fonts' => []
    ],

    // for website company
    'website_company' => [
      'css' => [
        '1' => 'company.css'
      ],
      'js' => [
        '1' => 'company.js'
      ],
      'node' => [
        'css' => [],
        'js' => []
      ],
      'fonts' => []
    ],

    // for website gallery
    'website_gallery' => [
      'css' => [
        '1' => 'gallery.css'
      ],
      'js' => [],
      'node' => [
        'css' => [],
        'js' => []
      ],
      'fonts' => []
    ],

    // for website services
    'website_services' => [
      'css' => [
        '1' => 'services.css'
      ],
      'js' => [],
      'node' => [
        'css' => [],
        'js' => []
      ],
      'fonts' => []
    ],

    // for website features
    'website_features' => [
      'css' => [
        '1' => 'features.css'
      ],
      'js' => [
        '1' => 'features.js'
      ],
      'node' => [
        'css' => [],
        'js' => []
      ],
      'fonts' => []
    ],

    // for website team
    'website_team' => [
      'css' => [
        '1' => 'team.css'
      ],
      'js' => [
        '1' => 'team.js'
      ],
      'node' => [
        'css' => [],
        'js' => []
      ],
      'fonts' => []
    ],

    // for website signup
    'website_desc' => [
      'css' => [
        '1' => 'description.css'
      ],
      'js' => [],
      'node' => [
        'css' => [],
        'js' => []
      ],
      'fonts' => []
    ],

    // for blog login
    'sys_tree_global' => [
      'css' => [
        '1' => 'global.css',
        '2' => 'footer.css',
      ],
      'js' => [
        '1' => 'global.js',
        '2' => 'validation.js',
        '3' => 'history.js',
      ],
      'footer' => [
        'user' => 'user-footer.php',
        'root' => 'root-footer.php'
      ],
      'navbar' => [
        'user' => 'user-navbar.php',
        'root' => 'root-navbar.php'
      ]
    ],

    'sys_tree_map' => [
      'css' => [],
      'js' => [
        '1' => 'treenet_map.js'
      ],
      'node' => [],
    ],

    // for blog login
    'sys_tree_login' => [
      'css' => [
        '1' => 'login.css'
      ],
      'js' => [],
    ],

    'sys_tree_signup' => [
      'css' => [
        '1' => 'signup.css'
      ],
      'js' => [
        '1' => 'signup.js'
      ],
    ],

    'sys_tree_dash' => [
      'css' => [
        '1' => 'dashboard.css',
      ],
      'js' => [],
    ],

    'sys_tree_user' => [
      'css' => [
        '1' => 'users.css',
      ],
      'js' => [
        '1' => 'users.js',
      ],
    ],

    'sys_tree_devices' => [
      'css' => [],
      'js' => [
        '1' => 'devices.js',
      ],
    ],

    'sys_tree_pieces' => [
      'css' => [],
      'js' => [
        '1' => 'pieces.js',
        '2' => 'devices.js',
      ],
    ],

    'sys_tree_clients' => [
      'css' => [],
      'js' => [
        '1' => 'clients.js',
      ],
    ],

    'sys_tree_dir' => [
      'css' => [
        '1' => 'hierarchical-chart.css',
      ],
      'js' => [
        '1' => 'directions.js',
      ],
    ],

    'sys_tree_malfunction' => [
      'css' => [
        '1' => 'malfunction.css',
        '2' => 'media-preview.css'
      ],
      'js' => [
        '1' => 'malfunction.js',
      ],
    ],

    'sys_tree_combination' => [
      'css' => [
        '1' => 'combination.css',
        '2' => 'media-preview.css'
      ],
      'js' => [
        '1' => 'combination.js'
      ],
    ],

    'sys_tree_reports' => [
      'css' => [
        '1' => 'reports.css'
      ],
      'js' => [
        // '1' => 'reports.js'
      ],
    ],

    'sys_tree_settings' => [
      'css' => [
        '1' => 'settings.css'
      ],
      'js' => [
        '1' => 'settings.js'
      ],
    ],

    'sys_tree_services' => [
      'css' => [
        '1' => 'services.css'
      ],
      'js' => [
        '1' => 'services.js'
      ],
    ],

    'sys_tree_root' => [
      'css' => [],
      'js' => [
        '1' => 'root-global.js'
      ],
    ],


    // for blog files
    'blog_global' => [
      'css' => [
        '1' => 'global.css'
      ],
      'js' => [
        '1' => 'global.js'
      ],
      'navbar' => 'blog-navbar.php',
      'footer' => 'blog-footer.php'
    ],

    // for blog
    'blog' => [
      'css' => [
        '1' => 'blog.css',
        '2' => 'articles.css'
      ],
      'js' => [
        '1' => 'articles.js'
      ],
    ],

    // for blog login
    'blog_login' => [
      'css' => [
        '1' => 'login.css',
      ],
      'js' => [
        '1' => 'login.js',
      ],
    ],
  ];
  // returns files of the given page role
  return key_exists($page_role, $project_files_archeticture) ? $project_files_archeticture[$page_role][$file_type] : null;
}
