<?php
// create an object of AboutUs class
$about_obj = !isset($about_obj) ? new AboutUs() : $about_obj;
// get all text
$text_info = $about_obj->get_all_texts();
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
  <div class="table-responsive-sm">
    <!-- strst pieces table -->
    <table class="table table-bordered table-striped table-striped display compact table-style" style="width:100%">
      <thead class="primary text-capitalize">
        <tr>
          <th class="text-center" style="max-width: 40px">#</th>
          <th class="text-center">
            <?php echo lang('AR TEXT', $lang_file) ?>
          </th>
          <th class="text-center">
            <?php echo lang('EN TEXT', $lang_file) ?>
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
        <?php if ($text_info != null && count($text_info) > 0) { ?>
          <?php foreach ($text_info as $key => $text) { ?>
            <tr>
              <td class="text-center">
                <?php echo $key + 1 ?>
              </td>
              <td class="text-center">
                <?php
                if (strlen($text['text_ar']) > 70) {
                  echo trim(substr($text['text_ar'], 0, 70), '') . "...";
                } else {
                  echo $text['text_ar'];
                }
                ?>
              </td>
              <td class="text-center">
                <?php
                if (strlen($text['text_en']) > 70) {
                  echo trim(substr($text['text_en'], 0, 70), '') . "...";
                } else {
                  echo $text['text_en'];
                }
                ?>
              </td>
              <td class="text-center">
                <?php if ($text['is_active']) { ?>
                  <i class="d-none">
                    <?php echo $text['is_active'] ?>
                  </i>
                  <i class="bi bi-check-circle-fill text-success"></i>
                <?php } else { ?>
                  <i class="d-none">
                    <?php echo $text['is_active'] ?>
                  </i>
                  <i class="bi bi-x-circle-fill text-danger"></i>
                <?php } ?>
              </td>
              <td class="text-center">
                <?php if ($text['is_active']) { ?>
                  <a href="?do=deactivate-text&id=<?php echo base64_encode($text['id']) ?>" class="btn btn-danger py-0"><i
                      class="bi bi-x"></i>
                    <span>
                      <?php echo lang('DEACTIVATE') ?>
                    </span></a>
                <?php } else { ?>
                  <a href="?do=activate-text&id=<?php echo base64_encode($text['id']) ?>" class="btn btn-primary py-0"><i
                      class="bi bi-check"></i>
                    <span>
                      <?php echo lang('ACTIVATE') ?>
                    </span></a>
                <?php } ?>
                <a href="?do=edit-text&id=<?php echo base64_encode($text['id']) ?>" class="btn btn-outline-success py-0"><i
                    class="bi bi-pencil-square"></i></a>
                <button type="button" data-href="?do=delete-text&id=<?php echo base64_encode($text['id']) ?>&back=true"
                  class="btn btn-outline-danger py-0" onclick="confirm_delete(this)">
                  <i class="bi bi-trash"></i></button>
              </td>
            </tr>
          <?php } ?>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>