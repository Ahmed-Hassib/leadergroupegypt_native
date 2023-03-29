<?php 
// get piece full name 
$client_name = $_GET['client-name'];
// create an object of Pieces class
$pcs_obj = new Pieces();
// query statement
$query = "SELECT COUNT(`comb_id`) FROM `combinations` WHERE `client_name` = ? AND `company_id` = ?";
// prepare statement
$stmt = $con->prepare($query);
$stmt->execute(array($client_name, $_SESSION['company_id']));
// get all rows
$result = $stmt->fetchColumn();

$is_exist_client_name = $result > 0 ? true :false;
// send the result as a json formate
echo json_encode(array($is_exist_client_name, $result));