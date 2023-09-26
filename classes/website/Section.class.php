<?php

/**
 * Login class
 */
class Section extends Database
{
  // properties
  public $con;
  protected $TABLE_NAME = 'sections';

  // constructor
  public function __construct()
  {
    // create an object of Database class
    $db_obj = new Database("localhost", "leadergroup_website", "root", "@hmedH@ssib");
    $this->con = $db_obj->con;
  }

  // function for get all sections
  public function get_all_sections()
  {
    // select all sections
    $select_sections = "SELECT *FROM `$this->TABLE_NAME`";
    // check if sections exist in database
    $stmt = $this->con->prepare($select_sections);
    $stmt->execute();
    $sections_info = $stmt->fetchAll();
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ? $sections_info : null;
  }

  // function to get activated section
  public function get_activated_sections()
  {
    // select all texts
    $select_texts = "SELECT *FROM `$this->TABLE_NAME` WHERE `is_active` = 1;";
    $stmt = $this->con->prepare($select_texts);
    $stmt->execute();
    $texts_info = $stmt->fetchAll();
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ? $texts_info : null;
  }

  // function to deactivate section
  public function get_deactivated_section()
  {
    // select all texts
    $select_texts = "SELECT *FROM `$this->TABLE_NAME` WHERE `is_active` = 0;";
    $stmt = $this->con->prepare($select_texts);
    $stmt->execute();
    $texts_info = $stmt->fetchAll();
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ? $texts_info : null;
  }

  // function to activate section
  public function activate_section($id)
  {
    // update activation query
    $update_query = "UPDATE `$this->TABLE_NAME` SET `is_active` = 1 WHERE `id` = ?;";
    $stmt = $this->con->prepare($update_query);
    $stmt->execute(array($id));
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ? true : null;
  }

  // function to deactivate section
  public function deactivate_section($id)
  {
    // update activation query
    $update_query = "UPDATE `$this->TABLE_NAME` SET `is_active` = 0 WHERE `id` = ?;";
    $stmt = $this->con->prepare($update_query);
    $stmt->execute(array($id));
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ? true : null;
  }
}