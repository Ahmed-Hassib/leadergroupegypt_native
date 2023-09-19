<?php

/**
 * Login class
 */
class AboutUs extends Database
{
  // properties
  public $con;

  // constructor
  public function __construct()
  {
    // create an object of Database class
    $db_obj = new Database("localhost", "leadergroup_website", "root", "@hmedH@ssib");
    $this->con = $db_obj->con;
  }

  // function to get all texts
  public function get_all_texts()
  {
    // select all texts
    $select_texts = "SELECT *FROM `about_us`";
    $stmt = $this->con->prepare($select_texts);
    $stmt->execute();
    $texts_info = $stmt->fetchAll();
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ? $texts_info : null;
  }

  // function to get all texts
  public function get_text($id)
  {
    // select all texts
    $select_texts = "SELECT *FROM `about_us` WHERE `id` = ?;";
    $stmt = $this->con->prepare($select_texts);
    $stmt->execute(array($id));
    $texts_info = $stmt->fetchAll();
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ? $texts_info : null;
  }

  // function to get all texts
  public function get_active_texts()
  {
    // select all texts
    $select_texts = "SELECT *FROM `about_us` WHERE `is_active` = 1;";
    $stmt = $this->con->prepare($select_texts);
    $stmt->execute();
    $texts_info = $stmt->fetchAll();
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ? $texts_info : null;
  }

  // function to get all texts
  public function get_deactive_texts()
  {
    // select all texts
    $select_texts = "SELECT *FROM `about_us` WHERE `is_active` = 0;";
    $stmt = $this->con->prepare($select_texts);
    $stmt->execute();
    $texts_info = $stmt->fetchAll();
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ? $texts_info : null;
  }

  // function to get all texts
  public function insert_new_text($info)
  {
    // insert new text query
    $insert_query = "INSERT INTO `about_us` (`text_ar`, `text_en`, `is_active`, `added_date`, `added_by`) VALUES (?, ?, ?, ?, ?) ;";
    $stmt = $this->con->prepare($insert_query);
    $stmt->execute($info);
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ? true : null;
  }

  public function delete_text($id)
  {
    // delete new text query
    $delete_query = "DELETE FROM `about_us` WHERE `id` = ?;";
    $stmt = $this->con->prepare($delete_query);
    $stmt->execute(array($id));
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ? true : null;
  }

  public function update_text($info)
  {
    // update new text query
    $update_query = "UPDATE `about_us` SET `text_ar` = ?, `text_en` = ?, `is_active` = ? WHERE `id` = ? ;";
    $stmt = $this->con->prepare($update_query);
    $stmt->execute($info);
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ? true : null;
  }

  public function activate_text($id)
  {
    // update new text query
    $update_query = "UPDATE `about_us` SET `is_active` = 1 WHERE `id` = ? ;";
    $stmt = $this->con->prepare($update_query);
    $stmt->execute(array($id));
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ? true : null;
  }

  public function deactivate_text($id)
  {
    // update new text query
    $update_query = "UPDATE `about_us` SET `is_active` = 0 WHERE `id` = ? ;";
    $stmt = $this->con->prepare($update_query);
    $stmt->execute(array($id));
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ? true : null;
  }
}