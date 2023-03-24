<?php 
// get piece full name 
$direction_name = $_GET['direction-name'];
// check id if isset
$id = isset($_GET['id']) && !empty($_GET['id']) ? $_GET['id'] : '';
// company id
$company_id = $_SESSION['company_id'];
// create an object of Direction class
$dir_obj = new Direction();
// check direction name when adding new direction
$adding_query = "SELECT COUNT(`direction_id`) FROM `direction` WHERE `direction_name` = ? AND `company_id` = ?";
// check direction name when editing direction
$editing_query = "SELECT COUNT(`direction_id`) FROM `direction` WHERE `direction_name` = ? AND `company_id` = ? AND `direction_id` != ?";
// query statement
$query = empty($id) ? $adding_query : $editing_query;
// prepare statement
$stmt = $con->prepare($query);
$stmt->execute(empty($_GET['id']) ? array($direction_name, $company_id) : array($direction_name, $company_id, $id));
// get all rows
$result = $stmt->fetchColumn();

$is_exist_direction = $result > 0 ? true :false;
// send the result as a json formate
echo json_encode(array($is_exist_direction, $result));