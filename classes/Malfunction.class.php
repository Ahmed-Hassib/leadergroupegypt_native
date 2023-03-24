<?php
/**
 * Malfunction class
 */
class Malfunction extends Database {
    // properties
    public $con;

    // constructor
    public function __construct() {
        // create an object of Database class
        $db_obj = new Database();
        $this->con = $db_obj->con;
    }

    // get all Malfunctions
    public function get_all_malfunctions($company) {
        
    }

    // insert a new Malfunction
    public function insert_new_malfunction($info) {
       // INSERT INTO malfunctions
        $insert_query = "INSERT INTO `malfunctions` (`mng_id`, `tech_id`, `client_id`, `descreption`, `added_date`, `added_time`, `company_id`) VALUES (?, ?, ?, ?, now(), now(), ?);";
        // prepare the query
        $stmt = $this->con->prepare($insert_query);
        $stmt->execute($info);
        $mal_count =  $stmt->rowCount();       // count effected rows
        // return result
        return $mal_count > 0 ? true : false;   
    }

    // update Malfunction info
    public function update_malfunction($id) {
    //    $mal_count =  $stmt->rowCount();       // count effected rows
    //     // return result
    //     return [$mal_count, $row];
    }

    // delete Malfunction info
    public function delete_malfunction($id) {
        // delete query
        $delete_query  = "DELETE FROM `malfunction` WHERE `mal_id` = ?";
        $delete_query .= "DELETE FROM `malfunctions_media` WHERE `mal_id` = ?";
        // prepare query
        $stmt = $this->con->prepare($delete_query);
        $stmt->execute(array($id, $id));
        $mal_count =  $stmt->rowCount();       // count effected rows
        // return result
        return $mal_count > 0 ? true : false;
    }
}
