<?php
// create an object of Section class
$sections_obj = !isset($sections_obj) ? new Section() : $sections_obj;
// get all sections
$sections_info = $sections_obj->get_all_sections();
?>
<div class="container page-container" dir="<?php echo $page_dir ?>">
  <div class="table-responsive-sm">
    <!-- strst pieces table -->
    <table class="table table-bordered table-striped table-striped display display-big-data compact table-style" style="width:100%">
      <thead class="primary text-capitalize">
        <tr>
          <th class="text-center" style="max-width: 40px">#</th>
          <th class="text-center">
            <?php echo lang('SEC CODE', $lang_file) ?>
          </th>
          <th class="text-center">
            <?php echo lang('SEC NAME', $lang_file) ?>
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
        <?php if ($sections_info != null && count($sections_info) > 0) { ?>
          <?php foreach ($sections_info as $key => $section) { ?>
            <tr>
              <td class="text-center">
                <?php echo $key + 1 ?>
              </td>
              <td class="text-center">
                <?php echo $section['section_id'] ?>
              </td>
              <td class="text-center">
                <?php echo $section['section_name'] ?>
              </td>
              <td class="text-center">
                <?php if ($section['is_active']) { ?>
                  <i class="d-none">
                    <?php echo $section['is_active'] ?>
                  </i>
                  <i class="bi bi-check-circle-fill text-success"></i>
                <?php } else { ?>
                  <i class="d-none">
                    <?php echo $section['is_active'] ?>
                  </i>
                  <i class="bi bi-x-circle-fill text-danger"></i>
                <?php } ?>
              </td>
              <td class="text-center">
                <?php if ($section['is_active']) { ?>
                  <a href="?do=deactivate-section&id=<?php echo base64_encode($section['id']) ?>" class="btn btn-danger py-0">
                    <i class="bi bi-x"></i>&nbsp;
                    <span>
                      <?php echo lang('DEACTIVATE') ?>
                    </span>
                  </a>
                <?php } else { ?>
                  <a href="?do=activate-section&id=<?php echo base64_encode($section['id']) ?>" class="btn btn-primary py-0"><i class="bi bi-check"></i>&nbsp;
                    <span>
                      <?php echo lang('ACTIVATE') ?>
                    </span>
                  </a>
                <?php } ?>
              </td>
            </tr>
          <?php } ?>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>