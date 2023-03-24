<?php
    // user name
    $license_id = isset($_GET['license_id']) ? $_GET['license_id'] : '';
    $company_id = isset($_GET['company_id']) ? $_GET['company_id'] : '';

    // check license id and company id
    if (!empty($license_id) && !empty($company_id)) {
        // query statement
        $query = "UPDATE `license` SET `isEnded`= 1 WHERE `ID` = ? AND `company_id` = ?";
        // prepare statement
        $stmt = $con->prepare($query);
        $stmt->execute(array($license_id, $company_id));
        // get all rows
        $result = $stmt->fetchAll();
        // send the result as a json formate
        echo json_encode($result);
    }