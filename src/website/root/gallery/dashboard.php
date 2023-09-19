<?php
// create an object of Gallery class
$gallery_obj = !isset($gallery_obj) ? new Gallery() : $gallery_obj;
// get all imgs
$imgs_info = $gallery_obj->get_all_imgs();
// get number of displayed content
$num_displayed = intval($gallery_obj->select_specific_column("`num_content`", "`sections`", "WHERE `section_id` = 2 AND `section_name` = 'gallery'")[0]['num_content'] ?? 9);

?>
<div class="container page-container" dir="<?php echo $page_dir ?>">
  <div class="dashboard-buttons">
    <a href="?do=add-new" class="btn btn-outline-primary py-1">
      <i class="bi bi-plus"></i>
      <span>
        <?php echo lang('ADD NEW', $lang_file) ?>
      </span>
    </a>
    <button type="button" data-bs-toggle="modal" data-bs-target="#changeDisplayedImgNum"
      class="btn btn-outline-primary text-capitalize py-1 fs-12">
      <i class="bi bi-gear"></i>
      <span>
        <?php echo lang('SETTINGS') ?>
      </span>
    </button>
  </div>
  <div class="table-responsive-sm">
    <!-- strst pieces table -->
    <table class="table table-bordered table-striped display compact table-style" style="width:100%">
      <thead class="primary text-capitalize">
        <tr>
          <th class="text-center" style="max-width: 40px">#</th>
          <th class="text-center">
            <?php echo lang('IMG NAME', $lang_file) ?>
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
        <?php if ($imgs_info != null && count($imgs_info) > 0) { ?>
          <?php foreach ($imgs_info as $key => $img) { ?>
            <tr>
              <td class="text-center">
                <?php echo $key + 1 ?>
              </td>
              <td class="text-center">
                <?php if (file_exists($gallery_img . $img['img_name'])) { ?>
                  <img src="<?php echo $gallery_img . $img['img_name'] ?>" class="img-thumbnail" alt="">
                <?php } else { ?>
                  <span class="text-danger">
                    <?php echo lang('NO DATA') ?>
                  </span>
                <?php } ?>
              </td>
              <td class="text-center">
                <?php if ($img['is_active']) { ?>
                  <i class="d-none">
                    <?php echo $img['is_active'] ?>
                  </i>
                  <i class="bi bi-check-circle-fill text-success"></i>
                <?php } else { ?>
                  <i class="d-none">
                    <?php echo $img['is_active'] ?>
                  </i>
                  <i class="bi bi-x-circle-fill text-danger"></i>
                <?php } ?>
              </td>
              <td class="text-center">
                <?php if ($img['is_active']) { ?>
                  <a href="?do=deactivate-img&id=<?php echo base64_encode($img['id']) ?>" class="btn btn-danger py-0"><i
                      class="bi bi-x"></i></a>
                <?php } else { ?>
                  <a href="?do=activate-img&id=<?php echo base64_encode($img['id']) ?>" class="btn btn-primary py-0"><i
                      class="bi bi-check"></i></a>
                <?php } ?>
                <a href="?do=edit-img&id=<?php echo base64_encode($img['id']) ?>" class="btn btn-outline-success py-0"><i
                    class="bi bi-pencil-square"></i></a>
                <button type="button" data-href="?do=delete-img&id=<?php echo base64_encode($img['id']) ?>&back=true"
                  class="btn btn-outline-danger py-0" onclick="confirm_delete_img(this)"><i
                    class="bi bi-trash"></i></button>
              </td>
            </tr>
          <?php } ?>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

<!-- modal to show -->
<div class="modal fade" id="changeDisplayedImgNum" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="width: 350px; margin: auto;" dir="<?php echo $page_dir ?>">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-capitalize " id="exampleModalLabel">
          <?php echo lang('SETTINGS', $lang_file) ?>
        </h5>
      </div>
      <div class="modal-body">
        <form action="?do=update-settings" method="POST" id="update-gallery-settings" onchange="form_validation(this)">
          <div class="form-floating">
            <input type="text" class="form-control" name="num-of-img" id="num-of-img"
              value="<?php echo $num_displayed ?>" placeholder="<?php echo lang('#DISPLAYED IMG', $lang_file) ?>">
            <label for="num-of-img">
              <?php echo lang('#DISPLAYED IMG', $lang_file) ?>
            </label>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary py-1" form="update-gallery-settings"
          onclick="form_validation(this.form, this)">
          <i class="bi bi-check-all"></i>
          <span>
            <?php echo lang('SAVE') ?>
          </span>
        </button>
        <button type="button" class="btn btn-outline-secondary py-1 fs-12" data-bs-dismiss="modal">
          <?php echo lang('CLOSE') ?>
        </button>
      </div>
    </div>
  </div>
</div>