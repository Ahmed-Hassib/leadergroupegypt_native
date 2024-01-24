<?php


class Pricing extends Database
{
  // properties
  public $con;

  // table name
  const TABLENAME = 'pricing_plans';

  // constructor
  public function __construct()
  {
    // create an object of Database class
    $db_obj = new Database("localhost", "jsl_db", "root", "@hmedH@ssib");

    $this->con = $db_obj->con;
  }

  // get all pricing
  public function get_all_pricing_plans()
  {
    // select pricing info query
    $pricing_info_query = "SELECT *FROM " . self::TABLENAME . " WHERE `status` = 1";
    // prepare the query
    $stmt = $this->con->prepare($pricing_info_query); // select all pricing
    $stmt->execute(); // execute data
    $rows = $stmt->fetchAll(); // assign all data to variable
    $count = $stmt->rowCount(); // all count of data
    // return
    return $count > 0 ? $rows : null;
  }

}