<?php


class ClientsDeletes extends Database
{
  // properties
  public $con;

  // constructor
  public function __construct()
  {
    // create an object of Database class
    $db_obj = new Database("localhost", "jsl_db", "root", "@hmedH@ssib");
    $this->con = $db_obj->con;
  }

  // delete client
  public function temporary_delete_client($id, $date)
  {
    if (!empty($id) && filter_var($id, FILTER_VALIDATE_INT)) {
      // delete query
      $delete_query = "INSERT INTO `deleted_pieces_dates` VALUES (?, ?);";
      $delete_query .= "INSERT INTO `deleted_pieces_addr` SELECT *FROM `pieces_addr` WHERE `id` = ?;";
      $delete_query .= "INSERT INTO `deleted_pieces_frequency` SELECT *FROM `pieces_frequency` WHERE `id` = ?;";
      $delete_query .= "INSERT INTO `deleted_pieces_info` SELECT *FROM `pieces_info` WHERE `id` = ?;";
      $delete_query .= "INSERT INTO `deleted_pieces_mac_addr` SELECT *FROM `pieces_mac_addr` WHERE `id` = ?;";
      $delete_query .= "INSERT INTO `deleted_pieces_pass_connection` SELECT *FROM `pieces_pass_connection` WHERE `id` = ?;";
      $delete_query .= "INSERT INTO `deleted_pieces_phones` SELECT *FROM `pieces_phones` WHERE `id` = ?;";
      $delete_query .= "INSERT INTO `deleted_pieces_ssid` SELECT *FROM `pieces_ssid` WHERE `id` = ?;";
      $delete_query .= "INSERT INTO `deleted_pieces_waves` SELECT *FROM `pieces_waves` WHERE `id` = ?;";
      $delete_query .= "INSERT INTO `deleted_pieces_Coordinates` SELECT *FROM `pieces_Coordinates` WHERE `id` = ?;";
      // prepare query
      $stmt = $this->con->prepare($delete_query);
      $stmt->execute(array($id, $date, $id, $id, $id, $id, $id, $id, $id, $id, $id));
      $pcs_count = $stmt->rowCount();       // count effected rows
      // return result
      return $pcs_count > 0 ? true : false;
    }
    return false;
  }

  // delete client
  public function delete_client($id)
  {
    if (!empty($id) && filter_var($id, FILTER_VALIDATE_INT)) {
      // delete query
      $delete_query = "DELETE FROM `pieces_addr` WHERE `id`= ?;";
      $delete_query .= "DELETE FROM `pieces_frequency`WHERE `id`= ?;";
      $delete_query .= "DELETE FROM `pieces_info` WHERE `id`= ?;";
      $delete_query .= "DELETE FROM `pieces_mac_addr`WHERE `id`= ?;";
      $delete_query .= "DELETE FROM `pieces_pass_connection`WHERE `id`= ?;";
      $delete_query .= "DELETE FROM `pieces_phones`WHERE `id`= ?;";
      $delete_query .= "DELETE FROM `pieces_ssid` WHERE `id`= ?;";
      $delete_query .= "DELETE FROM `pieces_waves`WHERE `id`= ?;";
      $delete_query .= "DELETE FROM `pieces_Coordinates`WHERE `id`= ?;";
      // prepare query
      $stmt = $this->con->prepare($delete_query);
      $stmt->execute(array($id, $id, $id, $id, $id, $id, $id, $id, $id));
      $pcs_count = $stmt->rowCount();       // count effected rows
      // return result
      return $pcs_count > 0 ? true : false;
    }
    return false;
  }

  // delete client
  public function permanent_delete_client($id)
  {
    if (!empty($id) && filter_var($id, FILTER_VALIDATE_INT)) {
      // delete query
      $delete_query = "DELETE FROM `pieces_addr` WHERE `id`= {$id};";
      $delete_query .= "DELETE FROM `pieces_frequency`WHERE `id`= {$id};";
      $delete_query .= "DELETE FROM `pieces_info` WHERE `id`= {$id};";
      $delete_query .= "DELETE FROM `pieces_mac_addr`WHERE `id`= {$id};";
      $delete_query .= "DELETE FROM `pieces_pass_connection`WHERE `id`= {$id};";
      $delete_query .= "DELETE FROM `pieces_phones`WHERE `id`= {$id};";
      $delete_query .= "DELETE FROM `pieces_ssid` WHERE `id`= {$id};";
      $delete_query .= "DELETE FROM `pieces_waves`WHERE `id`= {$id};";
      $delete_query .= "DELETE FROM `pieces_Coordinates`WHERE `id`= {$id};";
      $delete_query .= "DELETE FROM `deleted_pieces_dates` WHERE `id`= {$id};";
      $delete_query .= "DELETE FROM `deleted_pieces_addr` WHERE `id`= {$id};";
      $delete_query .= "DELETE FROM `deleted_pieces_frequency`WHERE `id`= {$id};";
      $delete_query .= "DELETE FROM `deleted_pieces_info` WHERE `id`= {$id};";
      $delete_query .= "DELETE FROM `deleted_pieces_mac_addr`WHERE `id`= {$id};";
      $delete_query .= "DELETE FROM `deleted_pieces_pass_connection`WHERE `id`= {$id};";
      $delete_query .= "DELETE FROM `deleted_pieces_phones`WHERE `id`= {$id};";
      $delete_query .= "DELETE FROM `deleted_pieces_ssid` WHERE `id`= {$id};";
      $delete_query .= "DELETE FROM `deleted_pieces_waves`WHERE `id`= {$id};";
      $delete_query .= "DELETE FROM `deleted_pieces_Coordinates`WHERE `id`= {$id};";
      // prepare query
      $stmt = $this->con->prepare($delete_query);
      $stmt->execute();
      $pcs_count = $stmt->rowCount();       // count effected rows
      // return result
      return $pcs_count > 0 ? true : false;
    }
    return false;
  }

  public function restore_client_data($id)
  {
    if (!empty($id) && filter_var($id, FILTER_VALIDATE_INT)) {
      // delete query
      $restore_query = "INSERT INTO `pieces_addr` SELECT *FROM `deleted_pieces_addr` WHERE `id` = {$id};";
      $restore_query .= "INSERT INTO `pieces_frequency` SELECT *FROM `deleted_pieces_frequency` WHERE `id` = {$id};";
      $restore_query .= "INSERT INTO `pieces_info` SELECT *FROM `deleted_pieces_info` WHERE `id` = {$id};";
      $restore_query .= "INSERT INTO `pieces_mac_addr` SELECT *FROM `deleted_pieces_mac_addr` WHERE `id` = {$id};";
      $restore_query .= "INSERT INTO `pieces_pass_connection` SELECT *FROM `deleted_pieces_pass_connection` WHERE `id` = {$id};";
      $restore_query .= "INSERT INTO `pieces_phones` SELECT *FROM `deleted_pieces_phones` WHERE `id` = {$id};";
      $restore_query .= "INSERT INTO `pieces_ssid` SELECT *FROM `deleted_pieces_ssid` WHERE `id` = {$id};";
      $restore_query .= "INSERT INTO `pieces_waves` SELECT *FROM `deleted_pieces_waves` WHERE `id` = {$id};";
      $restore_query .= "INSERT INTO `pieces_Coordinates` SELECT *FROM `deleted_pieces_Coordinates` WHERE `id` = {$id};";
      // prepare query
      $stmt = $this->con->prepare($restore_query);
      $stmt->execute();
      $pcs_count = $stmt->rowCount();       // count effected rows
      // return result
      return $pcs_count > 0 ? true : false;
    }
    return false;
  }

  // delete client
  public function delete_client_prev_data($id)
  {
    if (!empty($id) && filter_var($id, FILTER_VALIDATE_INT)) {
      // delete query
      $delete_query = "DELETE FROM `deleted_pieces_dates` WHERE `id`= ?;";
      $delete_query .= "DELETE FROM `deleted_pieces_addr` WHERE `id`= ?;";
      $delete_query .= "DELETE FROM `deleted_pieces_frequency`WHERE `id`= ?;";
      $delete_query .= "DELETE FROM `deleted_pieces_info` WHERE `id`= ?;";
      $delete_query .= "DELETE FROM `deleted_pieces_mac_addr`WHERE `id`= ?;";
      $delete_query .= "DELETE FROM `deleted_pieces_pass_connection`WHERE `id`= ?;";
      $delete_query .= "DELETE FROM `deleted_pieces_phones`WHERE `id`= ?;";
      $delete_query .= "DELETE FROM `deleted_pieces_ssid` WHERE `id`= ?;";
      $delete_query .= "DELETE FROM `deleted_pieces_waves`WHERE `id`= ?;";
      $delete_query .= "DELETE FROM `deleted_pieces_Coordinates`WHERE `id`= ?;";
      // prepare query
      $stmt = $this->con->prepare($delete_query);
      $stmt->execute(array($id, $id, $id, $id, $id, $id, $id, $id, $id, $id));
      $pcs_count = $stmt->rowCount();       // count effected rows
      // return result
      return $pcs_count > 0 ? true : false;
    }
    return false;
  }

  public function get_all_deleted_clients(...$date)
  {
    // check dates inputs
    if (count($date) == 1) {
      $condition = "WHERE `deleted_pieces_info`.`is_client` = 1 AND `deleted_pieces_dates`.`deleted_date` = '{$date[0]}'";
    } elseif (count($date) == 2) {
      $condition = "WHERE `deleted_pieces_info`.`is_client` = 1 AND Date(`deleted_pieces_dates`.`deleted_date`) BETWEEN '{$date[0]}' AND '{$date[1]}'";
    } else {
      $condition = "";
    }
    // query statement
    $clients_query = "SELECT 
        `deleted_pieces_info`.*, 
        `deleted_pieces_phones`.`phone`,
        `deleted_pieces_addr`.`address`, 
        `deleted_pieces_mac_addr`.`mac_add`,
        `deleted_pieces_dates`.`deleted_date`
    FROM 
        `deleted_pieces_info`
    LEFT JOIN `deleted_pieces_phones` ON `deleted_pieces_phones`.`id` = `deleted_pieces_info`.`id`
    LEFT JOIN `deleted_pieces_addr` ON `deleted_pieces_addr`.`id` = `deleted_pieces_info`.`id`
    LEFT JOIN `deleted_pieces_mac_addr` ON `deleted_pieces_mac_addr`.`id` = `deleted_pieces_info`.`id`
    LEFT JOIN `deleted_pieces_dates` ON `deleted_pieces_dates`.`id` = `deleted_pieces_info`.`id`
    {$condition}
    ORDER BY 
        `deleted_pieces_info`.`direction_id` ASC,
        `deleted_pieces_info`.`device_type` ASC";

    // prepare the query
    $stmt = $this->con->prepare($clients_query);
    $stmt->execute(); // execute query
    $clients_data = $stmt->fetchAll(); // fetch data
    $clients_counter = $stmt->rowCount();       // count effected rows
    // return result
    return $clients_counter > 0 ? $clients_data : null;
  }

}