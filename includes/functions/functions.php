<?php

/**
 * get_page_tilte function v2.0.5
 * This function not accept parameters
 * Contain global variable can be access from anywhere
 * get title page from the page and display it
 */
function get_page_tilte()
{
  global $page_title; // page title
  // check if set or not
  if (isset($page_title)) {
    echo strtoupper(language(strtoupper($page_title), isset($_SESSION['systemLang']) ? $_SESSION['systemLang'] : "ar"));
  } else {
    echo language('NOT ASSIGNED', isset($_SESSION['systemLang']) ? $_SESSION['systemLang'] : "ar");
  }
}

/**
 * redirect_home function v2
 * This function accepts parameters
 * $msg => echo the error message
 * $seconds => seconds before redirect
 */
function redirect_home($msg = null, $url = null, $seconds = 3)
{
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
  echo "<div dir='" . ($_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr') . "' >" . language('YOU WILL BE AUTOMATICALLY REDIRECTED AFTER', @$_SESSION['systemLang']) . " $seconds " . language('SECOND', @@$_SESSION['systemLang']) . "</div>";
  // exit
  exit();
}


/**
 * build_direction_tree function v1
 * This function used to build a tree view function
 * $arr => data array from the database
 * $parent => parent id
 * $level => tree level [0 is default]
 * $prelevel => tree prelevel [-1 is default]
 */
function build_direction_tree($arr, $parent, $level = 0, $prelevel = -1, $nav_up_level = 1)
{
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
      if ($data['ip'] != '0.0.0.0') {
        echo "<span class='device-status'>";
        echo "<span class='ping-preloader ping-preloader-table position-relative'>";
        echo "<span class='ping-spinner ping-spinner-table spinner-grow spinner-border'></span>";
        echo "</span>";
        echo "<span class='ping-status'></span>";                    
        echo "<span class='pcs-ip' data-pcs-ip=" . $data['ip'] . " id=" . $data['ip'] . ">" . $data['full_name'] . "<br>" . $data['ip'] . "</span>";
        echo '</span>';
      } else {
        echo "<span id=" . $data['ip'] . ">" . $data['full_name'] . "<br>" . $data['ip'] . "</span>";
      }
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


/**
 * restore_backup function v1
 * used to restore the backup
 * 
 */
function restore_backup($file)
{
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
 * // create_logs function v1
 * accepts 2 param
 * $username => username of owner of the log
 * $msg      => log message
 * $type     => [1] info -> default case
 *              [2] warning
 *              [3] danger
 */
function create_logs($username, $msg, $type = 1)
{
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
 * convert_ip function
 */
function add_zeros($ipSlice)
{
  return substr('000' . $ipSlice, -3);
}

function convert_ip($ip)
{
  return join("", array_map('add_zeros', explode(".", $ip)));
}


/**
 * bg_progress function
 * return background color depend on value
 */
function bg_progress($val)
{
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
function get_time_now($formate = null)
{
  $timestamp = strtotime(date('H:i:s')) + 60 * 60;
  return $formate != null ? date($formate, $timestamp) : date('H:i:s', $timestamp);
}

/**
 * get_date_now function
 * return the current date
 */
function get_date_now($formate = null)
{
  return $formate != null ? date($formate) : date('Y-m-d');
}

/**
 * random_digits function
 * accepts length of random digits
 */
function random_digits($length = 5)
{
  $digits = '';
  $numbers = range(0, 9);
  shuffle($numbers);
  for ($i = 0; $i < $length; $i++)
    $digits .= $numbers[$i];
  return $digits;
}

function generate_random_string($length = 5)
{
  $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
    $randomString .= $characters[random_int(0, $charactersLength - 1)];
  }
  return $randomString;
}


// ping to an ip and read ping result line by line
function ping($ip, $c = 1)
{
  // Set the maximum execution time to 5 minutes
  set_time_limit(300);

  // check operating system
  if (strtolower(PHP_OS) == 'winnt') {
    $ping_cmd = "ping -n $c $ip";
  } else {
    $ping_cmd = "ping -c $c $ip";
  }

  // execute the ping command
  $ping = exec($ping_cmd, $output, $status);

  // return result
  return array(
    "ping" => $ping,
    "output" => $output,
    "status" => $status
  );
}