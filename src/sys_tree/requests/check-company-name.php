<?php
// user name
$name = isset($_GET['name']) ? $_GET['name'] : '';
// query statement
$query = "SELECT count(`company_id`) FROM `companies` WHERE `company_name` LIKE ?";
// prepare statement
$stmt = $con->prepare($query);
$stmt->execute(array($name));
// get all rows
$result = $stmt->fetchColumn();
// send the result as a json formate
echo json_encode($result > 0 ? true : false);