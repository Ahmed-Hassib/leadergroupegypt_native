<?php
/**
 * Registration class
 */
class Registration extends Database {
  // properties
  public $con;

  // constructor
  public function __construct() {
    // create an object of Database class
    $db_obj = new Database();
    $this->con = $db_obj->con;
  }

  public function add_new_company($info) {
    // insertion query for company data
    $company_query = "INSERT INTO `companies` (`company_name`, `company_manager`, `company_phone`, `version`, `joined_date`) VALUES (?, ?, ?, 3, ?)";
    $company_stmt = $this->con->prepare($company_query);
    $company_stmt->execute($info);
    $count = $company_stmt->rowCount();
    // return
    return $count > 0 ? true : false;
  }

  public function add_company_license($info) {
    // activate license with month trial
    $license_info_query = "INSERT INTO `license` (`company_id`, `type`, `start_date`, `expire_date`, `isTrial`) VALUES (?, 1, ?, ?, 1)";
    $license_info_stmt = $this->con->prepare($license_info_query);
    $license_info_stmt->execute($info);
    $count = $license_info_stmt->rowCount();
    // return statement
    return $count > 0 ? true : false;
  }

  public function add_company_admin($info) {
    // insert admin info
    $admin_info_query = "INSERT INTO `users` (`company_id`, `UserName`, `Pass`, `Fullname`, `isTech`, `job_title_id`, `gender`, `TrustStatus`, `addedBy`,  `joinedDate`, `systemLang`) VALUES (?, ?, ?, ?, 0, 1, ?, 1, 1, ?, 0)";
    $admin_info_stmt = $this->con->prepare($admin_info_query);
    $admin_info_stmt->execute($info);
    $count = $admin_info_stmt->rowCount();
    // return
    return $count > 0 ? true : false;
  }

  public function add_admin_permission($user_id) {
    // insert admin info
    $admin_permissions_query = "INSERT INTO `users_permissions` (`UserID`, `user_add`, `user_update`, `user_delete`, `user_show`, `mal_add`, `mal_update`, `mal_delete`, `mal_show`, `mal_review`, `comb_add`, `comb_update`, `comb_delete`, `comb_show`, `comb_review`, `pcs_add`, `pcs_update`, `pcs_delete`, `pcs_show`, `dir_add`, `dir_update`, `dir_delete`, `dir_show`, `sugg_replay`, `sugg_delete`, `sugg_show`, `points_add`, `points_delete`, `points_show`, `reports_show`, `archive_show`, `take_backup`, `restore_backup`) VALUES (?, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1)";
    $admin_permissions_stmt = $this->con->prepare($admin_permissions_query);
    $admin_permissions_stmt->execute(array($user_id));
    $count = $admin_permissions_stmt->rowCount();
    // return
    return $count > 0 ? true : false;
  }
}