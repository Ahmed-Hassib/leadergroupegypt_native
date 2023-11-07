<!-- <pre dir="ltr"><?php print_r($_POST) ?></pre> -->
<?php
// check request method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // create an object of CompanyInfo class
  $cmp_obj = new CompanyInfo();

  // array of error
  $err_arr = array();

  // get id
  $id = isset($_POST['id']) && !empty($_POST['id']) ? base64_decode($_POST['id']) : null;

  // get company description
  $desc_ar = isset($_POST['desc-ar']) && !empty($_POST['desc-ar']) ? $_POST['desc-ar'] : null;
  $desc_en = isset($_POST['desc-en']) && !empty($_POST['desc-en']) ? $_POST['desc-en'] : null;

  // get company address
  $address_ar = isset($_POST['address-ar']) && !empty($_POST['address-ar']) ? $_POST['address-ar'] : null;
  $address_en = isset($_POST['address-en']) && !empty($_POST['address-en']) ? $_POST['address-en'] : null;

  // get job time
  $start_time = isset($_POST['start-job-time']) && !empty($_POST['start-job-time']) ? date("H:i:s", strtotime($_POST['start-job-time'])) : null;
  $end_time = isset($_POST['end-job-time']) && !empty($_POST['end-job-time']) ? date("H:i:s", strtotime($_POST['end-job-time'])) : null;

  // check errors
  if (empty($err_arr)) {
    // check if id was sent
    if ($id != null) {
      // update info
      $is_updated = $cmp_obj->update_info(array($desc_ar, $desc_en, $address_ar, $address_en, $start_time, $end_time, $id));
      // check if info updated
      if ($is_updated) {
        // prepare flash session variables
        $_SESSION['flash_message'][0] = 'UPDATED';
        $_SESSION['flash_message_icon'][0] = 'bi-check-circle-fill';
        $_SESSION['flash_message_class'][0] = 'success';
        $_SESSION['flash_message_status'][0] = true;
        $_SESSION['flash_message_lang_file'][0] = 'company';
      } else {
        // prepare flash session variables
        $_SESSION['flash_message'][0] = 'NO CHANGES';
        $_SESSION['flash_message_icon'][0] = 'bi-exclamation-triangle-fill';
        $_SESSION['flash_message_class'][0] = 'info';
        $_SESSION['flash_message_status'][0] = false;
        $_SESSION['flash_message_lang_file'][0] = 'global_';
      }
    } else {
      // insert info
      $is_inserted = $cmp_obj->insert_info(array(array($desc_ar, $desc_en, $address_ar, $address_en, $start_time, $end_time)));
      // check if info inserted
      if ($is_inserted) {
        // prepare flash session variables
        $_SESSION['flash_message'][0] = 'INSERTED';
        $_SESSION['flash_message_icon'][0] = 'bi-check-circle-fill';
        $_SESSION['flash_message_class'][0] = 'success';
        $_SESSION['flash_message_status'][0] = true;
        $_SESSION['flash_message_lang_file'][0] = 'company';
      } else {
        // prepare flash session variables
        $_SESSION['flash_message'][0] = 'NO CHANGES';
        $_SESSION['flash_message_icon'][0] = 'bi-exclamation-triangle-fill';
        $_SESSION['flash_message_class'][0] = 'info';
        $_SESSION['flash_message_status'][0] = false;
        $_SESSION['flash_message_lang_file'][0] = 'global_';
      }
    }
    // get company phones
    $phones = isset($_POST['phone']) && !empty($_POST['phone']) ? $_POST['phone'] : null;
    // get count of stored phones
    $stored_phones_num = $cmp_obj->count_records("`id`", "`company_phones`", "");
    // truncate phones table
    $cmp_obj->truncate_phones();
    // number of inserted phones
    $inserted_phones = 0;
    // loop on phones to insert it
    foreach ($phones as $key => $phone) {
      // insert phones
      $is_inserted = $cmp_obj->insert_phone($phone);
      // check if phone is inserted
      if ($is_inserted && !empty($phone)) {
        // increase inserted phones 1
        $inserted_phones += 1;
      }
    }

    // check if all phones are inserted or not
    if ($inserted_phones == count($phones) && $inserted_phones != 0) {
      // prepare flash session variables
      $_SESSION['flash_message'][1] = 'PHONES INSERTED';
      $_SESSION['flash_message_icon'][1] = 'bi-check-circle-fill';
      $_SESSION['flash_message_class'][1] = 'success';
      $_SESSION['flash_message_status'][1] = true;
      $_SESSION['flash_message_lang_file'][1] = 'company';
    } elseif ($inserted_phones < count($phones)) {
      // prepare flash session variables
      $_SESSION['flash_message'][1] = 'PHONES SOME INSERTED';
      $_SESSION['flash_message_icon'][1] = 'bi-exclamation-triangle-fill';
      $_SESSION['flash_message_class'][1] = 'info';
      $_SESSION['flash_message_status'][1] = false;
      $_SESSION['flash_message_lang_file'][1] = 'company';
    } elseif ($inserted_phones == 0 && $stored_phones_num > 0) {
      // prepare flash session variables
      $_SESSION['flash_message'][1] = 'PHONES DELETED';
      $_SESSION['flash_message_icon'][1] = 'bi-check-circle-fill';
      $_SESSION['flash_message_class'][1] = 'success';
      $_SESSION['flash_message_status'][1] = false;
      $_SESSION['flash_message_lang_file'][1] = 'company';
    }
  } else {
    // prepare flash session variables
    foreach ($err_arr as $key => $err) {
      $_SESSION['flash_message'][$key] = strtoupper($err);
      $_SESSION['flash_message_icon'][$key] = 'bi-exclamation-triangle-fill';
      $_SESSION['flash_message_class'][$key] = 'danger';
      $_SESSION['flash_message_status'][$key] = false;
      $_SESSION['flash_message_lang_file'][$key] = 'about';
    }
  }
  // redirect home
  redirect_home(null, 'back', 0);
} else {
  // include permission error module
  include_once $globmod . 'permission-error.php';
}