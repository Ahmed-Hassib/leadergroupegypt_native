<?php
/**
 * Company class
 */
class CompSugg extends Database {
  // properties
  public $con;

  // constructor
  public function __construct() {
    // create an object of Database class
    $db_obj = new Database();
    $this->con = $db_obj->con;
  }

  // function to complaints of specific company
  public function get_all_complaints($user_id, $company_id) {
    // complaints data
    $complaints_query = "SELECT *FROM `comp_sugg` WHERE `type` = 0 AND `added_by` = ? AND `company_id` = ?";
    $stmt = $this->con->prepare($complaints_query);
    $stmt->execute(array($user_id, $company_id));
    $complaints_data = $stmt->fetchAll();
    $count = $stmt->rowCount() ;    // all count of data
    // return
    return $count > 0 ? $complaints_data : null;
  }
  
  // function to suggestions of specific company
  public function get_all_suggestions($user_id, $company_id) {
    // suggestions data
    $suggestions_query = "SELECT *FROM `comp_sugg` WHERE `type` = 1 AND `added_by` = ? AND `company_id` = ?";
    $stmt = $this->con->prepare($suggestions_query);
    $stmt->execute(array($user_id, $company_id));
    $suggestions_data = $stmt->fetchAll();
    $count = $stmt->rowCount() ;    // all count of data
    // return
    return $count > 0 ? $suggestions_data : null;
  }
}