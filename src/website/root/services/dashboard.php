<?php
// create an object of Service class
$services_obj = !isset($services_obj) ? new Service() : $services_obj;
// get all services
$services_info = $services_obj->get_all_services();
?>
<div class="container page-container" dir="<?php echo $page_dir ?>">
  <div class="dashboard-buttons">
    <a href="?do=add-new" class="btn btn-outline-primary py-1">
      <i class="bi bi-plus"></i>
      <span><?php echo lang('ADD NEW', $lang_file) ?></span>
    </a>
  </div>
  <!-- strst pieces table -->
  <table class="table table-bordered table-striped table-striped display compact table-style" style="width:100%">
    <thead class="primary text-capitalize">
      <tr>
        <th class="text-center" style="max-width: 40px">#</th>
        <th class="text-center"><?php echo lang('SERVICE IMG', $lang_file) ?></th>
        <th class="text-center"><?php echo lang('LINK 1 AR', $lang_file) ?></th>
        <th class="text-center"><?php echo lang('LINK 1 EN', $lang_file) ?></th>
        <th class="text-center"><?php echo lang('LINK 1', $lang_file) ?></th>
        <th class="text-center"><?php echo lang('LINK 2 AR', $lang_file) ?></th>
        <th class="text-center"><?php echo lang('LINK 2 EN', $lang_file) ?></th>
        <th class="text-center"><?php echo lang('LINK 2', $lang_file) ?></th>
        <th class="text-center"><?php echo lang('STATUS', $lang_file) ?></th>
        <th class="text-center"><?php echo lang('CONTROL') ?></th>
      </tr>
    </thead>
    <tbody>
      <?php if ($services_info != null && count($services_info) > 0) { ?>
        <?php foreach ($services_info as $key => $service) { ?>
          <tr>
            <td class="text-center"><?php echo $key + 1 ?></td>
            <td class="text-center">
              <?php if (file_exists($services_img . $service['service_img'])) { ?>
                <img src="<?php echo $services_img . $service['service_img'] ?>" class="img-thumbnail" alt="">
              <?php } else { ?>
                <span class="text-danger"><?php echo lang('NO DATA') ?></span>
              <?php } ?>
            </td>
            <td><?php echo $service['link_1_ar'] ?></td>
            <td><?php echo $service['link_1_en'] ?></td>
            <td>
              <?php if (!empty($service['link_1'])) { ?>
                <a href="<?php echo $service['link_1'] ?>">
                  <?php
                  if (strlen($service['link_1']) > 20) {
                    echo trim(substr($service['link_1'], 0, 20), '') . "...";
                  } else {
                    echo $service['link_1'];
                  }
                  ?>
                </a>
              <?php } else { ?>
                <span class="text-danger"><?php echo lang('NO DATA') ?></span>
              <?php } ?>
            </td>
            <td><?php echo $service['link_2_ar'] ?></td>
            <td><?php echo $service['link_2_en'] ?></td>
            <td>
              <?php if (!empty($service['link_2'])) { ?>
                <a href="<?php echo $service['link_2'] ?>">
                  <?php
                  if (strlen($service['link_2']) > 20) {
                    echo trim(substr($service['link_2'], 0, 20), '') . "...";
                  } else {
                    echo $service['link_2'];
                  }
                  ?>
                </a>
              <?php } else { ?>
                <span class="text-danger"><?php echo lang('NO DATA') ?></span>
              <?php } ?>
            </td>
            <td class="text-center">
              <?php if ($service['is_active'] == 1) { ?>
                <i class="d-none"><?php echo $service['is_active'] ?></i>
                <i class="bi bi-check-circle-fill text-success"></i>
              <?php } elseif ($service['is_active'] == 2) { ?>
                <i class="d-none"><?php echo $service['is_active'] ?></i>
                <i class="bi bi-dash-circle-fill text-warning"></i>
              <?php } else { ?>
                <i class="d-none"><?php echo $service['is_active'] ?></i>
                <i class="bi bi-x-circle-fill text-danger"></i>
              <?php } ?>
            </td>
            <td class="text-center">
              <?php if ($service['is_active']) { ?>
                <a href="?do=deactivate-service&id=<?php echo base64_encode($service['id']) ?>" class="btn btn-danger py-0"><i class="bi bi-x"></i></a>
              <?php } else { ?>
                <a href="?do=activate-service&id=<?php echo base64_encode($service['id']) ?>" class="btn btn-primary py-0"><i class="bi bi-check"></i></a>
              <?php } ?>
              <a href="?do=edit-service&id=<?php echo base64_encode($service['id']) ?>" class="btn btn-outline-success py-0"><i class="bi bi-pencil-square"></i></a>
              <button type="button" data-href="?do=delete-service&id=<?php echo base64_encode($service['id']) ?>&back=true" class="btn btn-outline-danger py-0" onclick="confirm_delete_service(this)"><i class="bi bi-trash"></i></button>
            </td>
          </tr>
        <?php } ?>
      <?php } ?>
    </tbody>
  </table>
</div>