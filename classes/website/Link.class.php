<?php

/**
 * Login class
 */
class Link extends Database
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

  // function to get all links
  public function get_all_links()
  {
    // select all links
    $select_links = "SELECT *FROM `important_links`";
    $stmt = $this->con->prepare($select_links);
    $stmt->execute();
    $links_info = $stmt->fetchAll();
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ?  $links_info : null;
  }

  // function to get all links
  public function get_link($id)
  {
    // select all links
    $select_links = "SELECT *FROM `important_links` WHERE `id` = ?;";
    $stmt = $this->con->prepare($select_links);
    $stmt->execute(array($id));
    $links_info = $stmt->fetchAll();
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ?  $links_info : null;
  }

  // function to get all links
  public function get_active_links()
  {
    // select all links
    $select_links = "SELECT *FROM `important_links` WHERE `is_active` = 1;";
    $stmt = $this->con->prepare($select_links);
    $stmt->execute();
    $links_info = $stmt->fetchAll();
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ?  $links_info : null;
  }

  // function to get all links
  public function get_deactive_links()
  {
    // select all links
    $select_links = "SELECT *FROM `important_links` WHERE `is_active` = 0;";
    $stmt = $this->con->prepare($select_links);
    $stmt->execute();
    $links_info = $stmt->fetchAll();
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ?  $links_info : null;
  }

  // function to get all links
  public function insert_new_link($info)
  {
    // insert new link query
    $insert_query = "INSERT INTO `important_links` (`link_name_ar`, `link_name_en`, `is_active`, `link`, `added_date`, `added_time`, `added_by`) VALUES (?, ?, ?, ?, ?, ?, ?) ;";
    $stmt = $this->con->prepare($insert_query);
    $stmt->execute($info);
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ?  true : null;
  }

  public function delete_link($id)
  {
    // delete new link query
    $delete_query = "DELETE FROM `important_links` WHERE `id` = ? ;";
    $stmt = $this->con->prepare($delete_query);
    $stmt->execute(array($id));
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ?  true : null;
  }

  public function update_link($info)
  {
    // update new link query
    $update_query = "UPDATE `important_links` SET `link_name_ar` = ?, `link_name_en` = ?, `is_active` = ?, `link` = ? WHERE `id` = ? ;";
    $stmt = $this->con->prepare($update_query);
    $stmt->execute($info);
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ?  true : null;
  }

  public function activate_link($id)
  {
    // update new link query
    $update_query = "UPDATE `important_links` SET `is_active` = 1 WHERE `id` = ? ;";
    $stmt = $this->con->prepare($update_query);
    $stmt->execute(array($id));
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ?  true : null;
  }

  public function deactivate_link($id)
  {
    // update new link query
    $update_query = "UPDATE `important_links` SET `is_active` = 0 WHERE `id` = ? ;";
    $stmt = $this->con->prepare($update_query);
    $stmt->execute(array($id));
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ?  true : null;
  }
}
