<?php
// create an object of Compnay class
$cmp_obj = new CompanyInfo();
// get company info
$cmp_info = $cmp_obj->get_info();
// get company phones
$cmp_phones = $cmp_obj->get_phones();
// check result
$cmp_info = empty($cmp_info) || $cmp_info == null ? ['id' => null, 'desc' => '', 'desc_en' => '', 'address' => '', 'address_en' => '', 'job_time' => '', 'job_time_en' => ''] : $cmp_info[0];
?>
<div class="container page-container" dir="<?php echo $page_dir ?>">
  <!-- add new text form -->
  <form action="?do=update" method="post" id="edit-text" onchange="form_validation(this)">
    <div class="text-content">
      <div class="form-header">
        <h3 class="h3 text-capitalize">
          <?php echo lang('COMPANY DESC', $lang_file) ?>
        </h3>
      </div>
      <div id="section-content-desc">
        <div class="form-content form-content__content form-edit">
          <?php if ($cmp_info['id'] !== null) { ?>
            <input type="hidden" name="id" value="<?php echo base64_encode($cmp_info['id']) ?>">
          <?php } ?>
          <div class="form-floating">
            <textarea type="text" class="form-control" name="desc-ar" id="desc-ar"
              placeholder="<?php echo lang('AR DESC', $lang_file) ?>"><?php echo $cmp_info['desc'] ?></textarea>
            <label for="desc-ar">
              <?php echo lang('AR DESC', $lang_file) ?>
            </label>
          </div>
          <div class="form-floating">
            <textarea type="text" class="form-control" name="desc-en" id="desc-en"
              placeholder="<?php echo lang('EN DESC', $lang_file) ?>"
              dir="ltr"><?php echo $cmp_info['desc_en'] ?></textarea>
            <label for="desc-en">
              <?php echo lang('EN DESC', $lang_file) ?>
            </label>
          </div>
        </div>
      </div>
    </div>
    <div class="mt-5 text-content">
      <div class="form-header">
        <h3 class="h3 text-capitalize">
          <?php echo lang('JOB DETAILS', $lang_file) ?>
        </h3>
      </div>
      <div id="section-content-job">
        <div class="form-content form-content__content form-edit">
          <div class="form-floating">
            <input type="text" class="form-control" name="address-ar" id="address-ar"
              placeholder="<?php echo lang('AR ADDR', $lang_file) ?>" value="<?php echo $cmp_info['address'] ?>">
            <label for="address-ar">
              <?php echo lang('AR ADDR', $lang_file) ?>
            </label>
          </div>
          <div class="form-floating">
            <input type="text" class="form-control" name="address-en" id="address-en"
              placeholder="<?php echo lang('EN ADDR', $lang_file) ?>" dir="ltr"
              value="<?php echo $cmp_info['address_en'] ?>">
            <label for="address-en">
              <?php echo lang('EN ADDR', $lang_file) ?>
            </label>
          </div>
        </div>
        <div class="form-content form-content__content form-edit">
          <div class="form-floating">
            <input type="time" class="form-control" name="start-job-time" id="start-job-time"
              placeholder="<?php echo lang('START JOB TIME', $lang_file) ?>"
              value="<?php echo $cmp_info['start_job_time'] ?>">
            <label for="start-job-time">
              <?php echo lang('START JOB TIME', $lang_file) ?>
            </label>
          </div>
          <div class="form-floating">
            <input type="time" class="form-control" name="end-job-time" id="end-job-time"
              placeholder="<?php echo lang('END JOB TIME', $lang_file) ?>"
              value="<?php echo $cmp_info['end_job_time'] ?>">
            <label for="end-job-time">
              <?php echo lang('END JOB TIME', $lang_file) ?>
            </label>
          </div>
        </div>
      </div>
    </div>
    <div class="mt-5 text-content">
      <div class="form-header mb-1">
        <h3 class="h3 text-capitalize">
          <?php echo lang('PHONES DETAILS', $lang_file) ?>
        </h3>
      </div>
      <!-- add new phone button -->
      <button type="button" class="btn btn-outline-success me-auto fs-12 py-1"
        onclick="add_new_phone(this, this.nextElementSibling)" data-phone-num="<?php echo $cmp_phones != null && count($cmp_phones) > 0 ? count($cmp_phones) : 0 ?>">
        <i class="bi bi-plus"></i>
        <?php echo lang('ADD NEW PHONE', $lang_file) ?>
      </button>
      <!-- phones containers -->
      <div class="section-content-phones">
        <?php if ($cmp_phones != null && count($cmp_phones) > 0) { ?>
          <?php foreach ($cmp_phones as $key => $phone) { ?>
            <div class="phone-content">
              <div class="form-floating">
                <input class="form-control" type="text" id="phone-<?php echo $key + 1 ?>" name="phone[]"
                  value="<?php echo $phone['phone'] ?>" autocomplete="off" required="required">
                <label class="form-label text-capitalize phone-label" for="phone-1">
                  <?php echo lang('PHONE') . " " . ($key + 1) ?>
                </label>
              </div>
              <div><button class="btn btn-danger w-100 h-100" type="button" onclick="delete_phone(this.parentElement.parentElement)"><i class="bi bi-trash"></i></button></div>
            </div>
          <?php } ?>
        <?php } ?>
      </div>
    </div>
    <!-- submit button -->
    <div class="dashboard-buttons" dir="<?php echo $page_dir == 'rtl' ? 'ltr' : 'rtl' ?>">
      <button type="button" class="btn btn-primary" onclick="form_validation(this.form, this)">
        <i class="bi bi-check-all"></i>
        <?php echo lang('SAVE') ?>
      </button>
    </div>
  </form>
</div>