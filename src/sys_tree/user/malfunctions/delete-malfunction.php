<?php
if (!isset($mal_obj)) {
  // create an object of Malfunction class
  $mal_obj = new Malfunction();
}
// get malfunction id
$mal_id = isset($_GET['mal-id']) && intval($_GET['mal-id']) ? intval($_GET['mal-id']) : 0;
// get back flag if return back is possible
$is_back = isset($_GET['back']) && !empty($_GET['back']) ? 'back' : null;

// check if the current malfunction id is exist or not
$is_exist = $mal_obj->is_exist("`mal_id`", "`malfunctions`", $mal_id);
?>
<?php if ($is_exist == true) { 
  // call delete function
  $is_deleted = $mal_obj->delete_malfunction($mal_id);
  // check if deleted
  if ($is_deleted) {
    // prepare flash session variables
    $_SESSION['flash_message'] = 'MALFUNCTION WAS DELETED SUCCESSFULLY';
    $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
    $_SESSION['flash_message_class'] = 'success';
    $_SESSION['flash_message_status'] = true;
  } else {    
    // prepare flash session variables
    $_SESSION['flash_message'] = 'A PROBLEM WAS HAPPENED WHILE DELETING THE MALFUNCTION';
    $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
    $_SESSION['flash_message_class'] = 'danger';
    $_SESSION['flash_message_status'] = false;
  }
  // redirect to the previous page
  redirectHome(null, $is_back, 0);
} else {
  // include no data founded
  include_once $globmod . 'no-data-founded-no-redirect.php';
}
