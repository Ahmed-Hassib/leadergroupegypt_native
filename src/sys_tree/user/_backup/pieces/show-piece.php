<?php
// check if Get request dirId is numeric and get the integer value
$dirId = isset($_GET['dirId']) && is_numeric($_GET['dirId']) ? intval($_GET['dirId']) : -1;
// check if Get request srcId is numeric and get the integer value
$srcId = isset($_GET['srcId']) && is_numeric($_GET['srcId']) ? intval($_GET['srcId']) : -1;
// check the direction and source id
if ($dirId != -1 && $srcId != -1) {
    // include data table module
    include_once 'includes/data-table.php';
} else {
    // include data error
    include_once $globmod . 'data-error.php';
}
?>