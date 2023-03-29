<?php 
// get piece full name 
$ip = $_GET['ip'];
// get ip if set
$id = isset($_GET['id']) ? $_GET['id'] : 0;
// create an object of Pieces class
$pcs_obj = new Pieces();
// query statement
$query = $id ==  0 ? "SELECT COUNT(`id`) FROM `pieces_info` WHERE `ip` = ? AND `company_id` = ?" : "SELECT COUNT(`id`) FROM `pieces_info` WHERE `ip` = ? AND `company_id` = ? AND `id` != ?";
// prepare statement
$stmt = $con->prepare($query);
$stmt->execute($id ==  0 ? array($ip, $_SESSION['company_id']) : array($ip, $_SESSION['company_id'], $id));
// get all rows
$result = $stmt->fetchColumn();

$is_exist_fullname = $result > 0 ? true :false;
// send the result as a json formate
echo json_encode(array($is_exist_fullname, $result));