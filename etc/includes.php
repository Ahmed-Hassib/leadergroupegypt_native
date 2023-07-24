<?php

// array of used classes to include_once it
$classes_arr = [
    'Database', 'Login', 'User', 'Direction', 'Registration',
    'ManufuctureCompanies', 'Devices', 'Models',
    'Pieces', 'PiecesConn', 
    'Malfunction', 'Combination',
    'Companies', 'Session', 'CompSugg',
    'Countries'
];

// up level
$up_level = get_up_level($level);
// nav up level
$nav_up_level = get_up_level($nav_level);

// loop on classes
foreach ($classes_arr as $class) {
    // include_once classes
    include_once $up_level . "classes/$class.class.php";
}

function get_up_level($level) {
    // get up level depebding on current level
    $up_level = $level > 0 ? str_repeat("../", $level) : "./";
    // return $up_level
    return $up_level;
}