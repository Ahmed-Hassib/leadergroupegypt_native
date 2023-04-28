<?php
/**
 * Combination class
 */
class Combination extends Database {
  // properties
  public $con;

  // constructor
  public function __construct() {
    // create an object of Database class
    $db_obj = new Database();
    $this->con = $db_obj->con;
  }

  // get specific combination
  public function get_spec_combination($comb_id, $company_id) {
    // select query
    $select_query = "SELECT *FROM `combinations` WHERE `comb_id` = ? AND `company_id` = ?;";
    // prepare the query
    $stmt = $this->con->prepare($select_query);
    $stmt->execute(array($comb_id, $company_id));
    $comb_info = $stmt->fetchAll();
    $comb_count =  $stmt->rowCount();       // count effected rows
    // return result
    return $comb_count > 0 ? [true, $comb_info] : [false, null];
  }

  // function to get all combinations of specific company
  public function get_all_combinations() {
    // $count = $stmt->rowCount() ;    // all count of data
    // // return
    // return $count > 0 ? [true, $companies_data] : [false, null];
  }

  // function to insert a new combination
  public function insert_new_combination($comb_info) {
    // INSERT INTO combinations
    $insert_query = "INSERT INTO `combinations` (`client_name`, `phone`, `address`, `added_date`, `added_time`, `isFinished`, `comment`, `UserID`, `addedBy`, `company_id`) VALUES (?, ?, ?, ?, ?, 0, ?, ?, ?, ?);";
    // insert user info in database
    $stmt = $this->con->prepare($insert_query);
    $stmt->execute($comb_info);
    // get count
    $count = $stmt->rowCount() ;    // all count of data
    // return
    return $count > 0 ? true : false;
  }

  public function update_compination_mng($comb_info) {
    // review query
    $review_query = "UPDATE `combinations` SET `client_name` = ?, `phone` = ?, `address` = ?, `comment` = ?, `UserID` = ?, `lastEditDate`= ?, `lastEditTime` = ? WHERE `comb_id` = ?";
    // prepare the query
    $stmt = $this->con->prepare($review_query);
    $stmt->execute($comb_info);
    $comb_count =  $stmt->rowCount();       // count effected rows
    // return result
    return $comb_count > 0 ? true : false;
  }

  public function update_combination_tech($comb_info) {
    // review query
    $review_query = "UPDATE `combinations` SET `isFinished` = ?, `isAccepted` = ?, `finished_date` = ?, `finished_time` = ?, `lastEditDate` = ?, `lastEditTime` = ?, `cost` = ?, `tech_comment` = ? WHERE `comb_id` = ?";
    // prepare the query
    $stmt = $this->con->prepare($review_query);
    $stmt->execute($comb_info);
    $comb_count =  $stmt->rowCount();       // count effected rows
    // return result
    return $comb_count > 0 ? true : false;
  }

  public function update_combination_review($review_info) {
    // review query
    $review_query = "UPDATE `combinations` SET `isReviewed` = ?, `reviewed_date` = CURRENT_DATE, `reviewed_time` = now(), `money_review` = ?, `qty_service` = ?, `qty_emp` = ?, `qty_comment` = ?  WHERE `comb_id` = ?";
    // prepare the query
    $stmt = $this->con->prepare($review_query);
    $stmt->execute($review_info);
    $comb_count =  $stmt->rowCount();       // count effected rows
    // return result
    return $comb_count > 0 ? true : false;
  }

  public function reset_compination_info($tech_id, $comb_id) {
    // reset query
    $reset_query = "UPDATE `combinations` SET `UserID` = ?, `added_date` = ?, `added_time` = ?, `isFinished` = 0, `cost` = 0, `finished_date` = '0000-00-00', `finished_time` = '00:00:00', `isShowed` = 0, `showed_date` = '0000-00-00', `showed_time` = '00:00:00', `isAccepted` = -1,  `isReviewed` = 0, `reviewed_date` = '0000-00-00', `reviewed_time` = '00:00:00', `money_review` = 0, `qty_service` = 0, `qty_emp` = 0, `qty_comment` = ''  WHERE `comb_id` = ?";
    // prepare the query
    $stmt = $this->con->prepare($reset_query);
    $stmt->execute(array($tech_id, $comb_id));
    $comb_count =  $stmt->rowCount();       // count effected rows
    // return result
    return $comb_count > 0 ? true : false;
  }

  // function to delete combination
  public function delete_combination($comb_id) {
    $update_query = "DELETE FROM `combinations` WHERE `comb_id` = ?";
    // insert user info in database
    $stmt = $this->con->prepare($update_query);
    $stmt->execute(array($comb_id));
    // get count
    $count = $stmt->rowCount() ;    // all count of data
    // return
    return $count > 0 ? true : false;
  }
}