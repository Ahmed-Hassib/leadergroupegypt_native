<?php
  // connection info
  $databases  = ["jsl_db"];
  $host       = "localhost";
  $user       = "root";
  $pass       = "@hmedH@ssib";

  // get documnet root
  $document_root  = $_SERVER['DOCUMENT_ROOT'];
  // file location
  $mysqldump      = $lib . "mysqldump/Mysqldump.php";
  // include_once mysqldump
  include_once($mysqldump);
  // backup location
  $backup_location = $data . "backups/";

  // check if the directory is exist or not
  if (!file_exists($backup_location)) {
    // create a directory for the company
    mkdir($backup_location);
  }
  
  // loop on databases
  foreach ($databases as $database) {
    // check if database directory is exist
    if (!file_exists($backup_location . $database)) {
      // create a directory for the company
      mkdir($backup_location . $database);
    }

    if ($db_backup_file_name != null) {
      // database folder
      $backup_location_file = $backup_location . "$database/$db_backup_file_name";
      
      // take a backup
      try {
        // dsn for current database
        $dsn = "mysql:host=$host;dbname=$database";
        // get the dump
        $dump = new Ifsnop\Mysqldump\Mysqldump($dsn, $user, $pass);
        $dump->start($backup_location_file);
      } catch (\Exception $e) {
        echo 'mysqldump-php error: ' . $e->getMessage() . '<br>';
      }
    } else {
      $backup_location_file = null;
    }
  }
  // check database object was created or not
  if (!isset($db_obj)) {
    $db_obj = new Database();
  }

  // check if backup was taken
  if ($backup_flag == false && $db_backup_file_name != null && $backup_location_file != null) {
    // check backup file if exist
    if (file_exists($backup_location_file)) {
      // add a record to backups table in database
      $db_obj->add_new_backup_info(array($db_backup_file_name, get_date_now(), get_time_now(), 1));
    }
  }
?>
