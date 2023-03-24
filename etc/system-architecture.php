<?php
/**
 * 
 */
function get_page_dependencies($page_role, $file_type) {
  // include_once "app-routes.php";
  // website files
  $project_files_archeticture = [
    // global files
    'global' => [
      'css' => [
        '1' => 'normalize.css',
        '2' => 'bootstrap.min.css',
        // '3' => 'animation.css',
      ],
      'js' => [
        '1' => 'jquery-3.5.1.min.js',
        '2' => 'bootstrap.min.js',
        // '3' => 'global.js',
      ],
      'node' => [
        'css' => [
          '1' => 'bootstrap-icons/font/bootstrap-icons.css'
        ],
        'js' => []
      ],
      'fonts' => [
        '1' => 'cairo.css'
      ]
    ],

    // for tables files
    'tables' => [
      'css' => [
      ],
      'js' => [
        '1' => 'table-behaviour.js',
      ],
      'node' => [
        'css' => [
          '1' => "datatables.net-bs5/css/dataTables.bootstrap5.min.css",
          '2' => 'datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css',
        ],
        'js' => [
          '1'   => 'jszip/dist/jszip.min.js',
          '2'   => 'pdfmake/build/pdfmake.min.js',
          '3'   => 'pdfmake/build/vfs_fonts.js',
          '4'   => 'datatables.net/js/jquery.dataTables.min.js',
          '5'   => 'datatables.net-bs5/js/dataTables.bootstrap5.min.js',
          '6'   => 'datatables.net-buttons/js/dataTables.buttons.min.js',
          '7'   => 'datatables.net-buttons/js/buttons.colVis.js',
          '8'   => 'datatables.net-buttons/js/buttons.html5.min.js',
          '9'   => 'datatables.net-buttons/js/buttons.print.min.js',
          '10'  => 'datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js',
        ]
      ],
      'fonts' => []
    ],
    
    
    // for webite files
    'website' => [
      'css' => [
      ],
      'js' => [
      ],
      'node' => [
        'css' => [],
        'js' => []
      ],
      'fonts' => [
        '1' => 'cairo.css'
      ]
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
      'fonts' => [],
      'navbar' => 'website-navbar.php',
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
    
    // for website signup
    'website_signup' => [
      'css' => [
        '1' => "signup.css"
      ],
      'js' => [],
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
        '2' => 'sidebar-menu.css',
      ],
      'js' => [
        '1' => 'global.js',
        '2' => 'sidebar-menu.js',
        '3' => 'validation.js'
      ],
      'node' => [
        'css' => [],
        'js' => []
      ],
      'fonts' => [],
      'footer' => [
        'user' => 'user-footer.php',
        'root' => 'root-footer.php'
      ],
      'navbar' => [
        'user' => 'user-navbar.php',
        'root' => 'root-navbar.php'
      ]
    ],
    
    // for blog login
    'sys_tree_login' => [
      'css' => [
        '1' => 'login.css'
      ],
      'js' => [],
      'node' => [
        'css' => [],
        'js' => []
      ],
      'fonts' => [],  
    ],
    
    'sys_tree_signup' => [
      'css' => [
        '1' => 'signup.css'
      ],
      'js' => [
        '1' => 'signup.js'
      ],
      'node' => [
        'css' => [],
        'js' => []
      ],
      'fonts' => [],  
    ],
    
    'sys_tree_user' => [
      'css' => [],
      'js' => [
        '2' => 'devices.js'
      ],
      'node' => [
        'css' => [],
        'js' => []
      ],
      'fonts' => [],  
    ],

    'sys_tree_dir' => [
      'css' => [
        '1' => 'hierarchical-chart.css',
      ],
      'js' => [
        '1' => 'directions.js'
      ],
      'node' => [
        'css' => [],
        'js' => []
      ],
      'fonts' => [],  
    ],
    
    'sys_tree_dash' => [
      'css' => [],
      'js' => [],
      'node' => [
        'css' => [],
        'js' => []
      ],
      'fonts' => [],  
    ],

    'sys_tree_root' => [
      'css' => [],
      'js' => [
        '1' => 'root-global.js'
      ],
      'node' => [
        'css' => [],
        'js' => []
      ],
      'fonts' => [],  
    ],


    // for blog files
    'blog_global' => [
      'css' => [
        '1' => 'global.css'
      ],
      'js' => [
        '1' => 'global.js'
      ],
      'node' => [
        'css' => [],
        'js' => []
      ],
      'fonts' => [],
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
      'node' => [
        'css' => [],
        'js' => []
      ],
      'fonts' => [],
    ],
    
    // for blog login
    'blog_login' => [
      'css' => [
        '1' => 'login.css',
      ],
      'js' => [
        '1' => 'login.js',
      ],
      'node' => [
        'css' => [],
        'js' => []
      ],
      'fonts' => [],  
    ],
    
    // for blog signup
    'blog_signup' => [
      'css' => [],
      'js' => [],
      'node' => [
        'css' => [],
        'js' => []
      ],
      'fonts' => [],  
    ],
  ];
  // returns files of the given page role
  return $project_files_archeticture[$page_role][$file_type];
}