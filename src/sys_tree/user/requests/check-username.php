<?php
// user name
$username = isset($_GET['username']) ? $_GET['username'] : '';
// query statement
$query = "SELECT count(`UserID`) FROM `users` WHERE `UserName` = ?";
// prepare statement
$stmt = $con->prepare($query);
$stmt->execute(array($username));
// get all rows
$result = $stmt->fetchColumn();
// 
$is_exist_username = $result > 0 ? true : false;
// send the result as a json formate
echo json_encode(array($is_exist_username, $result));