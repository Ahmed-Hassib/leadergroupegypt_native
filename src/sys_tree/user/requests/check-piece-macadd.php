<?php 
// get piece full name 
$mac_add = $_GET['mac_add'];
// check id
$piece_id = isset($_GET['id']) && !empty($_GET['id']) ? $_GET['id'] : '';
// create an object of Pieces class
$pcs_obj = new Pieces();
// check mac address when adding piece
$adding_query ="SELECT COUNT(`mac_add`) FROM `pieces_mac_addr` LEFT JOIN `pieces_info` ON `pieces_info`.`id` = `pieces_mac_addr`.`id` WHERE `pieces_mac_addr`.`mac_add` = ? AND `pieces_info`.`company_id` = ?";
// check mac address when editing piece
$editing_query ="SELECT COUNT(`mac_add`) FROM `pieces_mac_addr` LEFT JOIN `pieces_info` ON `pieces_info`.`id` = `pieces_mac_addr`.`id` WHERE `pieces_mac_addr`.`mac_add` = ? AND `pieces_info`.`company_id` = ? AND `id` != ?";
// query statement
$query = empty($piece_id) ? $adding_query : $editing_query;
// prepare statement
$stmt = $con->prepare($query);
$stmt->execute(empty($piece_id) ? array($mac_add, $_SESSION['company_id']) : array($mac_add, $_SESSION['company_id'], $piece_id));
// get all rows
$result = $stmt->fetchColumn();

$is_exist_fullname = $result > 0 ? true :false;
// send the result as a json formate
echo json_encode(array($is_exist_fullname, $result));