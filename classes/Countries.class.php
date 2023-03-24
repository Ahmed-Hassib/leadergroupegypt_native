<?php
/**
 * countries class
 */
class countries extends Database {
  // properties
  public $con;

  // constructor
  public function __construct() {
    // create an object of Database class
    $db_obj = new Database();
    $this->con = $db_obj->con;
  }

  // get all countries
  public function get_all_countries() {
    // prepare query
    $countries_query = "SELECT *From `countries`";
    $stmt = $this->con->prepare($countries_query); // select all users
    $stmt->execute(); // execute data
    $countries_data = $stmt->fetchAll(); // assign all data to variable
    $countries_count = $stmt->rowCount(); // assign all data to variable
    // return result
    return $countries_count > 0 ? [$countries_count, $countries_data] : [0, null];
  }
  
}
