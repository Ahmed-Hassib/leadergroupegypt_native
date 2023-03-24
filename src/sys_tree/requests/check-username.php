<?php
// user name
$username = isset($_GET['username']) ? $_GET['username'] : '';
// query statement
$query = "SELECT count(`UserID`) FROM `users` WHERE `UserName` LIKE ?";
// prepare statement
$stmt = $con->prepare($query);
$stmt->execute(array($username));
// get all rows
$result = $stmt->fetchColumn();
// send the result as a json formate
echo json_encode($result > 0 ? true : false);