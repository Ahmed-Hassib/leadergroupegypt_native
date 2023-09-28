<?php

// up level
$up_level = get_up_level($level);
// nav up level
$nav_up_level = get_up_level($nav_level);

// array of used classes to include_once it
// global classes
$global_classes = [
	'Database'
];

// systree classes
$systree_classes = [
	'Login', 'User', 'Direction', 'Registration',
	'ManufuctureCompanies', 'Devices', 'Models',
	'Pieces', 'PiecesConn',
	'Malfunction', 'Combination',
	'Companies', 'Session', 'CompSugg',
	'Countries'
];

// website classes
$website_classes = [
	'Login', 'Section', 'Gallery', 'Link',
	'Service', 'About', 'Features',
	'Session'
];

switch ($page_category) {
	case 'website':
		$classes_arr = $website_classes;
		break;

	case 'sys_tree':
		$classes_arr = $systree_classes;
		break;
}

// loop on classes
foreach ($global_classes as $class) {
	// include_once classes
	include_once $up_level . "classes/global/$class.class.php";
}

// loop on classes
foreach ($classes_arr as $class) {
	// include_once classes
	include_once $up_level . "classes/$page_category/$class.class.php";
}

function get_up_level($level)
{
	// get up level depebding on current level
	$up_level = $level > 0 ? str_repeat("../", $level) : "./";
	// return $up_level
	return $up_level;
}
