<?php

/**
 * TeamMember class
 */
class TeamMember extends Database
{
  // properties
  public $con;
  // section id
  public $SECTION_ID = 'sec_1004';
  public $SECTION_NAME = 'team members';
  public $SECTION_CONTENT_TABLE = 'team_members';
  public $SECTION_CONTENT_FOLDER = 'members';

  // constructor
  public function __construct()
  {
    // create an object of Database class
    $db_obj = new Database("localhost", "leadergroup_website", "root", "@hmedH@ssib");
    $this->con = $db_obj->con;
  }

  // function for get all members
  public function get_all_members()
  {
    // select all members
    $select_members = "SELECT *FROM `$this->SECTION_CONTENT_TABLE`";
    // check if members exist in database
    $stmt = $this->con->prepare($select_members);
    $stmt->execute();
    $members_info = $stmt->fetchAll();
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ? $members_info : null;
  }

  // function for get all members
  public function get_member($id)
  {
    // select specific member
    $select_member = "SELECT *FROM `$this->SECTION_CONTENT_TABLE` WHERE `id` = ?";
    // check if member exist in database
    $stmt = $this->con->prepare($select_member);
    $stmt->execute(array($id));
    $member_info = $stmt->fetchAll();
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ? $member_info : null;
  }

  // function to get activated member
  public function get_active_members()
  {
    // select all texts
    $select_texts = "SELECT *FROM `$this->SECTION_CONTENT_TABLE` WHERE `is_active` = 1;";
    $stmt = $this->con->prepare($select_texts);
    $stmt->execute();
    $texts_info = $stmt->fetchAll();
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ? $texts_info : null;
  }

  // function to deactivate member
  public function get_deactivated_member()
  {
    // select all texts
    $select_texts = "SELECT *FROM `$this->SECTION_CONTENT_TABLE` WHERE `is_active` = 0;";
    $stmt = $this->con->prepare($select_texts);
    $stmt->execute();
    $texts_info = $stmt->fetchAll();
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ? $texts_info : null;
  }

  // function to activate member
  public function activate_member($id)
  {
    // update activation query
    $update_query = "UPDATE `$this->SECTION_CONTENT_TABLE` SET `is_active` = 1 WHERE `id` = ?;";
    $stmt = $this->con->prepare($update_query);
    $stmt->execute(array($id));
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ? true : null;
  }

  // function to deactivate member
  public function deactivate_member($id)
  {
    // update activation query
    $update_query = "UPDATE `$this->SECTION_CONTENT_TABLE` SET `is_active` = 0 WHERE `id` = ?;";
    $stmt = $this->con->prepare($update_query);
    $stmt->execute(array($id));
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ? true : null;
  }

  // function to insert a new member
  public function insert_new_member($info)
  {
    // insert activation query
    $insert_query = "INSERT INTO `$this->SECTION_CONTENT_TABLE` (`name`, `job_title`, `img`, `facebook`, `instagram`, `twitter`, `linkedin`, `youtube`, `is_active`, `added_date`, `added_by`) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
    $stmt = $this->con->prepare($insert_query);
    $stmt->execute($info);
    $count = $stmt->rowCount();
    // check the count
    // return $count > 0 ? true : null;
    return $insert_query;
  }

  // function to update emeber message
  public function update_img($info)
  {
    // update new img query
    $update_query = "UPDATE `$this->SECTION_CONTENT_TABLE` SET `img` = ? WHERE `id` = ? ;";
    $stmt = $this->con->prepare($update_query);
    $stmt->execute($info);
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ? true : null;
  }


  // function to update status
  public function update_status($info)
  {
    // update new member query
    $update_query = "UPDATE `$this->SECTION_CONTENT_TABLE` SET `is_active` = ? WHERE `id` = ? ;";
    $stmt = $this->con->prepare($update_query);
    $stmt->execute($info);
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ? true : null;
  }

  // function to up date member info
  public function update_member($info)
  {
    // update new member query
    $update_query = "UPDATE `$this->SECTION_CONTENT_TABLE` SET `name` = ?,`job_title` = ?,`facebook` = ?,`instagram` = ?,`twitter` = ?,`linkedin` = ?,`youtube` = ? WHERE `id` = ? ;";
    $stmt = $this->con->prepare($update_query);
    $stmt->execute($info);
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ? true : null;
  }

  // function to delete memebr
  public function delete_member($id)
  {
    // delete new member query
    $delete_query = "DELETE FROM `team_members` WHERE `id` = ? ;";
    $stmt = $this->con->prepare($delete_query);
    $stmt->execute(array($id));
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ? true : null;
  }
}