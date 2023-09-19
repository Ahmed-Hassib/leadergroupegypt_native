<?php
/**
 * Company class
 */
class Company extends Database {
  // properties
  public $con;

  // constructor
  public function __construct() {
    // create an object of Database class
        $db_obj = new Database("localhost", "jsl_db", "root", "@hmedH@ssib");

    $this->con = $db_obj->con;
  }

  // function to get all companies of specific company
  public function get_all_companies() {
    // get all companies data
    $select_all = "SELECT *FROM `companies` WHERE `company_id` != 1";
    $stmt = $this->con->prepare($select_all);
    $stmt->execute();
    $companies_data = $stmt->fetchAll();
    $count = $stmt->rowCount() ;    // all count of data
    // return
    return $count > 0 ? [true, $companies_data] : [false, null];
  }
  
  // function to upgrade company version
  public function upgrade_version($new_version_id, $company_id) {
    // update statement
    $update_query = "UPDATE `companies` SET `version` = ? WHERE `company_id` = ?";
    // prepare query
    $stmt = $this->con->prepare($update_query);
    // execute query
    $stmt->execute(array($new_version_id, $company_id));
    // count
    $count = $stmt->rowCount() ;    // all count of data
    // return
    return $count > 0 ? [true, $count]: [false, $count]; 
  }

  // function to renew company license
  public function renew_license ($license_type, $expire_date, $company_id) {
    $inset_query = "INSERT INTO `license` (`company_id`, `type`, `start_date`, `expire_date`) VALUES (?, ?, now(), ?);";
    // update the database with this info
    $stmt = $this->con->prepare($inset_query);
    $stmt->execute(array($company_id, $license_type, $expire_date));
    // count
    $count = $stmt->rowCount();    // all count of data
    // return
    return $count > 0 ? true : false; 
  }
  

  // function to update the previous license
  public function update_previous_license ($company_id) {
    // update query
    $update_query = "UPDATE `license` SET `isEnded` = 1 WHERE `company_id` = ?";
    // update the database with this info
    $stmt = $this->con->prepare($update_query);
    $stmt->execute(array($company_id));
    // count
    $count = $stmt->rowCount();    // all count of data
    // return
    return $count > 0 ? true : false; 
  }

  function upload_company_img($info) {
    // update query
    $upload_company_img_query = "UPDATE `companies` SET `company_img` = ? WHERE `company_id` = ?";
    // update the database with this info
    $stmt = $this->con->prepare($upload_company_img_query);
    $stmt->execute($info);
    $count = $stmt->rowCount();     // get number of effected rows
    // return
    return $count > 0 ? true : false;
  }

  public function delete_company_img($company_id) {
    // update query
    $upload_company_img_query = "UPDATE `companies` SET `company_img` = '' WHERE `company_id` = ?";
    // update the database with this info
    $stmt = $this->con->prepare($upload_company_img_query);
    $stmt->execute(array($company_id));
    $count = $stmt->rowCount();     // get number of effected rows
    // return
    return $count > 0 ? true : false;
  }
  
  public function update_company_code($company_id, $company_code) {
    // update query
    $company_code_query = "UPDATE `companies` SET `company_code` = ? WHERE `company_id` = ?";
    // update the database with this info
    $stmt = $this->con->prepare($company_code_query);
    $stmt->execute(array($company_code, $company_id));
    $count = $stmt->rowCount();     // get number of effected rows
    // return
    return $count > 0 ? true : false;
  }
  public function update_mikrotik($info) {
    // update query
    $mikrotik_query = "UPDATE `companies` SET `mikrotik_ip` = ?, `mikrotik_port` = ?, `mikrotik_username` = ?, `mikrotik_password` = ? WHERE `company_id` = ?";
    // update the database with this info
    $stmt = $this->con->prepare($mikrotik_query);
    $stmt->execute($info);
    $count = $stmt->rowCount();     // get number of effected rows
    // return
    return $count > 0 ? true : false;
  }
  
  public function update_opened_ports($company_id, $value) {
    // update query
    $opened_ports_query = "UPDATE `companies` SET `opened_ports` = ? WHERE `company_id` = ?";
    // update the database with this info
    $stmt = $this->con->prepare($opened_ports_query);
    $stmt->execute(array($value, $company_id));
    $count = $stmt->rowCount();     // get number of effected rows
    // return
    return $count > 0 ? true : false;
  }
}