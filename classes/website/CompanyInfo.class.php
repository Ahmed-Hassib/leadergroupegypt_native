<?php

/**
 * Login class
 */
class CompanyInfo extends Database
{
  // properties
  public $con;
  // section id
  public $SECTION_CONTENT_TABLE = 'company_info';
  public $SECTION_PHONES_TABLE = 'company_phones';

  // constructor
  public function __construct()
  {
    // create an object of Database class
    $db_obj = new Database("localhost", "leadergroup_website", "root", "@hmedH@ssib");
    $this->con = $db_obj->con;
  }

  // function to get info
  public function get_info()
  {
    // select all info
    $select_info = "SELECT *FROM `$this->SECTION_CONTENT_TABLE`";
    $stmt = $this->con->prepare($select_info);
    $stmt->execute();
    $company_info = $stmt->fetchAll();
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ? $company_info : null;
  }

  // function to get phones
  public function get_phones()
  {
    // select all phones
    $select_phones = "SELECT *FROM `$this->SECTION_PHONES_TABLE`";
    $stmt = $this->con->prepare($select_phones);
    $stmt->execute();
    $company_phones = $stmt->fetchAll();
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ? $company_phones : null;
  }

  public function insert_info($info)
  {
    // insert new info query
    $insert_query = "INSERT INTO `$this->SECTION_CONTENT_TABLE` (`desc`,`desc_en`,`address`,`address_en`,`start_job_time`,`job_time_en`) VALUES (?,?,?,?,?,?)";
    $stmt = $this->con->prepare($insert_query);
    $stmt->execute($info);
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ? true : null;
  }

  public function update_info($info)
  {
    // update info query
    $update_query = "UPDATE `$this->SECTION_CONTENT_TABLE` SET `desc` = ?,`desc_en` = ?,`address` = ?,`address_en` = ?,`start_job_time` = ?,`end_job_time` = ? WHERE `id` = ?";
    $stmt = $this->con->prepare($update_query);
    $stmt->execute($info);
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ? true : null;
  }

  public function insert_phone($phone)
  {
    // insert new phone query
    $insert_query = "INSERT INTO `$this->SECTION_PHONES_TABLE` (`phone`) VALUES (?)";
    $stmt = $this->con->prepare($insert_query);
    $stmt->execute(array($phone));
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ? true : null;
  }

  public function update_phone($phone, $id)
  {
    // update new phone query
    $update_query = "UPDATE `$this->SECTION_PHONES_TABLE` SET `phone` = ? WHERE `id` = ?";
    $stmt = $this->con->prepare($update_query);
    $stmt->execute(array($phone, $id));
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ? true : null;
  }

  public function truncate_phones()
  {
    // truncate phone query
    $trunc_query = "TRUNCATE `$this->SECTION_PHONES_TABLE`;";
    $stmt = $this->con->prepare($trunc_query);
    $stmt->execute();
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ? true : null;
  }
}