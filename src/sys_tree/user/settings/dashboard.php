<!-- start home stats container -->
<div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
  <div class="mb-3 row row-cols-sm-1 row-cols-md-2 row-cols-lg-3 align-items-stretch g-3 ">
    <!-- system info -->
    <div class="col-12">
      <div class="section-block">
          <!-- section header -->
        <div class="section-header">
          <h5 class="text-capitalize "><?php echo language('SYSTEM INFO', @$_SESSION['systemLang']) ?></h5>
          <hr />
        </div>
        <?php
        // get user info from database
        $stmt = $con->prepare("SELECT *FROM `license` WHERE `company_id` = " . $_SESSION['company_id'] . " ORDER BY `ID` DESC LIMIT 1");
        $stmt->execute();                     // execute query
        $row = $stmt->fetch();                        // fetch data
        $rowsCount = $stmt->rowCount();                   // get row count
        // check the row count
        if ($rowsCount > 0) { 
          if ($row['isTrial'] == 0) {
            switch($row['type']) {
              case 0:
                $type = language('FOREVER', @$_SESSION['systemLang']);
                break;
              case 1:
                $type = language('MONTHLY', @$_SESSION['systemLang']);
                break;
              case 2:
                $type = language('3 MONTHS', @$_SESSION['systemLang']);
                break;
              case 3:
                $type = language('6 MONTHS', @$_SESSION['systemLang']);
                break;
              case 4:
                $type = language('YEARLY', @$_SESSION['systemLang']);
                break;
            }
          } else {
            $type = language('TRIAL', @$_SESSION['systemLang']);
          }
          ?>
          <p>
            <span class="text-capitalize"><?php echo language('COMPANY NAME', @$_SESSION['systemLang']) . ": " . $_SESSION['company_name'] ?></span><br>
            <span class="text-capitalize"><?php echo language('APP VERSION', @$_SESSION['systemLang']) . ": " . $_SESSION['curr_version_name'] ?></span><br>
            <span class="text-capitalize"><?php echo language('TYPE OF LICENSE', @$_SESSION['systemLang']) . ": " ?><span class="<?php echo $row['isTrial'] == 1 ? 'badge bg-danger' : '' ?>"><?php echo $type ?></span></span><br>
            <span class="text-capitalize"><?php echo language('LICENSE EXPIRY DATE', @$_SESSION['systemLang']) . ": " . $row['expire_date'] ?></span><br>
            <?php 
              $start_date = date_create($row['start_date']);
              $expire_date = date_create($row['expire_date']);
              // get total days
              $total_days = date_diff($start_date, $expire_date);
              // get date of today
              $to_day = date_create(date("Y-m-d"));
              // get diffrence between today and expire date
              $diffrence = date_diff($to_day, $expire_date); 
              // get the rest
              $rest = round(($diffrence->days / $total_days->days) * 100, 2);
            ?>
            <div class="progress">
              <?php if ($rest < 15) { ?>
                <div class="progress-bar <?php echo bg_progress($rest) ?>" role="progressbar" style="width: <?php echo $rest ?>%" aria-valuenow="<?php echo $diffrence->days ?>" aria-valuemin="10" aria-valuemax="<?php echo $total_days->days ?>"></div>
                <div class="progress-value"><?php echo $rest ?>%</div>
              <?php } else { ?>
                <div class="progress-bar <?php echo bg_progress($rest) ?>" role="progressbar" style="width: <?php echo $rest ?>%" aria-valuenow="<?php echo $diffrence->days ?>" aria-valuemin="10" aria-valuemax="<?php echo $total_days->days ?>"><?php echo $rest ?>%</div>
              <?php }?>
            </div>
            <!-- <span></span>  -->
          </p>
        <?php } ?>
      </div>
    </div>
    
    <!-- system language setting -->
    <div class="col-12">
      <div class="section-block">
        <!-- section header -->
        <div class="section-header" >
          <h5 class="text-capitalize "><?php echo language('SYSTEM LANGUAGE', @$_SESSION['systemLang']) ?></h5>
          <hr />
        </div>
        <!-- language form -->
        <form action="?do=change-lang" method="POST">
          <!-- hidden input for employee id -->
          <input type="hidden" name="id" value="<?php echo $_SESSION['UserID'] ?>">
          <!-- strat language field -->
          <div class="mb-3 row">
            <div class="col-sm-12 col-md-8">
              <!-- arabic language -->
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="language" id="languageAr" value="0" <?php echo @$_SESSION['systemLang'] == "ar" ? "checked" : "" ?>>
                <label class="form-check-label text-capitalize" for="languageAr">
                  <?php echo language('ARABIC', @$_SESSION['systemLang']) ?>
                </label>
              </div>
              <!-- english language -->
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="language" id="languageEn" value="1" <?php echo @$_SESSION['systemLang'] == "en" ? "checked" : "" ?> disabled>
                <label class="form-check-label text-capitalize" for="languageEn">
                  <span><?php echo language('ENGLISH', @$_SESSION['systemLang']) ?>&nbsp;</span>
                  <span class="badge bg-secondary"><?php echo language("UNDER DEVELOPING", @$_SESSION['systemLang']) ?></span>
                </label>
              </div>
            </div>
          </div>
          <!-- end language field -->
          <!-- strat submit -->
          <div class="hstack gap-3">
            <button type="submit" class="me-auto btn btn-primary text-capitalize"><i class="bi bi-check-all me-1"></i>&nbsp;<?php echo language('SAVE CHANGES', @$_SESSION['systemLang']) ?></button>
          </div>
          <!-- end submit -->
        </form>
      </div>
    </div>
  </div>
  
  <?php if ($_SESSION['job_title_id'] == 1 || $_SESSION['isRoot'] == 1) { ?>
  <div class="mb-3 row row-cols-sm-1 align-items-stretch g-3 ">
    <!-- system info -->
    <div class="col-12">
      <div class="section-block">
        <!-- section header -->
        <div class="section-header" >
          <h5 class="text-capitalize"><?php echo language('COMPANY INFO', @$_SESSION['systemLang']) ?></h5>
          <hr />
        </div>
      </div>
    </div>
  </div>
  <?php } ?>
</div>
