<?php
// create an object of Features class
$features_obj = new Features();
// get all features
$features_info = $features_obj->get_all_features();
?>
<div class="container page-container" dir="<?php echo $page_dir ?>">
  <div class="dashboard-buttons">
    <a href="?do=add-new" class="btn btn-outline-primary py-1">
      <i class="bi bi-plus"></i>
      <span>
        <?php echo lang('ADD NEW', $lang_file) ?>
      </span>
    </a>
  </div>
  <!-- strst pieces table -->
  <table class="table table-bordered table-striped table-striped display compact table-style" style="width:100%">
    <thead class="primary text-capitalize">
      <tr>
        <th class="text-center" style="max-width: 40px">#</th>
        <th class="text-center">
          <?php echo lang('AR FEATURE NAME', $lang_file) ?>
        </th>
        <th class="text-center">
          <?php echo lang('EN FEATURE NAME', $lang_file) ?>
        </th>
        <th class="text-center">
          <?php echo lang('STATUS', $lang_file) ?>
        </th>
        <th class="text-center">
          <?php echo lang('CONTROL') ?>
        </th>
      </tr>
    </thead>
    <tbody>
      <?php if ($features_info != null && count($features_info) > 0) { ?>
        <?php foreach ($features_info as $key => $feature) { ?>
          <tr>
            <td class="text-center">
              <?php echo $key + 1 ?>
            </td>
            <!-- feature name in arabic -->
            <td>
              <?php echo $feature['feature_name_ar'] ?>
            </td>
            <!-- feature name in english -->
            <td dir="ltr">
              <?php echo $feature['feature_name_en'] ?>
            </td>
            <td class="text-center">
              <?php if ($feature['is_active'] == 1) { ?>
                <i class="d-none">
                  <?php echo $feature['is_active'] ?>
                </i>
                <i class="bi bi-check-circle-fill text-success"></i>
              <?php } elseif ($feature['is_active'] == 2) { ?>
                <i class="d-none">
                  <?php echo $feature['is_active'] ?>
                </i>
                <i class="bi bi-dash-circle-fill text-warning"></i>
              <?php } else { ?>
                <i class="d-none">
                  <?php echo $feature['is_active'] ?>
                </i>
                <i class="bi bi-x-circle-fill text-danger"></i>
              <?php } ?>
            </td>
            <td class="text-center">
              <?php if ($feature['is_active']) { ?>
                <a href="?do=deactivate-feature&id=<?php echo base64_encode($feature['id']) ?>" class="btn btn-danger py-0"><i
                    class="bi bi-x"></i></a>
              <?php } else { ?>
                <a href="?do=activate-feature&id=<?php echo base64_encode($feature['id']) ?>" class="btn btn-primary py-0"><i
                    class="bi bi-check"></i></a>
              <?php } ?>
              <a href="?do=edit-feature&id=<?php echo base64_encode($feature['id']) ?>"
                class="btn btn-outline-success py-0"><i class="bi bi-pencil-square"></i></a>
              <button type="button" data-href="?do=delete-feature&id=<?php echo base64_encode($feature['id']) ?>&back=true"
                class="btn btn-outline-danger py-0" onclick="confirm_delete_feature(this)"><i
                  class="bi bi-trash"></i></button>
            </td>
          </tr>
        <?php } ?>
      <?php } ?>
    </tbody>
  </table>
</div>