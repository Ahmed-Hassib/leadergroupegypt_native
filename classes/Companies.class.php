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
        $db_obj = new Database();
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
        $inset_query = "INSERT INTO `license` (`company_id`, `type`, `start_date`, `expire_date`) VALUES (?, ?, CURRENT_DATE, ?);";
        
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

}