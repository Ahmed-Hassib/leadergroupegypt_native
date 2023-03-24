<?php
// connect to database from configration file
include_once '../../etc/conf.php';
include_once 'functions.php';
// start SESSION
session_start();
// regenerate session id
session_regenerate_id();
// database connection
global $con;
// check the request method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
}

// get user id
$userid = $_SESSION['UserID'];
// get user type
$isTech = $_SESSION['isTech'];
// check if tech
if ($isTech) {
    // get all malfunctions of current technical man
    $malsQ = "SELECT `mal_id`, `mng_id`, `client_id` FROM `malfunctions` WHERE `tech_id` = $userid AND `isShowed` = 0 AND `mal_status` = 0";
    $stmt = $con->prepare($malsQ);
    $stmt->execute();
    $malsRows = $stmt->fetchAll();
    $count = $stmt->rowCount();
    // check the count
    if ($count > 0) {
        // empty array
        $mals = array();
        // loop on data
        foreach ($malsRows as $key => $row) {
            $mals[$key]['mal_id'] = $row['mal_id'];
            $mals[$key]['mng']    = selectSpecificColumn("`Username`", "`users`", "WHERE `UserID` = ".$row['mng_id'])[0]['Username'];
            $mals[$key]['client'] = selectSpecificColumn("`piece_name`", "`pieces`", "WHERE `piece_id` = ".$row['client_id'])[0]['piece_name'];
        }
    }

    //  print_r($mals);
    echo json_encode($mals);
}