<?php 
// get piece full name 
$mac_add = $_GET['mac_add'];
// create an object of Pieces class
$pcs_obj = new Pieces();
// query statement
$query = "SELECT COUNT(`mac_add`) FROM `pieces_mac_addr` LEFT JOIN `pieces_info` ON `pieces_info`.`id` = `pieces_mac_addr`.`id` WHERE `pieces_mac_addr`.`mac_add` LIKE ? AND `pieces_info`.`company_id` = ?";
// prepare statement
$stmt = $con->prepare($query);
$stmt->execute(array($mac_add, $_SESSION['company_id']));
// get all rows
$result = $stmt->fetchColumn();

$is_exist_fullname = $result > 0 ? true :false;
// send the result as a json formate
echo json_encode(array($is_exist_fullname, $result));