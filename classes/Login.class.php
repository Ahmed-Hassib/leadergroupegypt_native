<?php

/**
 * Login class
 */
class Login extends Database {
    // properties
    public $id;
    public $emp_username;
    public $emp_password;
    public $con;

    // constructor
    public function __construct($username, $password) {
        // check if the parameters is empty or not
        if (!empty($username) && !empty($password)) {
            // create an object of Database class
            $db_obj = new Database();
            $this->con = $db_obj->con;
            // set username and password
            $this->emp_username = $username;
            $this->emp_password = sha1($password);
        }
    }

    // function for login
    public function emp_login() {
        // select employee with specific username and password 
        $select_emp = "SELECT *FROM `employees` WHERE `emp_username` = ? AND `emp_password` = ? LIMIT 1";
        // check if employee exist in database
        $stmt = $this->con->prepare($select_emp);
        $stmt->execute(array($this->emp_username, $this->emp_password));
        $emp_info = $stmt->fetch();
        $count = $stmt->rowCount();
        // check the count
        return $count > 0 ? [true, $emp_info] : false;
    }
}





