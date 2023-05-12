<?php
// get company id to delete his profile image
$company_id = $_SESSION['company_id'];
// create an object of Company class
$company_obj = new Company();
// delete profile image from disk
unlink($uploads . "//companies-img/" . $_SESSION['company_id'] . "/" . $_SESSION['company_img']);
// delete profile image
echo json_encode($company_obj->delete_company_img($company_id));