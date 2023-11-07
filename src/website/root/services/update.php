<pre dir="ltr">
<?php
// check request method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // create an object of Service class
  $service_obj = !isset($service_obj) ? new Service() : $service_obj;

  // array of error
  $err_arr = array();

  // get service id
  $service_id = isset($_POST['id']) && !empty($_POST['id']) ? base64_decode($_POST['id']) : null;
  // get service info
  $link_1_ar = $_POST['name-1-ar'];
  $link_1_en = $_POST['name-1-en'];
  $link_1 = $_POST['link-1'];
  $link_2_ar = $_POST['name-2-ar'];
  $link_2_en = $_POST['name-2-en'];
  $link_2 = $_POST['link-2'];
  $is_active = $_POST['is-active'];
  $is_active = isset($_POST['is-active']) ? $_POST['is-active'] : null;

  if (empty($service_id) || $service_id == null) {
    $err_arr[] = 'id empty';
  }

  if ($is_active != 0 && empty($is_active)) {
    $err_arr[] = 'status empty';
  }

  // check errors
  if (empty($err_arr)) {
    // check if img id exists or not
    if ($service_obj->is_exist("`id`", "`services`", $service_id)) {
      // check if any image was uploaded
      if ($_FILES['service-img-input']['error'] <= 0) {
        // update image
        $is_updated = update_image($service_obj, $_FILES, $service_id);
        // check if img updated
        if ($is_updated) {
          // prepare flash session variables
          $_SESSION['flash_message'][0] = 'UPDATED';
          $_SESSION['flash_message_icon'][0] = 'bi-check-circle-fill';
          $_SESSION['flash_message_class'][0] = 'success';
          $_SESSION['flash_message_status'][0] = true;
          $_SESSION['flash_message_lang_file'][0] = 'services';
        } else {
          // prepare flash session variables
          $_SESSION['flash_message'][0] = 'NO CHANGES';
          $_SESSION['flash_message_icon'][0] = 'bi-exclamation-triangle-fill';
          $_SESSION['flash_message_class'][0] = 'info';
          $_SESSION['flash_message_status'][0] = false;
          $_SESSION['flash_message_lang_file'][0] = 'services';
        }
      }

      if (isset($is_active)) {
        // update status
        $status = update_status($service_obj, $is_active, $service_id);
        // check status
        if ($status != null) {
          // prepare flash session variables
          switch ($is_active) {
            case '0':
              $status_msg = 'deactivated';
              break;

            case '1':
              $status_msg = 'activated';
              break;

            default:
              $status_msg = 'waiting';
              break;
          }
          $_SESSION['flash_message'][1] = strtoupper($status_msg);
          $_SESSION['flash_message_icon'][1] = 'bi-check-circle-fill';
          $_SESSION['flash_message_class'][1] = 'success';
          $_SESSION['flash_message_status'][1] = true;
          $_SESSION['flash_message_lang_file'][1] = 'services';
        }
      }

      // update service links
      $service_obj->update_service(array($link_1_ar, $link_1_en, $link_1, $link_2_ar, $link_2_en, $link_2, $service_id));

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
      $_SESSION['flash_message_lang_file'][$key] = 'services';
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
  // is_updated flag
  $is_updated = false;

  // get service image info
  $file_name = $img_info['service-img-input']['name'];
  $file_type = $img_info['service-img-input']['type'];
  $file_error = $img_info['service-img-input']['error'];
  $file_size = $img_info['service-img-input']['size'];
  $files_tmp_name = $img_info['service-img-input']['tmp_name'];

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
    // service path
    $path .= "img/";
    // check path
    if (!file_exists($path)) {
      mkdir($path);
    }
    // service path
    $path .= "services/";
    // check path
    if (!file_exists($path)) {
      mkdir($path);
    }

    // media temp
    $media_temp = [];
    // check if not empty
    if (!empty($file_name)) {
      // get old name
      $old_name = $obj->select_specific_column("`service_img`", "`services`", "WHERE `id` = $id")[0]['service_img'];
      // check if old image was exist to delete it
      if (file_exists($GLOBALS['services_img'] . $old_name))
        unlink($GLOBALS['services_img'] . $old_name);
      $media_temp = explode('.', $file_name);
      $media_temp[0] = 'services_' . date('dmY') . '_' . rand(00000000, 99999999);
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
  return $obj->update_status(array($status, $id));
}