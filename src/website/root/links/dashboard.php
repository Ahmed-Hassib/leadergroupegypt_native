<?php
// create an object of Link class
$link_obj = !isset($link_obj) ? new Link() : $link_obj;
// get all links
$links_info = $link_obj->get_all_links();
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
    <table class="table table-bordered table-striped table-striped display display-big-data compact table-style" style="width:100%">
      <thead class="primary text-capitalize">
        <tr>
          <th class="text-center" style="max-width: 40px">#</th>
          <th class="text-center">
            <?php echo lang('AR NAME', $lang_file) ?>
          </th>
          <th class="text-center">
            <?php echo lang('EN NAME', $lang_file) ?>
          </th>
          <th class="text-center">
            <?php echo lang('LINK', $lang_file) ?>
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
        <?php if ($links_info != null && count($links_info) > 0) { ?>
          <?php foreach ($links_info as $key => $link) { ?>
            <tr>
              <td class="text-center">
                <?php echo $key + 1 ?>
              </td>
              <td class="text-center">
                <?php echo $link['link_name_ar'] ?>
              </td>
              <td class="text-center">
                <?php echo $link['link_name_en'] ?>
              </td>
              <td class="text-center">
                <a href="<?php echo $link['link'] ?>" target="_blank">
                  <?php
                  if (strlen($link['link']) > 50) {
                    echo trim(substr($link['link'], 0, 50), '') . "...";
                  } else {
                    echo $link['link'];
                  }
                  ?>
                </a>
              </td>
              <td class="text-center">
                <?php if ($link['is_active']) { ?>
                  <i class="d-none">
                    <?php echo $link['is_active'] ?>
                  </i>
                  <i class="bi bi-check-circle-fill text-success"></i>
                <?php } else { ?>
                  <i class="d-none">
                    <?php echo $link['is_active'] ?>
                  </i>
                  <i class="bi bi-x-circle-fill text-danger"></i>
                <?php } ?>
              </td>
              <td class="text-center">
                <?php if ($link['is_active']) { ?>
                  <a href="?do=deactivate-link&id=<?php echo base64_encode($link['id']) ?>" class="btn btn-danger py-0"><i class="bi bi-x"></i><span>
                      <?php echo lang('DEACTIVATE') ?>
                    </span></a>
                <?php } else { ?>
                  <a href="?do=activate-link&id=<?php echo base64_encode($link['id']) ?>" class="btn btn-primary py-0"><i class="bi bi-check"></i><span>
                      <?php echo lang('ACTIVATE') ?>
                    </span></a>
                <?php } ?>
                <a href="?do=edit-link&id=<?php echo base64_encode($link['id']) ?>" class="btn btn-outline-success py-0"><i class="bi bi-pencil-square"></i></a>
                <button type="button" data-href="?do=delete-link&id=<?php echo base64_encode($link['id']) ?>&back=true" class="btn btn-outline-danger py-0" onclick="confirm_delete(this)"><i class="bi bi-trash"></i></button>
              </td>
            </tr>
          <?php } ?>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>