<?php

/**
 * Login class
 */
class Gallery extends Database
{
  // properties
  public $con;
  // section id
  public $SECTION_ID = 2;
  public $SECTION_NAME = 'gallery';
  public $SECTION_CONTENT_TABLE = 'gallery';
  public $SECTION_CONTENT_FOLDER = 'gallery';

  // constructor
  public function __construct()
  {
    // create an object of Database class
    $db_obj = new Database("localhost", "leadergroup_website", "root", "@hmedH@ssib");
    $this->con = $db_obj->con;
  }

  // function to get all imagesW
  public function get_all_imgs()
  {
    // select all imagesW
    $select_img = "SELECT *FROM `gallery`";
    $stmt = $this->con->prepare($select_img);
    $stmt->execute();
    $imgs_info = $stmt->fetchAll();
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ?  $imgs_info : null;
  }

  // function to get all imagesW
  public function get_img($id)
  {
    // select all imagesW
    $select_img = "SELECT *FROM `gallery` WHERE `id` = ?;";
    $stmt = $this->con->prepare($select_img);
    $stmt->execute(array($id));
    $imgs_info = $stmt->fetchAll();
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ?  $imgs_info : null;
  }

  // function to get all imagesW
  public function get_active_imgs()
  {
    // select all imagesW
    $select_img = "SELECT *FROM `gallery` WHERE `is_active` = 1;";
    $stmt = $this->con->prepare($select_img);
    $stmt->execute();
    $imgs_info = $stmt->fetchAll();
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ?  $imgs_info : null;
  }

  // function to get all imagesW
  public function get_deactive_imgs()
  {
    // select all imagesW
    $select_img = "SELECT *FROM `gallery` WHERE `is_active` = 0;";
    $stmt = $this->con->prepare($select_img);
    $stmt->execute();
    $imgs_info = $stmt->fetchAll();
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ?  $imgs_info : null;
  }

  // function to get all imagesW
  public function insert_new_img($info)
  {
    // insert new img query
    $insert_query = "INSERT INTO `gallery` (`img_name`, `is_active`, `added_date`, `added_time`, `added_by`) VALUES (?, ?, ?, ?, ?) ;";
    $stmt = $this->con->prepare($insert_query);
    $stmt->execute($info);
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ?  true : null;
  }

  public function delete_img($id)
  {
    // delete new img query
    $delete_query = "DELETE FROM `gallery` WHERE `id` = ? ;";
    $stmt = $this->con->prepare($delete_query);
    $stmt->execute(array($id));
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ?  true : null;
  }

  public function update_img($info)
  {
    // update new img query
    $update_query = "UPDATE `gallery` SET `img_name` = ? WHERE `id` = ? ;";
    $stmt = $this->con->prepare($update_query);
    $stmt->execute($info);
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ?  true : null;
  }

  public function activate_img($id)
  {
    // update new img query
    $update_query = "UPDATE `gallery` SET `is_active` = 1 WHERE `id` = ? ;";
    $stmt = $this->con->prepare($update_query);
    $stmt->execute(array($id));
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ?  true : null;
  }

  public function deactivate_img($id)
  {
    // update new img query
    $update_query = "UPDATE `gallery` SET `is_active` = 0 WHERE `id` = ? ;";
    $stmt = $this->con->prepare($update_query);
    $stmt->execute(array($id));
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ? true : null;
  }

  public function insert_settings($info)
  {
    // update new img query
    $update_query = "INSERT INTO `sections` (`section_id`, `section_name`, `num_content`, `content_table`, `content_folder`, `added_date`, `added_time`, `added_by`) VALUES (2, 'gallery', ?, 'gallery', 'gallery', ?, ?, ?) ;";
    $stmt = $this->con->prepare($update_query);
    $stmt->execute($info);
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ? true : null;
  }

  public function update_settings($num, $id)
  {
    // update new img query
    $update_query = "UPDATE `sections` SET `num_content` = ? WHERE `section_id` = ? ;";
    $stmt = $this->con->prepare($update_query);
    $stmt->execute(array($num, $id));
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ? true : null;
  }
}
