<?php

/**
 * Session class
 */
class Session extends Database
{
  // properties
  public $con;    // for Database connection
  public $users_permission_columns;   // for users permission
  public $company_info_columns;   // for users permission

  // constructor
  public function __construct()
  {
    // create an object of Database class
    $db_obj = new Database("localhost", "leadergroup_website", "root", "@hmedH@ssib");
    $this->con = $db_obj->con;
  }

  // function to get all user`s info
  public function get_user_info($id)
  {
    // select query
    $query = "SELECT *FROM `users` WHERE `users`.`id` = ? LIMIT 1";

    // check if user exist in database
    $stmt = $this->con->prepare($query);
    $stmt->execute(array($id));
    $user_info = $stmt->fetch();
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ? $user_info : null;
  }

  // function to set basic info to session variable
  public function set_user_session($info)
  {
    // get basics info
    $_SESSION['website']['user_id']         = base64_encode($info['id']);           // assign userid to session
    $_SESSION['website']['username']        = $info['username'];
    $_SESSION['website']['is_root']         = $info['is_root'];                          // is technical man or not (0 -> not || 1 -> technical)
    $_SESSION['website']['is_admin']        = $info['is_admin'];                          // is root (0 -> all || 1 -> ahmed hassib only)
    $_SESSION['website']['lang']            = $info['lang'] == 0 ? 'ar' : 'en';                    // assign system display type
    $_SESSION['website']['profile_img']     = $info['profile_img'];                    // assign system display type

    // // set user permissions
    // $this->set_permissions($info);
  }

  /**
   * set_permissions function
   */
  public function set_permissions($permissions)
  {
    // $_SESSION['website]['user_add']            = $permissions['user_add'];           // permission to add users
  }

  public function update_session($user_id)
  {
    // get user data
    $user_data = $this->get_user_info($user_id);
    // get count
    $user_count = $user_data[0];
    // check count
    if ($user_count > 0) {
      // get user info
      $user_info = $user_data[1];
      // update user info
      $this->set_user_session($user_info);
    } else {
      return null;
    }
  }
}
