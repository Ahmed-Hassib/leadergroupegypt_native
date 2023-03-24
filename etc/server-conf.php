<?php

// include_once all outer files
include_once 'includes.php';

// database info
$host   = "sql313.eb2a.com";
$dbname = "eb2a_33040878_jsl_db";
$user   = "eb2a_33040878";
$pass   = "@hmedH@ssib";

// initiate database object
$db_obj = new Database($host, $dbname, $user, $pass);

// connect to database
$db_obj->db_connection();

// connection to database variable which will be use in the application
$con = $db_obj->con;
