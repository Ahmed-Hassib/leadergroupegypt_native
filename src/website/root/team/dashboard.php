<?php
// create an object of TeamMember class
$members_obj = !isset($members_obj) ? new TeamMember() : $members_obj;
// get all members
$members_info = $members_obj->get_all_members();
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
          <?php echo lang('MEMBER NAME', $lang_file) ?>
        </th>
        <th class="text-center">
          <?php echo lang('JOB TITLE', $lang_file) ?>
        </th>
        <th class="text-center">
          <?php echo lang('SOCIAL MEDIA', $lang_file) ?>
        </th>
        <th class="text-center">
          <?php echo lang('IMAGE', $lang_file) ?>
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
      <?php if ($members_info != null && count($members_info) > 0) { ?>
        <?php foreach ($members_info as $key => $member) { ?>
          <tr>
            <td class="text-center">
              <?php echo $key + 1 ?>
            </td>
            <td class="text-center">
              <?php echo $member['name'] ?>
            </td>
            <td class="text-center">
              <?php echo $member['job_title'] ?>
            </td>
            <td class="text-center">
              <div class="table-social">
                <?php if (!empty($member['facebook']) && facebook_validation(trim($member['facebook'], ' '))) { ?>
                  <!-- for facebook link -->
                  <a href="<?php echo trim($member['facebook'], " \n\r\t\v") ?>" target="_blank"><i
                      class="bi bi-facebook"></i></a>
                <?php } ?>
                <?php if (!empty($member['instagram']) && instagram_validation(trim($member['instagram'], ' '))) { ?>
                  <!-- for instagram link -->
                  <a href="<?php echo trim($member['instagram'], " \n\r\t\v") ?>" target="_blank"><i
                      class="bi bi-instagram"></i></a>
                <?php } ?>
                <?php if (!empty($member['twitter']) && twitter_validation(trim($member['twitter'], ' '))) { ?>
                  <!-- for twitter link -->
                  <a href="<?php echo trim($member['twitter'], " \n\r\t\v") ?>" target="_blank"><i
                      class="bi bi-twitter"></i></a>
                <?php } ?>
                <?php if (!empty($member['linkedin']) && linkedin_validation(trim($member['linkedin'], ' '))) { ?>
                  <!-- for linkedin link -->
                  <a href="<?php echo trim($member['linkedin'], " \n\r\t\v") ?>" target="_blank"><i
                      class="bi bi-linkedin"></i></a>
                <?php } ?>
                <?php if (!empty($member['youtube']) && youtube_validation(trim($member['youtube'], ' '))) { ?>
                  <!-- for youtube link -->
                  <a href="<?php echo trim($member['youtube'], " \n\r\t\v") ?>" target="_blank"><i
                      class="bi bi-youtube"></i></a>
                <?php } ?>
              </div>
            </td>
            <td class="text-center">
              <?php if (file_exists($members_img . $member['img'])) { ?>
                <img src="<?php echo $members_img . $member['img'] ?>" class="img-thumbnail" alt="">
              <?php } else { ?>
                <span class="text-danger">
                  <?php echo lang('NOT ASSIGNED') ?>
                </span>
              <?php } ?>
            </td>
            <td class="text-center">
              <?php if ($member['is_active'] == 1) { ?>
                <i class="d-none">
                  <?php echo $member['is_active'] ?>
                </i>
                <i class="bi bi-check-circle-fill text-success"></i>
              <?php } elseif ($member['is_active'] == 2) { ?>
                <i class="d-none">
                  <?php echo $member['is_active'] ?>
                </i>
                <i class="bi bi-dash-circle-fill text-warning"></i>
              <?php } else { ?>
                <i class="d-none">
                  <?php echo $member['is_active'] ?>
                </i>
                <i class="bi bi-x-circle-fill text-danger"></i>
              <?php } ?>
            </td>
            <td class="text-center">
              <?php if ($member['is_active']) { ?>
                <a href="?do=deactivate-member&id=<?php echo base64_encode($member['id']) ?>" class="btn btn-danger py-0"><i
                    class="bi bi-x"></i><span>
                      <?php echo lang('DEACTIVATE') ?>
                    </span></a>
              <?php } else { ?>
                <a href="?do=activate-member&id=<?php echo base64_encode($member['id']) ?>" class="btn btn-primary py-0"><i
                    class="bi bi-check"></i><span>
                      <?php echo lang('ACTIVATE') ?>
                    </span></a>
              <?php } ?>
              <a href="?do=edit-member&id=<?php echo base64_encode($member['id']) ?>"
                class="btn btn-outline-success py-0"><i class="bi bi-pencil-square"></i></a>
              <button type="button" data-href="?do=delete-member&id=<?php echo base64_encode($member['id']) ?>&back=true"
                class="btn btn-outline-danger py-0" onclick="confirm_delete(this)"><i
                  class="bi bi-trash"></i></button>
            </td>
          </tr>
        <?php } ?>
      <?php } ?>
    </tbody>
  </table>
</div>