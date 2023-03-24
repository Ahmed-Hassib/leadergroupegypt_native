<?php 
// get piece full name 
$full_name = $_GET['full_name'];
// check id if isset
$id = isset($_GET['id']) ? $_GET['id'] : '';
// create an object of Pieces class
$pcs_obj = new Pieces();
// check full name when adding new piece
$adding_query = "SELECT COUNT(`full_name`) FROM `pieces_info` WHERE `full_name` = ? AND `company_id` = ?";
// check full name when editing a piece
$editing_query = "SELECT COUNT(`full_name`) FROM `pieces_info` WHERE `full_name` = ? AND `company_id` = ? AND `id` != ?";
// query statement
$query = empty($id) ? $adding_query : $editing_query;
// prepare statement
$stmt = $con->prepare($query);
$stmt->execute(empty($id) ? array($full_name, $_SESSION['company_id']) : array($full_name, $_SESSION['company_id'], $id));
// get all rows
$result = $stmt->fetchColumn();

$is_exist_fullname = $result > 0 ? true :false;
// send the result as a json formate
echo json_encode(array($is_exist_fullname, $result));