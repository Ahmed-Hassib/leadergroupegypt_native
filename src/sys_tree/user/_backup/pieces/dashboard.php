<?php
// check the page title is set
if (isset($_GET['name'])) {
    // get value of page
    $page_type = $_GET['name'];
    // check the value
    if ($page_type == 'pieces') {
        // include pieces dashboard
        include_once 'includes/pieces-dashboard.php';
    } elseif ($page_type == 'clients') {
        // inclyde clients dashboard
        include_once 'includes/clients-dashboard.php';
    }
} else {
    // include error page 
    include_once $globmod . 'page-error.php';
}