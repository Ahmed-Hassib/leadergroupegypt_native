<?php

/**
 * Login class
 */
class Service extends Database
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

  // function to get all services
  public function get_all_services()
  {
    // select all services
    $select_services = "SELECT *FROM `services`";
    $stmt = $this->con->prepare($select_services);
    $stmt->execute();
    $services_info = $stmt->fetchAll();
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ?  $services_info : null;
  }

  // function to get all services
  public function get_service($id)
  {
    // select all services
    $select_services = "SELECT *FROM `services` WHERE `id` = ?;";
    $stmt = $this->con->prepare($select_services);
    $stmt->execute(array($id));
    $services_info = $stmt->fetchAll();
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ?  $services_info : null;
  }

  // function to get all services
  public function get_active_services()
  {
    // select all services
    $select_services = "SELECT *FROM `services` WHERE `is_active` IN (1,2);";
    $stmt = $this->con->prepare($select_services);
    $stmt->execute();
    $services_info = $stmt->fetchAll();
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ?  $services_info : null;
  }

  // function to get all services
  public function get_deactive_services()
  {
    // select all services
    $select_services = "SELECT *FROM `services` WHERE `is_active` = 0;";
    $stmt = $this->con->prepare($select_services);
    $stmt->execute();
    $services_info = $stmt->fetchAll();
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ?  $services_info : null;
  }

  // function to get all services
  public function insert_new_service($info)
  {
    // insert new service query
    $insert_query = "INSERT INTO `services` (`link_1_ar`, `link_1_en`, `link_1`, `link_2_ar`, `link_2_en`, `link_2`, `is_active`, `service_img`, `added_date`, `added_time`, `added_by`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) ;";
    $stmt = $this->con->prepare($insert_query);
    $stmt->execute($info);
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ?  true : null;
  }

  public function delete_service($id)
  {
    // delete new service query
    $delete_query = "DELETE FROM `services` WHERE `id` = ? ;";
    $stmt = $this->con->prepare($delete_query);
    $stmt->execute(array($id));
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ?  true : null;
  }

  public function update_service($info)
  {
    // update new service query
    $update_query = "UPDATE `services` SET `link_1_ar` = ?, `link_1_en` = ?, `link_1` = ?, `link_2_ar` = ?, `link_2_en` = ?, `link_2` = ? WHERE `id` = ? ;";
    $stmt = $this->con->prepare($update_query);
    $stmt->execute($info);
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ?  true : null;
  }

  public function update_img($info)
  {
    // update new img query
    $update_query = "UPDATE `services` SET `service_img` = ? WHERE `id` = ? ;";
    $stmt = $this->con->prepare($update_query);
    $stmt->execute($info);
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ?  true : null;
  }

  public function update_status($info)
  {
    // update new service query
    $update_query = "UPDATE `services` SET `is_active` = ? WHERE `id` = ? ;";
    $stmt = $this->con->prepare($update_query);
    $stmt->execute($info);
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ?  true : null;
  }

  public function activate_service($id)
  {
    // update new service query
    $update_query = "UPDATE `services` SET `is_active` = 1 WHERE `id` = ? ;";
    $stmt = $this->con->prepare($update_query);
    $stmt->execute(array($id));
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ?  true : null;
  }

  public function deactivate_service($id)
  {
    // update new service query
    $update_query = "UPDATE `services` SET `is_active` = 0 WHERE `id` = ? ;";
    $stmt = $this->con->prepare($update_query);
    $stmt->execute(array($id));
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ?  true : null;
  }
}
