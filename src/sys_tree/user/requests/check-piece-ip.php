<?php 
// get piece ip
$ip = $_GET['ip'];
// get piece id
$id = isset($_GET['id']) && !empty($_GET['id']) ? $_GET['id'] : '';
// create an object of Pieces class
$pcs_obj = new Pieces();
// check ip when adding new piece
$adding_query = "SELECT COUNT(`id`) FROM `pieces_info` WHERE `ip` = ? AND `company_id` = ?";
// check ip when editing new piece
$editing_query = "SELECT COUNT(`id`) FROM `pieces_info` WHERE `ip` = ? AND `company_id` = ? AND `id` != ?";
// query
$query = empty($id) ? $adding_query : $editing_query;
// prepare statement
$stmt = $con->prepare($query);
$stmt->execute(empty($id) ? array($ip, $_SESSION['company_id']) : array($ip, $_SESSION['company_id'], $id));
// get all rows
$result = $stmt->fetchColumn();

$is_exist_fullname = $result > 0 ? true :false;
// send the result as a json formate
echo json_encode(array($is_exist_fullname, $result));