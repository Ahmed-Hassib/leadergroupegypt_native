<?php
    // get client name
    $client_name = isset($_GET['client-name']) ? $_GET['client-name'] : 0;
    // company id
    $company_id = isset($_GET['company-id']) ? $_GET['company-id'] : 0;
    // update cliet name with %
    $client_name = '%'.$client_name.'%';
    // query statement
    $query = "SELECT `piece_id`, `piece_name` FROM `pieces` WHERE `piece_name` LIKE ? AND `company_id` = ?";
    // prepare statement
    $stmt = $con->prepare($query);
    $stmt->execute(array($client_name, $company_id));
    // get all rows
    $result = $stmt->fetchAll();
    // send the result as a json formate
    echo json_encode($result);