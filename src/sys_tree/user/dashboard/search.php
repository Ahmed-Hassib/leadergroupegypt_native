<?php
// get search 
$search = trim($_GET['search'], ' ');
// create an object from User class
$emp_obj = new User();
// search in employees
$employees = $emp_obj->search($search, base64_decode($_SESSION['sys']['company_id']));
// get employee counter
$emp_count = $employees != null ? count($employees) : 0;

// search in directions
$dir_obj = new Direction();
// search in directions
$directions = $dir_obj->search($search, base64_decode($_SESSION['sys']['company_id']));
// get direction counter
$dir_count = $directions != null ? count($directions) : 0;

// search in pieces
$pcs_obj = new Pieces();
// search in directions
$pieces = $pcs_obj->search($search, base64_decode($_SESSION['sys']['company_id']), 0);
// get direction counter
$pcs_count = $pieces != null ? count($pieces) : 0;

// search in company manufacture
// search in pieces connections
// search in clients

// total search results
$total_results = $emp_count + $dir_count + $pcs_count;
?>
<div class="container" dir="<?php echo $page_dir ?>">
  <?php if (empty($search)) { ?>
    <header class="mb-5">
      <h5 class="h5 text-capitalize text-danger">
        <i class="bi bi-exclamation-triangle-fill"></i>
        <?php echo lang('SEARCH STMT EMPTY') ?>
      </h5>
    </header>
  <?php } else { ?>
    <header class="mb-5">
      <h3 class="h3 text-capitalize"><?php echo lang('SEARCH RESULT') ?>: <?php echo $search ?></h3>
      <h6 class="h6 text-capitalize"><?php echo lang('TOTAL RESULTS') ?>: <?php echo $total_results ?></h6>
    </header>
    <!-- employees search -->
    <div class="mb-5 employee-search">
      <header class="<?php echo $page_dir == 'rtl' ? 'text-right' : 'text-left' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#employeesResult" aria-expanded="false" aria-controls="employeesResult">
        <h5 class="h5 text-capitalize"><?php echo lang('EMPLOYEES') ?></h5>
        <h6 class="h6 text-capitalize"><?php echo lang('#RESULTS') ?>: <?php echo $emp_count ?></h6>
        <hr>
      </header>
      <div class="mb-3 row row-cols-sm-1 row-cols-md-2 row-cols-lg-3 g-3 collapse" id="employeesResult">
        <?php if ($emp_count > 0) { ?>
          <?php foreach ($employees as $key => $emp) { ?>
            <div class="col-12">
              <div class="section-block">
                <header class="seaction-header">
                  <?php if ($_SESSION['sys']['user_add']) { ?>
                    <a href="<?php echo $nav_up_level ?>employees/index.php?do=edit-user-info&userid=<?php echo base64_encode($emp['userid']) ?>" target="_blank">
                      <h5 class="h5 text-capitalize">
                        <?php echo $emp['fullname'] ?>
                      </h5>
                    </a>
                  <?php } else { ?>
                    <h5 class="h5 text-capitalize">
                      <?php echo $emp['fullname'] ?>
                    </h5>
                  <?php } ?>
                  <hr>
                </header>
                <!-- employee info -->
                <div>
                  <?php if ($emp['job_title_id'] > 0) { ?>
                    <span class="m-1 badge bg-secondary">
                      <?php
                      // get user job name
                      $job_name = $emp_obj->select_specific_column("`job_title_name`", "`users_job_title`", "WHERE `job_title_id` = " . $emp['job_title_id'])[0]['job_title_name'];
                      // disply job title
                      echo lang($job_name, 'employees');
                      ?>
                    </span>
                  <?php } ?>
                  <?php if (!empty($emp['email'])) { ?>
                    <span class="m-1 badge bg-secondary">
                      <i class="bi bi-envelope"></i>&nbsp;
                      <?php echo $emp['email'] ?>
                    </span>
                  <?php } ?>
                  <?php if (!empty($emp['address'])) { ?>
                    <span class="m-1 badge bg-secondary">
                      <i class="bi bi-geo-alt-fill"></i>&nbsp;
                      <?php echo $emp['address'] ?>
                    </span>
                  <?php } ?>
                  <?php if (!empty($emp['phone'])) { ?>
                    <span class="m-1 badge bg-secondary">
                      <i class="bi bi-telephone-fill"></i>&nbsp;
                      <?php echo $emp['phone'] ?>
                    </span>
                  <?php } ?>
                </div>
              </div>
            </div>
          <?php } ?>
        <?php } else { ?>
          <h5 class="h5 text-capitalize text-danger"><?php echo lang('NO RESULT MATCH') ?></h5>
        <?php } ?>
      </div>
    </div>

    <!-- directions search -->
    <div class="mb-5 directions-search">
      <header class="<?php echo $page_dir == 'rtl' ? 'text-right' : 'text-left' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#directionsResult" aria-expanded="false" aria-controls="directionsResult">
        <h5 class="h5 text-capitalize"><?php echo lang('DIRECTIONS') ?></h5>
        <h6 class="h6 text-capitalize"><?php echo lang('#RESULTS') ?>: <?php echo $dir_count ?></h6>
        <hr>
      </header>
      <div class="mb-3 row row-cols-sm-1 row-cols-md-2 row-cols-lg-3 g-3 collapse" id="directionsResult">
        <?php if ($dir_count > 0) { ?>
          <?php foreach ($directions as $key => $dir) { ?>
            <div class="col-12">
              <div class="section-block">
                <header class="seaction-header">
                  <?php if ($_SESSION['sys']['user_add']) { ?>
                    <a href="<?php echo $nav_up_level ?>directions/index.php?do=show-direction-tree&dir-id=<?php echo base64_encode($dir['direction_id']) ?>" target="_blank">
                      <h5 class="h5 text-capitalize">
                        <?php echo $dir['direction_name'] ?>
                      </h5>
                    </a>
                  <?php } else { ?>
                    <h5 class="h5 text-capitalize">
                      <?php echo $dir['direction_name'] ?>
                    </h5>
                  <?php } ?>
                  <hr>
                </header>
              </div>
            </div>
          <?php } ?>
        <?php } else { ?>
          <h5 class="h5 text-capitalize text-danger"><?php echo lang('NO RESULT MATCH') ?></h5>
        <?php } ?>
      </div>
    </div>

    <!-- pieces search -->
    <div class="mb-5 pieces-search">
      <header class="<?php echo $page_dir == 'rtl' ? 'text-right' : 'text-left' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#pcsResult" aria-expanded="false" aria-controls="pcsResult">
        <h5 class="h5 text-capitalize"><?php echo lang('PIECES') ?></h5>
        <h6 class="h6 text-capitalize"><?php echo lang('#RESULTS') ?>: <?php echo $pcs_count ?></h6>
        <hr>
      </header>
      <div class="mb-3 row row-cols-sm-1 row-cols-md-2 row-cols-lg-3 g-3 collapse" id="pcsResult">
        <?php if ($pcs_count > 0) { ?>
          <?php foreach ($pieces as $key => $pcs) { ?>
            <div class="col-12">
              <div class="section-block">
                <header class="seaction-header">
                  <?php if ($_SESSION['sys']['user_add']) { ?>
                    <a href="<?php echo $nav_up_level ?>pieces/index.php?do=edit-piece&piece-id=<?php echo base64_encode($pcs['id']) ?>" target="_blank">
                      <h5 class="h5 text-capitalize">
                        <?php echo $pcs['fullname'] ?>
                      </h5>
                    </a>
                  <?php } else { ?>
                    <h5 class="h5 text-capitalize">
                      <?php echo $pcs['fullname'] ?>
                    </h5>
                  <?php } ?>
                  <hr>
                </header>
              </div>
            </div>
          <?php } ?>
        <?php } else { ?>
          <h5 class="h5 text-capitalize text-danger"><?php echo lang('NO RESULT MATCH') ?></h5>
        <?php } ?>
      </div>
    </div>
  <?php } ?>
</div>