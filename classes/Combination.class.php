<?php
/**
 * Combination class
 */
class Combination extends Database {
    // properties
    public $con;

    // constructor
    public function __construct() {
        // create an object of Database class
        $db_obj = new Database();
        $this->con = $db_obj->con;
    }

    // function to get all combinations of specific company
    public function get_all_combinations() {
        // $count = $stmt->rowCount() ;    // all count of data
        // // return
        // return $count > 0 ? [true, $companies_data] : [false, null];
    }

    // function to insert a new combination
    public function insert_new_combination($comb_info) {
        // INSERT INTO combinations
        $insert_query = "INSERT INTO `combinations` (`client_name`, `phone`, `address`, `added_date`, `added_time`, `isFinished`, `comment`, `UserID`, `addedBy`, `company_id`) VALUES (?, ?, ?, CURRENT_DATE, CURRENT_TIME, 0, ?, ?, ?, ?);";
        // insert user info in database
        $stmt = $this->con->prepare($insert_query);
        $stmt->execute($comb_info);
        // get count
        $count = $stmt->rowCount() ;    // all count of data
        // return
        return $count > 0 ? true : false;
    }

    // function to delete combination
    public function delete_combination($comb_id) {
        $update_query = "DELETE FROM `combinations` WHERE `comb_id` = ?";
        // insert user info in database
        $stmt = $this->con->prepare($update_query);
        $stmt->execute(array($comb_id));
        // get count
        $count = $stmt->rowCount() ;    // all count of data
        // return
        return $count > 0 ? true : false;
    }
    
   
}