<?php

/**
 * Login class
 */
class Login extends Database
{
  // properties
  public $user_username;
  public $user_password;
  public $con;

  // constructor
  public function __construct($username, $password)
  {
    // check if the parameters is empty or not
    if (!empty($username) && !empty($password)) {
      // create an object of Database class
      $db_obj = new Database("localhost", "leadergroup_website", "root", "@hmedH@ssib");
      $this->con = $db_obj->con;
      // set username and password
      $this->user_username = $username;
      $this->user_password = sha1($password);
    }
  }

  // function for login
  public function user_login()
  {
    // select user with specific username and password 
    $select_user =
      "SELECT *FROM `users` WHERE `users`.`username` = ? AND `users`.`password` = ? LIMIT 1";
    // check if user exist in database
    $stmt = $this->con->prepare($select_user);
    $stmt->execute(array($this->user_username, $this->user_password));
    $user_info = $stmt->fetch();
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ?  $user_info : null;
  }
}
