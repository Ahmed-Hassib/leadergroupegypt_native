<?php

// Database class
class Database extends PDO
{

  /** PROPERTIES */
  protected $host;
  protected $db_name;
  protected $dsn;
  protected $username;
  protected $password;
  public $con;


  /** CONSTANT */
  const OPTIONS = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',);


  /** METHODS */
  // constructor
  public function __construct($host = "localhost", $name = "leadergroup_website", $user =  "root", $pass = "@hmedH@ssib")
  {
    if (!$this->is_empty($name) && !$this->is_empty($user) && !$this->is_empty($pass)) {
      $this->db_name  = $name;
      $this->host     = $host;
      $this->dsn      = "mysql:host=$this->host;dbname=$this->db_name";
      $this->username = $user;
      $this->password = $pass;
      $this->con      = new PDO($this->dsn, $this->username, $this->password, self::OPTIONS);
    }
  }

  // check_prop function
  // -- used to check if the param is empty or not
  // -- return true if prop is empty
  // -- return false if prop is not empty
  public function is_empty($param)
  {
    return empty($param) ? true : false;
  }

  // db_connect function
  // -- used to connect to the specific database
  public function db_connection()
  {
    if ($this->is_empty($this->db_name) && $this->is_empty($this->dsn) && $this->is_empty($this->username) && $this->is_empty($this->password)) {
      try {
        $this->con = new PDO($this->dsn, $this->username, $this->password, self::OPTIONS);
        $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // success message
        echo "YOU ARE CONNECTED, WELCOME TO DATABASE";
      } catch (PDOException $e) {
        echo "Failed To Connect " . $e->getMessage();
      }
    }
  }

  /**
   * selectSpecificColumn function v1
   * This function is used to select specific column from specific table
   */
  public function select_specific_column($column, $table, $condition)
  {
    // prepare query
    $query = "SELECT $column FROM $table $condition";
    $stmt = $this->con->prepare($query);
    $stmt->execute();           // execute query
    $rows = $stmt->fetchAll();  // fetch all result
    return $rows;               // return result
  }

  /**
   * is_exist function v1
   * This function is used to check if specific record is exist or not
   */
  public function is_exist($column, $table, $value)
  {
    // prepare query
    $query = "SELECT COUNT($column) FROM $table WHERE $column = '$value'";
    $stmt = $this->con->prepare($query);
    $stmt->execute();           // execute query
    $count = $stmt->fetchColumn(); // count result
    return $count > 0 ? true : false;              // return result
  }

  /**
   * count_records function v2
   * This function used to count number of records in the specific table in database
   * This function accept parameters
   * $column => the column need to count
   * $table => table to count from
   */
  public function count_records($column, $table, $condition = null)
  {
    // prepare query
    $query = "SELECT COUNT($column) FROM $table $condition";
    $stmt = $this->con->prepare($query);
    $stmt->execute();
    $count = $stmt->fetchColumn();
    // return result
    return $count;
  }


  /**
   * get_latest_records function v2
   * This function used to get latest record
   * $column => column to select
   * $table => table to choose from
   * $limit => number of record to select by default 5
   * $order => order the record debepds on the latest records
   */
  public function get_latest_records($column, $table, $condition, $order, $limit = 5)
  {
    // prepare query
    $stmt = $this->con->prepare("SELECT $column FROM $table $condition ORDER BY $order DESC LIMIT $limit");
    $stmt->execute(); // execute query
    $rows = $stmt->fetchAll(); // fetch all result
    return $rows; // return result
  }

  /**
   * get_next_id function v1
   * This function is used to get next piece id
   */
  public function get_next_id($table)
  {
    // prepare query
    $stmt = $this->con->prepare("SELECT `AUTO_INCREMENT` AS 'AI' FROM information_schema.TABLES WHERE `TABLE_SCHEMA` = '$this->db_name' AND `TABLE_NAME` = ?");
    $stmt->execute(array($table));
    $rows = $stmt->fetchColumn();
    return $rows;
  }

  /**
   * get_license_id function v1
   */
  public function get_license_id($company_id)
  {
    $select_query = "SELECT `ID` FROM `license` WHERE `company_id` = ? ORDER BY `ID` DESC LIMIT 1";
    $stmt = $this->con->prepare($select_query);
    $stmt->execute(array($company_id));
    return $stmt->fetchColumn();
  }

  /**
   * get_license_info function v1
   */
  public function get_license_info($license_id, $company_id)
  {
    $select_query = "SELECT *FROM `license` WHERE `ID` = ? AND `company_id` = ? ORDER BY `ID` DESC LIMIT 1";
    $stmt = $this->con->prepare($select_query);
    $stmt->execute(array($license_id, $company_id));
    $license_info = $stmt->fetch();
    $license_count = $stmt->rowCount();
    return $license_count > 0 ? $license_info : null;
  }

  /**
   * is_expired function v1
   * accepts 1 parameter
   */
  public function is_expired($date)
  {
    $today = Date("Y-m-d");     // date for today
    $expire_date = date_format(date_create($date), 'Y-m-d');
    // check the diffrent
    return $expire_date > $today ? 0 : 1;
  }

  /**
   * add_backup_info function v1
   * insert a new backup info
   */
  public function add_new_backup_info($db_name, $info)
  {
    $insert_query = "INSERT INTO `$db_name`.`backups` (`file_name`, `backup_date`, `backup_time`, `status`) VALUES (?, ?, ?, ?);";
    $stmt = $this->con->prepare($insert_query);
    $stmt->execute($info);
    $query_count =  $stmt->rowCount();       // count effected rows
    // return result
    return $query_count > 0 ? true : null;
  }
  
  public function update_backup_info($db_name, $info)
  {
    $insert_query = "UPDATE `$db_name`.`backups` SET `backup_time` = ? WHERE `id` = ?;";
    $stmt = $this->con->prepare($insert_query);
    $stmt->execute($info);
    $query_count =  $stmt->rowCount();       // count effected rows
    // return result
    return $query_count > 0 ? true : null;
  }
}
