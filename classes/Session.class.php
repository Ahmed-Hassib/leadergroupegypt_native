<?php
/**
 * Session class
 */
class Session extends Database {
  // properties
  public $con;    // for Database connection
  public $users_permission_columns;   // for users permission
  public $company_info_columns;   // for users permission

  // constructor
  public function __construct() {
    // create an object of Database class
    $db_obj = new Database();
    $this->con = $db_obj->con;
    // set user permission columns
    $this->users_permission_columns = "`users_permissions`.`user_add`,`users_permissions`.`user_update`,`users_permissions`.`user_delete`,`users_permissions`.`user_show`,`users_permissions`.`mal_add`,`users_permissions`.`mal_update`,`users_permissions`.`mal_delete`,`users_permissions`.`mal_show`,`users_permissions`.`mal_review`,`users_permissions`.`mal_media_delete`,`users_permissions`.`mal_media_download`,`users_permissions`.`comb_add`,`users_permissions`.`comb_update`,`users_permissions`.`comb_delete`,`users_permissions`.`comb_show`,`users_permissions`.`comb_review`,`users_permissions`.`pcs_add`,`users_permissions`.`pcs_update`,`users_permissions`.`pcs_delete`,`users_permissions`.`pcs_show`,`users_permissions`.`dir_add`,`users_permissions`.`dir_update`,`users_permissions`.`dir_delete`,`users_permissions`.`dir_show`,`users_permissions`.`sugg_replay`,`users_permissions`.`sugg_delete`,`users_permissions`.`sugg_show`,`users_permissions`.`points_add`,`users_permissions`.`points_delete`,`users_permissions`.`points_show`,`users_permissions`.`reports_show`,`users_permissions`.`archive_show`,`users_permissions`.`take_backup`,`users_permissions`.`restore_backup`,`users_permissions`.`connection_add`,`users_permissions`.`connection_update`,`users_permissions`.`connection_delete`,`users_permissions`.`connection_show`,`users_permissions`.`permission_update`,`users_permissions`.`permission_show`,`users_permissions`.`change_company_img`";
    // get company info
    $this->company_info_columns = "`companies`.`company_name`,`companies`.`company_img`";
  }

  // function to get all user`s info
  public function get_user_info($id) {
    // select query
    $query = "SELECT 
          `users`.*,
          $this->users_permission_columns,
          $this->company_info_columns
        FROM `users` 
        LEFT JOIN  `users_permissions` ON `users`.`UserID` = `users_permissions`.`UserID`
        LEFT JOIN `companies` ON `companies`.`company_id` = `users`.`company_id`
        WHERE `users`.`UserID` = ? LIMIT 1";
        
    // check if user exist in database
    $stmt = $this->con->prepare($query);
    $stmt->execute(array($id));
    $user_info = $stmt->fetch();
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ? [true, $user_info] : [false, null];
  }

  // function to set basic info to session variable
  public function set_user_session($info) {
    // get basics info
    $_SESSION['UserID']             = $info['UserID'];          // assign userid to session
    $_SESSION['profile_img']        = $info['profile_img'];
    $_SESSION['company_img']        = $info['company_img'];
    $_SESSION['company_id']         = $info['company_id'];      // assign company id to session
    $_SESSION['company_name']       = $info['company_name'];    // assign company name to session
    $_SESSION['UserName']           = $info['UserName'];        // assign username to session
    $_SESSION['job_title_id']       = $info['job_title_id'];        // assign job title to session
    $_SESSION['isTech']             = $info['isTech'];          // is technical man or not (0 -> not || 1 -> technical)
    $_SESSION['isRoot']             = $info['isRoot'];          // is root (0 -> all || 1 -> ahmed hassib only)
    @$_SESSION['systemLang']        = $info['systemLang']  == 0 ? 'ar' : 'en';  // assign system display type
    $_SESSION['system_theme']       = $info['system_theme'];  // assign system display type
    $_SESSION['log']                = isset($_SESSION['log']) && $_SESSION['log'] != 0 ? $_SESSION['log'] : 0;  // to create a login log
    $_SESSION['phone']              = $info['phone'];
    $_SESSION['is_activated_phone'] = $info['is_activated_phone'];
    // additional info
    $license_id                     = $this->get_license_id($info['company_id']);
    $_SESSION['license_id']         = $license_id;
    $expire_date                    = $this->select_specific_column("`expire_date`", "`license`", "WHERE `ID` = $license_id")[0]['expire_date'];
    $_SESSION['expire_date']        = $this->select_specific_column("`expire_date`", "`license`", "WHERE `ID` = $license_id")[0]['expire_date'];
    $_SESSION['isLicenseExpired']   = $this->is_expired($expire_date);
    $_SESSION['isTrial']            = $this->select_specific_column("`isTrial`", "`license`", "WHERE `ID` = $license_id")[0]['isTrial'];
    // set version info into session
    $this->set_version_info($info['company_id'], $info['UserID']);

    // set user permissions
    $this->set_permissions($info);
  }

  /**
   * set_permissions function
   */
  public function set_permissions($permissions) {
    $_SESSION['user_add']           = $permissions['user_add'];           // permission to add users
    $_SESSION['user_update']        = $permissions['user_update'];        // permission to update users
    $_SESSION['user_delete']        = $permissions['user_delete'];        // permission to delete users
    $_SESSION['user_show']          = $permissions['user_show'];          // permission to show users
    $_SESSION['mal_add']            = $permissions['mal_add'];            // permission to add malfunctions
    $_SESSION['mal_update']         = $permissions['mal_update'];         // permission to update malfunctions
    $_SESSION['mal_delete']         = $permissions['mal_delete'];         // permission to delete malfunctions
    $_SESSION['mal_show']           = $permissions['mal_show'];           // permission to show malfunctions
    $_SESSION['mal_review']         = $permissions['mal_review'];         // permission to review malfunctions
    $_SESSION['mal_media_delete']   = $permissions['mal_media_delete'];   // permission to delete malfunctions media
    $_SESSION['mal_media_download'] = $permissions['mal_media_download']; // permission to download malfunctions media
    $_SESSION['comb_add']           = $permissions['comb_add'];           // permission to add combinations
    $_SESSION['comb_update']        = $permissions['comb_update'];        // permission to update combinations
    $_SESSION['comb_delete']        = $permissions['comb_delete'];        // permission to delete combinations
    $_SESSION['comb_show']          = $permissions['comb_show'];          // permission to show combinations
    $_SESSION['comb_review']        = $permissions['comb_review'];        // permission to review combinations
    $_SESSION['pcs_add']            = $permissions['pcs_add'];            // permission to add pieces/clients
    $_SESSION['pcs_update']         = $permissions['pcs_update'];         // permission to update pieces/clients
    $_SESSION['pcs_delete']         = $permissions['pcs_delete'];         // permission to delete pieces/clients
    $_SESSION['pcs_show']           = $permissions['pcs_show'];           // permission to show pieces/clients
    $_SESSION['connection_add']     = $permissions['connection_add'];     // permission to add connection type
    $_SESSION['connection_update']  = $permissions['connection_update'];  // permission to update connection type
    $_SESSION['connection_delete']  = $permissions['connection_delete'];  // permission to delete connection type
    $_SESSION['connection_show']    = $permissions['connection_show'];    // permission to show connection type
    $_SESSION['dir_add']            = $permissions['dir_add'];            // permission to add directions
    $_SESSION['dir_update']         = $permissions['dir_update'];         // permission to update directions
    $_SESSION['dir_delete']         = $permissions['dir_delete'];         // permission to delete directions
    $_SESSION['dir_show']           = $permissions['dir_show'];           // permission to show directions
    $_SESSION['sugg_replay']        = $permissions['sugg_replay'];        // permission to replay on complaints/suggestions
    $_SESSION['sugg_delete']        = $permissions['sugg_delete'];        // permission to delete complaints/suggestions
    $_SESSION['sugg_show']          = $permissions['sugg_show'];          // permission to show complaints/suggestions
    $_SESSION['points_add']         = $permissions['points_add'];         // permission to add motivation points
    $_SESSION['points_delete']      = $permissions['points_delete'];      // permission to delete motivation points
    $_SESSION['points_show']        = $permissions['points_show'];        // permission to show motivation points
    $_SESSION['reports_show']       = $permissions['reports_show'];       // permission to show reports
    $_SESSION['archive_show']       = $permissions['archive_show'];       // permission to show archive
    $_SESSION['take_backup']        = $permissions['take_backup'];        // permission to take a backup
    $_SESSION['restore_backup']     = $permissions['restore_backup'];     // permission to restore a backup
    $_SESSION['permission_update']  = $permissions['permission_update'];  // permission to update permissions
    $_SESSION['permission_show']    = $permissions['permission_show'];    // permission to show permissions
    $_SESSION['change_company_img'] = $permissions['change_company_img']; // permission to change company image
  }

  // function to get version id by his id
  public function get_version_id($id) {
    // get version id by company id
    $ver_id = $this->select_specific_column("`version`", "`companies`", "WHERE `company_id` = '$id'")[0]['version'];
    // return
    return $ver_id;
  }

  // function to get version info id by his id
  public function get_version_info($v_id) {
    // get ver_info id by version id
    $ver_info = $this->select_specific_column("*", "`versions`", "WHERE `v_id` = '$v_id'")[0];
    // return
    return $ver_info;
  }

  public function set_version_info($company_id, $user_id) {
    // get version id
    $curr_version_id                = $this->get_version_id($company_id);
    // get version info
    $_SESSION['curr_version_id']    = $curr_version_id;
    $version_info = $this->get_version_info($curr_version_id);

    if ($version_info['is_working'] == 1 && $version_info['is_developing'] == 0 && $version_info['is_expired'] == 0) {
      $_SESSION['curr_version_id']            = $version_info['v_id'];
      $_SESSION['curr_version_name']          = $version_info['v_name'];
      $_SESSION['curr_version_is_working']    = $version_info['is_working'];
      $_SESSION['curr_version_is_developing'] = $version_info['is_developing'];
    }
  }

  public function print_session() {
    print_r($_SESSION);
  }
  
  public function update_session($user_id) {
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
