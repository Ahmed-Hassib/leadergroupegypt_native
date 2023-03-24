<?php 
// get piece full name 
$ip = $_GET['ip'];
// create an object of Pieces class
$pcs_obj = new Pieces();
// query statement
$query = "SELECT COUNT(`ip`) FROM `pieces_info` WHERE `ip` LIKE ? AND `company_id` = ?";
// prepare statement
$stmt = $con->prepare($query);
$stmt->execute(array($ip, $_SESSION['company_id']));
// get all rows
$result = $stmt->fetchColumn();

$is_exist_fullname = $result > 0 ? true :false;
// send the result as a json formate
echo json_encode(array($is_exist_fullname, $result));