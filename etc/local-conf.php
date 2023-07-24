<?php

// include_once all outer files
include_once 'includes.php';

// database info
$host   = "your host";
$dbname = "your database";
$user   = "username of phpmyadmin";
$pass   = "your password";

if (!isset($db_obj)) {
  // initiate database object
  $db_obj = new Database($host, $dbname, $user, $pass);
}

// connect to database
$db_obj->db_connection();

// connection to database variable which will be use in the application
$con = $db_obj->con;
