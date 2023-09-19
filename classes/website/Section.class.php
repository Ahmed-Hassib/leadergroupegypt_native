<?php

/**
 * Login class
 */
class Section extends Database
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

  // function for login
  public function user_login()
  {
    // select user with specific username and password 
    $select_user =
      "SELECT *FROM `users` WHERE `users`.`username` = ? AND `users`.`password` = ? LIMIT 1";
    // check if user exist in database
    $stmt = $this->con->prepare($select_user);
    $stmt->execute();
    $user_info = $stmt->fetch();
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ?  $user_info : null;
  }
}
