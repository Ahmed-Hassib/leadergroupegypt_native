<div class="container" dir="<?php echo $page_dir ?>">
  <!-- start header -->
  <header class="header mb-3">
    <div class="hstack gap-2">
      <div>
        <span class="badge bg-danger p-2 d-inline-block"></span>
        <span>
          <?php echo lang('LICENSE EXPIRED', $lang_file) ?>
        </span>
      </div>
      <div>
        <span class="badge bg-success p-2 d-inline-block"></span>
        <span>
          <?php echo lang('LICENSE ACTIVE', $lang_file) ?>
        </span>
      </div>
    </div>
  </header>
  <!-- start companies list container -->
  <div class="table-responsive-sm">
    <!-- strst users table -->
    <table class="table table-bordered table-striped display display-big-data compact table-style" style="width:100%">
      <thead class="primary text-capitalize">
        <tr>
          <th>#</th>
          <th>
            <?php echo lang('STATUS', $lang_file) ?>
          </th>
          <th>
            <?php echo lang('COMPANY NAME', $lang_file) ?>
          </th>
          <th>
            <?php echo lang('MANAGER NAME', $lang_file) ?>
          </th>
          <th>
            <?php echo lang('PHONE', $lang_file) ?>
          </th>
          <th>
            <?php echo lang('APP VERSION', $lang_file) ?>
          </th>
          <th>
            <?php echo lang('JOINED DATE', $lang_file) ?>
          </th>
          <th>
            <?php echo lang('EXPIRE DATE', $lang_file) ?>
          </th>
          <th>
            <?php echo lang('PROGRESS', $lang_file) ?>
          </th>
          <th>
            <?php echo lang('CONTROL', $lang_file) ?>
          </th>
        </tr>
      </thead>
      <tbody id="companies-table">
        <?php
        // create an object of Company class
        $company_obj = new Company();
        // get all companies
        $all_companies = $company_obj->get_all_companies();
        // loop on data
        foreach ($all_companies as $key => $company) { ?>
          <?php
          // company_id
          $company_id = $company['company_id'];
          // company current license id
          $company_license_id = $company_obj->get_license_id($company_id);
          // company current license info
          $company_license_info = $company_obj->get_license_info($company_license_id, $company_id);
          // get company dates
          $dates = $company_obj->select_specific_column("`start_date`, `expire_date`", "`license`", "WHERE `isEnded` = 0 AND `company_id` = " . $company_id);
          // check the value
          if (count($dates) > 0) {
            $start_date = date_create($dates[0]['start_date']);
            $expire_date = date_create($dates[0]['expire_date']);
            $expire = $dates[0]['expire_date'];
            $is_ended = $expire < date("Y-m-d");
          } else {
            $is_ended = true;
            // get company dates
            $expire = $company_obj->select_specific_column("`expire_date`", "`license`", "WHERE `isEnded` = 1 AND `company_id` = " . $company_id . " ORDER BY `expire_date` DESC LIMIT 1");
            $expire = !empty($expire) ? $expire[0]['expire_date'] : '';
          }
          ?>
          <tr>
            <!-- index -->
            <td>
              <?php echo ++$key; ?>
            </td>
            <td class="text-center">
              <?php if ($is_ended == true) { ?>
                <span class="badge bg-danger p-2 d-inline-block" title="<?php echo lang('LICENSE EXPIRED', $lang_file) ?>"></span>
              <?php } else { ?>
                <span class="badge bg-success p-2 d-inline-block" title="<?php echo lang('LICENSE ACTIVATED', $lang_file) ?>"></span>
              <?php } ?>
            </td>
            <!-- company name -->
            <td>
              <?php echo $company['company_name'] ?>
            </td>
            <!-- company manager name -->
            <td>
              <?php echo $company['company_manager'] ?>
            </td>
            <!-- company phone -->
            <td class="<?php echo !empty($company['company_phone']) ? '' : 'text-danger fw-bold' ?>">
              <?php echo !empty($company['company_phone']) ? $company['company_phone'] : lang('NOT ASSIGNED', $lang_file) ?>
            </td>
            <!-- company version -->
            <td>
              <?php echo $company_obj->select_specific_column("`v_name`", "`versions`", "WHERE `v_id` = " . $company['version'])[0]['v_name']; ?>
            </td>
            <!-- company joined date -->
            <td>
              <?php echo !empty($company['joined_date']) ? $company['joined_date'] : lang('NOT ASSIGNED', $lang_file) ?>
            </td>
            <!-- company expire date -->
            <td>
              <?php echo $expire; ?>
            </td>
            <!-- company progress -->
            <td>
              <?php
              if ($is_ended == false) {
                // get total days
                $total_days = date_diff($start_date, $expire_date);
                // get date of today
                $to_day = date_create(date("Y-m-d"));
                // get diffrence between today and expire date
                $diffrence = date_diff($to_day, $expire_date);
                // check if diffrence is minus value
                $is_minus = $diffrence->invert;
                // get the rest
                $rest = round(($diffrence->days / $total_days->days) * 100, 2);
                // check the rest
                if ($rest >= 100) {
                  $rest = 100;
                } elseif ($is_minus) {
                  $rest = 0;
                }
              } else {
                $rest = 0;
              }
              ?>
              <div class="progress" title="<?php echo (isset($is_minus) && $is_minus == true) || !isset($diffrence) ? 0 : $diffrence->days ?> days">
                <?php if ($rest < 15) { ?>
                  <div class="progress-bar <?php echo bg_progress($rest) ?>" role="progressbar" style="width: <?php echo $rest ?>%" aria-valuenow="<?php echo $diffrence->days ?>" aria-valuemin="10" aria-valuemax="<?php echo $total_days->days ?>"></div>
                  <div class="progress-value">
                    <?php echo $rest ?>%
                  </div>
                <?php } else { ?>
                  <div class="progress-bar <?php echo bg_progress($rest) ?>" role="progressbar" style="width: <?php echo $rest ?>%" aria-valuenow="<?php echo $diffrence->days ?>" aria-valuemin="10" aria-valuemax="<?php echo $total_days->days ?>">
                    <?php echo $rest ?>%
                  </div>
                <?php } ?>
              </div>
            </td>
            <!-- control -->
            <td>
              <div class="hstack gap-2">
                <a href="?do=details&company-id=<?php echo base64_encode($company_id) ?>" class="btn btn-outline-primary">
                  <i class="bi bi-eye"></i>
                  <?php echo lang('show') ?>
                </a>
              </div>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

<?php include_once 'delete-modal.php' ?>