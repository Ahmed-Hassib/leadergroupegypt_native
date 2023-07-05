<?php

/**
 * getTitle function v1.0.1
 * This function not accept parameters
 * Contain global variable can be access from anywhere
 * get title page from the page and display it
 */
function getTitle() {
  global $page_title; // page title
  // check if set or not
  if (isset($page_title)) {
    echo strtoupper(language(strtoupper($page_title), isset($_SESSION['systemLang']) ? $_SESSION['systemLang'] : "ar"));
  } else {
    echo language('NOT ASSIGNED', isset($_SESSION['systemLang']) ? $_SESSION['systemLang'] : "ar");
  }
}

/**
 * redirectHome function v2
 * This function accepts parameters
 * $msg => echo the error message
 * $seconds => seconds before redirect
 */
function redirectHome($msg = null, $url = null, $seconds = 3) {
  // check the url
  if ($url == null) {
    $target_url = '../dashboard/index.php';
  } else {
    if ($url == 'back') {
      $target_url = isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '../dashboard/index.php';
    } else {
      $target_url = $url;
    }
  }
  // redirect page
  header("refresh:$seconds;url=$target_url");
  // check if empty message
  if (!empty($msg) && $msg != null) {
    echo $msg;
  }
  // show redirect messgae
  echo "<div dir='".($_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr')."' >". language('YOU WILL BE AUTOMATICALLY REDIRECTED AFTER', @$_SESSION['systemLang']) . " $seconds " . language('SECOND', @@$_SESSION['systemLang']) ."</div>";
  // exit
  exit();
}




/**
 * checkItems function v1
 * This function accept 3 parameter
 * $select => the item to select [Ex: User, Client, Piece]
 * $table => the table to select from [EX: users, Piece, Direction]
 * $value => the value of select [Ex: ahmed, DEV]
 */
function checkItem($select, $table, $value) {
  global $con;
  $statement = $con->prepare("SELECT $select FROM $table WHERE $select = ? AND `company_id` = " . $_SESSION['company_id']);
  $statement->execute(array($value));
  $count = $statement->rowCount();

  // echo $count;
  return $count;
}

/**
 * countRecords function v2
 * This function used to count number of records in the specific table in database
 * This function accept parameters
 * $column => the column need to count
 * $table => table to count from
 */
function countRecords($column, $table, $condition = null) {
  global $con; // connection to database

  $stmt = $con->prepare("SELECT COUNT($column) FROM $table $condition");
  $stmt->execute();
  
  return $stmt->fetchColumn();
}

/**
 * getLatestRecord function v2
 * This function used to get latest record
 * $column => column to select
 * $table => table to choose from
 * $limit => number of record to select by default 5
 * $order => order the record debepds on the latest records
 */
function getLatestRecord($column, $table, $condition, $order, $limit = 5) {
  global $con; // connection to database
  // prepare query
  $stmt = $con->prepare("SELECT $column FROM $table $condition ORDER BY $order DESC LIMIT $limit");
  $stmt->execute(); // execute query
  $rows = $stmt->fetchAll(); // fetch all result
  return $rows; // return result
}

/**
 * getNextID function v1
 * This function is used to get next piece id
 */
function getNextID($table) {
  global $con; // connection to database
  // prepare query
  $stmt = $con->prepare("SELECT `AUTO_INCREMENT` AS 'AI' FROM information_schema.TABLES WHERE `TABLE_SCHEMA` = 'jsl_db' AND `TABLE_NAME` = ?");
  $stmt->execute(array($table));
  $rows = $stmt->fetchColumn();
  return $rows;
}

/**
 * build_direction_tree function v1
 * This function used to build a tree view function
 * $arr => data array from the database
 * $parent => parent id
 * $level => tree level [0 is default]
 * $prelevel => tree prelevel [-1 is default]
 */
function build_direction_tree($arr, $parent, $level = 0, $prelevel = -1, $nav_up_level = 1) {
  foreach ($arr as $id => $data) {
    if ($parent == $data['source_id']) {
      // check if this record is main
      $data['src'] = $parent == 0 ? $data['ip'] : $arr[$parent]['ip'];
      // check tree level
      if ($level > $prelevel) {
        if ($level == 0 && count($arr) < 15) {
          echo "<ul class='justify-content-center'>";
        } else {
          echo "<ul>";
        }
      }
      if ($level == $prelevel) {
        echo "</li>";
      }

      $node_url = str_repeat("../", $nav_up_level) . "pieces/index.php?do=show-piece&dir-id=" . $data['direction_id'] . "&src-id=" . $data['id'];
      
      // show data
      echo "<li>";
      echo "<a href='$node_url'>";
      echo "<span id=". $data['ip'] .">" . $data['full_name'] . "<br>" . $data['ip'] . "</span>";
      echo "</a>";

      if ($level > $prelevel) {
        $prelevel = $level;
      }

      $level++;
      build_direction_tree($arr, $id, $level, $prelevel);
      $level--;
    }
  }
  if ($level == $prelevel) {
    echo "</li></ul>";
  }
}

// *******************************
/**
 * selectSpecificColumn function v1
 * This function is used to select specific column from specific table
 */
function selectSpecificColumn($column, $table, $condition) {
  global $con; // connection to database
  // prepare query
  $query = "SELECT $column FROM $table $condition";
  $stmt = $con->prepare($query);
  $stmt->execute(); // execute query
  $rows = $stmt->fetchAll(); // fetch all result
  return $rows; // return result
}
// *******************************

// check the ping of ip ..
function getPing($ip) {
  if ($ip != '1') {
    // set limit for execution process
    set_time_limit(5000);
    // executing ping command..
    $lostping   = shell_exec("ping -n 10 " . $ip . " | findstr /I /C:\"Lost\" ");
    $avping     = shell_exec("ping -n 10 " . $ip . " | findstr /I /C:\"Average\" ");
    // empty array for result
    // $temp       = array();      // temporary array
    // $pingRes    = array();      // for temp result
    // $finalRes   = array();      // for final result

    // remove the special charachters from average and loss packet
    $lostping   = trim($lostping, " \n");
    $avping     = trim($avping, " \n");

    // check if lost and average ping
    if (!empty($avping)) {
      // action when connected ..
      return $avping . ", " . $lostping;
    } else {
      //action in connection failure ..
      return "offline" . ", " . $lostping;
    }
  }
}


/**
 * restoreBackup function v1
 * used to restore the backup
 * 
 */
function restoreBackup($file) {
  // set limit for execution process
  set_time_limit(5000);
  global $con; // connection to database
  // check if the file is exist or not 
  if (file_exists($file)) {
    // empty query
    $query = "";
    // try .. catch
    try {
      // open the file with read mode
      $handle = fopen($file, "r");
      // append the content to the query
      $query = fread($handle, filesize($file));
      // prepare the query
      $stmt = $con->prepare($query);
      // execute the query
      $stmt->execute();
      // echo true
      return true;
    } catch (\Exception $e) {
      return $e->getMessage();
    }
  }
}


/**
 * updateChildDirection function v 1
 */
function updateChildDirection($srcId, $newDir) {
  // final query
  $finalQuery = "";
  // check piece if exist or not
  $checkPiece = checkItem("`id`", "`pieces`", $srcId);
  // if exist
  if ($checkPiece > 0) {
    // count children of the current piece
    $checkChildren = countRecords("`id`", "`pieces`", "WHERE `source_id` = " . $srcId);
    // check if has children
    if ($checkChildren > 0) {
      $finalQuery .= "UPDATE `pieces` SET `direction_id` = '" . $newDir . "' WHERE `id` = " . $srcId . " AND `company_id` = " . $_SESSION['company_id'] . ";";
      // condition
      $condition = "LEFT JOIN `direction` ON `direction`.`direction_id` = `pieces`.`direction_id`";
      $condition .= "WHERE `pieces`.`source_id` = " . $srcId . ";";
      // fetch all children
      $children = selectSpecificColumn("`pieces`.`id`, `pieces`.`direction_id`", "`pieces`", $condition);
      // loop on it
      foreach ($children as $value) {
        // get the children of the current piece
        $finalQuery .= updateChildDirection($value['id'], $newDir);
      }
    } else {
      $finalQuery .= "UPDATE `pieces` SET `direction_id` = '" . $newDir . "' WHERE `id` = " . $srcId . " AND `company_id` = " . $_SESSION['company_id'] . ";";
    }
  }
  // return the query
  return $finalQuery;
}

/**
 * // createLogs function v1
 * accepts 2 param
 * $username => username of owner of the log
 * $msg      => log message
 * $type     => [1] info -> default case
 *              [2] warning
 *              [3] danger
 */
function createLogs($username, $msg, $type = 1) {
  // get type of log
  switch ($type) {
    case 1:
      $typeName = "info";
      break;
    case 2:
      $typeName = "warning";
      break;
    case 3:
      $typeName = "danger";
      break;
  }
  // log
  $log = "[" . $username . "@" . Date('d/m/Y h:ia') . " ~ " . $typeName . " msg]:" . $msg . ".\n";
  // location
  $DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];
  $fileLocation = $DOCUMENT_ROOT . "data/log/";
  // check the fileLocation
  if (!file_exists($fileLocation) && !is_dir($fileLocation)) {
    mkdir($fileLocation);
  }
  $filename = "log-" . Date('Ymd') . "-" . Date('Ymd') . ".txt";
  $file = $fileLocation . $filename;
  // open file with append mode
  $handle = fopen($file, "aw+");
  // write in file
  fwrite($handle, $log);
  // close the file
  fclose($handle);
}



/**
 * convertIP function
 */
function addZeros($ipSlice) {
  return substr('000' . $ipSlice, -3);
}
function convertIP($ip) {
  return join("", array_map('addZeros', explode(".", $ip)));
}


/**
 * bg_progress function
 * return background color depend on value
 */
function bg_progress($val) {
  // get the progress bar color
  if ($val >= 0 && $val <= 10) {
    $bg_color = "bg-danger";
  } elseif ($val > 10 && $val <= 25) {
    $bg_color = "bg-warning";
  } elseif ($val > 25 && $val < 70) {
    $bg_color = "bg-primary";
  } else {
    $bg_color = "bg-success";
  }
  // return bg_color
  return $bg_color;
}

/**
 * get_time_now function
 * return the current time
 */
function get_time_now() {
  $timestamp = strtotime(date('H:i:s')) + 60*60;
  return date('H:i:s', $timestamp);
}

/**
 * get_date_now function
 * return the current date
 */
function get_date_now() {
  return date('Y-m-d');
}

/**
 * random_digits function
 * accepts length of random digits
 */
function random_digits($length = 5){
  $digits = '';
  $numbers = range(0,9);
  shuffle($numbers);
  for($i = 0;$i < $length;$i++)
    $digits .= $numbers[$i];
  return $digits;
}

function generate_random_string($length = 5) {
  $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[random_int(0, $charactersLength - 1)];
  }
  return $randomString;
}