<?php
    // connection info
    $databases  = ["jsl_db", "csoc"];
    $host       = "localhost";
    $user       = "root";
    $pass       = "@hmedH@ssib";

    // get documnet root
    $document_root  = $_SERVER['DOCUMENT_ROOT'];
    // file location
    $mysqldump      = $document_root . "/jsl-network/includes/libraries/mysqldump/Mysqldump.php";
    // include_once mysqldump
    include_once($mysqldump);
    // backup location
    $backupLocation = $document_root . "/jsl-network/data/backups/";

    // check if the directory is exist or not
    if (!file_exists($backupLocation)) {
        // // display dir is not found message
        // echo "the directory of databases is not found.<br>waiting for creating the directory....<br>";
        // create a directory for the company
        mkdir($backupLocation);
        // // display a success creation of the directory
        // echo "the directory of databases created successfully.<br>";
    }
    
    // loop on databases
    foreach ($databases as $database) {
        // check if database directory is exist
        if (!file_exists($backupLocation . $database)) {
            // // display dir is not found message
            // echo "the directory of current database '$database' is not found.<br>waiting for creating the directory....<br>";
            // create a directory for the company
            mkdir($backupLocation . $database);
            // // display a success creation of the directory
            // echo "the directory of current database '$database' created successfully.<br>";
        }
        // database file name
        $dbFileName = "db_backup_" . date("dmY") . ".sql";
        // database folder
        $dbFolder = $backupLocation . $database . "/" . $dbFileName;

        // take a backup
        try {
            // dsn for current database
            $dsn = "mysql:host=$host;dbname=$database";
            // get the dump
            $dump = new Ifsnop\Mysqldump\Mysqldump($dsn, $user, $pass);
            $dump->start($dbFolder);
            // echo success message
            // echo "NOTE: DATABASE BACKUP WAS TAKEN SUCCESSFULLY...<br>";
            echo json_encode(1);
        } catch (\Exception $e) {
            echo 'mysqldump-php error: ' . $e->getMessage() . '<br>';
            echo json_encode(0);
        }
    }
    
?>
