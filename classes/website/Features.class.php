<?php

/**
 * Featutres class
 */
class Features extends Database
{
  // properties
  public $con;
  // section id
  public $SECTION_ID = 'sec_1003';
  public $SECTION_NAME = 'features';
  public $SECTION_CONTENT_TABLE = 'features';
  public $SECTION_CONTENT_FOLDER = 'features';

  // constructor
  public function __construct()
  {
    // create an object of Database class
    $db_obj = new Database("localhost", "leadergroup_website", "root", "@hmedH@ssib");
    $this->con = $db_obj->con;
  }

  // function to get all featres
  public function get_all_features()
  {
    // select all featres
    $select_feature = "SELECT *FROM `features`";
    $stmt = $this->con->prepare($select_feature);
    $stmt->execute();
    $features_info = $stmt->fetchAll();
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ? $features_info : null;
  }

  // function to get all featres
  public function get_feature($id)
  {
    // select all featres
    $select_feature = "SELECT *FROM `features` WHERE `id` = ?;";
    $stmt = $this->con->prepare($select_feature);
    $stmt->execute(array($id));
    $features_info = $stmt->fetch();
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ? $features_info : null;
  }
  
  // function to get all featres
  public function get_feature_details($id)
  {
    // select all featres
    $select_feature = "SELECT *FROM `feature_details` WHERE `feature_id` = ?;";
    $stmt = $this->con->prepare($select_feature);
    $stmt->execute(array($id));
    $features_info = $stmt->fetchAll();
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ? $features_info : null;
  }

  // function to get all activated featres
  public function get_active_features()
  {
    // select all featres
    $select_feature = "SELECT *FROM `features` WHERE `is_active` = 1;";
    $stmt = $this->con->prepare($select_feature);
    $stmt->execute();
    $features_info = $stmt->fetchAll();
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ? $features_info : null;
  }

  // function to get all deactivated featres
  public function get_deactive_features()
  {
    // select all featres
    $select_feature = "SELECT *FROM `features` WHERE `is_active` = 0;";
    $stmt = $this->con->prepare($select_feature);
    $stmt->execute();
    $features_info = $stmt->fetchAll();
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ? $features_info : null;
  }

  // function to get all featres
  public function insert_new_feature($info)
  {
    // insert new feature query
    $insert_query = "INSERT INTO `features` (`feature_name_ar`, `feature_name_en`, `feature_desc_ar`, `feature_desc_en`, `feature_img`, `is_active`, `added_date`, `added_time`, `added_by`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?) ;";
    $stmt = $this->con->prepare($insert_query);
    $stmt->execute($info);
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ? true : null;
  }

  // function to insert feature details
  public function insert_new_feature_details($info)
  {
    // insert new feature query
    $insert_query = "INSERT INTO `feature_details` (`feature_id`, `detail_name_ar`, `detail_name_en`, `detail_ar`, `detail_en`, `added_date`, `added_time`, `added_by`) VALUES (?, ?, ?, ?, ?, ?, ?, ?) ;";
    $stmt = $this->con->prepare($insert_query);
    $stmt->execute($info);
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ? true : null;
  }

  // function to delete feature
  public function delete_feature($id)
  {
    // delete new feature query
    $delete_query = "DELETE FROM `features` WHERE `id` = ? ;";
    $delete_query .= "DELETE FROM `feature_details` WHERE `feature_id` = ?;";
    $stmt = $this->con->prepare($delete_query);
    $stmt->execute(array($id, $id));
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ? true : null;
  }
  
  // function to delete feature
  public function delete_feature_detail($id)
  {
    // delete new feature query
    $delete_query = "DELETE FROM `feature_details` WHERE `id` = ? ;";
    $stmt = $this->con->prepare($delete_query);
    $stmt->execute(array($id));
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ? true : null;
  }

  // function to update feature data
  public function update_feature($info)
  {
    // update new feature query
    $update_query = "UPDATE `features` SET `feature_name_ar` = ?, `feature_name_en` = ?, `feature_desc_ar` = ?, `feature_desc_en` = ?, `feature_img` = ?, `is_active` = ? WHERE `id` = ? ;";
    $stmt = $this->con->prepare($update_query);
    $stmt->execute($info);
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ? true : null;
  }

  // function to update featre details
  public function update_feature_details($info)
  {
    // update new feature query
    $update_query = "UPDATE `features` SET `feature_id` = ?, `text_ar` = ?, `text_en` = ? WHERE `id` = ?;";
    $stmt = $this->con->prepare($update_query);
    $stmt->execute($info);
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ? true : null;
  }

  // function to activate feature
  public function activate_feature($id)
  {
    // update new feature query
    $update_query = "UPDATE `features` SET `is_active` = 1 WHERE `id` = ? ;";
    $stmt = $this->con->prepare($update_query);
    $stmt->execute(array($id));
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ? true : null;
  }

  // function to deactivate feature
  public function deactivate_feature($id)
  {
    // update new feature query
    $update_query = "UPDATE `features` SET `is_active` = 0 WHERE `id` = ? ;";
    $stmt = $this->con->prepare($update_query);
    $stmt->execute(array($id));
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ? true : null;
  }

  // function to update number of views
  public function update_settings($num, $id)
  {
    // update new feature query
    $update_query = "UPDATE `sections` SET `num_content` = ? WHERE `section_id` = ? ;";
    $stmt = $this->con->prepare($update_query);
    $stmt->execute(array($num, $id));
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ? true : null;
  }
}