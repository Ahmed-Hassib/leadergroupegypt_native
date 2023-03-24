<?php

// include_once all outer files
include_once 'includes.php';

// database info
$host    = "localhost";
$dbname  = "jsl_db";
$user    = "root";
$pass    = "@hmedH@ssib";

// initiate database object
$db_obj = new Database($host, $dbname, $user, $pass);

// connect to database
$db_obj->db_connection();

// connection to database variable which will be use in the application
$con = $db_obj->con;