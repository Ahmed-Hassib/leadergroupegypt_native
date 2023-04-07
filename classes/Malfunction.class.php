<?php
/**
 * Malfunction class
 */
class Malfunction extends Database {
  // properties
  public $con;

  // constructor
  public function __construct() {
    // create an object of Database class
    $db_obj = new Database();
    $this->con = $db_obj->con;
  }

  // get specific malfunction
  public function get_spec_malfunction($mal_id, $company_id) {
    // select query
    $select_query = "SELECT *FROM `malfunctions` WHERE `mal_id` = ? AND `company_id` = ?;";
    // prepare the query
    $stmt = $this->con->prepare($select_query);
    $stmt->execute(array($mal_id, $company_id));
    $mal_info = $stmt->fetchAll();
    $mal_count =  $stmt->rowCount();       // count effected rows
    // return result
    return $mal_count > 0 ? [true, $mal_info] : [false, null];
  }

  // get all Malfunctions
  public function get_all_malfunctions($company_id) {
    
  }

  // get malfunction media
  public function get_malfunction_media($mal_id) {
    // select query
    $select_query = "SELECT *FROM `malfunctions_media` WHERE `mal_id` = ?;";
    // prepare the query
    $stmt = $this->con->prepare($select_query);
    $stmt->execute(array($mal_id));
    $mal_media = $stmt->fetchAll();
    $media_count =  $stmt->rowCount();       // count effected rows
    // return result
    return $media_count > 0 ? $mal_media : null;
  }

  // insert a new Malfunction
  public function insert_new_malfunction($info) {
     // INSERT INTO malfunctions
    $insert_query = "INSERT INTO `malfunctions` (`mng_id`, `tech_id`, `client_id`, `descreption`, `added_date`, `added_time`, `company_id`) VALUES (?, ?, ?, ?, now(), now(), ?);";
    // prepare the query
    $stmt = $this->con->prepare($insert_query);
    $stmt->execute($info);
    $mal_count =  $stmt->rowCount();       // count effected rows
    // return result
    return $mal_count > 0 ? true : false;
  }

  // update Malfunction info
  public function update_malfunction_tech($info) {
    $update_query = "UPDATE `malfunctions` SET `mal_status`= ?, `cost`=?, `repaired_date`= CURRENT_DATE, `repaired_time`= CURRENT_TIME, `tech_comment`= ?, `isAccepted`= ? WHERE `mal_id` = ?";
    // prepare the query
    $stmt = $this->con->prepare($update_query);
    $stmt->execute($info);
    $mal_count =  $stmt->rowCount();       // count effected rows
    // return result
    return $mal_count > 0 ? true : false;
  }
  
  // update Malfunction info
  public function update_malfunction_mng($info) {
    $update_query = "UPDATE `malfunctions` SET `descreption`= ? WHERE `mal_id` = ?";
    // prepare the query
    $stmt = $this->con->prepare($update_query);
    $stmt->execute($info);
    $mal_count =  $stmt->rowCount();       // count effected rows
    // return result
    return $mal_count > 0 ? true : false;
  }
  
  // update Malfunction info
  public function update_malfunction_review($info) {
    $update_query = "UPDATE `malfunctions` SET `isReviewed` = 1, `reviewed_date` = CURRENT_DATE, `reviewed_time` = CURRENT_TIME, `money_review` = ?, `qty_service` = ?, `qty_emp` = ?, `qty_comment` = ? WHERE `mal_id` = ?";
    // prepare the query
    $stmt = $this->con->prepare($update_query);
    $stmt->execute($info);
    $mal_count =  $stmt->rowCount();       // count effected rows
    // return result
    return $mal_count > 0 ? true : false;
  }
  
  // update Malfunction info
  public function reset_malfunction_info($info) {
    $update_query = "UPDATE `malfunctions` SET `tech_id` = ?, `descreption` = ?, `added_date` = CURRENT_DATE, `added_time` = CURRENT_TIME, `mal_status` =  0,`cost` =  0, `repaired_date` = '0000-00-00', `repaired_time` = '00:00:00', `tech_comment` = '', `isShowed` = 0, `showed_date` = '0000-00-00', `showed_time` = '00:00:00', `isAccepted` = -1, `isReviewed` = 0, `reviewed_date` = '0000-00-00', `reviewed_time` = '00:00:00', `money_review` = 0, `qty_service` = 0, `qty_emp` = 0, `qty_comment` = '' WHERE `mal_id` = ?";
    // prepare the query
    $stmt = $this->con->prepare($update_query);
    $stmt->execute($info);
    $mal_count =  $stmt->rowCount();       // count effected rows
    // return result
    return $mal_count > 0 ? true : false;
  }

  // delete Malfunction info
  public function delete_malfunction($id) {
    // delete query
    $delete_query  = "DELETE FROM `malfunctions` WHERE `mal_id` = ?;";
    $delete_query .= "DELETE FROM `malfunctions_media` WHERE `mal_id` = ?;";
    // prepare query
    $stmt = $this->con->prepare($delete_query);
    $stmt->execute(array($id, $id));
    $mal_count =  $stmt->rowCount();       // count effected rows
    // return result
    return $mal_count > 0 ? true : false;
  }

  public function upload_media($mal_id, $media_name, $type) {
    // delete query
    $insert_query  = "INSERT INTO `malfunctions_media`(`mal_id`, `media`, `type`) VALUES (?, ?, ?)";
    // prepare query
    $stmt = $this->con->prepare($insert_query);
    $stmt->execute(array($mal_id, $media_name, $type));
    $mal_count =  $stmt->rowCount();       // count effected rows
    // return result
    return $mal_count > 0 ? true : false;
  }

  public function delete_media($media_id) {
    // delete query
    $delete_query  = "DELETE FROM `malfunctions_media` WHERE `id` = ?";
    // prepare query
    $stmt = $this->con->prepare($delete_query);
    $stmt->execute(array($media_id));
    $mal_count =  $stmt->rowCount();       // count effected rows
    // return result
    return $mal_count > 0 ? true : false;
  }
}
