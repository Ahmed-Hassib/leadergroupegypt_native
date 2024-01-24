<?php


class Transaction extends Database
{
  // properties
  public $con;

  // table name
  const TABLENAME = 'transactions';

  // constructor
  public function __construct()
  {
    // create an object of Database class
    $db_obj = new Database("localhost", "jsl_db", "root", "@hmedH@ssib");

    $this->con = $db_obj->con;
  }

  // get all pricing
  public function get_all_transactions($company_id)
  {
    // select pricing info query
    $pricing_info_query = "SELECT *FROM `" . self::TABLENAME . "` WHERE `company_id` = ?";
    // prepare the query
    $stmt = $this->con->prepare($pricing_info_query); // select all pricing
    $stmt->execute(array($company_id)); // execute data
    $rows = $stmt->fetchAll(); // assign all data to variable
    $count = $stmt->rowCount(); // all count of data
    // return
    return $count > 0 ? $rows : null;
  }

  public function insert_transaction($info)
  {
    // insert pricing info query
    $pricing_info_query = "INSERT INTO " . self::TABLENAME . " (`company_id`, `is_success`, `is_pending`, `is_refunded`, `price`, `order_id`, `currency`, `is_error_occured`, `source_data_type`, `source_data_pan`, `txn_response_code`, `hmac`, `data_message`, `created_at`, `updated_at`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    // prepare the query
    $stmt = $this->con->prepare($pricing_info_query); // insert pricing
    $stmt->execute($info); // execute data
    $count = $stmt->rowCount(); // all count of data
    // return
    return $count > 0 ? true : false;
  }
}