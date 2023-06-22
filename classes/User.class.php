<?php
/**
 * User class
 */
class User extends Database {
  // properties
  public $con;

  // constructor
  public function __construct() {
    // create an object of Database class
    $db_obj = new Database();
    $this->con = $db_obj->con;
  }

  // function to get user id by his username
  public function get_user_id($username) {
    // get user id by user name
    $user_id = $this->select_specific_column("`UserID`", "`users`", "WHERE `UserName` = '$username'")[0]['UserID'];
    // return
    return $user_id;
  }

  // function to get all users of specific company
  public function get_all_users($company_id) {
    // select user info query
    $users_info_query = "SELECT *FROM `users` WHERE `UserID` != 1 AND `company_id` = ? ORDER BY `TrustStatus` DESC, `isTech` ASC";
    // prepare the query
    $stmt = $this->con->prepare($users_info_query);     // select all users
    $stmt->execute(array($company_id));               // execute data
    $rows = $stmt->fetchAll();      // assign all data to variable
    $count = $stmt->rowCount() ;    // all count of data
    // return
    return $count > 0 ? [$count, $rows] : [0, null];
  }
  
  // function to get all users of specific company
  public function get_user_info($user_id, $company_id) {
    // select user info query
    $user_info_query = "SELECT *FROM `users` WHERE `UserID` != 1 AND `UserID` = ? AND `company_id` = ? ORDER BY `TrustStatus` DESC, `isTech` ASC LIMIT 1";
    // prepare the query
    $stmt = $this->con->prepare($user_info_query);     // select all users
    $stmt->execute(array($user_id, $company_id));               // execute data
    $rows = $stmt->fetch();      // assign all data to variable
    $count = $stmt->rowCount() ;    // all count of data
    // return
    return $count > 0 ? [$count, $rows] : [0, null];
  }

  // insert a new user in specific company
  public function insert_user_info($info) {
    // query to insert the new user in `users` table
    $insertInfoQuery  = "INSERT INTO `users` (`company_id`, `UserName`, `Pass`, `Email`, `Fullname`, `isTech`, `job_title_id`, `gender`, `address`, `phone`, `date_of_birth`, `TrustStatus`, `addedBy`, `joinedDate`, `twitter`, `facebook`) ";
    $insertInfoQuery .= "VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
    // insert user info in database
    $stmt = $this->con->prepare($insertInfoQuery); 
    $stmt->execute($info);          // execute the query
    $count = $stmt->rowCount();     // get number of effected rows
    // return
    return $count > 0 ? true : false;
  }

  // insert a new user permission in specific company
  public function insert_user_permissions($permissions) {
    // query to insert permissions in `users_permissions` table
    $insertPermissionsQuery  = "INSERT INTO `users_permissions` (`UserID`, `user_add`, `user_update`, `user_delete`, `user_show`, `mal_add`, `mal_update`, `mal_delete`, `mal_show`, `mal_review`, `mal_media_delete`, `mal_media_download`, `comb_add`, `comb_update`, `comb_delete`, `comb_show`, `comb_review`, `comb_media_delete`, `comb_media_download`, `pcs_add`, `pcs_update`, `pcs_delete`, `pcs_show`, `dir_add`, `dir_update`, `dir_delete`, `dir_show`, `connection_add`, `connection_update`, `connection_delete`, `connection_show`, `permission_update`, `permission_show`, `change_company_img`)";
    $insertPermissionsQuery .= "VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
    // execute the query to insert the permissions into the table
    $stmt = $this->con->prepare($insertPermissionsQuery);
    $stmt->execute($permissions);          // execute the query
    $count = $stmt->rowCount();     // get number of effected rows
    // return
    return $count > 0 ? true : false;
  }

  // delete user 
  public function delete_user($userid) {
    // query for delete all user info, permissions, points, columns
    $q  = "DELETE FROM `users`                  WHERE `UserID` = ?;";
    $q .= "DELETE FROM `users_permissions`      WHERE `UserID` = ?;";
    $q .= "DELETE FROM `users_pieces_columns`   WHERE `UserID` = ?;";
    $q .= "DELETE FROM `users_points`           WHERE `UserID` = ?;";
    // prepare the query
    $stmt = $this->con->prepare($q);
    $stmt->execute(array($userid, $userid, $userid, $userid));      // execute the query
    $count = $stmt->rowCount();     // get number of effected rows
    // return
    return $count > 0 ? true : false;
  }

  // update user info
  public function update_user_info($info) {
    // update personal info
    $update_info_query = "UPDATE `users` SET `UserName` = ?, `Pass` = ?, `Email` = ?, `Fullname` = ?, `isTech` = ?, `job_title_id` = ?, `gender` = ?, `address` = ?, `phone` = ?, `date_of_birth` = ?, `TrustStatus` = ?,`twitter` = ?, `facebook` = ? WHERE `UserID` = ?";
    // update the database with this info
    $stmt = $this->con->prepare($update_info_query);
    $stmt->execute($info);
    $count = $stmt->rowCount();     // get number of effected rows
    // return
    return $count > 0 ? true : false;
  }

  function upload_profile_img($info) {
    // update query
    $upload_profile_img_query = "UPDATE `users` SET `profile_img` = ? WHERE `UserID` = ?";
    // update the database with this info
    $stmt = $this->con->prepare($upload_profile_img_query);
    $stmt->execute($info);
    $count = $stmt->rowCount();     // get number of effected rows
    // return
    return $count > 0 ? true : false;
  }
  
  function delete_profile_img($user_id) {
    // update query
    $upload_profile_img_query = "UPDATE `users` SET `profile_img` = '' WHERE `UserID` = ?";
    // update the database with this info
    $stmt = $this->con->prepare($upload_profile_img_query);
    $stmt->execute(array($user_id));
    $count = $stmt->rowCount();     // get number of effected rows
    // return
    return $count > 0 ? true : false;
  }
  
  // update user permissions
  public function update_user_permissions($permissions) {
    // update permissions
    $permissionsQuery = "UPDATE `users_permissions` SET  `user_add` = ?, `user_update` = ?, `user_delete` = ?, `user_show` = ?, `mal_add` = ?, `mal_update` = ?, `mal_delete` = ?, `mal_show` = ?, `mal_review` = ?, `mal_media_delete` = ?, `mal_media_download` = ?, `comb_add` = ?, `comb_update` = ?, `comb_delete` = ?, `comb_show` = ?, `comb_review` = ?, `comb_media_delete` = ?, `comb_media_download` = ?, `pcs_add` = ?, `pcs_update` = ?, `pcs_delete` = ?, `pcs_show` = ?, `dir_add` = ?, `dir_update` = ?, `dir_delete` = ?, `dir_show` = ?, `connection_add` = ?, `connection_update` = ?, `connection_delete` = ?, `connection_show` = ?, `permission_update` = ?, `permission_show` = ?, `change_company_img` = ? WHERE `UserID` = ?";
    $stmt = $this->con->prepare($permissionsQuery);
    $stmt->execute($permissions);
    $count = $stmt->rowCount();               // get number of effected rows
    // return
    return $count > 0 ? true : false;
  }

  // change user language
  public function change_user_language($language, $user_id) {
    // change language query
    $changeLangQuery = "UPDATE `users` SET `systemLang` = ? WHERE `UserID` = ?";
    // prepare statement
    $stmt = $this->con->prepare($changeLangQuery);
    $stmt->execute(array($language, $user_id));
    $count = $stmt->rowCount();               // get number of effected rows
    // return
    return $count > 0 ? true : false;
  }
  
  // do rating app
  public function do_rating_app($info) {
    // rating app query
    $ratingAppQuery = "INSERT INTO `app_rating`(`added_by`, `added_date`, `added_time`, `company_id`, `rating`, `comment`) VALUES (?, ?, ?, ?, ?, ?)";
    // prepare statement
    $stmt = $this->con->prepare($ratingAppQuery);
    $stmt->execute($info);
    $count = $stmt->rowCount();               // get number of effected rows
    // return
    return $count > 0 ? true : false;
  }
}
