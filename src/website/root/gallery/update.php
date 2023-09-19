<?php
// check request method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // create an object of Gallery class
  $gallery_obj = !isset($gallery_obj) ? new Gallery() : $gallery_obj;

  // array of error
  $err_arr = array();

  // get img id
  $img_id = isset($_POST['id']) && !empty($_POST['id']) ? base64_decode($_POST['id']) : null;
  $is_active = isset($_POST['is-active']) ? $_POST['is-active'] : null;

  if (empty($img_id) || $img_id == null) {
    $err_arr[] = 'id empty';
  }

  if ($is_active != 0 && empty($is_active)) {
    $err_arr[] = 'status empty';
  }

  // check errors
  if (empty($err_arr)) {
    // check if img id exists or not
    if ($gallery_obj->is_exist("`id`", "`gallery`", $img_id)) {
      // check if any image was uploaded
      if ($_FILES['gallery-img-input']['error'] <= 0) {
        // update image
        $is_updated = update_image($gallery_obj, $_FILES, $img_id);
        // check if img updated
        if ($is_updated) {
          // prepare flash session variables
          $_SESSION['flash_message'][0] = 'UPDATED';
          $_SESSION['flash_message_icon'][0] = 'bi-check-circle-fill';
          $_SESSION['flash_message_class'][0] = 'success';
          $_SESSION['flash_message_status'][0] = true;
          $_SESSION['flash_message_lang_file'][0] = 'gallery';
        } else {
          // prepare flash session variables
          $_SESSION['flash_message'][0] = 'NO CHANGES';
          $_SESSION['flash_message_icon'][0] = 'bi-exclamation-triangle-fill';
          $_SESSION['flash_message_class'][0] = 'info';
          $_SESSION['flash_message_status'][0] = false;
          $_SESSION['flash_message_lang_file'][0] = 'gallery';
        }
      }

      if (isset($is_active)) {
        // update status
        $status = update_status($gallery_obj, $is_active, $img_id);
        // check status
        if ($status != null) {
          // prepare flash session variables
          $_SESSION['flash_message'][1] = $is_active == 0 ? 'DEACTIVATED' : 'ACTIVATED';
          $_SESSION['flash_message_icon'][1] = 'bi-check-circle-fill';
          $_SESSION['flash_message_class'][1] = 'success';
          $_SESSION['flash_message_status'][1] = true;
          $_SESSION['flash_message_lang_file'][1] = 'gallery';
        }
      }
      // redirect home
      redirect_home(null, 'back', 0);
    } else {
      // include no data founded module
      include_once $globmod . 'no-data-founded.php';
    }
  } else {
    // prepare flash session variables
    foreach ($err_arr as $key => $err) {
      $_SESSION['flash_message'][$key] = strtoupper($err);
      $_SESSION['flash_message_icon'][$key] = 'bi-exclamation-triangle-fill';
      $_SESSION['flash_message_class'][$key] = 'danger';
      $_SESSION['flash_message_status'][$key] = false;
      $_SESSION['flash_message_lang_file'][$key] = 'imgs';
    }
    // redirect home
    redirect_home(null, 'back', 0);
  }
} else {
  // include permission error module
  include_once $globmod . 'permission-error.php';
}


/**
 * function to update image with status
 */
function update_image($obj, $img_info, $id)
{
  // get gallery image info
  $file_name        = $img_info['gallery-img-input']['name'];
  $file_type        = $img_info['gallery-img-input']['type'];
  $file_error       = $img_info['gallery-img-input']['error'];
  $file_size        = $img_info['gallery-img-input']['size'];
  $files_tmp_name   = $img_info['gallery-img-input']['tmp_name'];

  // check if company image changed
  if ($file_error > 0 && $file_size <= 0) {
    $err_arr[] = 'img empty';
  }
  // check array of error
  if (empty($err_arr)) {
    // website path
    $path = $GLOBALS['uploads'] . "website/";
    // check path
    if (!file_exists($path)) {
      mkdir($path);
    }
    // gallery path
    $path .= "img/";
    // check path
    if (!file_exists($path)) {
      mkdir($path);
    }
    // gallery path
    $path .= "gallery/";
    // check path
    if (!file_exists($path)) {
      mkdir($path);
    }

    // media temp
    $media_temp = [];
    // is_updated flag
    $is_updated = false;
    // check if not empty
    if (!empty($file_name)) {
      // get old name
      $old_name = $obj->select_specific_column("`img_name`", "`gallery`", "WHERE `id` = $id")[0]['img_name'];
      // check if old image was exist to delete it
      if (file_exists($GLOBALS['gallery_img'] . $old_name)) unlink($GLOBALS['gallery_img'] . $old_name);
      $media_temp = explode('.', $file_name);
      $media_temp[0] = 'gallery_' . date('dmY') . '_' . rand(00000000, 99999999);
      $media_name = join('.', $media_temp);
      move_uploaded_file($files_tmp_name, $path . $media_name);
      // upload files info into database
      $is_updated = $obj->update_img(array($media_name, $id));
    }
  }
  return $is_updated;
}

/**
 * function to update status only
 */
function update_status($obj, $status, $id)
{
  return $status == 1 ? $obj->activate_img($id) : $obj->deactivate_img($id);
}
