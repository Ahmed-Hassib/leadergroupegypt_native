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

  // get combination media
  public function get_combination_media($comb_id) {
    // select query
    $select_query = "SELECT *FROM `combinations_media` WHERE `comb_id` = ?;";
    // prepare the query
    $stmt = $this->con->prepare($select_query);
    $stmt->execute(array($comb_id));
    $mal_media = $stmt->fetchAll();
    $media_count =  $stmt->rowCount();       // count effected rows
    // return result
    return $media_count > 0 ? $mal_media : null;
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
    $review_query = "UPDATE `combinations` SET `isReviewed` = 1, `reviewed_date` = ?, `reviewed_time` = ?, `money_review` = ?, `qty_service` = ?, `qty_emp` = ?, `qty_comment` = ?  WHERE `comb_id` = ?";
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
    $update_query  = "DELETE FROM `combinations` WHERE `comb_id` = ?;";
    $update_query .= "DELETE FROM `combinations_media` WHERE `comb_id` = ?;";
    // insert user info in database
    $stmt = $this->con->prepare($update_query);
    $stmt->execute(array($comb_id, $comb_id));
    // get count
    $count = $stmt->rowCount() ;    // all count of data
    // return
    return $count > 0 ? true : false;
  }

  public function upload_media($comb_id, $media_name, $type) {
    // delete query
    $insert_query = "INSERT INTO `combinations_media` (`comb_id`, `media`, `type`) VALUES (?, ?, ?)";
    // prepare query
    $stmt = $this->con->prepare($insert_query);
    $stmt->execute(array($comb_id, $media_name, $type));
    $mal_count =  $stmt->rowCount();       // count effected rows
    // return result
    return $mal_count > 0 ? true : false;
  }

  public function delete_media($media_id) {
    // delete query
    $delete_query = "DELETE FROM `combinations_media` WHERE `id` = ?";
    // prepare query
    $stmt = $this->con->prepare($delete_query);
    $stmt->execute(array($media_id));
    $mal_count =  $stmt->rowCount();       // count effected rows
    // return result
    return $mal_count > 0 ? true : false;
  }
}